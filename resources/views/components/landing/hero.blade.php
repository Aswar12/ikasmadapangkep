<!-- Hero Section with Slider -->
<section class="hero-section">
    <div class="hero-slider">
        <div class="hero-slide active" style="background-image: url('{{ asset('images/DSC03084.JPG') }}');"></div>
        <div class="hero-slide" style="background-image: url('{{ asset('images/DSC03207.JPG') }}');"></div>
        <div class="hero-slide" style="background-image: url('{{ asset('images/DSC03216.JPG') }}');"></div>
    </div>
    <div class="hero-overlay"></div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 hero-content" data-aos="fade-up">
                <h1 class="hero-title">IKASMADA PANGKEP</h1>
                <p class="hero-description mx-auto">Ikatan Alumni SMA Negeri 1 Pangkajene dan Kepulauan, menjalin silaturahmi dan membangun masa depan bersama.</p>
                <div class="hero-buttons">
                    <a href="{{ route('register') }}" class="btn hero-btn primary-btn">Daftar</a>
                    <a href="#alumni" class="btn hero-btn secondary-btn">Cari Alumni</a>
                </div>
            </div>
        </div>
    </div>
    <div class="hero-controls">
        <button class="hero-control prev"><i class="fas fa-chevron-left"></i></button>
        <button class="hero-control next"><i class="fas fa-chevron-right"></i></button>
    </div>
</section>
