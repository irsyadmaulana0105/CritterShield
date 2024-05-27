<?php
$output = shell_exec("npm start");
$json_content = file_get_contents('jspicek/data.json');
$hasil = json_decode($json_content, true);

if ($hasil === null && json_last_error() !== JSON_ERROR_NONE) {
    die('Error parsing JSON');
}

// Menambahkan pengecekan untuk variabel yang diharapkan
if (isset($hasil['nama'])) {
    $nama = $hasil['nama'];
} else {
    $nama = "Nama Tidak Tersedia"; // Atau sesuaikan dengan nilai default yang sesuai
}

if (isset($hasil['skor'])) {
    $skor = $hasil['skor'];
} else {
    $skor = "Skor Tidak Tersedia"; // Atau sesuaikan dengan nilai default yang sesuai
}

// Mengambil data dari array hasil JSON
$nama = $hasil['nama'];
$skor = $hasil['skor'];
$tanggal = $hasil['tanggal'];
$link = $hasil['link'];
$path = $hasil['path'];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hama";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$id = null;

// Menentukan ID yang akan diambil dari database berdasarkan nilai JSON
switch ($hasil['nama']) {
    case 'blast':
        $id = 1;
        break;
    case 'blight':
        $id = 2;
        break;
    case 'tungro':
        $id = 3;
        break;
    default:
        // Default action jika nama tidak sesuai
        break;
}

// Memastikan ID telah ditentukan sebelum menjalankan query
if ($id !== null) {
    $sql = "SELECT * FROM about WHERE id = $id";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
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

/* .result {
    display: flex;
    flex-direction: column;
} */


    
    </style>
    </head>
    <body>
    <div class="main-container">
        <div class="left-container">
            <div class="card-img">
                <strong></strong>
                <img src="<?php echo htmlspecialchars($path); ?>" height="300px" width="400px" alt="Gambar">
            </div>
            <div class="result">
                <div class="card-result">
                    <strong>Name:</strong>
                    <span><?php echo htmlspecialchars($nama); ?></span>
                </div>
                <div class="card-result">
                    <strong>Skor:</strong>
                    <span><?php echo htmlspecialchars($skor); ?></span>
                </div>
            </div>
            <a class="back-button" href="javascript:history.go(-1)">Back</a>
        </div>
        <div class="right-container">
            <div class="card">
                <div class="card-item">
                    <strong>Isi:</strong>
                    <span><?php echo htmlspecialchars($row['isi']); ?></span>
                </div>
            </div>
            <div class="card">
            <div class="card-item">
                    <strong>Penanganan:</strong>
                    <span><?php echo htmlspecialchars($row['penanganan']); ?></span>
                </div>
            </div>
            <div class="card">
                <div class="card-item">
                    <strong>Pencegahan:</strong>
                    <span><?php echo htmlspecialchars($row['pencegahan']); ?></span>
                </div>
            </div>
        </div>
    </div>
    </body>
    </html>
