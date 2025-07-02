@extends('layouts.login')

@section('title', 'Login E-Learning')

@section('content')
<div class="login">
  <div class="login-box">
    <div class="login-image"></div>

    <div class="login-form">
      <h2>Login E-Learning</h2>
      <p>Selamat datang kembali, silakan login ke akun Anda untuk melanjutkan.</p>

      @if(session('error'))
        <div style="color: red; margin-bottom: 10px;">{{ session('error') }}</div>
      @endif

      <form method="POST" action="{{ route('login') }}">
        @csrf
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
      </form>
    </div>
  </div>
</div>

<a href="https://wa.me/6281234567890" target="_blank" class="whatsapp-float">
  <img src="{{ asset('assets/icon/whatsapp.svg') }}" alt="WhatsApp">
  <span>Hubungi Kami</span>
</a>
@endsection
