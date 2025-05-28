@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">{{ __('Reset Password') }}</h5>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('status') }}
                        </div>
                    @endif

                    <p class="text-muted mb-4">
                        Lupa password Anda? Tidak masalah. Masukkan alamat email Anda dan kami akan mengirimkan link untuk reset password.
                    </p>

                    <form method="POST" action="{{ route('password.email') }}" id="forgotPasswordForm">
                        @csrf

                        {{-- Email Field --}}
                        <div class="mb-3">
                            <label for="email" class="form-label">{{ __('Email') }}</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-envelope"></i>
                                </span>
                                <input id="email" 
                                       type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       name="email" 
                                       value="{{ old('email') }}" 
                                       required 
                                       autocomplete="email" 
                                       autofocus
                                       placeholder="Masukkan email terdaftar">
                            </div>
                            @error('email')
                                <div class="invalid-feedback d-block">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        {{-- Error Alert --}}
                        <div class="alert alert-danger d-none" id="errorAlert" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <span id="errorMessage"></span>
                        </div>

                        {{-- Success Alert --}}
                        <div class="alert alert-success d-none" id="successAlert" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            <span id="successMessage"></span>
                        </div>

                        {{-- Submit Button --}}
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary" id="submitButton">
                                <span id="buttonText">
                                    <i class="fas fa-paper-plane me-2"></i>{{ __('Kirim Link Reset Password') }}
                                </span>
                                <span id="buttonLoading" class="d-none">
                                    <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                                    Mengirim...
                                </span>
                            </button>
                        </div>

                        {{-- Back to Login --}}
                        <div class="mt-3 text-center">
                            <a href="{{ route('login') }}" class="text-decoration-none">
                                <i class="fas fa-arrow-left me-1"></i>Kembali ke Login
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Info Card --}}
            <div class="card mt-3 shadow-sm">
                <div class="card-body">
                    <h6 class="card-title">
                        <i class="fas fa-info-circle me-2 text-primary"></i>Informasi
                    </h6>
                    <ul class="mb-0 ps-3">
                        <li>Link reset password akan dikirim ke email terdaftar</li>
                        <li>Link berlaku selama 60 menit</li>
                        <li>Periksa folder spam jika email tidak masuk</li>
                        <li>Hubungi admin jika mengalami kesulitan</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Custom Styles --}}
<style>
    .card {
        border-radius: 10px;
        border: none;
    }
    
    .card-header {
        border-radius: 10px 10px 0 0 !important;
    }
    
    .btn-primary {
        background-color: #007bff;
        border: none;
        padding: 10px;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    .btn-primary:hover {
        background-color: #0056b3;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    
    .input-group-text {
        background-color: #f8f9fa;
        border-right: none;
    }
    
    .form-control {
        border-left: none;
        transition: all 0.3s ease;
    }
    
    .form-control:focus {
        box-shadow: none;
        border-color: #007bff;
    }
    
    .input-group:focus-within .input-group-text {
        border-color: #007bff;
        color: #007bff;
    }
</style>

{{-- JavaScript --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('forgotPasswordForm');
    const submitButton = document.getElementById('submitButton');
    const buttonText = document.getElementById('buttonText');
    const buttonLoading = document.getElementById('buttonLoading');
    const errorAlert = document.getElementById('errorAlert');
    const errorMessage = document.getElementById('errorMessage');
    const successAlert = document.getElementById('successAlert');
    const successMessage = document.getElementById('successMessage');
    
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        // Hide alerts
        errorAlert.classList.add('d-none');
        successAlert.classList.add('d-none');
        
        // Show loading state
        submitButton.disabled = true;
        buttonText.classList.add('d-none');
        buttonLoading.classList.remove('d-none');
        
        try {
            const formData = new FormData(form);
            const response = await fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                }
            });
            
            const data = await response.json();
            
            if (response.ok && data.success) {
                // Show success message
                successMessage.textContent = data.message || 'Link reset password telah dikirim ke email Anda.';
                successAlert.classList.remove('d-none');
                
                // Clear form
                form.reset();
                
                // Reset button state after delay
                setTimeout(() => {
                    submitButton.disabled = false;
                    buttonText.classList.remove('d-none');
                    buttonLoading.classList.add('d-none');
                }, 2000);
            } else {
                // Show error message
                let message = data.message || 'Terjadi kesalahan. Silakan coba lagi.';
                
                if (data.errors && data.errors.email) {
                    message = data.errors.email[0];
                }
                
                errorMessage.textContent = message;
                errorAlert.classList.remove('d-none');
                
                // Reset button state
                submitButton.disabled = false;
                buttonText.classList.remove('d-none');
                buttonLoading.classList.add('d-none');
            }
        } catch (error) {
            console.error('Error:', error);
            
            // Show generic error message
            errorMessage.textContent = 'Terjadi kesalahan. Silakan coba lagi.';
            errorAlert.classList.remove('d-none');
            
            // Reset button state
            submitButton.disabled = false;
            buttonText.classList.remove('d-none');
            buttonLoading.classList.add('d-none');
        }
    });
});
</script>
@endsection
