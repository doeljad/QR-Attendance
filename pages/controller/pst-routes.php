<?php
// Periksa apakah URL hanya "/index.php" tanpa parameter
if (!isset($_GET['page'])) {
    // Redirect ke "/index.php?page=dashboard"
    echo "<script>window.location.href = 'index.php?page=dashboard'</script>";
    exit(); // Hentikan eksekusi skrip setelah melakukan redirect
}
// Ambil parameter dari URL
$params = isset($_GET['page']) ? $_GET['page'] : 'dashboard';

// Definisikan route
$routes = [
    // Login 
    'login' => 'login.php',

    // Peserta
    'dashboard' => 'pages/peserta/dashboard.php',
    'logbook' => 'pages/peserta/logbook.php',
    'kehadiran' => 'pages/peserta/kehadiran.php',
    'sertifikat' => 'pages/peserta/sertifikat.php',
];

// Periksa apakah URL ada di route
if (isset($routes[$params])) {
    // Tentukan halaman yang akan dimuat
    $page = $routes[$params];
    // Include halaman yang sesuai
    include_once($page);
} else {
    // Jika URL tidak ada di route, redirect ke halaman 404 atau halaman lain yang sesuai
    echo "<script>window.location.href = 'pages/template/error-404.html'</script>";
    exit(); // Penting untuk menghentikan eksekusi skrip setelah melakukan redirect
}
