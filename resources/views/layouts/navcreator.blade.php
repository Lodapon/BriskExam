<!-- TOP Nav Bar -->
<div class="iq-top-navbar" style="box-shadow: 0 0.5rem 1rem rgb(0 0 0 / 6%)" id="my-iq-top-navbar">
    <div class="iq-navbar-custom">
       <nav class="navbar navbar-expand-lg navbar-light p-0">
        <a href="/" class="navbar-brand logo">
            <img src="{{ asset('assets/images/logo-02.jpg') }}" class="img-fluid brand-logo" alt="">
        </a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
        </div>

        @if(Session::get('user')->role =='C')
            <a class="nav-link  iq-waves-effect" href="/creator/dashboard">Dashboard <span class="sr-only">(current)</span></a>
        @else
            <a class="nav-link  iq-waves-effect" href="/admin/dashboard">Dashboard <span class="sr-only">(current)</span></a>
        @endif

        <a class="nav-link  iq-waves-effect" href="/testfix">Fix Exam</a>

        <a class="nav-link  iq-waves-effect" href="/logout">Log Out</a>

        <a href="javascript:void(0);" class="icon" style="margin-top: 32px; margin-right: 15px;" onclick="myNavFunction()">
          <i class="fa fa-bars"></i>
        </a>

       </nav>
   </div>
 </div>
<!-- TOP Nav Bar END -->



<style>
  .nav-link {font-size: 18px;}

  .nav-item:hover {opacity: 0.5}

  /* Hide the link that should open and close the topnav on small screens */
  .iq-top-navbar .icon {
    display: none;
  }

  /* When the screen is less than 994 pixels wide, hide all links, except for the first one ("Home"). Show the link that contains should open and close the topnav (.icon) */
  @media screen and (max-width: 994px) {
    .iq-top-navbar a:not(:first-child) {display: none;}
    .iq-top-navbar a.icon {
      float: right;
      display: block;
    }
  }

  /* The "responsive" class is added to the topnav with JavaScript when the user clicks on the icon. This class makes the topnav look good on small screens (display the links vertically instead of horizontally) */
  @media screen and (max-width: 994px) {
    .iq-top-navbar.responsive {position: fixed;}
    .iq-top-navbar.responsive a.icon {
      position: absolute;
      right: 0;
      top: 0;
    }
    .iq-top-navbar.responsive a {
      float: none;
      display: block;
      text-align: left;
    }
  }
</style>


<script>
  /* Toggle between adding and removing the "responsive" class to topnav when the user clicks on the icon */
  function myNavFunction() {
    var x = document.getElementById("my-iq-top-navbar");
    if (x.className === "iq-top-navbar") {
      x.className += " responsive";
    } else {
      x.className = "iq-top-navbar";
    }
  }
</script>
