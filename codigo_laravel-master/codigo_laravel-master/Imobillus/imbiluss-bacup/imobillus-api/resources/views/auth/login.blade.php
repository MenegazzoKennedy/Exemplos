@extends('layouts.app-auth')

@section('content')

<div class="login-box">
    
    <!-- /.login-logo -->
    <div class="card">
      <div class="card-body login-card-body">
        <div class="login-logo">
          <a href="{{ route('home') }}"><b>Imobillus</b></a>
        </div>
        
        <p class="login-box-msg">Faça login para iniciar sua sessão</p>
  
        <form action="{{ route('login') }}" method="POST">
            @csrf
          <div class="input-group mb-3">
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Digite seu e-mail">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          <div class="input-group mb-3">
            <input class="form-control @error('password') is-invalid @enderror" id="password" type="password" name="password" required autocomplete="current-password" placeholder="Digite sua senha">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          <div class="row">
            <div class="col-8">
              <div class="icheck-primary">
                <input type="checkbox" id="remember">
                <label for="remember">
                    {{ __('Mantenha-me conectado') }}
                </label>
              </div>
            </div>
            <!-- /.col -->
            <div class="col-4">
              <button type="submit" class="btn btn-success btn-block">Acessar</button>
            </div>
            <!-- /.col -->
          </div>
        </form>
  
        <div class="social-auth-links text-center mb-3 d-none">
          <p>- OU -</p>
          <a href="#" class="btn btn-block btn-danger d-none">
            <i class="fab fa-google mr-2"></i> Login com Google
          </a>
          <a href="{{route('login.facebook')}}" class="btn btn-block btn-primary">
            <i class="fab fa-facebook mr-2"></i> Login com Facebook
          </a>          
        </div>
        <!-- /.social-auth-links -->        
        <br>
        <p class="mb-2 text-center d-none">
          <a href="{{ route('password.request') }}">Esqueci a minha senha</a>
        </p>
        <p class="mb-0 text-center d-none">
          <a href="{{ route('register') }}" class="text-center">Registrar-se no APP</a>
        </p>
      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
  <!-- /.login-box -->
@endsection