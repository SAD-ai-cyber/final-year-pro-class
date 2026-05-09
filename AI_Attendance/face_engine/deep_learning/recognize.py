# Camera open
# Face detect
# Embedding compare
# result.json banata hai

import os
import sys

# SUPPRESS ALL TENSORFLOW WARNINGS & LOGS
os.environ["TF_CPP_MIN_LOG_LEVEL"] = "3"
os.environ["CUDA_VISIBLE_DEVICES"] = "-1"

import warnings
warnings.filterwarnings('ignore')

import logging
logging.disable(logging.CRITICAL)

# Redirect stdout/stderr before importing heavy libs
devnull = open(os.devnull, 'w')
old_stdout = sys.stdout
old_stderr = sys.stderr
sys.stdout = devnull
sys.stderr = devnull

import cv2
import numpy as np
import json
import time
import threading

# Restore stdout/stderr
sys.stdout = old_stdout
sys.stderr = old_stderr
devnull.close()

# =================================================
# PATHS
# =================================================
BASE_DIR = os.path.dirname(os.path.abspath(__file__))
EMB_DIR = os.path.join(BASE_DIR, "embeddings")
RESULT_FILE = os.path.join(BASE_DIR, "result.json")

os.makedirs(EMB_DIR, exist_ok=True)

# =================================================
# DEVICE MODE (ENV BASED – MACHINE SPECIFIC)
# =================================================
DEV_MODE = os.getenv("AI_DEV_MODE", "0") == "1"
CAMERA_INDEX = int(os.getenv("AI_CAMERA_INDEX", "0"))

# =================================================
# GLOBAL VARS (LAZY LOADED)
# =================================================
embedder = None
norm = None

# =================================================
# PARAMETERS
# =================================================
if DEV_MODE:
    THRESHOLD = 0.75
    MIN_FACE_SIZE = 60
    CAPTURE_SECONDS = 5
else:
    THRESHOLD = 0.7
    MIN_FACE_SIZE = 90
    CAPTURE_SECONDS = 5

# =================================================
# UTILS
# =================================================
def get_embedder():
    global embedder, norm
    if embedder is None:
        # Lazy import heavy libraries only when needed
        os.environ["TF_CPP_MIN_LOG_LEVEL"] = "3"
        import warnings
        warnings.filterwarnings('ignore')
        
        # Suppress import logs
        devnull = open(os.devnull, 'w')
        old_stdout = sys.stdout
        sys.stdout = devnull # Silence TF load
        
        from keras_facenet import FaceNet
        from numpy.linalg import norm as np_norm
        
        sys.stdout = old_stdout
        devnull.close()
        
        embedder = FaceNet()
        norm = np_norm
    return embedder, norm

def cosine_distance(a, b):
    _, n_func = get_embedder()
    return 1 - np.dot(a, b) / (n_func(a) * n_func(b))

def get_embedding(face_img):
    emb_model, _ = get_embedder()
    face_img = cv2.resize(face_img, (160, 160))
    face_img = face_img.astype("float32")
    return emb_model.embeddings([face_img])[0]

# =================================================
# AUTO FACE CAPTURE (FAST STARTUP)
# =================================================
def get_working_camera(max_index=5):
    for i in range(max_index):
        try:
            cap = cv2.VideoCapture(i, cv2.CAP_DSHOW)
            if cap.isOpened():
                for attempt in range(3):
                    ret, frame = cap.read()
                    if ret and frame is not None and frame.size > 0:
                        if np.mean(frame) > 10:
                            cap.release()
                            return i
                cap.release()
        except:
            pass
    return None

def capture_faces_auto():
    # Use Haar Cascade for FAST startup (No TensorFlow needed here)
    detector_path = cv2.data.haarcascades + 'haarcascade_frontalface_default.xml'
    face_cascade = cv2.CascadeClassifier(detector_path)
    
    cam_index = get_working_camera()
    if cam_index is None:
        return []
    
    cap = cv2.VideoCapture(cam_index, cv2.CAP_DSHOW)
    if not cap.isOpened():
        return []

    cap.set(cv2.CAP_PROP_FRAME_WIDTH, 640)
    cap.set(cv2.CAP_PROP_FRAME_HEIGHT, 480)
    cap.set(cv2.CAP_PROP_FPS, 30)

    cv2.namedWindow("AI Face Attendance", cv2.WINDOW_NORMAL)
    cv2.resizeWindow("AI Face Attendance", 960, 540)
    # FORCE WINDOW ON TOP
    cv2.setWindowProperty("AI Face Attendance", cv2.WND_PROP_TOPMOST, 1)

    collected_faces = []
    start = time.time()
    black_frame_count = 0

    while time.time() - start < CAPTURE_SECONDS:
        ret, frame = cap.read()
        if not ret or frame is None:
            continue

        # Skip black frames
        if np.mean(frame) < 10:
            black_frame_count += 1
            if black_frame_count > 10:
                break
            continue
        
        black_frame_count = 0

        # Fast detection with Haar
        gray = cv2.cvtColor(frame, cv2.COLOR_BGR2GRAY)
        faces = face_cascade.detectMultiScale(gray, 1.1, 4)

        for (x, y, w, h) in faces:
            if w < MIN_FACE_SIZE or h < MIN_FACE_SIZE:
                continue

            # Crop rgb face
            face_img = frame[y:y+h, x:x+w]
            # Convert BGR to RGB for FaceNet later
            face_img_rgb = cv2.cvtColor(face_img, cv2.COLOR_BGR2RGB)
            collected_faces.append(face_img_rgb)

            cv2.rectangle(frame, (x, y), (x+w, y+h), (0, 255, 0), 2)

        cv2.putText(
            frame,
            "Scanning... Stay Still",
            (20, 40),
            cv2.FONT_HERSHEY_SIMPLEX,
            0.9,
            (0, 255, 255),
            2
        )

        cv2.imshow("AI Face Attendance", frame)
        key = cv2.waitKey(1)
        if key == 27:  # ESC to quit
            break

    cap.release()
    cv2.destroyAllWindows()
    
    # Give time for window to close
    cv2.waitKey(100)
    
    return collected_faces

# =================================================
# RECOGNITION
# =================================================
def recognize(expected_id=None):
    # OPTIMIZATION: Start loading AI model in background thread
    # This hides the heavy TensorFlow import time (~5-10s) behind the camera interaction
    loading_thread = threading.Thread(target=get_embedder)
    loading_thread.start()

    # Capture faces from camera
    faces = capture_faces_auto()
    
    # Wait for AI to finish loading (if not already done)
    loading_thread.join()

    if len(faces) == 0:
        return {"status": "error", "message": "Face not detected"}

    # If verifying a specific student (Attendance Marking)
    if expected_id:
        expected_path = os.path.join(EMB_DIR, f"{expected_id}.npy")
        
        if not os.path.isfile(expected_path):
             return {"status": "error", "message": "Face not registered"}

        # Load the true student's embedding
        # NOTE: get_embedder() is called inside get_embedding(), ensuring lazy load
        true_emb = np.load(expected_path)
        
        best_dist = 1.0
        
        # OPTIMIZATION: Limit processing to speed up attendance
        # If we captured 100 frames, processing all takes 30-40s.
        # We only need to check a few frames to confirm identity.
        MAX_FACES_TO_CHECK = 5
        if len(faces) > MAX_FACES_TO_CHECK:
             # Pick evenly spaced frames
            indices = np.linspace(0, len(faces) - 1, MAX_FACES_TO_CHECK, dtype=int)
            faces = [faces[i] for i in indices]

        # Compare every detected face in the frame with the true student's embedding
        # We want to find if ANY face in the frame matches the student
        VERIFICATION_THRESHOLD = 0.38
        for face in faces:
            # Get embedding of the face in front of camera
            current_emb = get_embedding(face)
            
            # Calculate distance
            dist = cosine_distance(current_emb, true_emb)
            
            # Keep the lowest distance found (best match)
            if dist < best_dist:
                best_dist = dist

            # EARLY EXIT OPTIMIZATION:
            # If we find a valid match, stop checking other frames.
            # No need to waste time processing more frames.
            if best_dist < VERIFICATION_THRESHOLD:
                break
        
        # Check lighting quality of the BEST matching face
        # If the best match is too dark, we should warn the user
        # 80 is a safe threshold for "too dark"
        best_face = faces[0] # Simplification: Check first captured face for lighting
        gray_face = cv2.cvtColor(best_face, cv2.COLOR_RGB2GRAY)
        brightness = np.mean(gray_face)

        lighting_status = "ok"
        if brightness < 60:
             lighting_status = "poor (too dark)"
        elif brightness > 200:
             lighting_status = "poor (too bright)"
        
        # BALANCED SECURITY THRESHOLD
        # 0.35 was too strict for bad lighting/angles.
        # 0.38 is the sweet spot (Strict but allows slight variations).
        
        if best_dist < VERIFICATION_THRESHOLD:
            return {"status": "match", "student_id": expected_id, "distance": float(best_dist), "lighting": lighting_status}
        else:
            return {"status": "mismatch", "distance": float(best_dist), "threshold": VERIFICATION_THRESHOLD, "lighting": lighting_status}

    # If searching entire database (Not used in this flow but kept for compatibility)
    else:
        best_id = None
        best_dist = 1.0

        for face in faces:
            emb = get_embedding(face)
            
            for file in os.listdir(EMB_DIR):
                if not file.endswith(".npy"):
                    continue

                sid = file.replace(".npy", "")
                stored_emb = np.load(os.path.join(EMB_DIR, file))
                dist = cosine_distance(emb, stored_emb)

                if dist < best_dist:
                    best_dist = dist
                    best_id = sid
        
        if best_id and best_dist < 0.5:
             return {"status": "match", "student_id": best_id}
        
        return {"status": "unknown"}

# =================================================
# MAIN
# =================================================
if __name__ == "__main__":
    # Redirect stderr to prevent warnings from polluting output
    sys.stderr = open(os.devnull, 'w')
    
    try:
        expected = None
        if len(sys.argv) > 1:
            expected = str(sys.argv[1]).strip()
        result = recognize(expected_id=expected if expected else None)
        
        with open(RESULT_FILE, "w", encoding="utf-8") as f:
            json.dump(result, f)
            
        # Optional: Print result to stdout as well if needed by PHP
        sys.stdout = sys.__stdout__
        print(json.dumps(result))
        
    except Exception as e:
        error_result = {"status": "error", "message": str(e)}
        with open(RESULT_FILE, "w", encoding="utf-8") as f:
            json.dump(error_result, f)
        
        # Restore stdout for error
        sys.stdout = sys.__stdout__
        print(json.dumps(error_result))
