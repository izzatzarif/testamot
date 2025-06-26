<?php
header('Content-Type: application/json');

// Sambungan ke database
$host = "localhost";
$user = "root";
$password = ""; // Kosong je
$database = "testinfobip";

// Sambung ke MySQL
$conn = new mysqli($host, $user, $password, $database);

// Semak sambungan
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["error" => "Database connection failed: " . $conn->connect_error]);
    exit();
}

// SQL Query - ambil semua jawatan yang 'open'
$sql = "SELECT position, location FROM jobs WHERE status = 'open'";
$result = $conn->query($sql);

// Simpan data ke dalam array
$jobs = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $jobs[] = $row;
    }
} else {
    $jobs[] = ["message" => "Tiada jawatan tersedia buat masa ini"];
}

// Papar sebagai JSON
echo json_encode($jobs);
?>
