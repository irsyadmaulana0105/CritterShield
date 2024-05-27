<?php include("inc_sidebar.php") ?>
<body style='background-color:#F7DFD4'>
<?php
$sukses = "";
$katakunci = (isset($_GET['katakunci'])) ? $_GET['katakunci'] : "";
if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}
if ($op == 'delete') {
    $id = $_GET['id'];
    $sql1   = "select isi from about where id = '$id'";
    $q1     = mysqli_query($koneksi,$sql1);
    $r1     = mysqli_fetch_array($q1);
    @unlink("../gambar/".$r1['isi']);
 
    $sql1   = "delete from about where id = '$id'";
    $q1     = mysqli_query($koneksi, $sql1);
    if ($q1) {
        $sukses     = "Berhasil hapus data";
    }
}
?>
<div class="container">
<h1>Halaman Penyakit dan Hama</h1>
<!-- <p>
    <a href="about_input.php">
        <input type="button" class="btn btn-primary" value="Tambah Penyakit Baru" />
    </a>
</p> -->
<?php
if ($sukses) {
?>
    <div class="alert alert-primary" role="alert">
        <?php echo $sukses ?>
    </div>
<?php
}
?>

<table class="table table-striped">
    <thead>
        <tr>
            <th class="col-1">ID</th>
            <th class="col-2">Isi </th>
            <th>penanganan</th>
            <th class="col-2">Pencegahan</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sqltambahan = "";
        $per_halaman = 5;
        if ($katakunci != '') {
            $array_katakunci = explode(" ", $katakunci);
            for ($x = 0; $x < count($array_katakunci); $x++) {
                $sqlcari[] = "(nama like '%" . $array_katakunci[$x] . "%' or isi like '%" . $array_katakunci[$x] . "%')";
            }
            $sqltambahan    = " where " . implode(" or ", $sqlcari);
        }
        $sql1   = "select * from about $sqltambahan";
        $page   = isset($_GET['page'])?(int)$_GET['page']:1;
        $mulai  = ($page > 1) ? ($page * $per_halaman) - $per_halaman : 0;
        $q1     = mysqli_query($koneksi,$sql1);
        $total  = mysqli_num_rows($q1);
        $pages  = ceil($total / $per_halaman);
        $nomor  = $mulai + 1;
        // $sql1   = $sql1." order by id desc limit $mulai,$per_halaman"; // Order by ID in descending order

        // // $q1     = mysqli_query($koneksi, $sql1);
        // print_r(mysqli_fetch_assoc($q1));
        while ($r1 = mysqli_fetch_array($q1)) {
        ?>
            <tr>
                <td><?php echo $r1['id'] ?></td>
                <td><?php echo $r1['isi'] ?></td>
                <td><?php echo $r1['penanganan'] ?></td>
                <td><?php echo $r1['pencegahan'] ?></td>
                <td>
                    <a href="about_input.php?id=<?php echo $r1['id']?>">
                        <span class="badge bg-warning text-dark">Edit</span>
                    </a>

                    <a href="about.php?op=delete&id=<?php echo $r1['id'] ?>" onclick="return confirm('Apakah yakin mau hapus data bro?')">
                        <span class="badge bg-danger">Delete</span>
                    </a>
                </td>
            </tr>
        <?php
        }
        ?>

    </tbody>
</table>

<nav aria-label="Page navigation example">
    <ul class="pagination">
        <?php 
        $cari = isset($_GET['cari'])? $_GET['cari'] : "";

        for($i=1; $i <= $pages; $i++){
            ?>
            <li class="page-item">
                <a class="page-link" href="about.php?katakunci=<?php echo $katakunci?>&cari=<?php echo $cari?>&page=<?php echo $i ?>"><?php echo $i ?></a>
            </li>
            <?php
        }
        ?>
    </ul>
</nav>
</div>
