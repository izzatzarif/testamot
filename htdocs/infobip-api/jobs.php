<?php
header('Content-Type: application/json');

// API Key yang dibenarkan (dah digenerate secara rawak)
$validApiKey = '2f8ba71eae9c490895c7c6b5f327e9257fc2306c1a1b29c0e60b81ff49cddccf';

// Semak Authorization header
$headers = getallheaders();
$receivedKey = isset($headers['Authorization']) ? $headers['Authorization'] : '';

if ($receivedKey !== 'Bearer ' . $validApiKey) {
    http_response_code(401);
    echo json_encode(["error" => "Unauthorized: Invalid API Key"]);
    exit();
}

// Sambung ke database
$host = "localhost";
$user = "root";
$password = "";
$database = "testinfobip";

$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["error" => "Database connection failed"]);
    exit();
}

// Query jawatan yang status 'open'
$sql = "SELECT position, location FROM jobs WHERE status = 'open'";
$result = $conn->query($sql);

$jobs = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $jobs[] = $row;
    }
} else {
    $jobs[] = ["message" => "Tiada jawatan tersedia buat masa ini"];
}

// Return data sebagai JSON
echo json_encode($jobs);
?>
