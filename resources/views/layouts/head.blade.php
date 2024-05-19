<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- logo in address bar -->
    <link rel="icon" type="image/png" href="{{ asset('assets/images/logo-chrome-512x512.png') }}">

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-ZBFWEWYF87"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'G-ZBFWEWYF87');
    </script>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" ></script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">


    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/ionicons.min.css') }}">
    <!-- Typography CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/typography.css') }}">
    <!-- Style CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/cstyle.css') }}">
    <!-- Responsive CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
    <!-- <link href="{{ asset('plugin/dataTables/jquery.dataTables.min.css') }}" rel="stylesheet"> -->
    <link href="{{ asset('plugin/dataTables/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <!-- include FilePond library -->
    <link rel="stylesheet" href="{{ asset('vendor/filepond/filepond.css') }}">
    <!-- include FilePond plugins -->
    <link rel="stylesheet" href="{{ asset('vendor/filepond/filepond-plugin-image-preview.css') }}">

    <link rel="stylesheet" href="{{ asset("vendor/datatables/css/dataTables.bootstrap4.min.css") }}">
    <link rel="stylesheet" href="{{ asset('vendor/datatables/css/buttons.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/datatables/css/select.bootstrap4.min.css') }}">

     <!-- SweetAlert2 -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.5.1/sweetalert2.min.css">
     <link rel="stylesheet" href="{{ asset('assets-custom/tagsinput/tagsinput.css') }}">
</head>
