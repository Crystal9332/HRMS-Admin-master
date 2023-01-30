@extends('layouts.auth.index')

@section('login')
<div class="login-box card">
  <div class="card-body mt-5 pt-5">
    {{-- <form class="form-horizontal form-material text-center" id="loginform" action="index.html"> --}}
    {{-- <form class="form-horizontal form-material text-center" method="POST" action="{{ route('login') }}"> --}}
    <form class="form-horizontal form-material text-center" method="POST">
      @csrf
      <a href="javascript:void(0)" class="db">
        <img src="{{asset('images/logo.png')}}" alt="Home" />
      </a>
      <div class="my-5"></div>
      @if (session('success'))
        <div class="form-group m-t-40 text-primary font-weight-bold">
          {{session('success')}}
        </div>
      @endif
      <div class="form-group">
        <div class="col-xs-12">
          <input type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus placeholder="Username">

          @error('email')
          <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
          </span>
          @enderror
          {{-- <input class="form-control" type="text" required="" placeholder="Username"> --}}
        </div>
      </div>
      <div class="form-group">
        <div class="col-xs-12">
          <input type="password" class="form-control" name="password" required placeholder="Password">

          @error('password')
          <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
          </span>
          @enderror
          {{-- <input class="form-control" type="password" required="" placeholder="Password"> --}}
        </div>
      </div>
      <div class="form-group text-center m-t-20">
        <div class="col-xs-12">
          <button type="submit" class="btn btn-info btn-lg btn-block text-uppercase btn-rounded">
            {{ __('Login') }}
          </button>
          {{-- <button class="btn btn-info btn-lg btn-block text-uppercase btn-rounded" type="submit">Log In</button> --}}
        </div>
      </div>
    </form>
  </div>
</div>
@endsection