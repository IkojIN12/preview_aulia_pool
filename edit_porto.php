<?php
// Sertakan file koneksi
include 'koneksi.php';

// Ambil data berdasarkan ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM portofolio WHERE id=$id";
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($result);

    if (!$data) {
        echo "Data tidak ditemukan!";
        exit;
    }
}

// Handle Update Data
if (isset($_POST['action']) && $_POST['action'] == "update") {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $deskripsi = $_POST['deskripsi'];

    // Cek apakah ada file foto baru
    if (!empty($_FILES['foto']['name'])) {
        $foto = $_FILES['foto']['name'];
        $target = "uploads/" . basename($foto);
        move_uploaded_file($_FILES['foto']['tmp_name'], $target);

        // Update dengan foto baru
        $query = "UPDATE portofolio SET 
                    nama='$nama', 
                    alamat='$alamat', 
                    deskripsi='$deskripsi', 
                    foto='$target' 
                  WHERE id=$id";
    } else {
        // Update tanpa mengganti foto
        $query = "UPDATE portofolio SET 
                    nama='$nama', 
                    alamat='$alamat', 
                    deskripsi='$deskripsi' 
                  WHERE id=$id";
    }

    mysqli_query($conn, $query);

    // Redirect kembali ke halaman utama
    header("Location: crud_porto.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Portofolio</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container my-5">
        <h2 class="text-center text-warning mb-4">Edit Portofolio</h2>
        <div class="card shadow-sm">
            <div class="card-body">
                <form action="edit_porto.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="id" value="<?php echo $data['id']; ?>">

                    <div class="mb-3">
                        <label>Nama</label>
                        <input type="text" name="nama" class="form-control" value="<?php echo $data['nama']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label>Alamat</label>
                        <input type="text" name="alamat" class="form-control" value="<?php echo $data['alamat']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label>Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="3" required><?php echo $data['deskripsi']; ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label>Foto Saat Ini</label><br>
                        <img src="<?php echo $data['foto']; ?>" alt="Foto" width="150" class="img-thumbnail mb-2">
                    </div>
                    <div class="mb-3">
                        <label>Ganti Foto</label>
                        <input type="file" name="foto" class="form-control">
                        <small class="text-muted">Kosongkan jika tidak ingin mengubah foto.</small>
                    </div>
                    <div class="d-flex justify-content-end">
                        <a href="crud_porto.php" class="btn btn-secondary me-2">Batal</a>
                        <button type="submit" class="btn btn-warning">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// Tutup koneksi database
mysqli_close($conn);
?>
