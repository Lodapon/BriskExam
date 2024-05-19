<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('layouts.head')
    </head>
    <body class="header-top-bg">
        <!-- loader Start -->
        <div id="loading">
        </div>
        <!-- TOP Nav Bar -->
        <div class="iq-top-navbar">
            <div class="iq-navbar-custom">
               <nav class="navbar navbar-expand-lg navbar-light p-0">
                <a href="/" class="navbar-brand logo">
                    <img src="{{ asset('assets/images/logo-02.jpg') }}" class="img-fluid brand-logo" alt="">
                </a>
               </nav>
           </div>
         </div>
         <!-- TOP Nav Bar END -->

         <style>
              .dropbtn {
                background-color: #ffee85;
                border: none;

                font-family: 'Now', sans-serif;
                font-weight: 400;
                font-style: normal;
                margin: 0;
                background: #ffee85;

                font-size: 18px;
                padding: 0 15px;
                line-height: 73px;
                color: #777D74;
                display: block;
                min-height: 75px;
              }

              .dropdown {
                position: relative;
                display: inline-block;
              }

              .dropdown-content {
                display: none;
                position: absolute;
                background-color: #ffffff;
                min-width: 160px;
                box-shadow: 0px 8px 16px 0px rgba(0,0,0,0);
                z-index: 1;
              }

              .dropdown-content a {
                color: black;
                padding: 12px 16px;
                text-decoration: none;
                display: block;
                border: 0.5px solid #ffee85;
              }

              .dropdown-content a:hover {background-color: #ffee85;}

              .dropdown:hover .dropdown-content {display: block;}

              .dropdown:hover .dropbtn {background-color: #ffee85; opacity: 0.5}

              .nav-item:hover {opacity: 0.5}
              .aligncenter {
                text-align: center;
              }
        </style>
<section class="content">
    <!-- Wrapper Start -->
    
            <!-- Page Content  -->
<div id="content-page" class="content-page">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-lg-12">
                <div class="iq-card">
                    <div class="iq-card-header d-flex justify-content-between">
                        <div class="iq-header-title">
                            <h4 class="card-title">{{$exname}}</h4>
                        </div>
                    </div>
                    <div class="iq-card-body">
                        <form id="form-wizard1" class="text-center mt-4">
                        @foreach($test as $mock => $exam)
                            <div class="form-card text-left">
                                <div class="row">
                                    <div class="col-1">
                                        <h2 class="steps">ข้อ {{ $loop->iteration }}</h2>
                                    </div>
                                    <div class="col-11">
                                        <h3 class="mb-4">{!!$mock!!}</h3>
                                    </div>
                                </div>
                                @foreach($exam as $ans)
                                <div class="row">
                                    @if ($ans->me_type == 'C')
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-1">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input" id="{{ $ans->me_det_id }}_{{ $ans->me_ans_no }}" name="answer{{$ans->me_det_id}}" value="{{ $ans->me_det_id }}_{{ $ans->me_ans_no }}"/>
                                                </div>
                                            </div>
                                            <div class="col-11">
                                                <div class="custom-control custom-radio">
                                                    <label class="custom-control-label" for="{{ $ans->me_det_id }}_{{ $ans->me_ans_no }}">{!! $ans->me_ans !!}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @else
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="custom-control">
                                                    <input type="text" style="margin-bottom: 10px" class="form-control" id="{{ $ans->me_det_id }}_{{ $ans->me_ans_no }}" name="answer{{$ans->me_det_id}}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif

                                </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="iq-card">
                        <div class="iq-card-header d-flex justify-content-center">
                          
                                <h4 class="card-title">เฉลย</h4>
                        
                        </div>
                    <div class="iq-card-body">
                        @foreach($test as $mock => $exam)
                            <div class="form-card text-left">
                                <div class="row">
                                    <div class="col-1">
                                        <h2 class="steps">ข้อ {{ $loop->iteration }}</h2>
                                    </div>
                                    <div class="col-11">
                                        <h3 class="mb-4">{!!$mock!!}</h3>
                                    </div>
                                </div>
                                @foreach($exam as $ans)
                                <div class="row">
                                    @if ($loop->last)
                                    <div class="col-1">
                                        <h2 class="steps">ตอบ</h2>
                                    </div>
                                    <div class="col-11">
                                        <h3 class="mb-4">{!! $ans->me_soln !!}</h3>
                                    </div>
                                        {{-- <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-10">
                                                    <label> ตอบ {!! $ans->me_soln !!}</label>
                                                </div>
                                            </div>
                                        </div> --}}
                                    @endif
                                </div>
                                @endforeach
                            </div>
                        @endforeach
                        </form>
                    </div>
                {{-- </div> --}}
            </div>
        </div>
    </div>
</div>
</section>

<!-- Footer -->
<footer class="bg-white iq-footer">
    <div class="container-fluid">
    <div class="row">
        <div class="col-lg-6">
            <ul class="list-inline mb-0">
                <li class="list-inline-item"><a href="privacy-policy.html">Privacy Policy</a></li>
                <li class="list-inline-item"><a href="terms-of-service.html">Terms of Use</a></li>
            </ul>
        </div>
        <div class="col-lg-6 text-right">
            Copyright 2021 <a href="#">Brisk Exam</a> All Rights Reserved.
        </div>
    </div>
    </div>
</footer>
{{-- @include('layout.footer') --}}
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
<!-- Appear JavaScript -->
<script src="{{ asset('assets/js/jquery.appear.js') }}"></script>
<!-- Countdown JavaScript -->
<script src="{{ asset('assets/js/countdown.min.js') }}"></script>
<!-- Counterup JavaScript -->
<script src="{{ asset('assets/js/waypoints.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.counterup.min.js') }}"></script>
<!-- Wow JavaScript -->
<script src="{{ asset('assets/js/wow.min.js') }}"></script>
<!-- Apexcharts JavaScript -->
<script src="{{ asset('assets/js/apexcharts.js') }}"></script>
<!-- Slick JavaScript -->
<script src="{{ asset('assets/js/slick.min.js') }}"></script>
<!-- Select2 JavaScript -->
<script src="{{ asset('assets/js/select2.min.js') }}"></script>
<!-- Owl Carousel JavaScript -->
<script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
<!-- Magnific Popup JavaScript -->
<script src="{{ asset('assets/js/jquery.magnific-popup.min.js') }}"></script>
<!-- Smooth Scrollbar JavaScript -->
<script src="{{ asset('assets/js/smooth-scrollbar.js') }}"></script>
<!-- lottie JavaScript -->
<script src="{{ asset('assets/js/lottie.js') }}"></script>
<!-- Chart Custom JavaScript -->
<script src="{{ asset('assets/js/chart-custom.js') }}"></script>
<!-- Custom JavaScript -->
<script src="{{ asset('assets/js/custom.js') }}"></script>

<!-- include FilePond library -->
<script src="{{ asset("vendor/filepond/filepond.min.js") }}"></script>
<!-- include FilePond plugins -->
<script src="{{ asset("vendor/filepond/filepond-plugin-image-preview.min.js") }}"></script>
<!-- include FilePond jQuery adapter -->
<script src="{{ asset("vendor/filepond/filepond.jquery.js") }}"></script>

<script src="{{asset("vendor/ckeditor5/build/ckeditor.js")}}"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.6/MathJax.js?config=TeX-MML-AM_CHTML"></script>

<script src="{{ asset('vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
<script src="{{ asset('vendor/datatables/js/dataTables.select.min.js') }}"></script>

<script src="{{asset('vendor/sweetalert/sweetalert.all.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets-custom/tagsinput/tagsinput.js') }}"></script>
@include('sweetalert::alert')
</body>
</html>
