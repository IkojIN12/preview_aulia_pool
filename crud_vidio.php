<?php
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Sertakan file koneksi
include 'koneksi.php';

// Handle Create, Update, Delete Actions
if (isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action == "create") {
        $nama = mysqli_real_escape_string($conn, $_POST['nama']);
        $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);

        // Upload Video
        $video = $_FILES['video']['name'];
        $video_tmp = $_FILES['video']['tmp_name'];
        $video_size = $_FILES['video']['size'];
        $video_ext = strtolower(pathinfo($video, PATHINFO_EXTENSION));
        $allowed_ext = ['mp4', 'avi', 'mov', 'wmv'];

        // Validasi Format Video
        if (in_array($video_ext, $allowed_ext)) {
            if ($video_size <= 104857600) { // Maksimal 100MB
                $video_path = "uploads/" . time() . "_" . basename($video);
                if (move_uploaded_file($video_tmp, $video_path)) {
                    // Simpan ke database
                    $query = "INSERT INTO videos (nama, deskripsi, video_path) 
                              VALUES ('$nama', '$deskripsi', '$video_path')";
                    if (mysqli_query($conn, $query)) {
                        echo "<script>alert('Video berhasil diunggah!'); window.location.href='crud_vidio.php';</script>";
                    } else {
                        // Tampilkan error MySQL
                        echo "<script>alert('Gagal menyimpan data ke database: " . mysqli_error($conn) . "');</script>";
                    }
                } else {
                    echo "<script>alert('Gagal mengunggah video ke server.');</script>";
                }
            } else {
                echo "<script>alert('Ukuran file terlalu besar. Maksimal 100MB.');</script>";
            }
        } else {
            echo "<script>alert('Format file tidak diizinkan. Hanya MP4, AVI, MOV, WMV.');</script>";
        }
    } elseif ($action == "delete") {
        $id = intval($_POST['id']);

        // Hapus file video
        $result = mysqli_query($conn, "SELECT video_path FROM videos WHERE id=$id");
        $row = mysqli_fetch_assoc($result);
        if ($row && file_exists($row['video_path'])) {
            unlink($row['video_path']);
        }

        // Hapus data dari database
        $query = "DELETE FROM videos WHERE id=$id";
        if (mysqli_query($conn, $query)) {
            echo "<script>alert('Video berhasil dihapus!'); window.location.href='crud_vidio.php';</script>";
        } else {
            echo "<script>alert('Gagal menghapus data dari database: " . mysqli_error($conn) . "');</script>";
        }
    }
}
// Ambil data video
$result = mysqli_query($conn, "SELECT * FROM videos ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Vidio</title>
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
                        <a class="nav-link text-dark" href="crud_porto.php">Kelola Galeri</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="crud_vidio.php">Kelola Vidio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mt-5 pt-5">
    <h2 class="text-center mb-5 text-primary"></h2>
        <div class="text-right mb-3">
            <button class="btn btn-success" data-toggle="modal" data-target="#addModal">
                <i class="fas fa-plus"></i> Tambah Data
            </button>
        </div>

        <!-- Modal Tambah Data -->
        <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title" id="addModalLabel">Tambah Vidio</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="action" value="create">
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Nama</label>
                                <input type="text" name="nama" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Deskripsi</label>
                                <textarea name="deskripsi" class="form-control" rows="3" required></textarea>
                            </div>
                            <div class="form-group">
                                <label>Video</label>
                                <input type="file" name="video" class="form-control-file" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-success">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Tabel Vidio -->
        <div class="card shadow-sm">
            <div class="card-header bg-info text-dark text-center">Daftar Vidio</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead class="bg-dark text-white">
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>Deskripsi</th>
                                <th>Video</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                <tr>
                                    <td><?php echo $row['id']; ?></td>
                                    <td><?php echo $row['nama']; ?></td>
                                    <td><?php echo $row['deskripsi']; ?></td>
                                    <td>
                                        <video width="160" height="120" controls>
                                            <source src="<?php echo $row['video_path']; ?>" type="video/mp4">
                                            Browser Anda tidak mendukung tag video.
                                        </video>
                                    </td>
                                    <td>
                                        <button class="btn btn-danger btn-sm mb-3" data-toggle="modal" data-target="#confirmDeleteModal" data-id="<?php echo $row['id']; ?>">Hapus</button>
                                        <a href="edit_vidio.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm mb-3">Edit</a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus data ini?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <form id="deleteForm" action="" method="POST" style="display: inline;">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="id" id="deleteId">
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS & Dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Script untuk Menyimpan ID ke Modal Konfirmasi Hapus -->
    <script>
        $('#confirmDeleteModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var modal = $(this);
            modal.find('#deleteId').val(id);
        });
    </script>
</body>
</html>
