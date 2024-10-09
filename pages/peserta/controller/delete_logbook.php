<?php
include("../../controller/connection.php");

if (isset($_GET['id'])) {
    $id_logbook = $_GET['id'];
    $sql = "DELETE FROM logbook WHERE id_logbook = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_logbook);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Logbook berhasil dihapus.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus logbook.']);
    }

    $stmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'ID logbook tidak disediakan.']);
}

$conn->close();
