<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include("koneksi.php");
include_once 'navbar.php';

$error = "";

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    // Periksa kesamaan password dan konfirmasi password
    if ($password !== $confirmPassword) {
        $error = "Password dan Konfirmasi Password tidak cocok!";
    } else {
        // Periksa apakah username sudah ada di database
        $query = "SELECT * FROM user WHERE username = ?";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error = "Username sudah digunakan, silakan pilih username lain.";
        } else {
            // Hash password dan simpan data jika username belum ada
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $insertQuery = "INSERT INTO user (username, password) VALUES (?, ?)";
            $stmt = $mysqli->prepare($insertQuery);
            $stmt->bind_param("ss", $username, $hashedPassword);

            if ($stmt->execute()) {
                echo "<script>
                        alert('Registrasi berhasil ditambahkan');
                        window.location.href = 'index.php?page=loginUser.php';
                      </script>";
                exit;
            } else {
                $error = "Registrasi gagal. Silakan coba lagi.";
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .register-container {
            max-width: 1000px;
            width: 500px;
            margin-top: 80px;
        }
        .register-title  {
            font-size: 24px;
            font-weight: bold;
        }
        .card-body{
            border: 1px solid #ddd;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }
    </style>
</head>
<body>
    <h1>RegistrasiUser</h1>
<div class="container d-flex justify-content-center">
    <div class="card register-container shadow">
        <div class="card-body">
            <h2 class="text-center register-title mb-4">Register</h2>
            <?php if ($error): ?>
                <div class="alert alert-danger" role="alert">
                    <?= $error ?>
                </div>
            <?php endif; ?>
            <div>
                <form method="POST" action="registrasiUser.php">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Konfirmasi Password</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Konfirmasi password" required>
                    </div>
                    <button type="submit" name="register" class="btn btn-primary w-100">Register</button>
                </form>
            <div class="login-link mt-3">
                Sudah punya akun? <a href="index.php?page=loginUser.php">Login</a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
