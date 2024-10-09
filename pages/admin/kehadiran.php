<?php
include("pages/controller/connection.php");

// Query untuk mengambil data kehadiran
$sql = "SELECT 
    k.id_kehadiran, 
    k.id_peserta, 
    k.check_in, 
    k.check_out, 
    k.tanggal, 
    pm.nama, 
    j.waktu_mulai,
    CASE
        WHEN k.check_in <= j.waktu_mulai THEN 'Tepat Waktu'
        WHEN k.check_in > j.waktu_mulai THEN 
            CASE 
                WHEN TIMESTAMPDIFF(MINUTE, j.waktu_mulai, k.check_in) < 60 THEN CONCAT('Terlambat ', TIMESTAMPDIFF(MINUTE, j.waktu_mulai, k.check_in), ' menit')
                ELSE CONCAT('Terlambat ', FLOOR(TIMESTAMPDIFF(MINUTE, j.waktu_mulai, k.check_in) / 60), ' jam ', MOD(TIMESTAMPDIFF(MINUTE, j.waktu_mulai, k.check_in), 60), ' menit')
            END
        ELSE 'Tidak Hadir'
    END AS status
FROM 
    kehadiran k
JOIN 
    peserta_magang pm ON pm.id_peserta = k.id_peserta
JOIN (
    SELECT 
        DISTINCT id_peserta, waktu_mulai
    FROM 
        jadwal
) j ON k.id_peserta = j.id_peserta

ORDER BY 
    k.tanggal DESC;
";
$result = $conn->query($sql);

function getStatusClass($status)
{
    if ($status == 'Tepat Waktu') {
        return 'bg-success';
    } else {
        return 'bg-danger';
    }
}
?>

<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title"> Kehadiran </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">Home</li>
                <li class="breadcrumb-item"><a href="?page=kehadiran">Kehadiran</a></li>
            </ol>
        </nav>
    </div>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Data Kehadiran Peserta Magang</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered text-light">
                            <thead>
                                <tr>
                                    <th> No. </th>
                                    <th> Nama </th>
                                    <th> Jadwal </th>
                                    <th> Jam Masuk </th>
                                    <th> Jam Keluar </th>
                                    <th> Status </th>
                                    <th> Tanggal </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($result->num_rows > 0) {
                                    $no = 1;
                                    while ($row = $result->fetch_assoc()) { ?>
                                        <tr>
                                            <td><?php echo $no; ?></td>
                                            <td><?php echo $row['nama']; ?></td>
                                            <td><?php echo $row['waktu_mulai']; ?></td>
                                            <td><?php echo $row['check_in']; ?></td>
                                            <td><?php echo $row['check_out']; ?></td>
                                            <td class="<?php echo getStatusClass($row['status']); ?>"><?php echo $row['status']; ?></td>
                                            <td><?php echo getDayNameIndonesia($row['tanggal']) . ', ' . date('d-m-Y', strtotime($row['tanggal'])); ?></td>
                                        </tr>
                                    <?php
                                        $no++;
                                    }
                                } else {
                                    ?>
                                    <tr>
                                        <td colspan="4" class="text-center">Tidak ada data kehadiran peserta magang saat ini.</td>
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