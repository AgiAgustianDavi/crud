<?php
session_start();
if(!isset($_SESSION["login"])) { // jika tidak ada sesi login maka tendang user ke halaman login
    header("location: login.php");
    exit;
}
require 'functions.php';
$kru = query("SELECT * FROM crew ORDER BY id ASC "); // ORDER BY id ASC(mengurutkan dari id paling kecil ke besar) | DESC(mengurutkan dari id paling besar ke kecil)

// jika tombol cari di klik
if(isset($_POST["cari"])) {
    $kru = search($_POST["keyword"]);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Admin</title>
</head>
<body>
    <a href="logout.php">Log Out!</a>
    <h1>Daftar Kru Mugiwara</h1>
    <a href="create.php">Tambah data Kru Mugiwara</a>
    <br><br>
    <form action="" method="post" >
        <input type="text" name="keyword" size="35" autofocus 
        placeholder="Masukkan keyword pencarian" autocomplete="off">
        <button type="submit" name="cari" >Cari!</button>
    </form>
    <br>
    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>No.</th>
            <th>Aksi</th>
            <th>Gambar</th>
            <th>Nama</th>
            <th>Bounty</th>
            <th>Pangkat</th>
            <th>Kekuatan</th>
        </tr>

        <?php $i = 1; ?>
        <?php foreach ($kru as $k) : ?>
        <tr>
            <td><?= $i; ?></td>
            <td>
                <a href="update.php?id=<?= $k["id"]; ?>" >ubah</a> |
                <a href="delete.php?id=<?= $k["id"]; ?>" onclick="return confirm('yakin?');">hapus</a>
            </td>
            <td><img src="img/<?= $k["gambar"]; ?>" width="100" height="100" alt=""></td>
            <td><?= $k["nama"]; ?></td>
            <td><?= $k["bounty"]; ?></td>
            <td><?= $k["pangkat"]; ?></td>
            <td><?= $k["kekuatan"]; ?></td>
        </tr>
        <?php $i++; ?>
        <?php endforeach; ?>
    </table>
</body>
</html>