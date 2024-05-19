@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                        <section class="sign-in-page">
                            <div class="container p-0">
                                <div class="row no-gutters">
                                    <div class="col-sm-12 align-self-center">
                                        <div class="sign-in-from bg-white">
                                            <h1 class="mb-0">Sign in</h1>
                                            <p>Enter your email address and password to access admin panel.</p>
                                            <form class="mt-4">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Email address</label>
                                                    <input type="email" class="form-control mb-0" id="exampleInputEmail1" placeholder="Enter email">
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputPassword1">Password</label>
                                                    <a href="#" class="float-right">Forgot password?</a>
                                                    <input type="password" class="form-control mb-0" id="exampleInputPassword1" placeholder="Password">
                                                </div>
                                                <div class="d-inline-block w-100">
                                                    <div class="custom-control custom-checkbox d-inline-block mt-2 pt-1">
                                                        <input type="checkbox" class="custom-control-input" id="customCheck1">
                                                        <label class="custom-control-label" for="customCheck1">Remember Me</label>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary float-right">Sign in</button>
                                                </div>
                                                <div class="sign-info">
                                                    <span class="dark-color d-inline-block line-height-2">Don't have an account? <a href="#">Sign up</a></span>
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

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
