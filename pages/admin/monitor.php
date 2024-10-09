<?php

include("pages/controller/connection.php");

// Fungsi untuk mendapatkan nama hari
function getDayName($dayNumber)
{
    $days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
    return $days[$dayNumber];
}

$currentDay = getDayName(date('w'));

// Query untuk data tidak hadir
$sqlTidakHadir = "
    SELECT *, j.id_peserta
    FROM jadwal j
    LEFT JOIN kehadiran k ON j.id_peserta = k.id_peserta AND k.tanggal = CURDATE()
    INNER JOIN peserta_magang pm ON pm.id_peserta=j.id_peserta
    WHERE j.hari = '$currentDay' 
    AND (k.check_in IS NULL OR k.check_in IS NULL)";

// Query untuk data tepat waktu dan terlambat
$sqlTepatWaktu = "
    SELECT * 
    FROM kehadiran k
    JOIN jadwal j ON k.id_peserta = j.id_peserta
    INNER JOIN peserta_magang pm ON pm.id_peserta=k.id_peserta
    WHERE k.tanggal = CURDATE()
    AND k.check_in <= j.waktu_mulai
    AND j.hari = '$currentDay'";

$sqlTerlambat = "
    SELECT * 
    FROM kehadiran k
    JOIN jadwal j ON k.id_peserta = j.id_peserta
    INNER JOIN peserta_magang pm ON pm.id_peserta=k.id_peserta
    WHERE k.tanggal = CURDATE()
    AND k.check_in > j.waktu_mulai
    AND j.hari = '$currentDay'";

$resultTidakHadir = $conn->query($sqlTidakHadir);
$dataTidakHadir = $resultTidakHadir && $resultTidakHadir->num_rows > 0 ? $resultTidakHadir->fetch_assoc() : 0;

$resultTepatWaktu = $conn->query($sqlTepatWaktu);
$dataTepatWaktu = $resultTepatWaktu && $resultTepatWaktu->num_rows > 0 ? $resultTepatWaktu->fetch_assoc() : 0;

$resultTerlambat = $conn->query($sqlTerlambat);
$dataTerlambat = $resultTerlambat && $resultTerlambat->num_rows > 0 ? $resultTerlambat->fetch_assoc() : 0;

// Fungsi untuk mendapatkan data logbook berdasarkan page
function getDataKehadiran($conn, $query)
{
    $result = $conn->query($query);
    return $result;
}

// Menentukan query berdasarkan nilai parameter 'page'
$page = isset($_GET['page']) ? $_GET['page'] : 'monitor';

switch ($page) {
    case 'monitor-hadir':
        $monitor = "Hadir";
        $query = "SELECT * FROM kehadiran k INNER JOIN peserta_magang pm ON pm.id_peserta=k.id_peserta JOIN jadwal j ON k.id_peserta = j.id_peserta WHERE tanggal = CURDATE() AND j.hari = '$currentDay' AND k.check_in IS NOT NULL ";
        break;
    case 'monitor-selesai':
        $monitor = "Selesai";
        $query = "SELECT * FROM kehadiran k INNER JOIN peserta_magang pm ON pm.id_peserta=k.id_peserta JOIN jadwal j ON k.id_peserta = j.id_peserta WHERE tanggal = CURDATE() AND check_in IS NOT NULL AND check_out IS NOT NULL AND j.hari = '$currentDay'";
        break;
    case 'monitor-belum-selesai':
        $monitor = "Belum Selesai";
        $query = "SELECT * FROM kehadiran k INNER JOIN peserta_magang pm ON pm.id_peserta=k.id_peserta JOIN jadwal j ON k.id_peserta = j.id_peserta WHERE tanggal = CURDATE() AND check_in IS NOT NULL AND check_out IS NULL AND j.hari = '$currentDay'";
        break;
    case 'monitor-tidak-hadir':
        $monitor = "Tidak Hadir";
        $query = $sqlTidakHadir;
        break;
    case 'monitor-terlambat':
        $monitor = "Terlambat";
        $query = $sqlTerlambat;
        break;
    case 'monitor-tepat-waktu':
        $monitor = "Tepat Waktu";
        $query = $sqlTepatWaktu;
        break;
    default:
        $query = "SELECT * FROM kehadiran";
}

$dataKehadiran = getDataKehadiran($conn, $query);

?>
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title"> Monitor <?= $monitor; ?></h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">Home</li>
                <li class="breadcrumb-item"><a href="?page=monitor">Monitor <?= $monitor; ?></a></li>
            </ol>
        </nav>
    </div>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body ">
                    <h4 class="card-title">Data Monitor <?= $monitor; ?></h4>
                    <div class="table-responsive ">
                        <table class="table table-bordered text-light">
                            <thead>
                                <tr>
                                    <th> No </th>
                                    <th> Nama </th>
                                    <th> Jadwal Masuk </th>
                                    <th> Jam Masuk </th>
                                    <th> Jam Keluar </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                if ($dataKehadiran->num_rows > 0) {
                                    while ($row = $dataKehadiran->fetch_assoc()) {
                                ?>
                                        <tr>
                                            <td><?= $no ?></td>
                                            <td><?= $row['nama']; ?></td>
                                            <td><?= $row['waktu_mulai']; ?></td>
                                            <td><?= $row['check_in']; ?></td>
                                            <td><?= $row['check_out']; ?></td>
                                        </tr>
                                    <?php
                                        $no++;
                                    }
                                } else {
                                    ?>
                                    <tr>
                                        <td colspan="7" class="text-center">Tidak Ada Data Monitor <?= $monitor; ?> Saat Ini.</td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
// Tutup koneksi
$conn->close();
?>