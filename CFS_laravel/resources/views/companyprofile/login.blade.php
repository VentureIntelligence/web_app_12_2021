@extends('companyprofile.app')

@section('content')
<div class="login-box">
    <div class="login-logo">
      {{-- <a href=""><b>Admin</b>LTE</a> --}}
      <div class="vilogo"></div>

    </div>
    <!-- /.login-logo -->
    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg">Sign in to start your session</p>
  
        <form action="{{ route('login') }}" method="post">
        @csrf
          <div class="input-group mb-3">
            <input type="email" class="form-control" placeholder="Email" name="email" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" placeholder="Password" name="password" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <p class="mb-0">
                <input type="checkbox" name="chkTerm" checked="" required>
                By accessing this database, you agree to the  <a href="https://www.ventureintelligence.asia/dev/terms.htm">terms &amp; conditions</a> of use upon which access is provided.
                
            </p>
          </div>
          <div class="row">
            <div class="col-8">
              <div class="icheck-primary">
                <input type="checkbox" id="remember" name="remember">
                <label for="remember">
                  Remember Me
                </label>
              </div>
            </div>
            <!-- /.col -->
            <div class="col-4">
              <button type="submit" class="btn btn-primary btn-block">Sign In</button>
            </div>
            <!-- /.col -->
          </div>
        </form>
  
        <!-- /.social-auth-links -->
  
                        <p class="mb-1">
                          <a href="forgot-password.html">I forgot my password</a>
                        </p>
      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
  <!-- /.login-box -->
  
@endsection