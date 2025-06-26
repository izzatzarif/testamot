<?php
header('Content-Type: application/json');

// Sambungan ke database
$conn = new mysqli("localhost", "", "", "testinfobip");

// Semak sambungan
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["error" => "Database connection failed"]);
    exit();
}

// Ambil jawatan yang status 'open'
$result = $conn->query("SELECT position, location FROM jobs WHERE status='open'");

$jobs = [];
while($row = $result->fetch_assoc()) {
    $jobs[] = $row;
}

echo json_encode($jobs);
?>
