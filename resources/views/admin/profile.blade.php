
@extends('layouts.admin')

@section('title', 'Profile Admin')

@section('content')
<div class="profile-container">
    <div class="green-banner-header">
        <div class="banner-left">
            <div class="banner-icon">
                <i class="fas fa-user-circle"></i>
            </div>
            <div>
                <h1 class="page-title">Profile Admin</h1>
                <p class="page-subtitle">Kelola informasi dan keamanan akun admin CanyoKuy</p>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert error">{{ session('error') }}</div>
    @endif

    @if($errors->any())
        <div class="alert error">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="profile-card">
        <div class="card-heading">
            <i class="fas fa-id-card"></i>
            <div>
                <h2>Informasi Profil</h2>
                <p>Perbarui informasi akun admin kamu.</p>
            </div>
        </div>

        <form action="{{ route('admin.update-profile') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Nama Lengkap</label>
                <input class="form-control" type="text" id="name"
                    name="name" value="{{ old('name', $admin->name) }}" required>
            </div>

            <div class="form-group">
                <label for="username">Username</label>
                <input class="form-control" type="text" id="username"
                    name="username" value="{{ old('username', $admin->username) }}" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input class="form-control" type="email" id="email"
                    name="email" value="{{ old('email', $admin->email) }}" required>
            </div>

            <button class="btn-primary" type="submit">
                <i class="fas fa-save"></i> Simpan Perubahan
            </button>
        </form>
    </div>

    <div class="profile-card">
        <div class="card-heading">
            <i class="fas fa-lock"></i>
            <div>
                <h2>Ganti Password</h2>
                <p>Gunakan password yang kuat untuk menjaga keamanan akun.</p>
            </div>
        </div>

        <form action="{{ route('admin.change-password') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="current_password">Password Lama</label>
                <input class="form-control" type="password"
                    id="current_password" name="current_password" required>
            </div>

            <div class="form-group">
                <label for="password">Password Baru</label>
                <input class="form-control" type="password"
                    id="password" name="password" required>
            </div>

            <div class="form-group">
                <label for="password_confirmation">Konfirmasi Password Baru</label>
                <input class="form-control" type="password"
                    id="password_confirmation" name="password_confirmation" required>
            </div>

            <button class="btn-primary" type="submit">
                <i class="fas fa-key"></i> Ubah Password
            </button>
        </form>
    </div>
</div>

<style>
.profile-container {
    max-width: 1100px;
    margin: auto;
}

.profile-card {
    background: white;
    border-radius: 18px;
    padding: 28px;
    margin-bottom: 24px;
    box-shadow: 0 2px 10px rgba(0,0,0,.05);
}

.card-heading {
    display: flex;
    align-items: center;
    gap: 15px;
    margin-bottom: 25px;
}

.card-heading > i {
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #e8f5e9;
    color: #2F6B5E;
    border-radius: 12px;
    font-size: 21px;
}

.card-heading h2 {
    font-size: 19px;
    color: #26332F;
    margin-bottom: 5px;
}

.card-heading p {
    color: #777;
    font-size: 13px;
}

.profile-card .form-group {
    margin-bottom: 20px;
}

.profile-card .form-group label {
    display: block;
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 8px;
    color: #374151;
}

.profile-card .form-control {
    width: 100%;
    padding: 12px 14px;
    border: 1px solid #dce3df;
    border-radius: 10px;
    font-size: 14px;
}

.btn-primary {
    background: #2F6B5E;
    color: white;
    border: none;
    border-radius: 10px;
    padding: 12px 20px;
    font-weight: 600;
    cursor: pointer;
}

.btn-primary:hover {
    background: #1a4a40;
}

.alert {
    padding: 14px 18px;
    border-radius: 10px;
    margin-bottom: 20px;
}

.alert.success {
    background: #d4edda;
    color: #155724;
}

.alert.error {
    background: #f8d7da;
    color: #842029;
}
</style>
@endsection
