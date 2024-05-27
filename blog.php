<?php
function get_blog_data($id) {
    global $koneksi;
    $sql = "SELECT * FROM blogs WHERE id = '$id'";
    $query = mysqli_query($koneksi, $sql);
    $result = mysqli_fetch_array($query);
    return $result;
}

function get_blog_comment($id) {
    global $koneksi;
    $sql = "SELECT * FROM komentar WHERE id_blog = '$id'";
    $query = mysqli_query($koneksi, $sql);
    $result = [];
    while ($row = mysqli_fetch_array($query)) {
        $result[] = $row;
    }
    return $result;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $blog = get_blog_data($id);
    $comments = get_blog_comment($id);
} else {
    header('Location: index.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1><?php echo $blog['judul'] ?></h1>
    <p><?php echo $blog['isi'] ?></p>

    <h2>Komentar</h2>
    <form action="komentar_proses.php" method="post">
        <input type="hidden" name="id_blog" value="<?php echo $blog['id'] ?>">
        <textarea name="komentar" id="komentar" cols="30" rows="10"></textarea><br>
        <input type="submit" value="Kirim Komentar">
    </form>

    <?php foreach ($comments as $comment): ?>
        <p><?php echo $comment['komentar'] ?></p>
    <?php endforeach; ?>
</body>
</html>