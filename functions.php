<?php
// 1. koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "phpdasar");

function query($query) {
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)){
        $rows[] = $row;
    }
    return $rows;
}

function create($data) {
    global $conn;
    // ambil data dari tiap elemen dalam form
    $nama = htmlspecialchars($data["nama"]);
    $bounty = htmlspecialchars($data["bounty"]);
    $pangkat = htmlspecialchars($data["pangkat"]);
    $kekuatan = htmlspecialchars($data["kekuatan"]);

    // upload gambar
    $gambar = upload();

    if(!$gambar) {
        return false;
    }

    // query insert data
    $query = "INSERT INTO crew
    VALUES
    ('','$nama','$bounty','$pangkat','$kekuatan','$gambar')
    ";
mysqli_query($conn, $query);

return mysqli_affected_rows($conn);
}

function upload() {
    $namaFile = $_FILES['gambar']['name'];
    $ukuranFile = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $tmpName = $_FILES['gambar']['tmp_name'];

    //cek apakah tidak ada gambar yang diupload
    if($error == 4) {
        echo    "<script>
                    alert('Pilih gambar terlebih dahulu!');
                </scrpit>";
        return false;
    }

    //cek apakah yang di upload gambar atau bukan
    $ekstensiGambarValid = ['jpg','jpeg','png']; // jenis gambar yang diizinkan
    $ekstensiGambar = explode('.', $namaFile); // memecah nama file gambar (ex : agi.jpg menjadi array ['agi','jpg'])
    $ekstensiGambar = strtolower(end($ekstensiGambar)); 
    // fungsi end() untuk mengambil nama paling belakang dari array tadi 
    // dan fungsi strtolower() untuk mengubah huruf besar menjadi huruf kecil karena JPG dan jpg itu berbeda 
    // sehingga JPG di kecilkan jadi jpg dan sesuai dengan yang ditentukan diatas
    if(!in_array($ekstensiGambar, $ekstensiGambarValid))  { // cek ke-validan file yang di upload (harus gambar)
        echo    "<script>
                    alert('ERROR! Anda wajib mengupload gambar dengan type : jgp, jpeg, atau png!');
                </script>";
    }

    //cek jika ukuran gambar terlalu besar
    if($ukuranFile > 2000000 ) { // 2.000.000 byte == 2 MB
        echo    "<script>
                    alert('Ukuran file gambar yang di upload terlalu besar!');
                </script>";
    }
    
    // lolos pengecekan, gambar siap diupload
    
    // generate nama gambar baru
    $namaFileBaru = uniqid(); // fungsi uniqid() mengenerate angka random
    $namaFileBaru .='.';
    $namaFileBaru .= $ekstensiGambar;
    move_uploaded_file($tmpName, 'img/'.$namaFileBaru);

    return $namaFileBaru;
}

function delete($id) {
    global $conn;
    mysqli_query($conn, "DELETE FROM crew WHERE id =$id");
    return mysqli_affected_rows($conn);
}

function update($data) {
    global $conn;
    // ambil data dari tiap elemen dalam form
    $id = $data["id"];
    $nama = htmlspecialchars($data["nama"]);
    $bounty = htmlspecialchars($data["bounty"]);
    $pangkat = htmlspecialchars($data["pangkat"]);
    $kekuatan = htmlspecialchars($data["kekuatan"]);
    $gambarlama = htmlspecialchars($data["gambarLama"]);
    
    // cek apakah user pilih gambar baru atau tidak
    if($_FILES['gambar']['error'] === 4) {
        $gambar = $gambarlama;
    } else {
        $gambar = upload();
    }
    

    //query update data
    $query = "UPDATE crew SET
                nama = '$nama',
                bounty = '$bounty',
                pangkat = '$pangkat',
                kekuatan = '$kekuatan',
                gambar = '$gambar'
            WHERE id = $id
            ";
mysqli_query($conn, $query);

return mysqli_affected_rows($conn);
}

function search($keyword) {
    $query="SELECT * FROM crew 
                WHERE 
                nama LIKE '%$keyword%' OR
                bounty LIKE '%$keyword%' OR
                pangkat LIKE '%$keyword%' OR
                kekuatan LIKE '%$keyword%' 
            ";
    return query($query);
}

function register($data) {
    global $conn;

    $username = strtolower(stripslashes($data["username"])); // fungsi stripslashes untuk menghilangkan slash
    $password = mysqli_real_escape_string($conn, $data["password"]); // fungsi mysqli_real_escape_string() memungkinkan user menambahkan tanda kutip dan masuk ke database
    $password2 = mysqli_real_escape_string($conn, $data["password2"]);

    // cek username sudah ada atau belum
    $result = mysqli_query($conn, "SELECT username FROM users WHERE username = '$username'");
    
    if(mysqli_fetch_assoc($result)){
        echo "<script>
                alert('Username sudah ada! Silahkan pilih nama lain');
            </script>";
        return false;
    }

    // cek konfrimasi password
    if($password != $password2) {
        echo "<script>
                alert('Konfirmasi password tidak sesuai!');
            </script>";
        return false;
    }

    //enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);
    
    // tambahkan user baru ke database
    mysqli_query($conn, "INSERT INTO users VALUES('','$username','$password')");

    return mysqli_affected_rows($conn); // untuk menghasilkan 1 jika berhasil dan -1 jika tidak berhasil

}
?>