@extends('layouts.guest')

@section('content')
<div class="flex items-center justify-center min-h-screen py-12 px-4 sm:px-6 lg:px-8">
    <div class="w-full max-w-md space-y-8">
        <!-- Card Utama Register -->
        <div class="register-card animate-fade-in">
            <div class="card-body p-8 space-y-6">
                <!-- Session Status Alert -->
                <x-auth-session-status class="alert-custom mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('register') }}" class="space-y-6">
                    @csrf
                    
                    <!-- Nama Lengkap -->
                    <div class="form-group">
                        <label for="nama" class="form-label text-white block mb-2">Nama Lengkap</label>
                        <input id="nama" type="text" name="nama" value="{{ old('nama') }}" required autofocus autocomplete="nama" placeholder="Masukkan nama lengkap Anda" class="form-input-custom">
                        <x-input-error :messages="$errors->get('nama')" class="mt-2" />
                    </div>

                    <!-- Email -->
                    <div class="form-group">
                        <label for="email" class="form-label text-white block mb-2">Alamat Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="Masukkan alamat email" class="form-input-custom">
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Peran -->
                    <div class="form-group">
                        <label for="peran" class="form-label text-white block mb-2">Daftar sebagai...</label>
                        <select id="peran" name="peran" required class="form-select-custom">
                            <option value="" disabled selected>Pilih peran Anda</option>
                            <option value="petani" {{ old('peran') == 'petani' ? 'selected' : '' }}>Petani</option>
                            <option value="pengepul" {{ old('peran') == 'pengepul' ? 'selected' : '' }}>Pengepul</option>
                            <option value="distributor" {{ old('peran') == 'distributor' ? 'selected' : '' }}>Distributor</option>
                        </select>
                        <x-input-error :messages="$errors->get('peran')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <label for="password" class="form-label text-white block mb-2">Password</label>
                        <input id="password" type="password" name="password" required autocomplete="new-password" placeholder="Buat password yang kuat" class="form-input-custom">
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Konfirmasi Password -->
                    <div class="form-group">
                        <label for="password_confirmation" class="form-label text-white block mb-2">Konfirmasi Password</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Ulangi password Anda" class="form-input-custom">
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <!-- Link Login -->
                    <div class="text-center" style="margin-top: 15px;">
                        <a href="{{ route('login') }}" class="text-light hover:text-white transition-colors duration-300 underline">
                            <i class="fas fa-sign-in-alt me-1"></i>Sudah punya akun? Masuk sekarang
                        </a>
                    </div>

                    <!-- Submit Button - Kotak Orange Kecil, Rata Tengah -->
                    <div class="text-center" style="margin-top: 15px;">
                        <button type="submit" class="btn-signup">
                            <i class="fas fa-user-check me-2"></i>SIGN UP
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .register-card {
        background: linear-gradient(135deg, #4CAF50, #81C784);
        backdrop-filter: blur(10px);
        border: 1px solid #FF9800;
        border-radius: 16px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        color: #fff;
        margin-top: 70px; 
    }
    
    .register-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #FF9800, #4CAF50);
    }
    
    .register-card:hover {
        transform: translateY(-5px) scale(1.02);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
    }
    
    .card-body {
        padding: 2rem;
    }
    
    .form-label {
        font-weight: 600;
        color: #fff;
        font-size: 0.95rem;
    }
    
    .form-input-custom, .form-select-custom {
        width: 100%;
        padding: 12px 16px;
        background: rgba(255, 255, 255, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.5);
        border-radius: 12px;
        color: #fff;
        font-size: 1rem;
        transition: all 0.3s ease;
        backdrop-filter: blur(5px);
    }
    
    .form-input-custom::placeholder {
        color: rgba(255, 255, 255, 0.7);
    }
    
    .form-select-custom {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%23fff' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
        background-position: right 12px center;
        background-repeat: no-repeat;
        background-size: 16px;
        padding-right: 40px;
        appearance: none;
        color: #fff;
    }
    
    .form-select-custom option {
        background: #4CAF50;
        color: #fff;
    }
    
    .form-input-custom:focus, .form-select-custom:focus {
        outline: none;
        background: rgba(255, 255, 255, 0.3);
        border-color: #FF9800;
        box-shadow: 0 0 0 0.2rem rgba(255, 152, 0, 0.25);
        color: #fff;
        transform: translateY(-1px);
    }
    
    .form-input-custom:focus::placeholder {
        color: rgba(255, 255, 255, 0.5);
    }
    
    /* Styling untuk Error Messages (x-input-error) */
    .alert-custom {
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        backdrop-filter: blur(5px);
        border-left: 4px solid;
        padding: 12px 16px;
        color: #fff;
        background: rgba(220, 53, 69, 0.2);
        border-left-color: #dc3545;
    }
    
    .alert-custom ul {
        margin: 0;
        padding-left: 1rem;
    }
    
    .alert-custom li {
        color: #fff;
    }
    
    /* Button Signup - Kotak Orange Kecil, Rata Tengah */
    .btn-signup {
        display: inline-block;
        padding: 14px 32px;
        background: linear-gradient(135deg, #FF9800, #FFB74D);
        color: #fff;
        font-weight: 600;
        font-size: 1.1rem;
        border: none;
        border-radius: 12px;
        transition: all 0.3s ease;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(255, 152, 0, 0.3);
        position: relative;
        overflow: hidden;
        min-width: 180px; /* Lebar minimal agar tidak terlalu kecil */
    }
    
    .btn-signup::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s;
    }
    
    .btn-signup:hover {
        background: linear-gradient(135deg, #F57C00, #FF8F00);
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(255, 152, 0, 0.4);
    }
    
    .btn-signup:hover::before {
        left: 100%;
    }
    
    .btn-signup:active {
        transform: translateY(0);
    }
    
    /* Link Styling */
    .text-light {
        color: rgba(255, 255, 255, 0.8) !important;
    }
    
    .text-light:hover {
        color: #fff !important;
    }
    
    /* Animasi */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .animate-fade-in {
        animation: fadeInUp 0.6s ease-out forwards;
    }
    
    /* Responsiveness */
    @media (max-width: 768px) {
        .card-body {
            padding: 1.5rem;
        }
        
        .form-input-custom, .form-select-custom {
            padding: 12px 14px;
            font-size: 0.95rem;
        }
        
        .btn-signup {
            padding: 12px 24px;
            font-size: 1rem;
            min-width: 160px;
        }
    }
</style>
@endsection