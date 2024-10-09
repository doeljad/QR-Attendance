<?php include("pages/admin/controller/create-data-kehadiran.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Perusahaan XYZ</title>
    <style>
        .swal2-popup .swal2-title,
        .swal2-popup .swal2-content {
            color: black !important;
        }
    </style>

</head>

<body>
    <div class="container-scroller">
        <?php include("pages/admin/template/sidebar.php") ?>
        <div class="container-fluid page-body-wrapper">
            <?php include("pages/admin/template/navbar.php") ?>

            <div class="modal fade" id="generateModal" tabindex="-1" role="dialog" aria-labelledby="generateModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content bg-white">
                        <div class="modal-header">
                            <h5 class="modal-title text-black" id="generateModalLabel">QR CODE</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div id="qrcode-container"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="main-panel">
                <?php include("pages/controller/adm-routes.php") ?>
                <footer class="footer">
                    <div class="d-sm-flex justify-content-center justify-content-sm-between">
                        <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © Stevania Frederica Fidela Setiawan 2024</span>
                    </div>
                </footer>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/js-cookie/3.0.1/js.cookie.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.8/html5-qrcode.min.js" integrity="sha512-r6rDA7W6ZeQhvl8S7yRVQUKVHdexq+GAlNkNNqVC7YyIV+NwqCTJe2hDWCiffTyRNOeGEzRRJ9ifvRm/HCzGYg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js" integrity="sha512-CNgIRecGo7nphbeZ04Sc13ka07paqdeTu0WR1IM4kNcpmBAUSHSQX0FslNhTDadL4O5SAGapGt4FodqL8My0mA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="assets/js/off-canvas"></script>
    <script src="assets/js/hoverable-collapse.js"></script>
    <script src="assets/js/misc.js"></script>
    <script src="assets/js/settings.js"></script>
    <script src="assets/js/dashboard.js"></script>
    <script src="assets/vendors/js/vendor.bundle.base.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            $('.navbar-toggler[data-toggle="minimize"]').click(function() {
                $('#logo').toggle(); // toggle() akan mengubah display antara none dan block
            });

            function updateQRCode() {
                $.ajax({
                    url: 'pages/admin/controller/fetch-qrcode.php',
                    method: 'GET',
                    success: function(response) {
                        const data = JSON.parse(response);
                        if (data.status === 'success') {
                            let qrcodeContainer = document.getElementById('qrcode-container');
                            qrcodeContainer.innerHTML = ''; // Clear previous QR code
                            new QRCode(qrcodeContainer, {
                                text: data.password,
                                width: 470,
                                height: 470
                            });
                        } else {
                            console.error('Error fetching password:', data.message);
                        }
                    },
                    error: function(error) {
                        console.error('AJAX error:', error);
                    }
                });
            }

            // Update QR Code setiap 5 detik
            setInterval(updateQRCode, 60000);

            // Update pertama kali saat halaman dimuat
            updateQRCode();
        });

        function updateQRCode() {
            $.ajax({
                url: 'pages/admin/controller/update-qrcode.php',
                method: 'GET',
                success: function(response) {
                    const data = JSON.parse(response);
                    if (data.status === 'success') {
                        document.getElementById('password').innerText = 'Password: ' + data.password;
                        document.getElementById('updated_at').innerText = 'Updated At: ' + data.updated_at;
                    } else {
                        console.error('Error updating QR code:', data.message);
                    }
                },
                error: function(error) {
                    console.error('AJAX error:', error);
                }
            });
        }

        // Update QR Code setiap 5 detik
        setInterval(updateQRCode, 60000);

        // Update pertama kali saat halaman dimuat
        updateQRCode();


        document.getElementById('logout').addEventListener('click', function() {
            window.location.href = 'logout.php';
        });
    </script>
</body>

</html>