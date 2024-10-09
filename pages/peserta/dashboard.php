<?php
include("pages/controller/connection.php");
// session_start();
$id_user = $_SESSION['id_user'];

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

// Mengambil data untuk setiap card
$dataHadir = hitungData($conn, 'peserta_magang', "RIGHT JOIN kehadiran k ON peserta_magang.id_peserta = k.id_peserta AND k.check_in IS NOT NULL AND k.check_out IS NOT NULL 
    WHERE peserta_magang.id_user = '$id_user'");
$dataBelumSelesai = hitungData(
    $conn,
    'peserta_magang pm',
    "JOIN jadwal j ON pm.id_peserta = j.id_peserta 
LEFT JOIN kehadiran k ON j.id_peserta = k.id_peserta  WHERE pm.id_user = '$id_user' AND (k.check_out IS NULL OR k.check_out = '') AND CURRENT_TIME() > j.waktu_selesai"
);

// Query untuk data tidak hadir
$sqlTidakHadir = "
    SELECT COUNT(*) as total 
    FROM peserta_magang pm
    JOIN jadwal j ON pm.id_peserta = j.id_peserta
    RIGHT JOIN kehadiran k ON j.id_peserta = k.id_peserta AND k.tanggal = CURDATE()
    WHERE pm.id_user = '$id_user'
    AND j.hari = '$currentDay'
    AND k.check_in IS NULL";


// Query untuk data tepat waktu dan terlambat
$sqlTepatWaktu = "
    SELECT COUNT(*) as total 
    FROM kehadiran k
    JOIN jadwal j ON k.id_peserta = j.id_peserta
    JOIN peserta_magang pm ON j.id_peserta = pm.id_peserta
    WHERE k.tanggal = CURDATE()
    AND pm.id_user = '$id_user'
    AND k.check_in <= j.waktu_mulai";

$sqlTerlambat = "
    SELECT COUNT(*) as total 
    FROM kehadiran k
    JOIN jadwal j ON k.id_peserta = j.id_peserta
    JOIN peserta_magang pm ON j.id_peserta = pm.id_peserta
    WHERE k.tanggal = CURDATE()
    AND pm.id_user = '$id_user'
    AND k.check_in > j.waktu_mulai";

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
                                <h2 class="mb-0"><?php echo $dataHadir; ?></h2>
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
                    <h5>Tidak Hadir</h5>
                    <div class="row">
                        <div class="col-8 col-sm-12 col-xl-8 my-auto">
                            <div class="d-flex d-sm-block d-md-flex align-items-center">
                                <h2 class="mb-0"><?php echo $dataTidakHadir; ?></h2>
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
                    <h5>Tepat Waktu</h5>
                    <div class="row">
                        <div class="col-8 col-sm-12 col-xl-8 my-auto">
                            <div class="d-flex d-sm-block d-md-flex align-items-center">
                                <h2 class="mb-0"><?php echo $dataTepatWaktu; ?></h2>
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
                    <h5>Terlambat</h5>
                    <div class="row">
                        <div class="col-8 col-sm-12 col-xl-8 my-auto">
                            <div class="d-flex d-sm-block d-md-flex align-items-center">
                                <h2 class="mb-0"><?php echo $dataTerlambat; ?></h2>
                            </div>
                        </div>
                        <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                            <i class="icon-lg mdi mdi-clock-alert-outline text-warning ms-auto"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        if ($dataBelumSelesai == 1) {
        ?>
            <div class="col-sm-8 grid-margin justify-content-center">
                <div class="card bg-danger">
                    <div class="card-body">
                        <h3>Waktu magang anda masih berlanjut, Anda belum melakukan checkout, silahkan melakukan scan QR terlebih dahulu!</h3>
                    </div>
                </div>
            </div>
        <?php
        }
        ?>


    </div>
</div>

<?php
// Tutup koneksi
$conn->close();
?>