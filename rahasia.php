<?php include("inc_header.php")?>
<?php 
if($_SESSION['members_email'] == ''){ //dia belum login
    header("location:login.php");
    exit();
}

echo "<script>alert('sukk')</script>";
?>
<div style="background-color: brown;font-size:large;padding:50px;color:#FFFFFF;text-align:center">
Selamat datang <?php echo $_SESSION['members_nama_lengkap']?> di Dashboard Website CritterShield.
</div>
<?php include("inc_footer.php")?>