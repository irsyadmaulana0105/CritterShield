<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["start_npm"])) {
    $json_content = file_get_contents('../jspicek/data.json');
    $hasil = json_decode($json_content, true);
    $targetDir = "gambar/";
    $targetFile = $targetDir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile,PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($targetFile)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile)) {
            // Update link dan path dalam array $hasil
            $hasil["link"] = 'http://localhost/CritterShield/jspicek/gambar/' . $_FILES["fileToUpload"]["name"];
            $hasil["path"] = 'jspicek/gambar/' . $_FILES["fileToUpload"]["name"];

            // Encode array $hasil ke dalam format JSON  
            $json_updated = json_encode($hasil);
            // Simpan JSON yang diperbarui ke dalam file data.json
            file_put_contents('../jspicek/data.json', $json_updated);

            echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
    header("Location: ../predik.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CritterShield</title>
    <style>
body {
    margin: 0;
    padding: 0;
    overflow: hidden; /* Mencegah scroll pada body */
    font-family: Arial, sans-serif; /* Menambahkan font yang lebih konsisten */
}

#foto-container {
    margin-top: 38px;
    margin-left: 39px;
    border: 2px solid #007bff;
    background: white;
    width: 300px;
    height: 300px;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
}
#preview {
    max-width: 100%;
    max-height: 100%;
    display: none;
}

.card {
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 16px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    background-color: #fff;
    width: 100%;
    max-width: 750px; /* Batas maksimal lebar kartu */
    height: 200px;
    box-sizing: border-box;
}

.main-container {
    display: flex;
    flex-direction: row;
    height: 100vh; /* Sesuaikan tinggi kontainer dengan viewport */
}

.left-container {
    background-color: #F7DFD4;
    width: 35%;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    padding: 10px;
    box-sizing: border-box;
}

.right-container {
    background-color: #F7DFD4;
    width: 65%;
    display: flex;
    justify-content: center;
    align-items: center; /* Mulai elemen dari atas */
    flex-direction: column;
    gap: 12px;
    padding: 10px; /* Tambahkan padding untuk jarak */
    box-sizing: border-box;
    overflow-y: auto; /* Mengaktifkan scroll vertikal jika konten terlalu tinggi */
}

.card-item {
    display: flex;
    flex-direction: column;
    /* align-items: center;
    justify-content: center; */
    margin-bottom: 8px; /* Menambahkan jarak antar item dalam kartu */
    gap: 5px;
}

.back-button {
    position: fixed;
    top: 0;
    left: 0;
    display: inline-block;
    padding: 10px 20px;
    background-color: #007C5A;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    text-align: center;
    margin: 20px; /* Menambahkan jarak dari tepi */
}

.card-img {
    border-radius: 20px ;
}

.card-result {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
}
input[type="file"] {
    margin: 10px 0;
}
button {
    padding: 10px 20px;
    font-size: 16px;
    cursor: pointer;
    border: none;
    border-radius: 5px;
    background-color: #007bff;
    color: white;
}
button:hover {
    background-color: #0056b3;
}

    </style>
</head>
<body>
    <!-- <h1>Upload Gambar</h1> -->
    <!-- <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
        <input type="file" name="fileToUpload" id="fileToUpload">
        <button type="submit" name="start_npm">Tekan Saya</button>
    </form> -->
    <a class="back-button" href="../index.php" class="back-button">Back</a>
    <div class="main-container">
        <div class="left-container">
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
        <input type="file" name="fileToUpload" id="fileToUpload">
        <button type="submit" name="start_npm">Tekan Saya</button>
        <div id="foto-container">
                    <img id="preview" src="#" alt="Preview Gambar">
                </div>
        
            <a class="back-button" href="javascript:history.go(-1)">Back</a>
        </div>
        <div class="right-container">
            <div class="card">
                <div class="card-item">
                    <strong>Isi:</strong>

                </div>
            </div>
            <div class="card">
            <div class="card-item">
                    <strong>Penanganan:</strong>

                </div>
            </div>
            <div class="card">
                <div class="card-item">
                    <strong>Pencegahan:</strong>

                </div>
            </div>
        </div>
    </div>
</body>
</html>

<script>
        document.getElementById('fileToUpload').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('preview');
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        });
    </script>