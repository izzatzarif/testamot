<?php
header('Content-Type: application/json');

// Dapatkan Authorization header dari request
$headers = getallheaders();
$apiKey = isset($headers['Authorization']) ? $headers['Authorization'] : '';

// API key sebenar
$validKey = 'amotuV1feCcVomSDuIBb92DQd60uUN4wCVgA';

// Semak API key
if ($apiKey !== 'Bearer ' . $validKey) {
    http_response_code(401);
    echo json_encode(["error" => "Unauthorized: Invalid API Key"]);
    exit();
}

// Sambungan ke database
$host = "localhost";
$user = "root";
$password = ""; // kosong je
$database = "testinfobip";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["error" => "Database connection failed"]);
    exit();
}

$sql = "SELECT position, location FROM jobs WHERE status = 'open'";
$result = $conn->query($sql);

$jobs = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $jobs[] = $row;
    }
} else {
    $jobs[] = ["message" => "Tiada jawatan tersedia buat masa ini"];
}

echo json_encode($jobs);
?>
