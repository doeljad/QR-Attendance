<?php

include("pages/controller/connection.php");

// Query untuk mengambil data jadwal peserta magang
$sql = "SELECT * FROM jadwal j 
INNER JOIN peserta_magang pm ON pm.id_peserta=j.id_peserta";
$result = $conn->query($sql);

?>

<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title"> Jadwal </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">Home</li>
                <li class="breadcrumb-item"><a href="?page=jadwal">Jadwal</a></li>
            </ol>
        </nav>
    </div>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Data Jadwal Peserta Magang</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered text-light">
                            <thead>
                                <tr>
                                    <th> No </th>
                                    <th> Nama </th>
                                    <th> Hari </th>
                                    <th> Waktu Mulai </th>
                                    <th> Waktu Selesai </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($result->num_rows > 0) {
                                    $no = 1;
                                    while ($row = $result->fetch_assoc()) {
                                ?>
                                        <tr>
                                            <td><?php echo $no; ?></td>
                                            <td><?php echo $row['nama']; ?></td>
                                            <td><?php echo $row['hari']; ?></td>
                                            <td><?php echo $row['waktu_mulai']; ?></td>
                                            <td><?php echo $row['waktu_selesai']; ?></td>
                                        </tr>
                                    <?php
                                        $no++;
                                    }
                                } else {
                                    ?>
                                    <tr>
                                        <td colspan="6" class="text-center">Tidak ada data jadwal saat ini.</td>
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