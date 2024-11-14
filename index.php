<!DOCTYPE html>
<html>
<head>
    <title>Poliklinik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php
session_start();
include_once 'navbar.php';

// Fungsi untuk redirect ke halaman login jika belum login
function redirectToLoginIfNotLoggedIn() {
    if (!isset($_SESSION['username'])) {
        header("Location: loginUser.php");
        exit;
    }
}

?>

<div class="container mt-4">
    <?php
    if (isset($_GET['page'])) {
        $page = $_GET['page'];
        
        switch ($page) {
            case 'dokter':
                redirectToLoginIfNotLoggedIn(); // Cek login sebelum akses
                include 'dokter.php';
                break;
            case 'pasien':
                redirectToLoginIfNotLoggedIn(); // Cek login sebelum akses
                include 'pasien.php';
                break;
            case 'periksa':
                redirectToLoginIfNotLoggedIn(); // Cek login sebelum akses
                include 'periksa.php';
                break;
            case 'loginUser.php':
                include 'loginUser.php';
                break;
            case 'registrasiUser.php':
                include 'registrasiUser.php';
                break;
            case 'home':
            default:
                echo "<h1>Selamat Datang di Sistem Informasi Poliklinik</h1>";
                echo "<h2>Silakan Login</h2>";
                break;
        }
    } else {
        echo "<h1>Selamat Datang di Sistem Informasi Poliklinik</h1>";
    }
    ?>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
