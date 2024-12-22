<!-- Contact-->
<section class="page-section" id="contact" style="background: linear-gradient(200deg, #fff 0%, #198754 100%); color: white; padding: 60px 0;">
    <div class="container">
        <div class="text-center">
            <h2 class="section-heading text-uppercase" style="color: #212529;">Tuliskan Pertanyaan Anda, Kami akan merespon segera.</h2>
            <h3 class="section-subheading text-muted" style="color: rgba(255, 255, 255, 0.8);">
                Isi data dan kami akan menerima pesan Anda langsung di WhatsApp.
            </h3>
        </div>
        <form id="contactForm" style="background: rgba(255, 255, 255, 0.1); padding: 20px; border-radius: 10px;">
            <div class="row align-items-stretch mb-5">
                <div class="col-md-6">
                    <div class="form-group">
                        <input class="form-control" id="nama" type="text" placeholder="Nama Lengkap *" required
                            style="background: rgba(255, 255, 255, 0.8); border: none; border-radius: 5px;" />
                    </div>
                    <div class="form-group">
                        <input class="form-control" id="alamat" type="text" placeholder="Alamat Anda*" required
                            style="background: rgba(255, 255, 255, 0.8); border: none; border-radius: 5px;" />
                    </div>
                    <div class="form-group mb-md-0">
                        <input class="form-control" id="nomor" type="tel" placeholder="Nomor WhatsApp Anda*" required
                            style="background: rgba(255, 255, 255, 0.8); border: none; border-radius: 5px;" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group form-group-textarea mb-md-0">
                        <textarea class="form-control" id="pesan" placeholder="Tuliskan Pesan Anda *" required
                            style="background: rgba(255, 255, 255, 0.8); border: none; border-radius: 5px; min-height: 150px;"></textarea>
                    </div>
                </div>
            </div>
            <div class="text-center">
                <button class="btn btn-success btn-xl text-uppercase" id="submitButton" type="button" onclick="kirimPesan()"
                    style="background-color: #34c759; border: none; padding: 15px 30px; font-size: 18px; border-radius: 5px; color: white;">
                    <i class="fab fa-whatsapp" style="font-size: 1.2rem; margin-right: 10px;"></i> Kirim Pesan
                </button>
            </div>
        </form>
    </div>
</section>

<script>
    function kirimPesan() {
        // Ambil nilai dari input
        const nama = document.getElementById('nama').value.trim();
        const alamat = document.getElementById('alamat').value.trim();
        const nomor = document.getElementById('nomor').value.trim();
        const pesan = document.getElementById('pesan').value.trim();

        // Validasi sederhana
        if (!nama || !alamat || !nomor || !pesan) {
            alert('Harap isi semua field!');
            return;
        }

        // Validasi nomor telepon
        const nomorPattern = /^[0-9]+$/;
        if (!nomorPattern.test(nomor)) {
            alert('Nomor WhatsApp harus berupa angka!');
            return;
        }

        // Format pesan untuk WhatsApp
        const whatsappNumber = '6282126850099'; // Ganti dengan nomor tujuan
        const url = `https://wa.me/${whatsappNumber}?text=${encodeURIComponent(
            `Halo, saya ${nama}.\nAlamat: ${alamat}\nNomor: ${nomor}\nPesan: ${pesan}`
        )}`;

        // Buka WhatsApp
        window.open(url, '_blank');
    }
</script>
