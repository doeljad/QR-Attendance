<?php
include("../../controller/connection.php");
// Buat password baru
date_default_timezone_set('Asia/Jakarta');
$newPassword = bin2hex(random_bytes(64)); // Contoh password random

// Dapatkan waktu sekarang
$updatedAt = date('Y-m-d H:i:s');

// Query untuk memperbarui tabel qr_code
$sql = "UPDATE qr_code SET password='$newPassword', updated_at='$updatedAt'";

if ($conn->query($sql) === TRUE) {
    echo json_encode(['status' => 'success', 'password' => $newPassword, 'updated_at' => $updatedAt]);
} else {
    echo json_encode(['status' => 'error', 'message' => $conn->error]);
}

$conn->close();
