<?php
include("../../controller/connection.php");

// Query untuk mengambil password terbaru
$sql = "SELECT password FROM qr_code ORDER BY updated_at DESC LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode(['status' => 'success', 'password' => $row['password']]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'No data found']);
}

$conn->close();
