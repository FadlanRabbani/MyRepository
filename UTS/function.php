<?php

session_start();

//koneksi
$c = mysqli_connect('localhost','root','','kasir_minimarket');

//login
if(isset($_POST['login'])){
    //inisialisasi variabel
    $username = $_POST['username'];
    $password = $_POST['password'];

    $check = mysqli_query($c,"SELECT * FROM user WHERE username='$username' and password='$password'");
    $hitung = mysqli_num_rows($check);

    if($hitung>0){
        //berhasil
        $_SESSION['login'] = 'True';
        header('location:index.php');
    } else {
        echo '
        <script>
        alert("Username atau Password salah!");
        window.location.href="login.php"
        </script>
        ';
        exit;
    }
}

if(isset($_POST['tambahbarang'])){
    $namaproduk = $_POST['namaproduk'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga'];
    $stock = $_POST['stock'];

    // $insert = mysqli_query($c,"INSERT INTO produk (nama_produk,deskripsi,harga,stock) values ('$namaproduk','$deskripsi','$harga','$stock')");
    
    // Validate input types

    if (!is_numeric($harga) || !is_numeric($stock)) {
        echo '
        <script>
        alert("Harga dan Stock harus berupa angka!");
        window.location.href="stock.php";
        </script>
        ';
        exit; // Stop further execution
    }

    // Prepare and execute the insert query
    $insert = mysqli_query($c, "INSERT INTO produk (nama_produk, deskripsi, harga, stock) VALUES ('$namaproduk', '$deskripsi', '$harga', '$stock')");

    if ($insert) {
        header('location:stock.php');
    } else {
        // Capture MySQL error
        $error = mysqli_error($c);
        echo '
        <script>
        alert("Gagal menambah barang baru! Error: ' . $error . '");
        window.location.href="stock.php";
        </script>
        ';
    }
    
    // if($insert){
    //     header('location:stock.php');
    // } else {
    //     echo '
    //     <script>
    //     alert("Gagal menambah barang baru!");
    //     window.location.href="stock.php"
    //     </script>
    //     ';
    // }
}

if(isset($_POST['editbarang'])){
    $namaproduk = $_POST['namaproduk'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga'];
    $stock = $_POST['stock'];
    $idp = $_POST['idp'];

    if (!is_numeric($harga) || !is_numeric($stock)) {
        echo '
        <script>
        alert("Harga dan Stock harus berupa angka!");
        window.location.href="stock.php";
        </script>
        ';
        exit; // Stop further execution
    }
    
    $query = mysqli_query($c,"UPDATE produk SET nama_produk='$namaproduk', deskripsi='$deskripsi', harga='$harga', stock='$stock' WHERE id_produk='$idp'");
    
    if ($query) {
        header('location:stock.php');
    } else {
        // Capture MySQL error
        $error = mysqli_error($c);
        echo '
        <script>
        alert("Gagal mengedit barang! Error: ' . $error . '");
        window.location.href="stock.php";
        </script>
        ';
    }
}

if(isset($_POST['deletebarang'])){
    $idp = $_POST['idp'];
    
    $query = mysqli_query($c,"DELETE FROM produk WHERE id_produk='$idp'");
    
    if ($query) {
        header('location:stock.php');
    } else {
        // Capture MySQL error
        $error = mysqli_error($c);
        echo '
        <script>
        alert("Gagal menghapus barang! Error: ' . $error . '");
        window.location.href="stock.php";
        </script>
        ';
    }
}
?>