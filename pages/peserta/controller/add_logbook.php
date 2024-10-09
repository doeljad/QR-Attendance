<?php
include("../../controller/connection.php");
session_start();
$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tanggal = $_POST['tanggal'];
    $kegiatan = $_POST['kegiatan'];
    $catatan = $_POST['catatan'];
    $waktu_mulai = $_POST['waktu_mulai'];
    $waktu_selesai = $_POST['waktu_selesai'];
    $id_peserta = $_SESSION['id_user']; // Pastikan id_user disimpan di sesi saat login

    // Get id_peserta based on id_user
    $stmt = $conn->prepare("SELECT id_peserta FROM peserta_magang WHERE id_user = ?");
    $stmt->bind_param("s", $id_peserta);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $id_peserta = $user['id_peserta'];

        // Insert data into logbook table
        $stmt = $conn->prepare("INSERT INTO logbook (id_peserta, tanggal, kegiatan, catatan, waktu_mulai, waktu_selesai) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssss", $id_peserta, $tanggal, $kegiatan, $catatan, $waktu_mulai, $waktu_selesai);
        if ($stmt->execute()) {
            $response['status'] = 'success';
            $response['message'] = 'Logbook berhasil ditambahkan';
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Gagal menambahkan logbook: ' . $stmt->error;
        }
    } else {
        $response['status'] = 'error';
        $response['message'] = 'User tidak ditemukan';
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'Metode request tidak valid';
}

echo json_encode($response);

$conn->close();
