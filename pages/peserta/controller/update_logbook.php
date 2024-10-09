<?php
include("../../controller/connection.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_logbook = $_POST['id_logbook'];
    $tanggal = $_POST['tanggal'];
    $kegiatan = $_POST['kegiatan'];
    $catatan = $_POST['catatan'];
    $waktu_mulai = $_POST['waktu_mulai'];
    $waktu_selesai = $_POST['waktu_selesai'];

    $sql = "UPDATE logbook SET tanggal = ?, kegiatan = ?, catatan = ?, waktu_mulai = ?, waktu_selesai = ? WHERE id_logbook = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $tanggal, $kegiatan, $catatan, $waktu_mulai, $waktu_selesai, $id_logbook);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Logbook berhasil diperbarui.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Gagal memperbarui logbook.']);
    }

    $stmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Metode permintaan tidak valid.']);
}

$conn->close();
