<!-- Alumni Search Section -->
<section id="alumni" class="section-padding py-5">
    <div class="container">
        <div class="section-heading text-center mb-5" data-aos="fade-up">
            <h2 class="fw-bold">Direktori Alumni</h2>
            <p class="lead">Temukan dan terhubung dengan sesama alumni SMA Negeri 2 Pangkep</p>
        </div>
        <div class="row justify-content-center mb-5">
            <div class="col-md-8" data-aos="fade-up" data-aos-delay="100">
                <div class="card border-0 shadow">
                    <div class="card-body p-4">
                        <h5 class="mb-4"><i class="fas fa-search me-2"></i> Cari Alumni</h5>
                        <form>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <select class="form-select">
                                        <option selected disabled>Tahun Kelulusan</option>
                                        @for ($i = date('Y'); $i >= 1980; $i--)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <select class="form-select">
                                        <option selected disabled>Profesi</option>
                                        <option>Pegawai Negeri</option>
                                        <option>Swasta</option>
                                        <option>Wirausaha</option>
                                        <option>Dokter</option>
                                        <option>Guru/Dosen</option>
                                        <option>Lainnya</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-primary"><i class="fas fa-search me-2"></i> Cari</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center" data-aos="fade-up" data-aos-delay="200">
            <p>Daftar sebagai alumni untuk dapat mengakses direktori alumni lengkap</p>
            <a href="{{ route('register') }}" class="btn btn-primary px-4"><i class="fas fa-user-plus me-2"></i> Daftar Sekarang</a>
        </div>
    </div>
</section>