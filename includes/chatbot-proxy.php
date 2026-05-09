<?php
// Headers set karna zaroori hai - CORS aur JSON Format ke liye
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

require 'security.php';
require_once 'config.php';

// Security/session bootstrap.
start_secure_session();
// Apply security headers for this request.
send_security_headers();
// User ka naam session se nikalo, nahi to 'Student' use karo
$userName = isset($_SESSION['username']) ? $_SESSION['username'] : "Student";

// Input JSON decode karo
$input = json_decode(file_get_contents("php://input"), true);
$csrf = $input['csrf_token'] ?? '';
if (!verify_csrf_token($csrf)) {
    echo json_encode(["reply" => "Invalid request."]);
    exit;
}
$userMessage = trim($input['prompt'] ?? '');

// Agar message khali hai to yahi se wapas bhej do
if (empty($userMessage)) {
    echo json_encode(["reply" => "Please type something!"]);
    exit;
}

// --- API CONFIGURATION ---
// Using centralized API key from config.php
$apiKey = defined('GEMINI_API_KEY') ? GEMINI_API_KEY : $GLOBALS['gemini_api_key']; 

// ? FIX: Wahi Model use kiya jo Exam file me hai (gemini-flash-latest)
$apiUrl = "https://generativelanguage.googleapis.com/v1beta/models/gemini-flash-latest:generateContent?key=$apiKey";

// --- SMART PROMPT (AI Instruction) ---
$systemInstruction = "
You are a friendly and helpful Computer Science Assistant for a Class Management System. 
Your user's name is '$userName'.

RULES:
1. If the user greets you (hi, hello), reply: 'Hello $userName! I am your IT Assistant. Ask me anything about computers, coding, or technology.'
2. If the user asks a question related to Computers, Programming, IT, Hardware, Software, Math, or Logic, answer it clearly and concisely.
3. If the question is completely unrelated (e.g., cooking, sports, movies), politely refuse: 'Sorry $userName, I can only answer computer-related questions.'
4. Format your answer nicely using bullet points or bold text where necessary.
";

// Payload banana (Request Body)
$body = [
    "contents" => [[
        "parts" => [[ 
            "text" => $systemInstruction . "\n\nUser Question: " . $userMessage 
        ]]
    ]]
];

// cURL Request Setup
$ch = curl_init($apiUrl);
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_HTTPHEADER => ["Content-Type: application/json"],
    CURLOPT_POSTFIELDS => json_encode($body),
    CURLOPT_SSL_VERIFYPEER => false // Localhost SSL Error fix
]);

$apiResponse = curl_exec($ch);

// Agar connection me koi error aaye
if (curl_errno($ch)) {
    echo json_encode(["reply" => "Connection Error: " . curl_error($ch)]);
    exit;
}
curl_close($ch);

// Response Decode karo
$decoded = json_decode($apiResponse, true);

// ? Check karo ki answer aaya ya error
if (isset($decoded['candidates'][0]['content']['parts'][0]['text'])) {
    $aiReply = $decoded['candidates'][0]['content']['parts'][0]['text'];
    echo json_encode(["reply" => $aiReply]);
} else {
    // Agar Google ne error bheja hai, to wo dikhao
    if(isset($decoded['error'])) {
        $errorMsg = $decoded['error']['message'];
        echo json_encode(["reply" => "API Error: " . $errorMsg]);
    } else {
        echo json_encode(["reply" => "Sorry, I didn't get a valid response. Try asking differently."]);
    }
}
?>
