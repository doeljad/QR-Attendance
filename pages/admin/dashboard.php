<?php
include("pages/controller/connection.php");

function hitungData($conn, $table, $where = '')
{
    $sql = "SELECT COUNT(*) as total FROM $table $where";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['total'];
    } else {
        return 0;
    }
}

// Fungsi untuk mendapatkan hari dalam format ENUM
function getDayName($dayNumber)
{
    $days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
    return $days[$dayNumber];
}

$currentDay = getDayName(date('w'));

// Menghitung total pesera magang
$pesertaMagang = hitungData($conn, 'peserta_magang');
// Mengambil data untuk setiap card
$dataHadir = hitungData($conn, 'kehadiran k', "WHERE tanggal = CURDATE() AND k.check_in IS NOT NULL ");
$dataSelesai = hitungData($conn, 'kehadiran', "WHERE tanggal = CURDATE() AND check_in IS NOT NULL AND check_out IS NOT NULL");
$dataBelumSelesai = hitungData($conn, 'kehadiran', "WHERE tanggal = CURDATE() AND check_in IS NOT NULL AND check_out IS NULL");

// Query untuk data tidak hadir
$sqlJadwalHariIni = "
    SELECT COUNT(*) as total 
    FROM jadwal j
    LEFT JOIN kehadiran k ON j.id_peserta = k.id_peserta AND k.tanggal = CURDATE()
    WHERE j.hari = '$currentDay'";


// Query untuk data tidak hadir
$sqlTidakHadir = "
    SELECT COUNT(*) as total 
    FROM jadwal j
    LEFT JOIN kehadiran k ON j.id_peserta = k.id_peserta AND k.tanggal = CURDATE()
    WHERE j.hari = '$currentDay' 
    AND (k.check_in IS NULL AND k.check_in IS NULL)";



// Query untuk data tepat waktu dan terlambat
$sqlTepatWaktu = "
    SELECT COUNT(*) as total 
    FROM kehadiran k
    JOIN jadwal j ON k.id_peserta = j.id_peserta
    WHERE k.tanggal = CURDATE()
    AND k.check_in <= j.waktu_mulai";

$sqlTerlambat = "
    SELECT COUNT(*) as total 
    FROM kehadiran k
    JOIN jadwal j ON k.id_peserta = j.id_peserta
    WHERE k.tanggal = CURDATE()
    AND k.check_in > j.waktu_mulai";

$resultJadwalHariIni = $conn->query($sqlJadwalHariIni);
$dataJadwalHariIni = $resultJadwalHariIni && $resultJadwalHariIni->num_rows > 0 ? $resultJadwalHariIni->fetch_assoc()['total'] : 0;

$resultTidakHadir = $conn->query($sqlTidakHadir);
$dataTidakHadir = $resultTidakHadir && $resultTidakHadir->num_rows > 0 ? $resultTidakHadir->fetch_assoc()['total'] : 0;

$resultTepatWaktu = $conn->query($sqlTepatWaktu);
$dataTepatWaktu = $resultTepatWaktu && $resultTepatWaktu->num_rows > 0 ? $resultTepatWaktu->fetch_assoc()['total'] : 0;

$resultTerlambat = $conn->query($sqlTerlambat);
$dataTerlambat = $resultTerlambat && $resultTerlambat->num_rows > 0 ? $resultTerlambat->fetch_assoc()['total'] : 0;

?>
<div class="content-wrapper">
    <div class="row">
        <div class="col-sm-4 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h5>Hadir</h5>
                    <div class="row">
                        <div class="col-8 col-sm-12 col-xl-8 my-auto">
                            <div class="d-flex d-sm-block d-md-flex align-items-center">
                                <h2 class="mb-0"><?= $dataHadir; ?></h2>
                            </div>
                        </div>
                        <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                            <i class="icon-lg mdi mdi-checkbox-marked-circle text-primary ms-auto"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h5>Selesai</h5>
                    <div class="row">
                        <div class="col-8 col-sm-12 col-xl-8 my-auto">
                            <div class="d-flex d-sm-block d-md-flex align-items-center">
                                <h2 class="mb-0"><?= $dataSelesai; ?></h2>
                            </div>
                        </div>
                        <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                            <i class="icon-lg mdi mdi-check-circle-outline text-success ms-auto"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-4 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h5>Tepat Waktu</h5>
                    <div class="row">
                        <div class="col-8 col-sm-12 col-xl-8 my-auto">
                            <div class="d-flex d-sm-block d-md-flex align-items-center">
                                <h2 class="mb-0"><?= $dataTepatWaktu; ?></h2>
                            </div>
                        </div>
                        <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                            <i class="icon-lg mdi mdi-clock-check-outline text-success ms-auto"></i>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h5>Tidak Hadir</h5>
                    <div class="row">
                        <div class="col-8 col-sm-12 col-xl-8 my-auto">
                            <div class="d-flex d-sm-block d-md-flex align-items-center">
                                <h2 class="mb-0"><?= $dataTidakHadir; ?></h2>
                            </div>
                        </div>
                        <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                            <i class="icon-lg mdi mdi-close-circle-outline text-danger ms-auto"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h5>Terlambat</h5>
                    <div class="row">
                        <div class="col-8 col-sm-12 col-xl-8 my-auto">
                            <div class="d-flex d-sm-block d-md-flex align-items-center">
                                <h2 class="mb-0"><?= $dataTerlambat; ?></h2>
                            </div>
                        </div>
                        <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                            <i class="icon-lg mdi mdi-clock-alert-outline text-warning ms-auto"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h5>Belum Selesai</h5>
                    <div class="row">
                        <div class="col-8 col-sm-12 col-xl-8 my-auto">
                            <div class="d-flex d-sm-block d-md-flex align-items-center">
                                <h2 class="mb-0"><?= $dataBelumSelesai; ?></h2>
                            </div>
                        </div>
                        <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                            <i class="icon-lg mdi mdi-progress-clock text-warning ms-auto"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h5>Jadwal Peserta Hari Ini</h5>
                    <div class="row">
                        <div class="col-8 col-sm-12 col-xl-8 my-auto">
                            <div class="d-flex d-sm-block d-md-flex align-items-center">
                                <h2 class="mb-0"><?= $dataJadwalHariIni; ?></h2>
                            </div>
                        </div>
                        <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                            <i class="icon-lg mdi mdi-account-group-outline text-primary ms-auto"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-4 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h5>Peserta Magang</h5>
                    <div class="row">
                        <div class="col-8 col-sm-12 col-xl-8 my-auto">
                            <div class="d-flex d-sm-block d-md-flex align-items-center">
                                <h2 class="mb-0"><?= $pesertaMagang; ?></h2>
                            </div>
                        </div>
                        <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                            <i class="icon-lg mdi mdi-account-group-outline text-primary ms-auto"></i>
                        </div>
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