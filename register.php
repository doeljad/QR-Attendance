<?php
include('pages/controller/connection.php');

$sql_departemen = "SELECT * FROM departemen";
$result_departemen = $conn->query($sql_departemen);

$error_message = '';
$success_message = '';

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
            $success_message = "Peserta berhasil ditambahkan.";
        } else {
            $error_message = "Error: " . $sql_peserta . "<br>" . $conn->error;
        }
    } else {
        $error_message = "Error: " . $sql_user . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Register Form</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style media="screen">
        body {
            background-color: #080710;
            font-family: 'Poppins', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            width: 500px;
            background-color: rgba(255, 255, 255, 0.13);
            border-radius: 10px;
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 0 40px rgba(8, 7, 16, 0.6);

        }

        .modal-content * {
            color: #ffffff;
            letter-spacing: 0.5px;
            outline: none;
            border: none;
        }

        .modal-title {
            font-size: 32px;
            font-weight: 500;
            line-height: 42px;
            text-align: center;
            margin-bottom: 30px;
        }

        .form-group label {
            font-size: 16px;
            font-weight: 500;
            margin-top: 20px;
        }

        .form-group input,
        .form-group select {
            height: 50px;
            width: 100%;
            background-color: rgba(255, 255, 255, 0.07);
            border-radius: 3px;
            padding: 0 10px;
            margin-top: 8px;
            font-size: 14px;
            font-weight: 300;
        }

        .form-group input::placeholder {
            color: #e5e5e5;
        }

        .modal-footer button {
            margin-top: 40px;
            width: 100%;
            background-color: #ffffff;
            color: #080710;
            padding: 15px 0;
            font-size: 18px;
            font-weight: 600;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .modal-footer button:hover {
            background-color: #f09819;
        }
    </style>
</head>

<body>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahPesertaModalLabel">Pendaftaran Peserta Magang</h5>
                </div>
                <div class="modal-body">
                    <!-- Users Table Fields -->
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>

                    <!-- Peserta Magang Table Fields -->
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="telepon">Telepon</label>
                        <input type="text" class="form-control" id="telepon" name="telepon">
                    </div>
                    <!-- Departemen Field -->
                    <div class="form-group ">
                        <label for="id_departemen">Departemen</label>
                        <select class="form-control bg-dark" id="id_departemen" name="id_departemen" required>
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
                        <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" required>
                    </div>
                    <div class="form-group">
                        <label for="tanggal_selesai">Tanggal Selesai</label>
                        <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai" required>
                    </div>

                    <!-- Jadwal Table Fields -->
                    <div class="form">
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
                        <input type="time" class="form-control" id="waktu_mulai" name="waktu_mulai" required>
                    </div>
                    <div class="form-group">
                        <label for="waktu_selesai">Waktu Selesai</label>
                        <input type="time" class="form-control" id="waktu_selesai" name="waktu_selesai" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <?php if ($success_message) : ?>
        <script>
            alert("<?php echo $success_message; ?>");
        </script>
    <?php endif; ?>

    <?php if ($error_message) : ?>
        <script>
            alert("<?php echo $error_message; ?>");
        </script>
    <?php endif; ?>

</body>

</html>