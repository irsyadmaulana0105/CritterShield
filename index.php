<?php
// Mulai sesi jika belum dimulai
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Redirect ke halaman login jika pengguna belum login
if (!isset($_SESSION['members_email'])) {
    header("Location: login.php");
    exit();
}

include_once("inc_header.php");
?>

<!-- untuk home -->

<style>
body {
    margin: 0;
    padding: 0;
    overflow: hidden;
    font-family: Arial, sans-serif;
}

#home {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    background-color: #874E4C;
    padding: 0 20px; /* Tambahkan padding untuk menghindari konten terlalu mepet ke tepi */
}

.kolom {
    display: flex;
    justify-content: space-between; /* Pisahkan konten secara horizontal */
    align-items: center;
    width: 100%;
}

.description {
    flex: 1;
    color: white;
    max-width: 500px;
    margin-left: 50px; /* Beri jarak di sebelah kiri deskripsi */
    font-family: "kreon", Arial, sans-serif;
    font-size: 20px;
}

.container {
    flex: 1;
    display: flex;
    justify-content: center;
    align-items: center;
    margin-right: 50px; /* Beri jarak di sebelah kanan gambar */
}

img {
    max-width: 100%;
    height: auto;
}

#blogs {
    background-color: #874E4C;
    color: white;
    padding: 20px;
    box-sizing: border-box;
}

.boxcontainer {
    background-color: #F7DFD4;
    width: 100%;
    height: auto;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 12px;
    padding: 20px;
    box-sizing: border-box;
    overflow-y: auto;
    /* max-height: 70vh; Batasi tinggi maksimum agar tidak terlalu tinggi */
    margin-top: 50px;
}

.card {
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 16px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    background-color: #fff;
    color: #000;
    margin: 20px 0;
    width: 100%;
    max-width: 750px;
    box-sizing: border-box;
    display: flex;
    flex-direction: row;
    /* background-color: red ; */
    justify-content: center;
    align-items: center;
    gap: 20px;
}

.flex-card {
    display: flex;
    flex-direction: column;
    /* background-color: blue; */
    padding: 8px;
    font-size: medium;
    /* justify-content: center;
    align-items: center; */
}

.card-item {
    margin-bottom: 8px;
}

.card img {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
}
</style>

<section id="home"> 
    <div class="kolom">
        <div class="description">
            <h1>WELCOME</h1>
            <p>CritterShield hadir sebagai solusi komprehensif bagi petani padi. 
                <br>Kami menyediakan platform yang mempermudah petani dalam mendeteksi, mengobati, dan mencegah penyakit serta hama pada tanaman padi. 
                Akses mudah ke saran praktis dan edukasi terkini.</p>
            <h1>Hasilkanlah padi yang berkualitas, dengan daftar secara Gratis</h1>
        </div>
        <div class="container">
            <img src="image.png" width="700px" height="600px" alt="Deskripsi gambar">
        </div>
    </div>
</section>

<!-- section page blogs -->
<section id="blogs"> 
    <div class="boxcontainer">
        <h2>List of Blogs</h2>
        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "hama";

        // Sambungkan ke database
        $conn = mysqli_connect($servername, $username, $password, $dbname);

        // Periksa koneksi
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Ambil data dari tabel
        $sql = "SELECT isi, judul, foto FROM blogs";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $rows = mysqli_fetch_all($result, MYSQLI_ASSOC); // Mengambil semua baris hasil sebagai array asosiatif
    mysqli_close($conn);
    ?>
    <?php foreach ($rows as $edukasi): ?>
    <div class="card">
        <div class="card-item"><img src="gambar/<?php echo htmlspecialchars($edukasi['foto']); ?>" alt="Blog Image" style="max-width: 200px; max-height: 200px;"></div>
        <div class="flex-card">
            <div class="card-item"><strong>Judul:</strong> <?php echo htmlspecialchars($edukasi['judul']); ?></div>
            <div class="card-item"><strong>Isi:</strong> <?php echo htmlspecialchars($edukasi['isi']); ?></div>
        </div>
    </div>
    <?php endforeach; ?>
    <?php
} else {
    echo "<div class='card'><div class='card-item'>No results found.</div></div>";
}

// Tutup koneksi
// mysqli_close($conn);
?>

    </div> 
</section>


