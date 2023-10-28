<?php
session_start();
if(!isset($_SESSION["login"])) { // jika tidak ada sesi login maka tendang user ke halaman login
    header("location: login.php");
    exit;
}
require 'functions.php';

// cek apakah tombol submit sudah ditekan atau belum
if( isset($_POST["submit"])) {

    // cek apakah data berhasil ditambahkan atau tidak
    if( create($_POST) > 0) {
        echo "
            <script>
                alert('data berhasil ditambahkan!');
                document.location.href = 'index.php';
            </script>
            ";
    } else {
        echo "
            <script>
                alert('data gagal ditambahkan!');
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
    <title>Tambah data kru</title>
</head>
<body>
    <h1>Tambah data kru Topi Jerami</h1>
    <form action="" method="post" enctype="multipart/form-data" > 
        <ul>
            <li>
                <label for="nama">Nama : </label>
                <input type="text" name="nama" id="nama" required>
            </li>
            <li>
                <label for="bounty">Bounty : </label>
                <input type="text" name="bounty" id="bounty" required>
            </li>
            <li>
                <label for="pangkat">Pangkat : </label>
                <input type="text" name="pangkat" id="pangkat" required>
            </li>
            <li>
                <label for="kekuatan">Kekuatan : </label>
                <input type="text" name="kekuatan" id="kekuatan" required>
            </li>
            <li>
                <label for="gambar">Gambar : </label>
                <input type="file" name="gambar" id="gambar" required>
            </li>
            <li>
                <button type="submit" name="submit">Create data!</button>
            </li>
        </ul>
    </form>
</body>
</html>