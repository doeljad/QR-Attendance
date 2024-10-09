<?php
session_start();
include '../../controller/connection.php';
require '../../../assets/vendors/vendor/autoload.php'; // Autoload Composer

use setasign\Fpdi\Fpdi;

$id_user = $_SESSION['id_user'];

// Ambil informasi peserta magang
$query_peserta = "SELECT nama FROM peserta_magang WHERE id_user = $id_user";
$result_peserta = mysqli_query($conn, $query_peserta);

if ($result_peserta && mysqli_num_rows($result_peserta) > 0) {
    $peserta = mysqli_fetch_assoc($result_peserta);
} else {
    die("Peserta tidak ditemukan.");
}

// Ambil informasi sertifikat
$query_sertifikat = "SELECT * FROM sertifikat WHERE id_sertifikat = 12"; // Sesuaikan dengan sertifikat yang diupload
$result_sertifikat = mysqli_query($conn, $query_sertifikat);

if ($result_sertifikat && mysqli_num_rows($result_sertifikat) > 0) {
    $sertifikat = mysqli_fetch_assoc($result_sertifikat);
} else {
    die("Sertifikat tidak ditemukan.");
}

$file_path = '../../../assets/images/sertifikat/' . $sertifikat['file_name'];

if (!file_exists($file_path)) {
    die("File sertifikat tidak ditemukan.");
}

$pdf = new Fpdi();

// Tambahkan halaman dari file sertifikat
$page_count = $pdf->setSourceFile($file_path);
$template_id = $pdf->importPage(1);
$pdf->addPage();
$pdf->useTemplate($template_id, ['adjustPageSize' => true]);

// Set font
$pdf->SetFont('Helvetica', '', 24); // Mengatur ukuran font menjadi lebih besar
$pdf->SetTextColor(255, 255, 255); // Mengatur warna font menjadi putih

// Hitung posisi X agar teks berada di tengah
$page_width = $pdf->GetPageWidth();
$text = $peserta['nama'];
$text_width = $pdf->GetStringWidth($text);
$x = ($page_width - $text_width) / 2;

// Set posisi Y dan tulis teks
$pdf->SetXY($x, 70); // Sesuaikan posisi Y sesuai kebutuhan
$pdf->Write(0, $text);

// Output PDF
$pdf->Output('D', 'Sertifikat-' . $peserta['nama'] . '.pdf');
