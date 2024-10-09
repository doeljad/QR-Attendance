<?php
include("../../controller/connection.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM sertifikat WHERE id_sertifikat = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode($row);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Data sertifikat tidak ditemukan.']);
    }
}
