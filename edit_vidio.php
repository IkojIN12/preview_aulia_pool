<?php
// Sertakan file koneksi
include 'koneksi.php';

// Ambil ID dari URL
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Ambil data video berdasarkan ID
    $result = mysqli_query($conn, "SELECT * FROM videos WHERE id=$id");
    $video = mysqli_fetch_assoc($result);

    if (!$video) {
        echo "<script>alert('Data tidak ditemukan!'); window.location.href='crud_vidio.php';</script>";
        exit;
    }
} else {
    echo "<script>alert('ID tidak valid!'); window.location.href='crud_vidio.php';</script>";
    exit;
}

// Proses update data
if (isset($_POST['action']) && $_POST['action'] == 'update') {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);

    // Periksa apakah ada file video baru yang diunggah
    if (!empty($_FILES['video']['name'])) {
        $video_file = $_FILES['video']['name'];
        $video_tmp = $_FILES['video']['tmp_name'];
        $video_size = $_FILES['video']['size'];
        $video_ext = strtolower(pathinfo($video_file, PATHINFO_EXTENSION));
        $allowed_ext = ['mp4', 'avi', 'mov', 'wmv'];

        // Validasi format dan ukuran video
        if (in_array($video_ext, $allowed_ext) && $video_size <= 104857600) { // Maksimal 100MB
            $video_path = "uploads/" . time() . "_" . basename($video_file);

            // Hapus file lama jika ada
            if (file_exists($video['video_path'])) {
                unlink($video['video_path']);
            }

            // Upload file baru
            if (move_uploaded_file($video_tmp, $video_path)) {
                $query = "UPDATE videos SET nama='$nama', deskripsi='$deskripsi', video_path='$video_path' WHERE id=$id";
            } else {
                echo "<script>alert('Gagal mengunggah video baru!');</script>";
            }
        } else {
            echo "<script>alert('Format atau ukuran video tidak valid!');</script>";
        }
    } else {
        // Jika tidak ada file video baru, update hanya nama dan deskripsi
        $query = "UPDATE videos SET nama='$nama', deskripsi='$deskripsi' WHERE id=$id";
    }

    if (isset($query) && mysqli_query($conn, $query)) {
        echo "<script>alert('Data berhasil diperbarui!'); window.location.href='crud_vidio.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui data: " . mysqli_error($conn) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Vidio</title>
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="assets/img/logo-01.png" />
    <!-- Font Awesome -->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700" rel="stylesheet" />
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet" />
</head>
<body id="page-top">
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top" id="mainNav">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <img src="assets/img/logo-01-removebg-preview.png" style="height: 75px; width: auto;" />
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive"
                aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span>Menu</span>
                <i class="fas fa-bars ms-1"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="crud_porto.php">Kelola Galeri</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="crud_vidio.php">Kelola Vidio</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mt-5 pt-5">
        <h2 class="text-center mb-4 text-primary">Edit Vidio</h2>
        <div class="card shadow-sm">
            <div class="card-header bg-info text-dark">Form Edit Vidio</div>
            <div class="card-body">
                <form action="" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="update">
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" name="nama" class="form-control" value="<?php echo $video['nama']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="3" required><?php echo $video['deskripsi']; ?></textarea>
                    </div>
                    <div class="form-group">
                        <label>Video</label>
                        <input type="file" name="video" class="form-control-file">
                        <small class="text-muted">Biarkan kosong jika tidak ingin mengganti video.</small>
                    </div>
                    <div class="text-right">
                        <a href="crud_vidio.php" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS & Dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
