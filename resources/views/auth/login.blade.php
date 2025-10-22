@extends('layouts.guest')

@section('content')
<div class="flex items-center justify-center min-h-screen py-12 px-4 sm:px-6 lg:px-8">
    <div class="w-full max-w-md space-y-8">
        <!-- Card Utama Login -->
        <div class="login-card animate-fade-in">
            <div class="card-body p-8 space-y-6">
                <!-- Session Status Alert -->
                <x-auth-session-status class="alert-custom mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf
                    
                    <!-- Email -->
                    <div class="form-group">
                        <label for="email" class="form-label text-white block mb-2">Alamat Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="Masukkan alamat email" class="form-input-custom">
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <label for="password" class="form-label text-white block mb-2">Password</label>
                        <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="Masukkan password" class="form-input-custom">
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Remember & Forgot Password -->
                    <div class="flex items-center justify-between">
                        <!-- Remember Me Checkbox -->
                        <div class="flex items-center">
                            <input id="remember" type="checkbox" name="remember" class="form-checkbox-custom">
                            <label for="remember" class="ml-2 text-light cursor-pointer select-none" style="margin-top: 15px;">Remember me</label>
                        </div>
                        
                        <!-- Forgot Password -->
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-light hover:text-white transition-colors duration-300 underline text-sm">
                                <i class="fas fa-key me-1" style="margin-top: 15px;"></i>Forgot password?
                            </a>
                        @endif
                    </div>

                    <!-- Link Register -->
                    <div class="text-center" style="margin-top: 15px;">
                        <a href="{{ route('register') }}" class="text-light hover:text-white transition-colors duration-300 underline">
                            <i class="fas fa-user-plus me-1"></i>Belum punya akun? Daftar sekarang
                        </a>
                    </div>

                    <!-- Submit Button - Kotak Orange Kecil, Rata Tengah -->
                    <div class="text-center" style="margin-top: 15px;">
                        <button type="submit" class="btn-login">
                            <i class="fas fa-sign-in-alt me-2"></i>LOGIN
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .login-card {
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
    
    .login-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #FF9800, #4CAF50);
    }
    
    .login-card:hover {
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
    
    .form-input-custom {
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
    
    .form-input-custom:focus {
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
    
    /* Custom Checkbox untuk Remember Me */
    .form-checkbox-custom {
        width: 18px;
        height: 18px;
        background: rgba(255, 255, 255, 0.2);
        border: 2px solid rgba(255, 255, 255, 0.5);
        border-radius: 4px;
        cursor: pointer;
        appearance: none;
        position: relative;
        transition: all 0.3s ease;
        backdrop-filter: blur(5px);
    }
    
    .form-checkbox-custom:checked {
        background: #FF9800;
        border-color: #FF9800;
    }
    
    .form-checkbox-custom:checked::after {
        content: '\f00c';
        font-family: 'Font Awesome 5 Free';
        font-weight: 900;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: #fff;
        font-size: 12px;
    }
    
    .form-checkbox-custom:focus {
        box-shadow: 0 0 0 0.2rem rgba(255, 152, 0, 0.25);
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
    
    /* Button Login - Kotak Orange Kecil, Rata Tengah */
    .btn-login {
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
    
    .btn-login::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s;
    }
    
    .btn-login:hover {
        background: linear-gradient(135deg, #F57C00, #FF8F00);
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(255, 152, 0, 0.4);
    }
    
    .btn-login:hover::before {
        left: 100%;
    }
    
    .btn-login:active {
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
        
        .form-input-custom {
            padding: 12px 14px;
            font-size: 0.95rem;
        }
        
        .btn-login {
            padding: 12px 24px;
            font-size: 1rem;
            min-width: 160px;
        }
        
        .flex.items-center.justify-between {
            flex-direction: column;
            gap: 10px;
            align-items: stretch;
        }
    }
</style>
@endsection