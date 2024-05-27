<?php
// $output = shell_exec("npm start");
// $json_content = file_get_contents('data.json');
// $hasil = json_decode($json_content, true);
// var_dump($hasil);

// $nama = $data['nama'];
// $skor = $data['skor'];
// $tanggal = $data['tanggal'];
// $link = $data['link'];

// echo "Name: " . $name . "<br>";
// echo "skor: " . $skor . "<br>";
// echo "tanggal: " . $tanggal . "<br>";
// echo "link: " . $link . "<br>";


$output = shell_exec("npm start");
$json_content = file_get_contents('jspicek/data.json');
$hasil = json_decode($json_content, true);
if ($hasil === null && json_last_error() !== JSON_ERROR_NONE) {
    die('Error parsing JSON');
}
// var_dump($hasil);

$nama = $hasil['nama'];
$skor = $hasil['skor'];
$tanggal = $hasil['tanggal'];
$link = $hasil['link'];
$path = $hasil['path'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CritterShield</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f0f0f0;
            margin: 0;
        }
        table {
            border-collapse: collapse;
            width: 80%;
            margin: 20px 0;
            background: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #FEDAC1;
            color: white;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        img {
            max-width: 200px;
            height: auto;
        }
        .back-button {
            position: absolute;
            top: 20px; /* Adjust as needed */
            left: 20px; /* Adjust as needed */
            padding: 5px 10px;
            font-size: 16px;
            cursor: pointer;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            z-index: 999; /* Ensure the button appears on top of other content */
        }
        .back-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <table>
        <tr>
            <th>Name</th>
            <th>Skor</th>
            <th>Tanggal</th>
            <th>Link</th>
            <th>Gambar</th>
        </tr>
        <tr>
            <td><?php echo htmlspecialchars($nama); ?></td>
            <td><?php echo htmlspecialchars($skor); ?></td>
            <td><?php echo htmlspecialchars($tanggal); ?></td>
            <td><a href="<?php echo htmlspecialchars($link); ?>" target="_blank"><?php echo htmlspecialchars($link); ?></a></td>
            <td><img src="<?php echo htmlspecialchars($path); ?>" alt="Gambar"></td>
        </tr>
    </table>
    <a class="back-button" href="javascript:history.go(-1)">Back</a>
</body>
</html>
