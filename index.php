<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Perusahaan XYZ</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/5.3.45/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="shortcut icon" href="assets/images/favicon.png" />
  <style>
    @media (max-width: 470px) {
      .qr-text {
        display: none;
      }
    }

    /* Menyembunyikan teks pada layar di bawah 470px */
    @media (max-width: 470px) {
      .scan-text {
        display: none;
      }
    }
  </style>
</head>

<body>

  <?php
  session_start();
  date_default_timezone_set('Asia/Jakarta');
  function getDayNameIndonesia($tanggal)
  {
    // Pisahkan tanggal menjadi komponen hari, bulan, dan tahun
    $tgl_arr = explode('-', $tanggal);
    $tahun = $tgl_arr[0];
    $bulan = $tgl_arr[1];
    $hari = $tgl_arr[2];

    // Buat array nama-nama hari dalam bahasa Indonesia
    $nama_hari = array(
      'Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'
    );

    // Ambil nama hari berdasarkan tanggal yang diberikan
    $nama_hari_ini = date('w', mktime(0, 0, 0, $bulan, $hari, $tahun));

    // Return nama hari dalam bahasa Indonesia
    return $nama_hari[$nama_hari_ini];
  }
  // Memeriksa apakah pengguna sudah login
  if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    // Menampilkan pesan selamat datang

    // Memeriksa role dan memuat konten yang sesuai
    if ($_SESSION['role'] == '1') {
      include('pages/admin/index.php');
    } else {
      include('pages/peserta/index.php');
    }
  } else {
    // Jika tidak ada session, arahkan ke halaman login
    header("Location: login.php");
    exit();
  }
  ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.8/html5-qrcode.min.js" integrity="sha512-r6rDA7W6ZeQhvl8S7yRVQUKVHdexq+GAlNkNNqVC7YyIV+NwqCTJe2hDWCiffTyRNOeGEzRRJ9ifvRm/HCzGYg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

  <script>
    // Generate QR COde
    import {
      QRCode
    } from 'https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js';
    // an SVG image as base64 data URI will be returned by default
    let qrcode = (new QRCode()).render('https://www.youtube.com/watch?v=dQw4w9WgXcQ');

    // append it to the DOM
    let img = document.createElement('img');
    img.alt = 'QRCode';
    img.src = qrcode
    document.getElementById('qrcode-container').appendChild(img);

    let currentUrl = window.location.href;
    let navLinks = document.querySelectorAll('.nav-link');

    navLinks.forEach(link => {
      let linkUrl = link.getAttribute('href');
      if (currentUrl.includes(linkUrl)) {
        link.parentNode.classList.add('active');
        let collapseLink = link.closest('.collapse').previousElementSibling;
        if (collapseLink && !collapseLink.classList.contains('active')) {
          collapseLink.classList.add('active');
        }
      }
    });
  </script>
</body>

</html>