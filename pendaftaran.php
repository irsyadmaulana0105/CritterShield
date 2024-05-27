<?php include("inc_header.php")?>
<?php 
if(isset($_SESSION['members_email']) != ''){ //sudah dalam keadaan login
    header("location:index.php");
    exit();
}
?>

<?php 
$email          = "";
$nama_lengkap   = "";
$err            = "";
$sukses         = "";

if(isset($_POST['simpan'])){
    $email                  = $_POST['email'];
    $nama_lengkap           = $_POST['nama_lengkap'];
    $password               = $_POST['password'];
    $konfirmasi_password    = $_POST['konfirmasi_password'];

    if($email == '' or $nama_lengkap == '' or $konfirmasi_password =='' or $password == ''){
        $err .= "<li>Please fill out this field.</li>";
    }

    //cek di bagian db, apakah email sudah ada atau belum
    if($email != ''){
        $sql1   = "select email from members where email = '$email'";
        $q1     = mysqli_query($koneksi,$sql1);
        $n1     = mysqli_num_rows($q1);
        if($n1 > 0){
            $err .= "<li>Email yang kamu masukkan sudah terdaftar.</li>";
        }

        //validasi email
        if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
            $err .= "<li>the given data was invalid.</li>";
        }
    }

    //cek kesesuaian password & konfirmasi password
    if($password != $konfirmasi_password){
        $err .= "<li>Password dan Konfirmasi Password tidak sesuai.</li>";
    }
    if(strlen($password) < 6){
        $err .= "<li>Panjang karakter yang diizinkan untuk password paling tidak 6 karakter.</li>";
    }

    if(empty($err)){
        $status             = md5(rand(0,1000));
        // $status             = uniqid();
        $judul_email        = "Halaman Konfirmasi Pendaftaran";
        $isi_email          = "Akun yang kamu miliki dengan email <b>$email</b> telah siap digunakan.<br/>";
        $isi_email          .= "Sebelumnya silakan melakukan aktifasi email di link di bawah ini:<br/>";
        $isi_email          .= url_dasar()."/verifikasi.php?email=$email&kode=$status";

        kirim_email($email,$nama_lengkap,$judul_email,$isi_email);

        $sql1       = "insert into members(email,nama_lengkap,password,status) values ('$email','$nama_lengkap','$password','$status')";
        $q1         = mysqli_query($koneksi,$sql1);
        if($q1){
            $sukses = "Proses Berhasil. Silakan cek email kamu untuk verifikasi.";
        }

        
    }

}
// Generate verification code
$verificationCode = generateVerificationCode();

// Simpan kode verifikasi ke dalam database
$query = "UPDATE members SET activation_code = '$verificationCode' WHERE email = '$email'";
$result = mysqli_query($koneksi, $query);

if ($result) {

} 
else {

}
function generateVerificationCode() {

}

?>
<?php if($err) {echo "<div class='error'><ul>$err</ul></div>";} ?>
<?php if($sukses) {echo "<div class='sukses'>$sukses</div>";} ?>

<div class="login-container">
    <form action="" method="POST" class="login-form">
        <h3>Login Ke Halaman Users</h3>
    <div class="form2">
                    <input type="text" name="email" placeholder="email"  value="<?php echo $email?>"/>
                    <input type="text" name="nama_lengkap" placeholder="nama lengkap"  value="<?php echo $nama_lengkap?>"/>
                    <input type="password" placeholder="password" name="password"  />
                    <input type="password" placeholder="password" name="konfirmasi_password"  />
                </div>
                
                <div>Sudah punya akun? Silakan <a href='<?php echo url_dasar()?>/login.php'>login</a></div>
            
                <input type="submit" name="simpan" value="daftar" class="tbl-biru"/>
    
</form>

<style>

body {
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: #F7DFD4;
}

.login-container {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    height: 100%;
    width: 100%;
    /* background-color: #0056b3; */
}

.login-form {
    /* background-color: red; */
    padding: 20px;
    max-width: 500px; /* Ubah ukuran maksimum form */
    width: 100%;
    margin: 0 auto; /* Menengahkan form */
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    gap: 10px;
}

.login-form h3 {
    display: flex;
    justify-content: center;
}

.table {
    width: 100%;
}

/* .label {
    padding-right: 10px;
    color: #000;
} */

.form2 input {
    padding: 10px;
    margin: 5px 0;
    box-sizing: border-box;
    border: 1px solid #ccc;
    border-radius: 10px;
    width: 300px; 
}

.form2 {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
}



.tbl-biru {
    background-color: #007bff;
    color: white;
    padding: 10px 15px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.tbl-biru:hover {
    background-color: #0056b3;
}

.error ul.pesan {
    list-style-type: none;
    padding: 0;
    color: red;
}
    

</style>