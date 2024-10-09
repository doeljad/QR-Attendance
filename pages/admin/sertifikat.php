<?php
include("pages/controller/connection.php");
$sesi = $_SESSION['id_user'];

// Query untuk mengambil data sertifikat
$sql = "SELECT * FROM sertifikat";
$result = $conn->query($sql);
?>

<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title"> Sertifikat </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">Home</li>
                <li class="breadcrumb-item"><a href="?page=sertifikat">Sertifikat</a></li>
            </ol>
        </nav>
    </div>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body ">
                    <div class="page-header">
                        <h4 class="card-title">Data Sertifikat</h4>
                        <nav aria-label="breadcrumb">
                            <button type="button" class="btn btn-success mb-3" data-toggle="modal" data-target="#addSertifikatModal">
                                Tambah Sertifikat
                            </button>
                        </nav>
                    </div>

                    <div class="table-responsive ">
                        <table class="table table-bordered text-light">
                            <thead>
                                <tr>
                                    <th> No </th>
                                    <th> Judul </th>
                                    <th> Tanggal Terbit </th>
                                    <th> File </th>
                                    <th> Actions </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($result->num_rows > 0) {
                                    $no = 1; // Inisialisasi variabel untuk penomoran
                                    while ($row = $result->fetch_assoc()) {
                                ?>
                                        <tr>
                                            <td><?php echo $no; ?></td> <!-- Menampilkan nomor urut -->
                                            <td><?php echo $row['judul']; ?></td>
                                            <td><?php echo $row['tanggal_terbit']; ?></td>
                                            <td><?php echo $row['file_name']; ?></td>
                                            <td>
                                                <button type="button" class="btn btn-warning btn-sm edit-btn" data-id="<?php echo $row['id_sertifikat']; ?>">Edit</button>
                                                <button type="button" class="btn btn-danger btn-sm delete-btn" data-id="<?php echo $row['id_sertifikat']; ?>">Delete</button>
                                            </td>
                                        </tr>
                                    <?php
                                        $no++; // Increment variabel penomoran
                                    }
                                } else {
                                    ?>
                                    <tr>
                                        <td colspan="5" class="text-center">Tidak ada data sertifikat saat ini.</td>
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

<!-- Modal Tambah Sertifikat -->
<div class="modal fade" id="addSertifikatModal" tabindex="-1" role="dialog" aria-labelledby="addSertifikatModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addSertifikatModalLabel">Tambah Sertifikat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addSertifikatForm" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="judul">Judul Sertifikat</label>
                        <input type="text" class="form-control text-white" id="judul" name="judul" required>
                    </div>
                    <div class="form-group">
                        <label for="tanggal_terbit">Tanggal Terbit</label>
                        <input type="date" class="form-control text-white" id="tanggal_terbit" name="tanggal_terbit" required>
                    </div>
                    <div class="form-group">
                        <label for="file">Pilih File Sertifikat (PDF)</label>
                        <input type="file" class="form-control text-white" id="file" name="file" accept="application/pdf" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Sertifikat -->
<div class="modal fade" id="editSertifikatModal" tabindex="-1" role="dialog" aria-labelledby="editSertifikatModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editSertifikatModalLabel">Edit Sertifikat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editSertifikatForm" enctype="multipart/form-data">
                    <input type="hidden" id="edit_id_sertifikat" name="id_sertifikat">
                    <div class="form-group">
                        <label for="edit_judul">Judul Sertifikat</label>
                        <input type="text" class="form-control text-white" id="edit_judul" name="judul" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_tanggal_terbit">Tanggal Terbit</label>
                        <input type="date" class="form-control text-white" id="edit_tanggal_terbit" name="tanggal_terbit" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_file">Pilih File Sertifikat (PDF)</label>
                        <input type="file" class="form-control text-white" id="edit_file" name="file" accept="application/pdf">
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Add Sertifikat
    document.getElementById('addSertifikatForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Mencegah form submit secara default
        var formData = new FormData(this);

        fetch('pages/admin/controller/proses-upload-sertifikat.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Sertifikat berhasil ditambahkan',
                        customClass: {
                            popup: 'swal2-custom-popup'
                        }
                    }).then(() => {
                        location.reload(); // Refresh halaman setelah berhasil menambahkan sertifikat
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Gagal menambahkan sertifikat: ' + data.message,
                        customClass: {
                            popup: 'swal2-custom-popup'
                        }
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Terjadi kesalahan saat menambahkan sertifikat.',
                    customClass: {
                        popup: 'swal2-custom-popup'
                    }
                });
            });
    });

    // Edit Sertifikat
    document.querySelectorAll('.edit-btn').forEach(button => {
        button.addEventListener('click', function() {
            var id = this.getAttribute('data-id');
            fetch('pages/admin/controller/get-sertifikat.php?id=' + id)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('edit_id_sertifikat').value = data.id_sertifikat;
                    document.getElementById('edit_judul').value = data.judul;
                    document.getElementById('edit_tanggal_terbit').value = data.tanggal_terbit;
                    $('#editSertifikatModal').modal('show');
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Terjadi kesalahan saat mengambil data sertifikat.',
                        customClass: {
                            popup: 'swal2-custom-popup'
                        }
                    });
                });
        });
    });

    document.getElementById('editSertifikatForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Mencegah form submit secara default
        var formData = new FormData(this);

        fetch('pages/admin/controller/update-sertifikat.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Sertifikat berhasil diperbarui',
                        customClass: {
                            popup: 'swal2-custom-popup'
                        }
                    }).then(() => {
                        location.reload(); // Refresh halaman setelah berhasil memperbarui sertifikat
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Gagal memperbarui sertifikat: ' + data.message,
                        customClass: {
                            popup: 'swal2-custom-popup'
                        }
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Terjadi kesalahan saat memperbarui sertifikat.',
                    customClass: {
                        popup: 'swal2-custom-popup'
                    }
                });
            });
    });

    // Delete Sertifikat
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function() {
            var id = this.getAttribute('data-id');
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Anda tidak akan dapat mengembalikan ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('pages/admin/controller/delete-sertifikat.php?id=' + id, {
                            method: 'GET'
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === 'success') {
                                Swal.fire(
                                    'Dihapus!',
                                    'Sertifikat berhasil dihapus.',
                                    'success'
                                ).then(() => {
                                    location.reload(); // Refresh halaman setelah berhasil menghapus sertifikat
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: 'Gagal menghapus sertifikat: ' + data.message,
                                    customClass: {
                                        popup: 'swal2-custom-popup'
                                    }
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Terjadi kesalahan saat menghapus sertifikat.',
                                customClass: {
                                    popup: 'swal2-custom-popup'
                                }
                            });
                        });
                }
            });
        });
    });
</script>

<?php
// Tutup koneksi
$conn->close();
?>