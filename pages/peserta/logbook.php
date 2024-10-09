<?php
include("pages/controller/connection.php");
$sesi = $_SESSION['id_user'];
// Query untuk mengambil data logbook magang
$sql = "SELECT l.*,pm.nama,pm.id_user FROM logbook l
INNER JOIN peserta_magang pm ON l.id_peserta=pm.id_peserta 
WHERE pm.id_user=$sesi";
$result = $conn->query($sql);
?>

<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title"> Logbook </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">Home</li>
                <li class="breadcrumb-item"><a href="?page=logbook-peserta">Logbook</a></li>
            </ol>
        </nav>
    </div>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body ">
                    <div class="page-header">
                        <h4 class="card-title">Data Logbook Magang</h4>
                        <nav aria-label="breadcrumb">
                            <button type="button" class="btn btn-success mb-3" data-toggle="modal" data-target="#addLogbookModal">
                                Tambah Logbook
                            </button>
                        </nav>
                    </div>

                    <div class="table-responsive ">
                        <table class="table table-bordered text-light">
                            <thead>
                                <tr>
                                    <th> No </th>
                                    <th> Tanggal </th>
                                    <th> Kegiatan </th>
                                    <th> Catatan </th>
                                    <th> Waktu Mulai </th>
                                    <th> Waktu Selesai </th>
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
                                            <td><?php echo $row['tanggal']; ?></td>
                                            <td><?php echo $row['kegiatan']; ?></td>
                                            <td><?php echo $row['catatan']; ?></td>
                                            <td><?php echo $row['waktu_mulai']; ?></td>
                                            <td><?php echo $row['waktu_selesai']; ?></td>
                                            <td>
                                                <button type="button" class="btn btn-warning btn-sm edit-btn" data-id="<?php echo $row['id_logbook']; ?>">Edit</button>
                                                <button type="button" class="btn btn-danger btn-sm delete-btn" data-id="<?php echo $row['id_logbook']; ?>">Delete</button>
                                            </td>
                                        </tr>
                                    <?php
                                        $no++; // Increment variabel penomoran
                                    }
                                } else {
                                    ?>
                                    <tr>
                                        <td colspan="7" class="text-center">Tidak ada data logbook saat ini.</td>
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

<!-- Modal Tambah Logbook -->
<div class="modal fade" id="addLogbookModal" tabindex="-1" role="dialog" aria-labelledby="addLogbookModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addLogbookModalLabel">Tambah Logbook</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addLogbookForm">
                    <div class="form-group">
                        <label for="tanggal">Tanggal</label>
                        <input type="date" class="form-control text-white" id="tanggal" name="tanggal" required>
                    </div>
                    <div class="form-group">
                        <label for="kegiatan">Kegiatan</label>
                        <input type="text" class="form-control text-white" id="kegiatan" name="kegiatan" required>
                    </div>
                    <div class="form-group">
                        <label for="catatan">Catatan</label>
                        <textarea class="form-control text-white" id="catatan" name="catatan" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="waktu_mulai">Waktu Mulai</label>
                        <input type="time" class="form-control text-white" id="waktu_mulai" name="waktu_mulai" required>
                    </div>
                    <div class="form-group">
                        <label for="waktu_selesai">Waktu Selesai</label>
                        <input type="time" class="form-control text-white" id="waktu_selesai" name="waktu_selesai" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Logbook -->
<div class="modal fade" id="editLogbookModal" tabindex="-1" role="dialog" aria-labelledby="editLogbookModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editLogbookModalLabel">Edit Logbook</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editLogbookForm">
                    <input type="hidden" id="edit_id_logbook" name="id_logbook">
                    <div class="form-group">
                        <label for="edit_tanggal">Tanggal</label>
                        <input type="date" class="form-control text-white" id="edit_tanggal" name="tanggal" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_kegiatan">Kegiatan</label>
                        <input type="text" class="form-control text-white" id="edit_kegiatan" name="kegiatan" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_catatan">Catatan</label>
                        <textarea class="form-control text-white" id="edit_catatan" name="catatan" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="edit_waktu_mulai">Waktu Mulai</label>
                        <input type="time" class="form-control text-white" id="edit_waktu_mulai" name="waktu_mulai" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_waktu_selesai">Waktu Selesai</label>
                        <input type="time" class="form-control text-white" id="edit_waktu_selesai" name="waktu_selesai" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    document.getElementById('addLogbookForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Mencegah form submit secara default
        var formData = new FormData(this);

        fetch('pages/peserta/controller/add_logbook.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Logbook berhasil ditambahkan',
                    }).then(() => {
                        location.reload(); // Refresh halaman setelah berhasil menambahkan logbook
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Gagal menambahkan logbook: ' + data.message,
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Terjadi kesalahan saat menambahkan logbook.',
                });
            });
    });

    // Edit Logbook
    document.querySelectorAll('.edit-btn').forEach(button => {
        button.addEventListener('click', function() {
            var id = this.getAttribute('data-id');
            fetch('pages/peserta/controller/get_logbook.php?id=' + id)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('edit_id_logbook').value = data.id_logbook;
                    document.getElementById('edit_tanggal').value = data.tanggal;
                    document.getElementById('edit_kegiatan').value = data.kegiatan;
                    document.getElementById('edit_catatan').value = data.catatan;
                    document.getElementById('edit_waktu_mulai').value = data.waktu_mulai;
                    document.getElementById('edit_waktu_selesai').value = data.waktu_selesai;
                    $('#editLogbookModal').modal('show');
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Terjadi kesalahan saat mengambil data logbook.',
                    });
                });
        });
    });

    document.getElementById('editLogbookForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Mencegah form submit secara default
        var formData = new FormData(this);

        fetch('pages/peserta/controller/update_logbook.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Logbook berhasil diperbarui',
                    }).then(() => {
                        location.reload(); // Refresh halaman setelah berhasil memperbarui logbook
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Gagal memperbarui logbook: ' + data.message,
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Terjadi kesalahan saat memperbarui logbook.',
                });
            });
    });

    // Delete Logbook
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
                    fetch('pages/peserta/controller/delete_logbook.php?id=' + id, {
                            method: 'GET'
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === 'success') {
                                Swal.fire(
                                    'Dihapus!',
                                    'Logbook berhasil dihapus.',
                                    'success'
                                ).then(() => {
                                    location.reload(); // Refresh halaman setelah berhasil menghapus logbook
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: 'Gagal menghapus logbook: ' + data.message,
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Terjadi kesalahan saat menghapus logbook.',
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