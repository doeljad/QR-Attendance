<?php
// Koneksi ke database (ganti dengan koneksi sesuai konfigurasi Anda)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "perusahaan_xyz";

$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi ke database gagal: " . $conn->connect_error);
}
