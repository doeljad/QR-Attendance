<?php
include("pages/controller/connection.php");

// Mendapatkan hari saat ini
$hari_ini = date('l'); // Mendapatkan nama hari dalam bahasa Inggris

// Menerjemahkan nama hari dari bahasa Inggris ke bahasa Indonesia
$hari_map = [
    'Monday' => 'Senin',
    'Tuesday' => 'Selasa',
    'Wednesday' => 'Rabu',
    'Thursday' => 'Kamis',
    'Friday' => 'Jumat',
    'Saturday' => 'Sabtu',
    'Sunday' => 'Minggu'
];

$hari_sekarang = $hari_map[$hari_ini];

// Mendapatkan tanggal saat ini
$tanggal_sekarang = date('Y-m-d');

// Query untuk mendapatkan id_peserta dari tabel jadwal berdasarkan hari saat ini
$sql_jadwal = "SELECT id_peserta FROM jadwal WHERE hari = '$hari_sekarang'";
$result_jadwal = $conn->query($sql_jadwal);

if ($result_jadwal->num_rows > 0) {
    // Loop melalui setiap peserta yang ditemukan
    while ($row = $result_jadwal->fetch_assoc()) {
        $id_peserta = $row['id_peserta'];

        // Cek apakah data kehadiran sudah ada untuk id_peserta dan tanggal saat ini
        $sql_cek_kehadiran = "SELECT id_kehadiran FROM kehadiran WHERE id_peserta = '$id_peserta' AND tanggal = '$tanggal_sekarang'";
        $result_cek_kehadiran = $conn->query($sql_cek_kehadiran);

        if ($result_cek_kehadiran->num_rows == 0) {
            // Membuat entri baru dalam tabel kehadiran jika belum ada
            $sql_kehadiran = "INSERT INTO kehadiran (id_peserta, check_in, check_out, tanggal, created_at) VALUES ('$id_peserta', NULL, NULL, '$tanggal_sekarang', CURRENT_TIMESTAMP)";
            $conn->query($sql_kehadiran);
        }
    }
}

// Menutup koneksi
$conn->close();
