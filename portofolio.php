<?php
include 'koneksi.php'; 
?>

<section class="page-section" id="portfolio" style="background-color: #e7f5ff; padding: 50px 0;">
    <div class="container">
        <div class="text-center">
            <h2 class="section-heading text-uppercase">Galeri Kami</h2>
            <h3 class="section-subheading text-muted">--------------</h3>
        </div>
        <div class="row">
            <?php
            // Query untuk ambil data dari tabel portofolio
            $query = "SELECT * FROM portofolio";
            $result = mysqli_query($conn, $query);

            // Perulangan untuk menampilkan setiap data portofolio
            while ($row = mysqli_fetch_assoc($result)) {
            ?>
                <div class="col-lg-4 col-sm-6 mb-4">
                    <div class="portfolio-item">
                        <a class="portfolio-link" data-bs-toggle="modal" href="#portfolioModal<?php echo $row['id']; ?>">
                            <div class="portfolio-hover">
                                <div class="portfolio-hover-content"><i class="fas fa-plus fa-3x"></i></div>
                            </div>
                            <img class="img-fluid" style="width: 100%; height: 200px; object-fit: cover;" src="<?php echo $row['foto']; ?>" alt="<?php echo $row['nama']; ?>" />
                        </a>
                        <div class="portfolio-caption">
                            <div class="portfolio-caption-heading"><?php echo $row['nama']; ?></div>
                            <div class="portfolio-caption-subheading text-muted"><?php echo $row['alamat']; ?></div>
                        </div>
                    </div>
                </div>

                <!-- Portfolio Modal -->
                <div class="portfolio-modal modal fade" id="portfolioModal<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="close-modal" data-bs-dismiss="modal">
                                <img src="assets/img/close-icon.svg" alt="Close modal" />
                            </div>
                            <div class="container">
                                <div class="row justify-content-center">
                                    <div class="col-lg-8">
                                        <div class="modal-body">
                                            <!-- Project Details -->
                                            <h2 class="text-uppercase"><?php echo $row['nama']; ?></h2>
                                            <img class="img-fluid d-block mx-auto" src="<?php echo $row['foto']; ?>" alt="..." />
                                        
                                            <ul class="list-inline">
                                                <li><strong>Alamat:</strong> <?php echo $row['alamat']; ?></li>
                                                <li><strong>Deskripsi:</strong> <?php echo $row['deskripsi']; ?></li>
                                            </ul>
                                            <button class="btn btn-danger btn-xl text-uppercase" data-bs-dismiss="modal" type="button">
                                                <i class="fas fa-xmark me-1"></i>
                                                Tutup
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</section>
