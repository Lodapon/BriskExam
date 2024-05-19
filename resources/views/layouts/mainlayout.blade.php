<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('layouts.head')
    </head>
    <body class="header-top-bg">
        <!-- loader Start -->
        <div id="loading">

        </div>
        @if(Session::has('user'))
            @if(Session::get('user')->role =='A')
                @include('layouts.navadmin')
            @endif
            @if(Session::get('user')->role =='B')
            @include('layouts.navadminb')
        @endif
            @if(Session::get('user')->role =='C')
                @include('layouts.navcreator')
            @endif
            @if(Session::get('user')->role =='U'||Session::get('user')->role =='G')
                @include('layouts.navstd')
            @endif
        @else
            @include('layouts.nav')
        @endif

        <section class="content">
            @yield('content')
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
