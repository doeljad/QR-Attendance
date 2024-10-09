<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Perusahaan XYZ</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
    <style>
        .swal2-popup .swal2-title,
        .swal2-popup .swal2-content {
            color: black !important;
        }
    </style>

</head>

<body>

    <div class="container-scroller">
        <?php include("pages/peserta/template/sidebar.php") ?>
        <div class="container-fluid page-body-wrapper">
            <?php include("pages/peserta/template/navbar.php") ?>

            <div class="modal fade" id="scanModal" tabindex="-1" role="dialog" aria-labelledby="scanModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="scanModalLabel">Scan QR Code</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div id="reader" style="width:100%"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="main-panel">
                <?php include("pages/controller/pst-routes.php") ?>
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
    <script src="assets/js/hoverable-collapse.js"></script>
    <script src="assets/js/misc.js"></script>
    <script src="assets/js/settings.js"></script>
    <script src="assets/js/dashboard.js"></script>
    <script src="assets/vendors/js/vendor.bundle.base.js"></script>
    <script src="assets/js/off-canvas"></script>
    <script>
        $('.navbar-toggler[data-toggle="minimize"]').click(function() {
            $('#logo').toggle(); // toggle() akan mengubah display antara none dan block
        });
        // Initialize variables
        let html5QrCode;
        let isScannerRunning = false;

        function onScanSuccess(decodedText, decodedResult) {
            $('#scanModal').modal('hide');
            if (isScannerRunning && html5QrCode) {
                html5QrCode.stop().then(ignore => {
                    html5QrCode.clear();
                    isScannerRunning = false;
                }).catch(err => {
                    console.error(`Error stopping scanner: ${err}`);
                });
            }

            $.ajax({
                url: 'pages/peserta/controller/process_qrcode.php',
                type: 'POST',
                data: {
                    qrCodePassword: decodedText
                },
                success: function(response) {
                    console.log(response); // Log the response to see the message from PHP
                    if (response.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Sukses',
                            text: response.message, // Use response.message to get the message from PHP
                            customClass: {
                                popup: 'swal2-custom-popup'
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload(); // Reload the page after success
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message, // Use response.message to get the message from PHP
                            customClass: {
                                popup: 'swal2-custom-popup'
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $('#scanModal').modal('show'); // Reopen the modal if there's an error
                                if (!isScannerRunning && html5QrCode) {
                                    html5QrCode.start({
                                            facingMode: "environment"
                                        }, {
                                            fps: 30,
                                            qrbox: {
                                                width: 250,
                                                height: 250
                                            }
                                        },
                                        onScanSuccess).then(() => {
                                        isScannerRunning = true;
                                    }).catch(err => {
                                        console.log(`Unable to start scanning, error: ${err}`);
                                    });
                                }
                            }
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Internal Server Error. Silakan coba lagi.',
                        customClass: {
                            popup: 'swal2-custom-popup'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $('#scanModal').modal('show'); // Reopen the modal if there's an error
                            if (!isScannerRunning && html5QrCode) {
                                html5QrCode.start({
                                        facingMode: "environment"
                                    }, {
                                        fps: 30,
                                        qrbox: {
                                            width: 250,
                                            height: 250
                                        }
                                    },
                                    onScanSuccess).then(() => {
                                    isScannerRunning = true;
                                }).catch(err => {
                                    console.log(`Unable to start scanning, error: ${err}`);
                                });
                            }
                        }
                    });
                }
            });
        }

        $('#scanModal').on('shown.bs.modal', function() {
            if (!isScannerRunning && html5QrCode) {
                html5QrCode.start({
                        facingMode: "environment"
                    }, {
                        fps: 10,
                        qrbox: {
                            width: 250,
                            height: 250
                        }
                    },
                    onScanSuccess).then(() => {
                    isScannerRunning = true;
                }).catch(err => {
                    console.log(`Unable to start scanning, error: ${err}`);
                });
            }
        });

        $('#scanModal').on('hidden.bs.modal', function() {
            if (isScannerRunning && html5QrCode) {
                html5QrCode.stop().then(ignore => {
                    html5QrCode.clear();
                    isScannerRunning = false;
                }).catch(err => {
                    console.log(`Unable to stop scanning, error: ${err}`);
                });
            }
        });

        $(document).ready(function() {
            html5QrCode = new Html5Qrcode("reader");
        });
        document.getElementById('logout').addEventListener('click', function() {
            window.location.href = 'logout.php';
        });
    </script>

</body>

</html>