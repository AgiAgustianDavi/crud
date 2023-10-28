<?php
session_start();
if(!isset($_SESSION["login"])) { // jika tidak ada sesi login maka tendang user ke halaman login
    header("location: login.php");
    exit;
}
require 'functions.php';

// ambil data di URL
$id = $_GET["id"];

// query data kru berdasarkan id
$kru = query("SELECT * FROM crew WHERE id=$id")[0];

// cek apakah tombol submit sudah ditekan atau belum
if( isset($_POST["submit"])) {

    // cek apakah data berhasil diubah atau tidak
    if( update($_POST) > 0) {
        echo "
            <script>
                alert('data berhasil diubah!');
                document.location.href = 'index.php';
            </script>
            ";
    } else {
        echo "
            <script>
                alert('data gagal diubah!');
                document.location.href = 'index.php';
            </script>
            ";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update data kru</title>
</head>
<body>
    <h1>Update data kru Topi Jerami</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $kru["id"]; ?>">
        <input type="hidden" name="gambarLama" value="<?= $kru["gambar"]; ?>">
        <ul>
            <li>
                <label for="nama">Nama : </label>
                <input type="text" name="nama" id="nama" required value="<?= $kru["nama"]; ?>">
            </li>
            <li>
                <label for="bounty">Bounty : </label>
                <input type="text" name="bounty" id="bounty" required value="<?= $kru["bounty"]; ?>">
            </li>
            <li>
                <label for="pangkat">Pangkat : </label>
                <input type="text" name="pangkat" id="pangkat" required value="<?= $kru["pangkat"]; ?>" >
            </li>
            <li>
                <label for="kekuatan">Kekuatan : </label>
                <input type="text" name="kekuatan" id="kekuatan" required value="<?= $kru["kekuatan"]; ?>" >
            </li>
            <li>
                <label for="gambar">Gambar : </label>
                <br>
                <img src="img/<?= $kru['gambar'] ?>" width="75" height="75" alt="">
                <br>
                <input type="file" name="gambar" id="gambar" >
            </li>
            <li>
                <button type="submit" name="submit">Update data!</button>
            </li>
        </ul>
    </form>
</body>
</html>