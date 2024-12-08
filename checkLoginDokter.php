<?php
session_start();
require 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password']; // Gunakan nama langsung sebagai password

    // Hash password dengan MD5 untuk dibandingkan dengan yang ada di database
    $hashedPassword = md5($password);

    // Cek apakah username dan password cocok di database
    $query = "SELECT * FROM dokter WHERE nama = '$username' AND password = '$hashedPassword'";
    $result = mysqli_query($mysqli, $query);

    if (mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);

        // Jika login berhasil, simpan data ke sesi
        $_SESSION['id'] = $data['id'];
        $_SESSION['username'] = $data['nama'];
        $_SESSION['password'] = $data['password'];
        $_SESSION['akses'] = "dokter";

        header("location: dashboard_dokter.php"); // Redirect ke dashboard dokter
    } else {
        // Jika tidak ada data yang cocok, kirimkan alert dan kembali ke halaman login
        echo '<script>alert("Username atau password salah!");location.href="loginDokter.php";</script>';
    }
}
?>
