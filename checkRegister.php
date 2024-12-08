<?php

require 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil tanggal, tahun, dan bulan saat ini
    $tanggal = date('d'); // Tanggal
    $tahun = date('y');   // Tahun dalam 2 digit
    $bulan = date('m');   // Bulan

    // Ambil data dari form register
    $nama = $_POST['nama'];
    $no_ktp = $_POST['no_ktp'];
    $alamat = $_POST['alamat'];
    $no_hp = $_POST['no_hp'];
    $password = md5($_POST['password']); // Hash password

    // Validasi input tidak kosong
    if (empty($nama) || empty($no_ktp) || empty($alamat) || empty($no_hp) || empty($password)) {
        echo '<script>alert("Semua kolom harus diisi!");window.location.href="registerPasien.php";</script>';
        exit();
    }

    // Cek apakah no_ktp sudah ada
    $cekNoKTP = "SELECT * FROM pasien WHERE no_ktp = '$no_ktp'";
    $queryCekKTP = mysqli_query($mysqli, $cekNoKTP);
    if (mysqli_num_rows($queryCekKTP) > 0) {
        echo '<script>alert("No KTP telah terdaftar sebelumnya");window.location.href="registerPasien.php";</script>';
        exit();
    }

    // Buat nomor rekam medis dengan format dd/yy/mm-xxx
    $prefix = sprintf('%s%s%s', $tanggal, $tahun, $bulan);
    $getLastData = "SELECT no_rm FROM pasien WHERE no_rm LIKE '$prefix%' ORDER BY no_rm DESC LIMIT 1";
    $queryGetLast = mysqli_query($mysqli, $getLastData);

    if (mysqli_num_rows($queryGetLast) > 0) {
        $lastData = mysqli_fetch_assoc($queryGetLast);
        $substring = substr($lastData['no_rm'], 7); // Ambil 3 digit terakhir
        $urutanTerakhir = (int) $substring + 1; // Increment nomor urut
    } else {
        $urutanTerakhir = 1; // Jika tidak ada data, mulai dari 1
    }

    // Format nomor RM menjadi 3 digit
    $no_rm = sprintf('%s-%03d', $prefix, $urutanTerakhir);

    // Insert data ke database
    $insertData = "INSERT INTO pasien (nama, password, alamat, no_ktp, no_hp, no_rm) VALUES ('$nama', '$password', '$alamat', '$no_ktp', '$no_hp', '$no_rm')";
    $queryInsert = mysqli_query($mysqli, $insertData);

    if ($queryInsert) {
        echo '<script>alert("Pendaftaran akun berhasil");window.location.href="loginPasien.php";</script>';
    } else {
        echo '<script>alert("Pendaftaran akun gagal: ' . mysqli_error($mysqli) . '");window.location.href="registerPasien.php";</script>';
    }
}

// Tutup koneksi
mysqli_close($mysqli);
?>