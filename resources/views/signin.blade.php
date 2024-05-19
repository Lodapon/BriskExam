@extends('layouts.mainlayout')
@section('content')
 <div class="wrapper">
    <!-- Sign in Start -->
    <section class="sign-in-page">
      <div class="container p-0">
          <div class="row no-gutters">
              <div class="col-sm-12 align-self-center">
                  <div class="sign-in-from bg-white">
                     <div style="text-align: center">
                        <img src="{{$pic}}" class="brand-logo" />
                     </div>
                     <form id="loginForm" class="mt-4" action="/login" method="post">
                        @csrf
                        <div class="form-group">
                              <label for="exampleInputEmail1">Email address</label>
                              <input type="email" name="usr" class="form-control mb-0" id="exampleInputEmail1" placeholder="Enter email">
                          </div>
                          <div class="form-group">
                              <label for="exampleInputPassword1">Password</label>
                              <a href="/reset" class="float-right">Forgot password?</a>
                              <input type="password" name="pwd" class="form-control mb-0" id="exampleInputPassword1" placeholder="Password">
                          </div>
                          <div class="d-inline-block w-100">
                              {{-- <div class="custom-control custom-checkbox d-inline-block mt-2 pt-1">
                                  <input type="checkbox" class="custom-control-input" id="customCheck1">
                                  <label class="custom-control-label" for="customCheck1">Remember Me</label>
                              </div> --}}
                              <button type="submit" class="btn btn-primary float-right">Log in</button>
                          </div>
                          <div class="sign-info">
                           {{-- <div class="d-flex justify-content-center  alert alert-warning ml-0 mr-0" role="alert">{{$message}}</div> --}}
                              {{-- <span class="dark-color d-inline-block line-height-2">Don't have an account? <a href="#">Sign up</a></span> --}}
                              <ul class="iq-social-media">
                                  <li><a href="#"><i class="ri-facebook-box-line"></i></a></li>
                                  <li><a href="#"><i class="ri-twitter-line"></i></a></li>
                                  <li><a href="#"><i class="ri-instagram-line"></i></a></li>
                              </ul>
                          </div>
                      </form>
                  </div>
              </div>
          </div>
      </div>
  </section>
  <!-- Sign in END -->
 </div>

&nbsp;

 <!-- Wrapper END -->
@endsection
