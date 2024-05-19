<!-- TOP Nav Bar -->
<div class="iq-top-navbar" style=" box-shadow: 0 0.5rem 1rem rgb(0 0 0 / 6%)" id="my-iq-top-navbar">
    <div class="iq-navbar-custom">
       <nav class="navbar navbar-expand-lg navbar-light p-0">
        <a href="/" class="navbar-brand logo">
            <img src="{{ asset('assets/images/logo-02.jpg') }}" class="img-fluid brand-logo" alt="">
        </a>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
          </div>

        @if(Session::get('user')->role =='C')
            <a class="nav-link navbar-list  iq-waves-effect" href="/creator/dashboard">Dashboard <span class="sr-only">(current)</span></a>
        @else
            <a class="nav-link navbar-list  iq-waves-effect" href="/admin/dashboard">Dashboard <span class="sr-only">(current)</span></a>
        @endif

        <a class="nav-link navbar-list iq-waves-effect" href="/admin/addcredit">Add Credit</a>

        <a class="nav-link navbar-list iq-waves-effect" href="/testfix">Fix Exam</a>

        <div class="dropdown">
          <button class="dropbtn">Mock Up Exam</button>
          <div class="dropdown-content">
            <a class="nav-link  iq-waves-effect" href="{{route('mock.template')}}">Create Template</a>
            <a class="nav-link  iq-waves-effect" href="/viewtemplate">Templates</a>
            <a class="nav-link  iq-waves-effect" href="{{route('mock.add')}}">Input Problem</a>
            <a class="nav-link  iq-waves-effect" href="{{route('mock.edit')}}">Edit Problem</a>
          </div>
        </div>

        <div class="dropdown">
          <button class="dropbtn">Book</button>
          <div class="dropdown-content">
            <a class="nav-link  iq-waves-effect" href="/admin/print">Print</a>
            <a class="nav-link  iq-waves-effect" href="/admin/bookshelf">Bookshelf</a>
          </div>
        </div>

        <a class="nav-link navbar-list iq-waves-effect" href="/admin/users">Edit User</a>

        <a class="nav-link navbar-list iq-waves-effect" href="/logout">Log Out</a>

        <a href="javascript:void(0);" class="icon" style="margin-top: 32px; margin-right: 15px;" onclick="myNavFunction()">
          <i class="fa fa-bars"></i>
        </a>

       </nav>
   </div>
 </div>
<!-- TOP Nav Bar END -->



 <style>

  .navbar-list {
    font-size: 18px;
    padding: 0 15px;
    line-height: 73px;
    color: #4F6272;
    display: block;
    min-height: 75px;
  }

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
    /* display: inline-block; */
    /* Dropdown container - needed to position the dropdown content */
    float: left;
    /* overflow: hidden; */
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


  /* Hide the link that should open and close the topnav on small screens */
  .iq-top-navbar .icon {
    display: none;
  }

  /* When the screen is less than 994 pixels wide, hide all links, except for the first one ("Home"). Show the link that contains should open and close the topnav (.icon) */
  @media screen and (max-width: 994px) {
    .iq-top-navbar a:not(:first-child), .dropdown .dropbtn {
      display: none;
    }
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

    .iq-top-navbar.responsive .dropdown {float: none;}
    .iq-top-navbar.responsive .dropdown-content {position: relative;}
    .iq-top-navbar.responsive .dropdown .dropbtn {
      display: block;
      width: 100%;
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

