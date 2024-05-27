<?php include("inc_header.php")?>
<?php 
if(isset($_SESSION['members_email']) == ''){ // not logged in
    header("location:login.php");
    exit();
}
?>
<h3>Ganti Profile Akun</h3>
<?php 
$email          = "";
$nama_lengkap   = "";
$err            = "";
$sukses         = "";

if(isset($_POST['simpan'])){
    $nama_lengkap           = $_POST['nama_lengkap'];
    $password_lama          = $_POST['password_lama'];
    $password               = $_POST['password'];
    $konfirmasi_password    = $_POST['konfirmasi_password'];

    if($nama_lengkap == ''){
        $err .= "<li>Silakan masukkan nama lengkap</li>";
    }

    if($password != ''){ // if password change is requested
        $sql1 = "SELECT * FROM members WHERE email = '".$_SESSION['members_email']."'";
        $q1   = mysqli_query($koneksi, $sql1);
        $r1   = mysqli_fetch_array($q1);
        if(md5($password_lama) != $r1['password']){
            $err .= "<li>Password yang kamu tuliskan tidak sesuai dengan password sebelumnya</li>";
        }

        if($password_lama == '' || $konfirmasi_password == '' || $password == ''){
            $err .= "<li>Silakan masukkan password lama, password baru serta konfirmasi password</li>";
        }

        if($password != $konfirmasi_password){
            $err .= "<li>Silakan masukkan password dan konfirmasi password yang sama</li>";
        }

        if(strlen($password) < 6){
            $err .= "<li>Panjang karakter yang diizininkan untuk password adalah 6 karakter, minimal.</li>";
        }
    }

    if(empty($err)){
        $sql1 = "UPDATE members SET nama_lengkap = '".$nama_lengkap."' WHERE email = '".$_SESSION['members_email']."'";
        mysqli_query($koneksi, $sql1);
        $_SESSION['members_nama_lengkap'] = $nama_lengkap;

        if($password){
            $sql2 = "UPDATE members SET password = md5('".$password."') WHERE email = '".$_SESSION['members_email']."'";
            mysqli_query($koneksi, $sql2);
        }

        $sukses = "Successfully update profile";
    }
}
?>
<?php if($err) {echo "<div class='error'><ul>$err</ul></div>";} ?>
<?php if($sukses) {echo "<div class='sukses'>$sukses</div>";} ?>

<form action="" method="POST">
    <table>
        <tr>
            <td class="label">Email</td>
            <td>
                <?php echo $_SESSION['members_email']?>
            </td>
        </tr>
        <tr>
            <td class="label">Nama Lengkap</td>
            <td>
                <input type="text" name="nama_lengkap" class="input" value="<?php echo $_SESSION['members_nama_lengkap']?>"/>
            </td>
        </tr>
        <tr>
            <td class="label">Password Lama</td>
            <td>
                <input type="password" name="password_lama" class="input" />
            </td>
        </tr>
        <tr>
            <td class="label">Password Baru</td>
            <td>
                <input type="password" name="password" class="input" />
            </td>
        </tr>
        <tr>
            <td class="label">Konfirmasi Password</td>
            <td>
                <input type="password" name="konfirmasi_password" class="input" />
            </td>
        </tr>
        <tr>
            <td></td>
            <td>
                <input type="submit" name="simpan" value="Save Changes" class="tbl-biru"/>
                <a href="index.php" class="tbl-biru">No</a>
            </td>
        </tr>
        <tr>
        <td></td>
        <td>
            <!-- <a href="index.php" class="tbl-biru">Close</a> -->
        </td>
        </tr>
    </table>
</form>


