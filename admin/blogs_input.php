<?php include("inc_sidebar.php") ?>
<body style='background-color:#F7DFD4'>
<?php

$isi        = "";
$judul     = "";
$foto       = "";
$foto_name  = "";

$error      = "";
$sukses     = "";

if(isset($_GET['id'])){
    $id = $_GET['id'];
}else{
    $id = "";
}

if($id != ""){
    $sql1   = "select * from blogs where id = '$id'";
    $q1     = mysqli_query($koneksi,$sql1);
    $r1     = mysqli_fetch_array($q1);
    $isi        = $r1['isi'];
    $judul        = $r1['judul'];
    $foto   = $r1['foto'];

    if($isi == ''){
        $error  = "Data tidak ditemukan";
    }
}

if (isset($_POST['simpan'])) {
    $isi        = $_POST['isi'];
    $judul        = $_POST['judul'];

    if ($isi == '') {
        $error     = "Silakan masukkan semua data yakni adalah data isi dan foto.";
    }
    //Array ( [foto] => Array ( [name] => Budi Rahardjo.jpg [type] => image/jpeg [tmp_name] => C:\xampp2\tmp\php4FDD.tmp [error] => 0 [size] => 2375701 ) )
    // print_r($_FILES);
    if($_FILES['foto']['name']){
        $foto_name = $_FILES['foto']['name'];
        $foto_file = $_FILES['foto']['tmp_name'];

        $detail_file = pathinfo($foto_name);
        $foto_ekstensi = $detail_file['extension'];
        // Array ( [dirname] => . [basename] => Romi Satrio Wahono.jpg [extension] => jpg [filename] => Romi Satrio Wahono )
        $ekstensi_yang_diperbolehkan = array("jpg","jpeg","png","gif");
        if(!in_array($foto_ekstensi,$ekstensi_yang_diperbolehkan)){
            $error = "Ekstensi yang diperbolehkan adalah jpg, jpeg, png dan gif";
        }

    }

    if (empty($error)) {
        if($foto_name){
            $direktori = "../gambar";

            @unlink($direktori."/$foto"); //delete data

            $foto_name = "blogs_".time()."_".$foto_name;
            move_uploaded_file($foto_file,$direktori."/".$foto_name);

            $foto = $foto_name;
        }else{
            $foto_name = $foto; //memasukkan data dari data yang sebelumnya ada
        }

        if($id != ""){
            $sql1   = "update blogs set foto='$foto_name',isi='$isi',judul='$judul' where id = '$id'";
        }else{
            $sql1       = "insert into blogs(foto,isi,judul) values ('$foto_name','$isi','$judul')";
        }
        
        $q1         = mysqli_query($koneksi, $sql1);
        if ($q1) {
            $sukses     = "Sukses memasukkan data";
        } else {
            $error      = "Gagal masukkan data";
        }
    }
}


?>
<div class="container">
<h1>Halaman Admin Input Data Blogs</h1>
<div class="mb-3 row">
    <a href="blogs.php">
        << Kembali ke halaman admin Blogs</a>
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
<form action="" method="post" enctype="multipart/form-data">
    <div class="mb-3 row">
        <label for="foto" class="col-sm-2 col-form-label">Foto</label>
        <div class="col-sm-10">
            <?php 
            if($foto){
                echo "<img src='../gambar/$foto' style='max-height:100px;max-width:100px'/>";
            }
            ?>
            <input type="file" class="form-control" id="foto" name="foto">
        </div>
    </div>
    <div class="mb-3 row">
        <label for="isi" class="col-sm-2 col-form-label">Judul</label>
        <div class="col-sm-10">
            <textarea name="judul" class="form-control" id="summernote"><?php echo $judul ?></textarea>
        </div>
    </div>
    <div class="mb-3 row">
        <label for="isi" class="col-sm-2 col-form-label">Isi</label>
        <div class="col-sm-10">
            <textarea name="isi" class="form-control" id="summernote"><?php echo $isi ?></textarea>
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