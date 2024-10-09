<?php
include("pages/controller/connection.php");

// Query untuk mengambil data peserta magang
$sql = "SELECT * FROM peserta_magang pm 
INNER JOIN departemen d ON pm.id_departemen=d.id_departemen";
$result = $conn->query($sql);

// Query untuk mengambil data departemen
$sql_departemen = "SELECT * FROM departemen";
$result_departemen = $conn->query($sql_departemen);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Insert into users
    $username = $_POST['username'];
    $nama = $_POST['nama'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = 2; // Role is set to 2

    $sql_user = "INSERT INTO users (username, nama, password, role) VALUES ('$username', '$nama', '$password', '$role')";
    if ($conn->query($sql_user) === TRUE) {
        $id_user = $conn->insert_id;

        // Insert into peserta_magang
        $email = $_POST['email'];
        $telepon = $_POST['telepon'];
        $tanggal_mulai = $_POST['tanggal_mulai'];
        $tanggal_selesai = $_POST['tanggal_selesai'];
        $id_departemen = $_POST['id_departemen'];

        $sql_peserta = "INSERT INTO peserta_magang (id_user, nama, email, telepon, tanggal_mulai, tanggal_selesai, id_departemen) VALUES ('$id_user', '$nama', '$email', '$telepon', '$tanggal_mulai', '$tanggal_selesai', '$id_departemen')";
        if ($conn->query($sql_peserta) === TRUE) {
            $id_peserta = $conn->insert_id;

            // Insert into jadwal
            foreach ($_POST['hari'] as $hari) {
                $waktu_mulai = $_POST['waktu_mulai'];
                $waktu_selesai = $_POST['waktu_selesai'];
                $sql_jadwal = "INSERT INTO jadwal (id_peserta, hari, waktu_mulai, waktu_selesai) VALUES ('$id_peserta', '$hari', '$waktu_mulai', '$waktu_selesai')";
                $conn->query($sql_jadwal);
            }
            echo "Peserta berhasil ditambahkan.";
        } else {
            echo "Error: " . $sql_peserta . "<br>" . $conn->error;
        }
    } else {
        echo "Error: " . $sql_user . "<br>" . $conn->error;
    }
}
?>

<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title"> Peserta Magang </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">Home</li>
                <li class="breadcrumb-item"><a href="?page=peserta-magang">Peserta Magang</a></li>
            </ol>
        </nav>
    </div>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="page-header">
                        <h4 class="card-title">Data Daftar Peserta Magang</h4>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><button class="btn btn-success" data-toggle="modal" data-target="#tambahPesertaModal">Tambah Peserta</button></li>
                            </ol>
                        </nav>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered text-light">
                            <thead>
                                <tr>
                                    <th> No. </th>
                                    <th> Nama </th>
                                    <th> Departemen </th>
                                    <th> Email </th>
                                    <th> Telepon </th>
                                    <th> Tanggal Mulai </th>
                                    <th> Tanggal Selesai </th>
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
                                            <td><?php echo $row['nama_departemen']; ?></td>
                                            <td><?php echo $row['email']; ?></td>
                                            <td><?php echo $row['telepon']; ?></td>
                                            <td><?php echo getDayNameIndonesia($row['tanggal_mulai']) . ', ' . date('d-m-Y', strtotime($row['tanggal_mulai'])); ?></td>
                                            <td><?php echo getDayNameIndonesia($row['tanggal_selesai']) . ', ' . date('d-m-Y', strtotime($row['tanggal_selesai'])); ?></td>
                                        </tr>
                                    <?php
                                        $no++;
                                    }
                                } else {
                                    ?>
                                    <tr>
                                        <td colspan="6" class="text-center">Tidak ada data peserta magang saat ini.</td>
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
    <!-- Modal Tambah Peserta Magang -->
    <div class="modal fade" id="tambahPesertaModal" tabindex="-1" role="dialog" aria-labelledby="tambahPesertaModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="POST" action="">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tambahPesertaModalLabel">Tambah Peserta Magang</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Users Table Fields -->
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control text-white" id="username" name="username" required>
                        </div>
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control text-white" id="nama" name="nama" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control text-white" id="password" name="password" required>
                        </div>

                        <!-- Peserta Magang Table Fields -->
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control text-white" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="telepon">Telepon</label>
                            <input type="text" class="form-control text-white" id="telepon" name="telepon">
                        </div>
                        <!-- Departemen Field -->
                        <div class="form-group">
                            <label for="id_departemen">Departemen</label>
                            <select class="form-control text-white" id="id_departemen" name="id_departemen" required>
                                <?php
                                if ($result_departemen->num_rows > 0) {
                                    while ($row_departemen = $result_departemen->fetch_assoc()) {
                                        echo "<option value='" . $row_departemen['id_departemen'] . "'>" . $row_departemen['nama_departemen'] . "</option>";
                                    }
                                } else {
                                    echo "<option value=''>Tidak ada departemen</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="tanggal_mulai">Tanggal Mulai</label>
                            <input type="date" class="form-control text-white" id="tanggal_mulai" name="tanggal_mulai" required>
                        </div>
                        <div class="form-group">
                            <label for="tanggal_selesai">Tanggal Selesai</label>
                            <input type="date" class="form-control text-white" id="tanggal_selesai" name="tanggal_selesai" required>
                        </div>

                        <!-- Jadwal Table Fields -->
                        <div class="form-group">
                            <label>Hari</label><br>
                            <label><input type="checkbox" name="hari[]" value="Senin"> Senin</label>
                            <label><input type="checkbox" name="hari[]" value="Selasa"> Selasa</label>
                            <label><input type="checkbox" name="hari[]" value="Rabu"> Rabu</label>
                            <label><input type="checkbox" name="hari[]" value="Kamis"> Kamis</label>
                            <label><input type="checkbox" name="hari[]" value="Jumat"> Jumat</label>
                            <label><input type="checkbox" name="hari[]" value="Sabtu"> Sabtu</label>
                            <label><input type="checkbox" name="hari[]" value="Minggu"> Minggu</label>
                        </div>
                        <div class="form-group">
                            <label for="waktu_mulai">Waktu Mulai</label>
                            <input type="time" class="form-control text-white" id="waktu_mulai" name="waktu_mulai" required>
                        </div>
                        <div class="form-group">
                            <label for="waktu_selesai">Waktu Selesai</label>
                            <input type="time" class="form-control text-white" id="waktu_selesai" name="waktu_selesai" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
// Tutup koneksi
$conn->close();
?>