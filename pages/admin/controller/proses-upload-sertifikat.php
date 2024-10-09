<?php
include("../../controller/connection.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judul = $_POST['judul'];
    $tanggal_terbit = $_POST['tanggal_terbit'];
    $file = $_FILES['file'];

    $target_dir = "../../../assets/images/sertifikat/";
    $original_file_name = pathinfo($file["name"], PATHINFO_FILENAME);
    $file_extension = pathinfo($file["name"], PATHINFO_EXTENSION);
    $new_file_name = $original_file_name . '_' . uniqid() . '.' . $file_extension;
    $target_file = $target_dir . $new_file_name;

    $uploadOk = 1;
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if file is a PDF
    if ($fileType != "pdf") {
        $uploadOk = 0;
        echo json_encode(['status' => 'error', 'message' => 'File bukan PDF.']);
        exit();
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo json_encode(['status' => 'error', 'message' => 'File gagal diupload.']);
    } else {
        if (move_uploaded_file($file["tmp_name"], $target_file)) {
            $sql = "INSERT INTO sertifikat (judul, tanggal_terbit, file_name) VALUES ('$judul', '$tanggal_terbit', '$new_file_name')";
            if ($conn->query($sql) === TRUE) {
                echo json_encode(['status' => 'success', 'message' => 'Sertifikat berhasil ditambahkan.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Gagal menambahkan sertifikat ke database.']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Terjadi kesalahan saat mengupload file.']);
        }
    }
}
