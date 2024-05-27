<?php
// Lokasi file gambar yang akan diunggah
$target_dir = "/path/to/your/image/directory/";
$target_file = $target_dir . basename($_FILES["file"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Cek apakah file gambar valid
if (isset($_POST["submit"])) {
    $check = getimagesize($_FILES["file"]["tmp_name"]);
    if ($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}

// Coba unggah file
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
} else {
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
        echo "The file " . htmlspecialchars(basename($_FILES["file"]["name"])) . " has been uploaded.";

        // Kirim gambar ke API Flask
        $url = 'http://localhost:5000/predict';
        $file = curl_file_create($target_file, $_FILES["file"]["type"], basename($_FILES["file"]["name"]));
        $data = array('file' => $file);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        // Cetak hasil prediksi
        echo "<pre>";
        print_r($response);
        echo "</pre>";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>
