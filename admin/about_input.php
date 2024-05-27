<?php include("inc_sidebar.php")?>
<body style='background-color:#F7DFD4'>
<?php

$isi        = "";
$penanganan = "";
$pencegahan = "";
$error      = "";
$sukses     = "";

// Mendapatkan ID jika ada
if(isset($_GET['id'])){
    $id = $_GET['id'];
}else{
    $id = "";
}

// Jika ID tidak kosong, ambil data berdasarkan ID tersebut
if($id != ""){
    $sql1   = "SELECT * FROM about WHERE id = '$id'";
    $q1     = mysqli_query($koneksi, $sql1);
    $r1     = mysqli_fetch_array($q1);
    $isi        = $r1['isi'];
    $penanganan = $r1['penanganan'];
    $pencegahan = $r1['pencegahan'];

    if($isi == ''){
        $error  = "Data tidak ditemukan";
    }
}

// Proses penyimpanan data
if (isset($_POST['simpan'])) {
    $isi        = $_POST['isi'];
    $penanganan = $_POST['penanganan'];
    $pencegahan = $_POST['pencegahan'];

    if ($isi == '' || $penanganan == '' || $pencegahan == '') {
        $error = "please fill out this field.";
    }
    if ($isi == '' ) {
        $error = "please fill isi.";
    }
    if ($penanganan == '' ) {
        $error = "please fill penanganan.";
    }
    if ($pencegahan == '' ) {
        $error = "please fill pencegahan.";
    }
    
    if (empty($error)) {
        if($id != ""){
            // Query update dengan klausa WHERE
            $sql1 = "UPDATE about SET penanganan='$penanganan', pencegahan='$pencegahan', isi='$isi' WHERE id='$id'";
        }else{
            // Query insert untuk menambahkan data baru
            $sql1 = "INSERT INTO about(penanganan, pencegahan, isi) VALUES ('$penanganan','$pencegahan','$isi')";
        }
        
        $q1 = mysqli_query($koneksi, $sql1);
        if ($q1) {
            $sukses = "Sukses memasukkan data";
        } else {
            $error = "Gagal masukkan data";
        }
    }
}
?>

<div class="container">
    <h1>Halaman Input Penyakit dan Hama</h1>
    <div class="mb-3 row">
        <a href="about.php"><< Kembali ke halaman penyakit dan hama</a>
    </div>
    <?php
    if ($error) {
    ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $error ?>
        </div>
    <?php
    }
    ?>
    <?php
    if ($sukses) {
    ?>
        <div class="alert alert-primary" role="alert">
            <?php echo $sukses ?>
        </div>
    <?php
    }
    ?>
    <form action="" method="post">
        <div class="mb-3 row">
            <label for="isi" class="col-sm-2 col-form-label">Isi</label>
            <div class="col-sm-10">
                <textarea name="isi" class="form-control"><?php echo $isi ?></textarea>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="penanganan" class="col-sm-2 col-form-label">Penanganan</label>
            <div class="col-sm-10">
                <textarea name="penanganan" class="form-control"><?php echo $penanganan ?></textarea>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="pencegahan" class="col-sm-2 col-form-label">Pencegahan</label>
            <div class="col-sm-10">
                <textarea name="pencegahan" class="form-control"><?php echo $pencegahan ?></textarea>
            </div>
        </div>
        <div class="mb-3 row">
            <div class="col-sm-2"></div>
            <div class="col-sm-10">
                <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary" />
            </div>
        </div>
    </form>
</div>
</body>
