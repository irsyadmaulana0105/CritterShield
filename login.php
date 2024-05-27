<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include("inc_header.php");
?>
<div class="login-container">
    <form action="" method="POST" class="login-form">
        <h3>Login Ke Halaman Users</h3>
        <?php 
        include_once("inc/inc_koneksi.php");
        include_once("inc/inc_fungsi.php");

        $email      = "";
        $password   = "";
        $err        = "";

        if(isset($_POST['login'])){
            $email      = $_POST['email'];
            $password   = $_POST['password'];

            if($email == '' || $password == ''){
                $err .= "<li>Please fill out this field</li>";
            }else{
                $sql1   = "select * from members where email = '$email'";
                $q1     = mysqli_query($koneksi,$sql1);
                $r1     = mysqli_fetch_array($q1);
                $n1     = mysqli_num_rows($q1);

                if($n1 > 0 && $r1['status'] == '1'){
                    if($r1['password'] != md5($password)){
                        $err .= "<li>the given data was invalid</li>";
                    }
                } else {
                    $err .= "<li>Akun tidak ditemukan atau belum aktif</li>";
                }

                if(empty($err)){
                    $_SESSION['members_email'] = $email;
                    $_SESSION['members_nama_lengkap'] = $r1['nama_lengkap'];
                    
                    header("location:index.php");
                    exit();
                }
            }
        }
        ?>
        <?php if($err){ echo "<div class='error'><ul  class='pesan'>$err</ul></div>";}?>
        
            
                <!-- <td class="label"></td> -->
                <div class="form2">
                    <input type="text" name="email" placeholder="email"  value="<?php echo $email?>"/>
                    <input type="password" placeholder="password" name="password"  />
                </div>
            
            
                <div> Sudah punya akun? Silakan <a href='<?php echo url_dasar()?>/pendaftaran.php'>daftar</a></div>
            
            
                <!--  -->
                <input type="submit" name="login" value="Login" class="tbl-biru"/>
            
        
    </form>
</div>


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