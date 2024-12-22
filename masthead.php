<header class="masthead"
    style="background: #f8f9fa; height: 100vh; display: flex; flex-direction: column; justify-content: center; align-items: center;">
    <!-- Container Utama -->
    <div class="container"
        style="max-width: 1200px; width: 100%; padding: 0 15px; display: flex; flex-direction: column; align-items: center;">
        <!-- Div untuk Foto dengan Slider -->
        <div class="masthead-image"
            style="width: 100%; max-height: 400px; position: relative; overflow: hidden; margin-bottom: 20px;">
            <div class="slider" style="width: 100%; height: 100%; position: relative;">
                <!-- Slide Images -->
                <img src="assets/img/Highlight.jpeg" alt="Highlight" class="slide"
                    style="width: 100%; height: 100%; object-fit: cover; display: block;">
                <img src="assets/img/Highlight2.jpeg" alt="Highlight2" class="slide"
                    style="width: 100%; height: 100%; object-fit: cover; display: none;">
                <img src="assets/img/Highlight4.jpeg" alt="Highlight3" class="slide"
                    style="width: 100%; height: 100%; object-fit: cover; display: none;">
            </div>
        </div>
    </div>

    <script>
        // Simple slider script
        const slides = document.querySelectorAll('.slide');
        let currentSlide = 0;

        // Function to show the slide based on index
        function showSlide(index) {
            slides.forEach((slide, i) => {
                slide.style.display = i === index ? 'block' : 'none';
            });
        }

        // Function to move to the next slide
        function nextSlide() {
            currentSlide = (currentSlide + 1) % slides.length;
            showSlide(currentSlide);
        }

        // Berubah setiap 4 detik
        setInterval(nextSlide, 4000);

        // Initialize slider
        showSlide(currentSlide);
    </script>
</header>