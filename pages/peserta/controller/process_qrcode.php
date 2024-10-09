<?php
session_start();
date_default_timezone_set('Asia/Jakarta');
include("../../controller/connection.php");

header('Content-Type: application/json'); // Set response header for JSON

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $qrCodePassword = $_POST['qrCodePassword'];
    $userId = $_SESSION['id_user']; // Make sure session is properly set

    // Example SQL query to check QR code validity
    $stmt = $conn->prepare("SELECT * FROM qr_code WHERE password = ?");
    $stmt->bind_param("s", $qrCodePassword);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // QR code valid, proceed to check or insert attendance
        $date = date("Y-m-d");
        $time = date("H:i:s");
        $created_at = date("Y-m-d H:i:s"); // Create a proper datetime value

        // Get id_peserta based on id_user
        $stmt = $conn->prepare("SELECT id_peserta FROM peserta_magang WHERE id_user = ?");
        $stmt->bind_param("s", $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $id_peserta = $user['id_peserta'];

            // Check if user has schedule today
            function getDayName($dayNumber)
            {
                $days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                return $days[$dayNumber];
            }

            $dayOfWeek = getDayName(date('w'));
            $stmt = $conn->prepare("SELECT * FROM jadwal WHERE id_peserta = ? AND hari = ?");
            $stmt->bind_param("is", $id_peserta, $dayOfWeek);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows == 0) {
                // User is not scheduled today
                echo json_encode(['status' => 'error', 'message' => 'Anda tidak dijadwalkan hari ini']);
            } else {
                // User has schedule, proceed with attendance
                $attendance = $result->fetch_assoc();

                // Check if user has already checked in and checked out today
                $stmt = $conn->prepare("SELECT * FROM kehadiran WHERE id_peserta = ? AND tanggal = ? ORDER BY created_at DESC LIMIT 1");
                $stmt->bind_param("is", $id_peserta, $date);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $attendanceRecord = $result->fetch_assoc();
                    if (!empty($attendanceRecord['check_out'])) {
                        // User has already checked in and checked out today
                        echo json_encode(['status' => 'error', 'message' => 'Anda sudah melakukan check-in dan check-out hari ini']);
                    } elseif (empty($attendanceRecord['check_in']) && empty($attendanceRecord['check_out'])) {
                        // User has not checked in today, perform check-in
                        $stmt = $conn->prepare("UPDATE kehadiran SET check_in = ?, created_at = ? WHERE id_kehadiran = ?");
                        $stmt->bind_param("ssi", $time, $created_at, $attendanceRecord['id_kehadiran']);
                        if ($stmt->execute()) {
                            echo json_encode(['status' => 'success', 'message' => 'Check-in berhasil']);
                        } else {
                            // Capture and log the error for debugging
                            error_log("Database update error: " . $stmt->error);
                            echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan data check-in']);
                        }
                    } elseif (!empty($attendanceRecord['check_in']) && empty($attendanceRecord['check_out'])) {
                        // User has checked in today but not yet checked out, perform check-out
                        $stmt = $conn->prepare("UPDATE kehadiran SET check_out = ? WHERE id_kehadiran = ?");
                        $stmt->bind_param("si", $time, $attendanceRecord['id_kehadiran']);
                        if ($stmt->execute()) {
                            echo json_encode(['status' => 'success', 'message' => 'Check-out berhasil']);
                        } else {
                            // Capture and log the error for debugging
                            error_log("Database update error: " . $stmt->error);
                            echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan data check-out']);
                        }
                    }
                } else {
                    // User has no attendance record today, perform check-in
                    $stmt = $conn->prepare("INSERT INTO kehadiran (id_peserta, check_in, tanggal, created_at) VALUES (?, ?, ?, ?)");
                    $stmt->bind_param("isss", $id_peserta, $time, $date, $created_at);
                    if ($stmt->execute()) {
                        echo json_encode(['status' => 'success', 'message' => 'Check-in berhasil']);
                    } else {
                        // Capture and log the error for debugging
                        error_log("Database insert error: " . $stmt->error);
                        echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan data check-in']);
                    }
                }
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'User tidak ditemukan']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'QR code tidak valid']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Metode request tidak valid']);
}
