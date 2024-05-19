@extends('layouts.mainlayout')

@section('content')
 <!-- Wrapper Start -->
<script type="text/javascript">
   $(document).ready(function() {

      var password = document.getElementById("password")
      , confirm_password = document.getElementById("cfPassword");

      function validatePassword(){
      if(password.value != confirm_password.value) {
         confirm_password.setCustomValidity("Passwords Don't Match");
      } else {
         confirm_password.setCustomValidity('');
      }
      }

      password.onchange = validatePassword;
      confirm_password.onkeyup = validatePassword;
      $('#email').on('blur', function(){
         var email = $('#email').val();
         if (email == '') {
            return;
         }
         $("#sbtn").attr("disabled", true);
         $.ajax({
            url: '/chk/mail',
            type: 'post',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {
               'email' : email,
            },
            success: function(response){
               if (response > 0 ) {
                  $("#chkmmsg").text('Sorry... Email already taken');
                  $("#chkmmsg").attr("class","d-flex justify-content-center  alert alert-danger ml-0 mr-0");
                  $("#sbtn").attr("disabled", true);
               }else{
                  $('#sbtn').removeAttr("disabled");
                  $("#chkmmsg").removeAttr("class");
                  $("#chkmmsg").hide();
               }
            }
         });
      });
   });
   function ShowHideDiv() {
        var account_type = document.getElementById("account_type");
        var signupform = document.getElementById("signupform");
        signupform.style.display = account_type.value != "none" ? "block" : "none";
        var Undergraduate = document.getElementById("Undergraduate");
        Undergraduate.style.display = account_type.value == "U" ? "block" : "none";
      //   var Graduated = document.getElementById("Graduated");
      //   Graduated.style.display = account_type.value == "G" ? "block" : "none";
        var Creator = document.getElementById("Creator");
        Creator.style.display = account_type.value == "C" ? "block" : "none";
        $('#occupation').hide();
        if(account_type.value!="U")
         {
            $('#occupation').show();
         }
    }
</script>

<script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
<link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />

 <div class="wrapper">
    <!-- Page Content  -->
    <div id="content-page" class="content-page">
       <div class="container-fluid">
          <div class="row">
            <div class="container p-0">
              <div class="row no-gutters">
                <div class="col-sm-12 align-self-center">
                  <div class="sign-in-from bg-white">
                    <h1 class="mb-0">Sign Up</h1>
                      <p>Select your role and fill the form below to sign up.</p>
                      <form class="mt-4" enctype="multipart/form-data" action="/signup" method="post">
                        @csrf
                          <div class="form-group">
                            <select id="account_type" name="acctype" class="form-control form-control-sm mb-3" onchange = "ShowHideDiv()">
                                <option selected="none" value="none">เลือกประเภทการสมัคร</option>
                                <option value="U">Examinee (Undergraduate)</option>
                                <option value="G">Examinee (Graduated)</option>
                                <option value="C">Creator</option>
                            </select>
                          </div>

                          <div id="signupform" style="display: none">
                            <hr>
                            <label for="Name">Name</label>
                            <div class="form-row">
                               <div class="col">
                                  <input type="text" name="firstname" class="form-control" placeholder="First name">
                               </div>
                               <div class="col">
                                  <input type="text" name="lastname" class="form-control" placeholder="Last name">
                               </div>
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="Address">Address</label>
                                <input type="text" name="address" class="form-control mb-0" id="Address" placeholder="Your Address">
                            </div>
                            <div class="form-group">
                                <label for="BD">Birth Date</label>
                                <input type="BD" name="birthdate" class="form-control mb-0" id="BD" placeholder="Select Date"> 
                            </div>

                            <div id="Undergraduate" style="display: none">
                              <div class="form-group">
                                  <label for="School">School</label>
                                  <input type="text" name="school" class="form-control mb-0" id="School" placeholder="School">
                              </div>
                            </div>

                            {{-- <div id="Graduated" style="display: none">
                              <div class="form-group">
                                  <label for="Occupation">Occupation</label>
                                  <input type="text" name="occupation" class="form-control mb-0" id="Occupation" placeholder="Your Occupation">
                              </div>
                            </div> --}}

                            <div id="occupation">
                              <div class="form-group">
                                  <label for="Occupation">Occupation</label>
                                  <input type="text" name="occupation" class="form-control mb-0" id="Occupation" placeholder="Your Occupation">
                              </div>
                            </div>
                              <div id="Creator" style="display: none">
                              <label for="Payment">Payment</label>
                                <div class="form-row">
                                   <div class="col">
                                      <input type="text" name="accnum" class="form-control" placeholder="Account Number">
                                   </div>
                                   <div class="col">
                                      <select id="Bank" name="bank" class="form-control form-control-sm mb-3">
                                          <option selected="">เลือกธนาคาร</option>
                                          <option value="KTB">กรุงไทย</option>
                                          <option value="KSB">กรุงศรี</option>
                                          <option value="KBank">กสิกร</option>
                                          <option value="BKB">กรุงเทพ</option>
                                          <option value="SCB">ไทยพานิชย์</option>
                                      </select>
                                   </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="Email">Email address</label>
                                <input type="Email" name="email" class="form-control mb-0" id="email" required pattern="[^@\s]+@[^@\s]+\.[^@\s]+" title="Invalid email address" placeholder="Enter email">
                            </div>
                              <div id="chkmmsg" role="alert"></div>
                            <hr>

                            <label for="Account">Account</label>
                            <div class="form-row">
                               <div class="col">
                                  <input type="text" id="username" name="username" class="form-control" placeholder="Username" required pattern="\w+">
                               </div>
                               <div class="col">
                                  <input type="password" id="password" name="psw" class="form-control" placeholder="Password" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" title="The password must contain at least 6 characters including numbers, uppercase and lowercase characters">
                               </div>
                            </div>
                            <div class="form-group">
                              <br>
                              <input type="password" class="form-control mb-0" id="cfPassword" placeholder="Confirm Password" required>
                            </div>
                            <br>

                            <div class="form-row">
                               <div class="col-sm-2">
                                  <div class="media-support-user-img mr-3">
                                    <img class="rounded-circle img-fluid" src="../../assets/images/user/1.jpg" alt="">
                                  </div>
                               </div>
                               <div class="col-sm-10">
                                  <div class="custom-file" align="left">
                                     <input type="file" name="profileImg" class="custom-file-input" id="validatedCustomFile" required="" accept="image/*">
                                     <label class="custom-file-label" for="validatedCustomFile">Choose Profile Picture/Avatar...</label>
                                     <div class="invalid-feedback">Example invalid custom file feedback</div>
                                  </div>
                               </div>
                            </div>
                            <div class="d-inline-block w-100">
                                <div class="custom-control custom-checkbox d-inline-block mt-2 pt-1">
                                    <input type="checkbox" class="custom-control-input" id="customCheck1">
                                    <label class="custom-control-label" for="customCheck1">I accept <a href="../../assets/pdf/BE-TermsAndConditions.pdf" target="_blank">Terms and Conditions</a></label>
                                </div>
                                <button id="sbtn" type="submit" class="btn btn-primary float-right">Sign Up</button>
                            </div>
                          </div>
                      </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
       </div>
    </div>
 </div>

&nbsp;

<script>
    $('#BD').datepicker({
        format: 'dd/mm/yyyy',
        uiLibrary: 'bootstrap'
    });
</script>
 <!-- Wrapper END -->
@endsection
