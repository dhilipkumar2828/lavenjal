@extends('backend.layouts.master')
@section('content')

<style>
  .login-section{
    height: 100%;
  }
  </style>

<!--start content-->
<main class="authentication-content">
        <div class="container">
            <!-- <div class="card rounded-0 overflow-hidden shadow-none border mb-5 mb-lg-0 p-5"> -->
              <div class="row g-0">
                <div class="col-12 order-1 col-xl-6 d-flex align-items-center justify-content-center border-end">
                  <img src="{{asset('assets/images/banner/01.png')}}" alt="">
                </div>
                <div class="col-12 col-xl-6 order-xl-2">
                  <div class="card-body p-5 p-sm-5">
                    <a class="app-logo">
                      <center>
                    <img src="{{asset('assets/images/lavenjal-logo.png')}}" class="logo-icon me-2 text-center" alt="logo icon"></center>
                    </a>
                    <form method="POST" action="{{ route('sales-loginsubmit') }}">
                        @csrf
                      
                        <div class="row g-3">
                          <div class="col-12">
                            <label for="inputEmailAddress" class="form-label mb-3">Phone Number</label>
                            <div class="ms-auto position-relative">
                              <div class="position-absolute top-50 translate-middle-y search-icon px-3 mb-3"><i class="bi bi-envelope-fill"></i></div>
                       

                              <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror radius-30 ps-5" name="phone" value="{{ old('phone') }}" required autocomplete="phone" autofocus placeholder="Phone">

                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                            </div>
                          </div>
                          <div class="col-12">
                            <label for="inputChoosePassword" class="form-label mb-3">Enter Password</label>
                            <div class="ms-auto position-relative">
                              <div class="position-absolute top-50 translate-middle-y search-icon px-3 mb-3"><i class="bi bi-lock-fill"></i></div>
                 

                              <input id="password" type="password" class="form-control @error('password') is-invalid @enderror radius-30 ps-5 p-2" name="password" required autocomplete="current-password" placeholder="Password">

                              <input type="hidden" name="user_type" value="admin">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                          </div>
                          <div class="col-6">
                            <div class="form-check form-switch">
                              <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" checked="">
                              <label class="form-check-label" for="flexSwitchCheckChecked">Remember Me</label>
                            </div>
                            <div class="col-6">
                                @if (Route::has('password.request'))
                                        <a class="btn btn-link form-control" href="{{ route('password.request') }}">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                    @endif
                            </div>
                          </div>
                          <!-- <div class="col-6 text-end">	<a href="authentication-forgot-password.html">Forgot Password ?</a>
                          </div> -->
                          <div class="col-12">
                            <div class="d-grid">
                              <button type="submit" class="btn btn-primary radius-30 p-2">Login</button>
                            </div>
                          </div>

                          <div class="col-12">
                            <div class="login-separater text-center">
                            </div>
                          </div>
                          <div class="col-12">
                            <!-- <div class="d-flex align-items-center gap-3 justify-content-center">
                              <button type="button" class="btn btn-white text-danger"><i class="bi bi-google me-0"></i></button>
                              <button type="button" class="btn btn-white text-primary"><i class="bi bi-linkedin me-0"></i></button>
                              <button type="button" class="btn btn-white text-info"><i class="bi bi-facebook me-0"></i></button>
                            </div> -->
                          </div>
                          <div class="col-12 text-center">
                            <!-- <p class="mb-0">Don't have an account yet? <a href="authentication-signup-with-header-footer.html">Sign up here</a></p> -->
                          </div>
                        </div>
                    </form>
                 </div>
                </div>
              </div>
            <!-- </div> -->
        </div>
       </main>
        
       <!--end page main-->
@endsection
