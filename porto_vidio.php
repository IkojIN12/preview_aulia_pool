<?php
include 'koneksi.php'; // Sertakan file koneksi
?>

<section class="page-section" id="portfolio" style="background-color: #e7f5ff; padding: 50px 0;">
    <div class="container">
        <div class="text-center">
            <h2 class="section-heading text-uppercase">Vidio Kami</h2>
            <h3 class="section-subheading text-muted">--------------</h3>
        </div>
        <div class="row">
            <?php
            // Query untuk ambil data dari tabel videos
            $query = "SELECT * FROM videos";
            $result = mysqli_query($conn, $query);

            // Perulangan untuk menampilkan setiap data video
            while ($row = mysqli_fetch_assoc($result)) {
            ?>
                <div class="col-lg-4 col-sm-6 mb-4">
                    <div class="portfolio-item">
                        <a class="portfolio-link" data-bs-toggle="modal" href="#videoModal<?php echo $row['id']; ?>">
                            <div class="portfolio-hover">
                                <div class="portfolio-hover-content"><i class="fas fa-play fa-3x"></i></div>
                            </div>
                            <video class="img-fluid" style="width: 100%; height: 200px; object-fit: cover;" controls muted>
                                <source src="<?php echo $row['video_path']; ?>" type="video/mp4">
                                Browser Anda tidak mendukung tag video.
                            </video>
                        </a>
                        <div class="portfolio-caption">
                            <div class="portfolio-caption-heading"><?php echo $row['nama']; ?></div>
                            <div class="portfolio-caption-subheading text-muted"><?php echo $row['deskripsi']; ?></div>
                        </div>
                    </div>
                </div>

                <!-- Video Modal -->
                <div class="portfolio-modal modal fade" id="videoModal<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="close-modal" data-bs-dismiss="modal">
                                <img src="assets/img/close-icon.svg" alt="Close modal" />
                            </div>
                            <div class="container">
                                <div class="row justify-content-center">
                                    <div class="col-lg-8">
                                        <div class="modal-body">
                                            <!-- Video Details -->
                                            <h2 class="text-uppercase"><?php echo $row['nama']; ?></h2>
                                            <video class="img-fluid d-block mx-auto" controls>
                                                <source src="<?php echo $row['video_path']; ?>" type="video/mp4">
                                                Browser Anda tidak mendukung tag video.
                                            </video>
                                            <ul class="list-inline">
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
