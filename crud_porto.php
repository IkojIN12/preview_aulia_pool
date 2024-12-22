<?php
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'koneksi.php';

if (isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action == "create") {
        $nama = $_POST['nama'];
        $alamat = $_POST['alamat'];
        $deskripsi = $_POST['deskripsi'];
        $foto = $_FILES['foto']['name'];
        $target = "uploads/" . basename($foto);
        $imageFileType = strtolower(pathinfo($target, PATHINFO_EXTENSION));
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($imageFileType, $allowedTypes)) {
            if (move_uploaded_file($_FILES['foto']['tmp_name'], $target)) {
                $query = "INSERT INTO portofolio (nama, alamat, deskripsi, foto) 
                          VALUES ('$nama', '$alamat', '$deskripsi', '$target')";
                mysqli_query($conn, $query);
                echo "<script>alert('Data berhasil ditambahkan!');</script>";
            } else {
                echo "<script>alert('Gagal mengunggah file.');</script>";
            }
        } else {
            echo "<script>alert('Hanya file dengan format JPG, JPEG, PNG, atau GIF yang diperbolehkan.');</script>";
        }
    } elseif ($action == "delete") {
        $id = $_POST['id'];
        $query = "DELETE FROM portofolio WHERE id=$id";
        mysqli_query($conn, $query);
        echo "<script>alert('Data berhasil dihapus!');</script>";
    }
}

$result = mysqli_query($conn, "SELECT * FROM portofolio");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Galeri</title>
    <link rel="icon" type="image/x-icon" href="assets/img/logo-01.png" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
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
                    <li class="nav-item"><a class="nav-link text-dark" href="crud_porto.php">Kelola Galeri</a></li>
                    <li class="nav-item"><a class="nav-link text-dark" href="crud_vidio.php">Kelola Vidio</a></li>
                    <li class="nav-item"><a class="nav-link text-dark" href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Main Content -->
    <div class="container mt-5 pt-5">
        <h2 class="text-center mb-3 text-primary"></h2>
        <!-- Tombol Tambah Data -->
        <div class="text-right mt-5 mb-3">
            <button class="btn btn-success" data-toggle="modal" data-target="#addModal">
                <i class="fas fa-plus"></i> Tambah Data
            </button>
        </div>

        <!-- Modal Tambah Data -->
        <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title" id="addModalLabel">Tambah Portofolio</h5>
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
                                <label>Alamat</label>
                                <input type="text" name="alamat" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Deskripsi</label>
                                <textarea name="deskripsi" class="form-control" rows="3" required></textarea>
                            </div>
                            <div class="form-group">
                                <label>Foto</label>
                                <input type="file" name="foto" class="form-control-file" accept="image/*" required>
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

        <!-- Tabel Galeri -->
        <div class="card shadow-sm">
            <div class="card-header bg-info text-dark text-center">Daftar Galeri</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead class="bg-dark text-white">
                            <tr>
                                <th>#id</th>
                                <th>Nama</th>
                                <th>Alamat</th>
                                <th>Deskripsi</th>
                                <th>Foto</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                <tr>
                                    <td><?php echo $row['id']; ?></td>
                                    <td><?php echo $row['nama']; ?></td>
                                    <td><?php echo $row['alamat']; ?></td>
                                    <td><?php echo $row['deskripsi']; ?></td>
                                    <td>
                                        <img src="<?php echo $row['foto']; ?>" alt="Foto" width="80" height="80"
                                            class="img-thumbnail">
                                    </td>
                                    <td>
                                        <button class="btn btn-danger btn-sm mb-3" data-toggle="modal"
                                            data-target="#confirmDeleteModal"
                                            data-id="<?php echo $row['id']; ?>">Hapus</button>
                                        <a href="edit_porto.php?id=<?php echo $row['id']; ?>"
                                            class="btn btn-warning btn-sm mb-3">Edit</a>
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
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel"
        aria-hidden="true">
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

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $('#confirmDeleteModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            $('#deleteId').val(id);
        });
    </script>
</body>

</html>