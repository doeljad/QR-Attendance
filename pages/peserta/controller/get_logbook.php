<?php
include("../../controller/connection.php");

if (isset($_GET['id'])) {
    $id_logbook = $_GET['id'];
    $sql = "SELECT * FROM logbook WHERE id_logbook = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_logbook);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        echo json_encode($data);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Data logbook tidak ditemukan.']);
    }

    $stmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'ID logbook tidak disediakan.']);
}

$conn->close();
