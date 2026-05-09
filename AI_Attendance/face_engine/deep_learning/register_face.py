# =================================================
# FACE REGISTRATION SCRIPT (OPTIMIZED - LAZY LOAD)
# =================================================

import os
import sys

# SUPPRESS ALL TENSORFLOW WARNINGS & LOGS
os.environ["TF_CPP_MIN_LOG_LEVEL"] = "3"
os.environ["CUDA_VISIBLE_DEVICES"] = "-1"

import warnings
warnings.filterwarnings('ignore')

# Suppress stdout/stderr before importing heavy libs
import io
import logging

# Disable all logging
logging.disable(logging.CRITICAL)

# Redirect stdout/stderr temporarily
devnull = open(os.devnull, 'w')
old_stdout = sys.stdout
old_stderr = sys.stderr
sys.stdout = devnull
sys.stderr = devnull

# Import light libraries
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
os.makedirs(EMB_DIR, exist_ok=True)

# =================================================
# GLOBAL VARS (LAZY LOADING)
# =================================================
detector = None
embedder = None

# =================================================
# PARAMETERS
# =================================================
CAPTURE_SECONDS = 6
MIN_FACE_SIZE = 80

# =================================================
# LAZY LOADER
# =================================================
def get_embedder():
    global embedder
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
        
        sys.stdout = old_stdout
        devnull.close()
        
        embedder = FaceNet()
    return embedder

def get_mtcnn():
    global detector
    if detector is None:
        from mtcnn import MTCNN
        detector = MTCNN()
    return detector

# =================================================
# AUTO CAMERA DETECTION
# =================================================
def get_working_camera(max_index=5):
    for i in range(max_index):
        try:
            cap = cv2.VideoCapture(i, cv2.CAP_DSHOW)
            if cap.isOpened():
                for attempt in range(5):
                    ret, frame = cap.read()
                    if ret and frame is not None and frame.size > 0:
                        if np.mean(frame) > 10:
                            cap.release()
                            return i
                cap.release()
        except:
            pass
    return None

# =================================================
# FACE REGISTRATION FUNCTION
# =================================================
def register_face(student_id):

    # 1. Use Haar Cascade for FAST startup (Lightweight)
    detector_path = cv2.data.haarcascades + 'haarcascade_frontalface_default.xml'
    face_cascade = cv2.CascadeClassifier(detector_path)

    # OPTIMIZATION: Start loading AI model in background thread
    loading_thread = threading.Thread(target=get_embedder)
    loading_thread.start()

    cam_index = get_working_camera()
    if cam_index is None:
        return {"status": "error", "message": "No working camera found"}

    cap = cv2.VideoCapture(cam_index, cv2.CAP_DSHOW)
    if not cap.isOpened():
        return {"status": "error", "message": "Camera not accessible"}

    # Set camera properties
    # Set camera properties
    cap.set(cv2.CAP_PROP_FRAME_WIDTH, 640)
    cap.set(cv2.CAP_PROP_FRAME_HEIGHT, 480)
    cap.set(cv2.CAP_PROP_FPS, 30)

    cv2.namedWindow("Register Face", cv2.WINDOW_NORMAL)
    cv2.resizeWindow("Register Face", 960, 540)
    # FORCE WINDOW ON TOP
    cv2.setWindowProperty("Register Face", cv2.WND_PROP_TOPMOST, 1)

    collected_bgr = []
    start = time.time()
    black_frame_count = 0

    # 2. Capture Loop (Fast - No heavy AI here)
    while time.time() - start < CAPTURE_SECONDS:
        ret, frame = cap.read()
        if not ret or frame is None:
            continue

        if np.mean(frame) < 10:
            black_frame_count += 1
            if black_frame_count > 10:
                break
            continue
        
        black_frame_count = 0

        gray = cv2.cvtColor(frame, cv2.COLOR_BGR2GRAY)
        faces = face_cascade.detectMultiScale(gray, 1.1, 4)

        for (x, y, w, h) in faces:
            if w < MIN_FACE_SIZE or h < MIN_FACE_SIZE:
                continue

            # Collect face (Keep in BGR for display, store for processing)
            face = frame[y:y+h, x:x+w]
            collected_bgr.append(face)

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

        cv2.imshow("Register Face", frame)
        key = cv2.waitKey(1)
        if key == 27:  # ESC to quit
            break

    cap.release()
    cv2.destroyAllWindows()
    cv2.waitKey(100) # Ensure window closes

    if len(collected_bgr) == 0:
        return {"status": "error", "message": "No face captured"}

    # 3. Post-Process (Load heavy AI now)
    # User sees window close, now we process in background
    
    # Wait for background load to finish
    loading_thread.join()

    # OPTIMIZATION: Limit frames to process
    # Processing 100+ frames is slow. We only need ~10 good frames.
    MAX_FRAMES_TO_PROCESS = 15
    if len(collected_bgr) > MAX_FRAMES_TO_PROCESS:
        # Pick evenly spaced frames
        indices = np.linspace(0, len(collected_bgr) - 1, MAX_FRAMES_TO_PROCESS, dtype=int)
        collected_bgr = [collected_bgr[i] for i in indices]

    emb_model = get_embedder()
    
    embeddings = []
    for face_bgr in collected_bgr:
        # Convert to RGB for FaceNet
        face_rgb = cv2.cvtColor(face_bgr, cv2.COLOR_BGR2RGB)
        face_resized = cv2.resize(face_rgb, (160, 160))
        face_float = face_resized.astype("float32")
        
        emb = emb_model.embeddings([face_float])[0]
        embeddings.append(emb)

    if not embeddings:
         return {"status": "error", "message": "Processing failed"}

    # Average embeddings for stability
    final_embedding = np.mean(embeddings, axis=0)

    out_file = os.path.join(EMB_DIR, f"{student_id}.npy")
    np.save(out_file, final_embedding)

    return {
        "status": "success",
        "student_id": student_id,
        "file": f"{student_id}.npy"
    }

# =================================================
# MAIN (STDOUT JSON ONLY)
# =================================================
if __name__ == "__main__":
    # Redirect stderr to prevent warnings from polluting output
    sys.stderr = open(os.devnull, 'w')

    if len(sys.argv) < 2:
        # Restore stdout specifically for this print
        sys.stdout = sys.__stdout__
        print(json.dumps({
            "status": "error",
            "message": "Student ID missing"
        }))
        sys.exit(1)

    student_id = sys.argv[1]
    
    try:
        result = register_face(student_id)
        
        # Restore stdout specifically for result
        sys.stdout = sys.__stdout__
        print(json.dumps(result))
        
    except Exception as e:
        # Restore stdout specifically for error
        sys.stdout = sys.__stdout__
        print(json.dumps({
            "status": "error",
            "message": str(e)
        }))
