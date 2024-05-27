<?php
// process_prediction.php

// Menerima data POST dari klien
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['rowValue'])) {
    $rowValue = $data['rowValue'];

    // Lakukan koneksi ke database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "hama";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Periksa koneksi
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Lakukan query SQL untuk mencari data berdasarkan nilai baris
    $sql = "SELECT prevention, handling FROM abau WHERE className = '$rowValue'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Data ditemukan, kirimkan kembali data ke klien dalam format JSON
        $row = $result->fetch_assoc();
        echo json_encode($row);
    } else {
        // Data tidak ditemukan
        echo json_encode(array('prevention' => 'Data pencegahan tidak ditemukan', 'handling' => 'Data penanganan tidak ditemukan'));
    }

    // Tutup koneksi database
    $conn->close();
} else {
    // Jika nilai baris tidak ditemukan dalam data yang diterima
    echo json_encode(array('prevention' => 'Tidak ada nilai rowValue yang diterima', 'handling' => ''));
}
?>
