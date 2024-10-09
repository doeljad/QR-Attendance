<?php

include("pages/controller/connection.php");

// Query untuk mengambil data logbook peserta magang
$sql = "SELECT l.*,pm.nama FROM logbook l
INNER JOIN peserta_magang pm ON l.id_peserta=pm.id_peserta";
$result = $conn->query($sql);

?>

<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title"> Logbook Peserta </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">Home</li>
                <li class="breadcrumb-item"><a href="?page=logbook-peserta">Logbook Peserta</a></li>
            </ol>
        </nav>
    </div>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body ">
                    <h4 class="card-title">Data Logbook Peserta Magang</h4>
                    <div class="table-responsive ">
                        <table class="table table-bordered text-light">
                            <thead>
                                <tr>
                                    <th> No </th>
                                    <th> Nama Peserta </th>
                                    <th> Tanggal </th>
                                    <th> Kegiatan </th>
                                    <th> Catatan </th>
                                    <th> Waktu Mulai </th>
                                    <th> Waktu Selesai </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                ?>
                                        <tr>
                                            <td><?php echo $row['id_logbook']; ?></td>
                                            <td><?php echo $row['nama']; ?></td>
                                            <td><?php echo getDayNameIndonesia($row['tanggal']) . ', ' . date('d-m-Y', strtotime($row['tanggal'])); ?></td>
                                            <td><?php echo $row['kegiatan']; ?></td>
                                            <td><?php echo $row['catatan']; ?></td>
                                            <td><?php echo $row['waktu_mulai']; ?></td>
                                            <td><?php echo $row['waktu_selesai']; ?></td>
                                        </tr>
                                    <?php
                                    }
                                } else {
                                    ?>
                                    <tr>
                                        <td colspan="8" class="text-center">Tidak ada data logbook saat ini.</td>
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