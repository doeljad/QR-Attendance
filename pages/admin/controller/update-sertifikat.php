<?php
include("../../controller/connection.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_sertifikat = $_POST['id_sertifikat'];
    $judul = $_POST['judul'];
    $tanggal_terbit = $_POST['tanggal_terbit'];
    $file = isset($_FILES['file']) ? $_FILES['file'] : null;

    if ($file) {
        $target_dir = "../../../assets/images/sertifikat/";
        $target_file = $target_dir . basename($file["name"]);
        $base_name = basename($file["name"]);
        $uploadOk = 1;
        $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if file is a PDF
        if ($fileType != "pdf") {
            $uploadOk = 0;
            echo json_encode(['status' => 'error', 'message' => 'File bukan PDF.']);
            exit();
        }

        if ($uploadOk == 1 && move_uploaded_file($file["tmp_name"], $target_file)) {
            $sql = "UPDATE sertifikat SET judul = '$judul', tanggal_terbit = '$tanggal_terbit', file_name = '$base_name' WHERE id_sertifikat = $id_sertifikat";
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Terjadi kesalahan saat mengupload file.']);
            exit();
        }
    } else {
        $sql = "UPDATE sertifikat SET judul = '$judul', tanggal_terbit = '$tanggal_terbit' WHERE id_sertifikat = $id_sertifikat";
    }

    if ($conn->query($sql) === TRUE) {
        echo json_encode(['status' => 'success', 'message' => 'Sertifikat berhasil diperbarui.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Gagal memperbarui sertifikat.']);
    }
}
