<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query untuk mendapatkan data user berdasarkan username
    $query = "SELECT * FROM user WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Ambil data user
        $user = $result->fetch_assoc();

        // Verifikasi password tanpa hash
        if ($password === $user['password']) {
            // Password benar, login berhasil
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header("Location: crud_porto.php"); 
            exit();
        } else {
            // Password salah
            echo "<script>alert('Password salah!'); window.location.href = 'login.php';</script>";
        }
    } else {
        // Username tidak ditemukan
        echo "<script>alert('Username tidak ditemukan!'); window.location.href = 'login.php';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Login - Aulia Pool</title>
    <link rel="icon" type="image/x-icon" href="assets/img/logo-01.png" />
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container d-flex align-items-center justify-content-center min-vh-100">
        <div class="card shadow-lg p-4" style="max-width: 400px; width: 100%;">
            <div class="text-center">
                <img src="assets/img/logo-01-removebg-preview.png" alt="Logo" class="img-fluid"
                    style="height: 100px; width: auto;">
                <h4 class="mt-3">Login</h4>
            </div>
            <form action="login.php" method="post">
                <div class="form-group mt-4">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" class="form-control"
                        placeholder="Enter your username" required>
                </div>
                <div class="form-group mt-3">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control"
                        placeholder="Enter your password" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block mt-4">Login</button>
            </form>
            <a href="index.php" class="btn btn-secondary btn-block mt-4">Kembali Ke Halaman Utama</a>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.4.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
