@extends('layouts.mainlayout')

@section('content')
<script>
function update() {
        if(isValid()){
            $("#update" ).submit();
        }

    }
    function isValid() {
        var validateText = "<ul style='border-top: 1px solid #eee;padding: 1em 0 0;display: block' class='invalid-feedback'>";
       
        if ($("#firstname").val() === "") {
            validateText += "<li>กรุณากรอก First name</li>"
        }
        if ($("#lastname").val() === "") {
            validateText += "<li>กรุณากรอก Last name</li>"
        }
        if ($("#address").val() === "") {
            validateText += "<li>กรุณากรอก Address</li>"
        }
        if ($("#BD").val() === "") {
            validateText += "<li>กรุณากรอก Birth Date</li>"
        }
        validateText += "</ul>"

        if (validateText !== "<ul style='border-top: 1px solid #eee;padding: 1em 0 0;display: block' class='invalid-feedback'></ul>") {
            Swal.fire({
                title: 'กรุณากรอกข้อมูลให้ครบถ้วน',
                icon: 'warning',
                html: validateText,
                confirmButtonText: `ตรวจสอบ`,
                allowOutsideClick: true
            })
            return false;
        }
        return true;
    }
</script>
<div id="content-page" class="content-page">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
            </div>
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-lg-3 profile-left">
                        <div class="iq-card">
                            <div class="iq-card-header d-flex justify-content-between">
                                <div class="iq-header-title">
                                <h4 class="card-title">Profile</h4>
                                </div>
                            </div>
                            <div class="iq-card-body">
                                {{-- <div class="row"> --}}
                                    <div class="col-md-12">
                                        <div class="user-detail">
                                            <div class="user-profile">
                                                <img src="{{'data:'.$userdata->profile_img_type.';base64,'.base64_encode( $userdata->profile_img )}}" alt="profile-img" class="avatar-130 img-fluid">
                                            </div>
                                            <div class="profile-detail mt-3">
                                                <h3 class="d-inline-block">{{ $userdata->username }}</h3>
                                                <p class="d-inline-block pl-1">- {{ $userdata->role_name }}</p>
                                            </div>
                                        </div>
                                    </div>
                            </div> 
                        </div>
                    </div>
                    
                    <div class="col-lg-9 profile-center">
                        <div class="iq-card">
                            <div class="iq-card-header d-flex justify-content-between">
                                <div class="iq-header-title">
                                    <h4 class="card-title">About User</h4>
                                </div>
                                <div class="iq-card-header-toolbar d-flex align-items-center">
                                    <a href="javascript:update();" class="float-right mr-1 btn btn-sm btn-primary"><i class="fa fa-pencil-square-o"></i>Update</a> 
                                </div>
                            </div>
                            <div class="iq-card-body">
                                <form class="mt-4" id="update" enctype="multipart/form-data" action="{{route('std.update')}}" method="post">
                                    @csrf
                                      <div id="editform">
                                        <label for="Name">Name</label>
                                        <div class="form-row">
                                           <div class="col">
                                              <input type="text" name="firstname" id="firstname" class="form-control" placeholder="First name" value="{{ $userdata->first_name }}">
                                           </div>
                                           <div class="col">
                                              <input type="text" name="lastname" id="lastname" class="form-control" placeholder="Last name" value="{{ $userdata->last_name }}">
                                           </div>
                                        </div>
                                        <br>
                                        <div class="form-group">
                                            <label for="Address">Address</label>
                                            <input type="text" name="address" class="form-control mb-0" id="address" placeholder="Your Address" value="{{ $userdata->address }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="BD">Birth Date</label>
                                            <input type="BD" name="birthdate" class="form-control mb-0" id="BD" placeholder="Select Date" value="{{ \Carbon\Carbon::parse($userdata->birth_date)->format('d/m/Y')}}"> 
                                        </div>
            
                                        @if(session("user")->role =='U')
                                          <div class="form-group">
                                              <label for="School">School</label>
                                              <input type="text" name="school" class="form-control mb-0" id="School" placeholder="School" value="{{ $userdata->school }}">
                                          </div>
                                        </div>
                                        @endif
                                        @if(session("user")->role !='U')
                                          <div class="form-group">
                                              <label for="Occupation">Occupation</label>
                                              <input type="text" name="occupation" class="form-control mb-0" id="Occupation" placeholder="Your Occupation" value="{{ $userdata->occupation }}">
                                          </div>
                                        @endif
                                        @if(session("user")->role !='C')
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
                                        @endif
                                        <div class="form-group">
                                            <label for="Email">Email address</label>
                                            <input type="Email" name="email" class="form-control mb-0" id="email" required pattern="[^@\s]+@[^@\s]+\.[^@\s]+" title="Invalid email address" placeholder="Enter email" value="{{ $userdata->email }}">
                                        </div>
                                          <div id="chkmmsg" role="alert"></div>
                                        <hr>
                                        <br>
                                        <div class="form-row">
                                           <div class="col-sm-2">
                                              <div class="media-support-user-img mr-3">
                                                <img class="rounded-circle img-fluid" src="{{'data:'.$userdata->profile_img_type.';base64,'.base64_encode( $userdata->profile_img )}}" alt="">
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
                                      </div>
                            </div>
                        </div>
                    
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
