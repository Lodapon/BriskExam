@extends('layouts.mainlayout')

@section('content')
<script>
function addSubject() {
        Swal.fire({
        title: 'เพิ่มรายวิชา',
        input: 'text',
        inputAttributes: {
            autocapitalize: 'off'
        },
        showCancelButton: true,
        confirmButtonText: 'Add',
        showLoaderOnConfirm: true,
        allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/api/subject',
                    type: 'post',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        'subname': result.value,
                    },
                    cache: false,
                    success: function(response) {
                        $("#sel-subject").append(
                            $('<option selected></option>')
                                .attr("value", ""+response.id)
                                .html(""+response.sub_name)
                        );
                        // if (response.status == 200) {
                            Swal.fire({
                                title: 'Success',
                                text: "Add Success",
                                icon: 'success',
                                width: '550px',
                                showConfirmButton: true,
                            })
                        //     // setTimeout(function() {
                        //     //     swal.close();
                        //     //     $('#test-fe-id').val(fid);
                        //     //     $('#do-test').submit();
                        //     // }, 1500)
                        // } else {
                        //     Swal.fire({
                        //         title: 'Error',
                        //         text: "Failed to Add subject",
                        //         icon: 'error',
                        //         width: '550px',
                        //         showConfirmButton: true,
                        //         timer: 3000
                        //     })
                        // }
                    }
                });
            }
        })
  }
  function addGrade() {
        Swal.fire({
        title: 'เพิ่มระดับชั้น',
        input: 'text',
        inputAttributes: {
            autocapitalize: 'off'
        },
        showCancelButton: true,
        confirmButtonText: 'Add',
        showLoaderOnConfirm: true,
        allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/api/grade',
                    type: 'post',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        'gname': result.value,
                    },
                    cache: false,
                    success: function(response) {
                        $("#sel-grade").append(
                            $('<option selected></option>')
                                .attr("value", ""+response.id)
                                .html(""+response.g_name)
                        );
                        // if (response.status == 200) {
                            Swal.fire({
                                title: 'Success',
                                text: "Add Success",
                                icon: 'success',
                                width: '550px',
                                showConfirmButton: true,
                            })
                        //     // setTimeout(function() {
                        //     //     swal.close();
                        //     //     $('#test-fe-id').val(fid);
                        //     //     $('#do-test').submit();
                        //     // }, 1500)
                        // } else {
                        //     Swal.fire({
                        //         title: 'Error',
                        //         text: "Failed to Add subject",
                        //         icon: 'error',
                        //         width: '550px',
                        //         showConfirmButton: true,
                        //         timer: 3000
                        //     })
                        // }
                    }
                });
            }
        })
  }
  function addCate() {
      if($('#sel-subject').val()===""){
        Swal.fire({
            // title: 'กรุณาระบุข้อวิชา',
            icon: 'warning',
            html: 'กรุณาระบุวิชา',
            confirmButtonText: `ตรวจสอบ`,
            allowOutsideClick: true
        })
      }else{
        Swal.fire({
        title: 'เพิ่มข้อสอบ (บท)',
        input: 'text',
        inputAttributes: {
            autocapitalize: 'off'
        },
        showCancelButton: true,
        confirmButtonText: 'Add',
        showLoaderOnConfirm: true,
        allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/api/cate',
                    type: 'post',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        'catename': result.value,
                        'subid': $('#sel-subject').val(),
                    },
                    cache: false,
                    success: function(response) {
                        $("#sel-cate").append(
                            $('<option selected></option>')
                                .attr("value", ""+response.id)
                                .html(""+response.cate_name)
                        );
                        // if (response.status == 200) {
                            Swal.fire({
                                title: 'Success',
                                text: "Add Success",
                                icon: 'success',
                                width: '550px',
                                showConfirmButton: true,
                            })
                        //     // setTimeout(function() {
                        //     //     swal.close();
                        //     //     $('#test-fe-id').val(fid);
                        //     //     $('#do-test').submit();
                        //     // }, 1500)
                        // } else {
                        //     Swal.fire({
                        //         title: 'Error',
                        //         text: "Failed to Add subject",
                        //         icon: 'error',
                        //         width: '550px',
                        //         showConfirmButton: true,
                        //         timer: 3000
                        //     })
                        // }
                    }
                });
            }
        })
    }
  }

  function delSubject() {
    if($('#sel-subject').val()===""){
        Swal.fire({
            // title: 'กรุณาระบุข้อวิชา',
            icon: 'warning',
            html: 'กรุณาระบุวิชา',
            confirmButtonText: `ตรวจสอบ`,
            allowOutsideClick: true
        })
      }else{
    var subId = $('#sel-subject').val()
        Swal.fire({
        title: 'ลบรายวิชา',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Delete',
        showLoaderOnConfirm: true,
        allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/api/subject',
                    type: 'delete',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        'subId': subId,
                    },
                    cache: false,
                    success: function(response) {
                        if (response.status == 200) {
                            var x = document.getElementById("sel-subject");
                            x.remove(x.selectedIndex);
                            Swal.fire({
                                title: 'Success',
                                text: "Delete Success",
                                icon: 'success',
                                width: '550px',
                                showConfirmButton: true,
                            })
                        } else {
                            Swal.fire({
                                title: 'Error',
                                text: "Failed to Delete subject",
                                icon: 'error',
                                width: '550px',
                                showConfirmButton: true
                            })
                        }
                    }
                });
            }
        })
    }
  }

  function delGrade() {
    if($('#sel-grade').val()===""){
        Swal.fire({
            // title: 'กรุณาระบุข้อวิชา',
            icon: 'warning',
            html: 'กรุณาระบุระดับชั้น',
            confirmButtonText: `ตรวจสอบ`,
            allowOutsideClick: true
        })
      }else{
    var gId = $('#sel-grade').val()
        Swal.fire({
        title: 'ลบระดับชั้น',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Delete',
        showLoaderOnConfirm: true,
        allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/api/grade',
                    type: 'delete',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        'gId': gId,
                    },
                    cache: false,
                    success: function(response) {
                        if (response.status == 200) {
                            var x = document.getElementById("sel-grade");
                            x.remove(x.selectedIndex);
                            Swal.fire({
                                title: 'Success',
                                text: "Delete Success",
                                icon: 'success',
                                width: '550px',
                                showConfirmButton: true,
                            })
                        } else {
                            Swal.fire({
                                title: 'Error',
                                text: "Failed to Delete Grade",
                                icon: 'error',
                                width: '550px',
                                showConfirmButton: true
                            })
                        }
                    }
                });
            }
        })
    }
  }

  function delCate() {
    if($('#sel-cate').val()===""){
        Swal.fire({
            // title: 'กรุณาระบุข้อวิชา',
            icon: 'warning',
            html: 'กรุณาระบุข้อสอบ (บท)',
            confirmButtonText: `ตรวจสอบ`,
            allowOutsideClick: true
        })
      }else{
    var cateId = $('#sel-cate').val()
        Swal.fire({
        title: 'ลบข้อสอบ (บท)',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Delete',
        showLoaderOnConfirm: true,
        allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/api/cate',
                    type: 'delete',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        'cateId': cateId,
                    },
                    cache: false,
                    success: function(response) {
                        if (response.status == 200) {
                            var x = document.getElementById("sel-cate");
                            x.remove(x.selectedIndex);
                            Swal.fire({
                                title: 'Success',
                                text: "Delete Success",
                                icon: 'success',
                                width: '550px',
                                showConfirmButton: true,
                            })
                        } else {
                            Swal.fire({
                                title: 'Error',
                                text: "Failed to Delete subject",
                                icon: 'error',
                                width: '550px',
                                showConfirmButton: true
                            })
                        }
                    }
                });
            }
        })
    }
  }
</script>
 <!-- Wrapper Start -->
 <div class="wrapper">
    <!-- Page Content  -->
    <div id="content-page" class="content-page">
       <div class="container-fluid">
          <div class="row">

              <div class="col-lg-12">
                  <div class="iq-card">
                      <div class="iq-card-header d-flex justify-content-between">
                          <div class="iq-header-title">
                              <h4 class="card-title">ข้อสอบถาวร (ข้อสอบ Fix) รายบท แยกชุด</h4>
                          </div>
                      </div>

                      <input type="hidden" id="feId" value="{{$fixExam->fe_id ?? ""}}" />

                      <div class="iq-card-body">
                          <div class="iq-card-body">
                              <div class="form-group row">
                                  <div class="col-lg-4">
                                      <label>รายวิชา</label>
{{--                                      <input type="text" class="form-control" disabled value="{{$fixExam->sub_name}}">--}}
                                      <input type="hidden" id="subValue" value="{{$fixExam->sub_id ?? null}}" />
                                      <select id="sel-subject" class="form-control form-control-sm mb-3" onchange="loadCategories()">
                                          <option selected value="">เลือกรายวิชา</option>
                                      </select>
                                      <button type="button" class="btn mb-3 btn-primary" id="addSubject" onClick="addSubject()">
                                        <i class="fa fa-plus" aria-hidden="true"></i>เพิ่มรายวิชา</button>
                                      <button type="button" class="btn mb-3 btn-danger" id="delSubject" onClick="delSubject()">
                                        <i class="fa fa-minus" aria-hidden="true"></i>ลบรายวิชา</button>
                                  </div>
                                  <div class="col-lg-4">
                                      <label>ระดับชั้น</label>
{{--                                      <input type="text" class="form-control" disabled value="{{$fixExam->g_name}}">--}}
                                      <input type="hidden" id="gradeValue" value="{{$fixExam->g_id ?? null}}" />
                                      <select id="sel-grade" class="form-control form-control-sm mb-3">
                                          <option selected  value="">เลือกระดับชั้น</option>
                                      </select>
                                      <button type="button" class="btn mb-3 btn-primary" id="addGrade" onClick="addGrade()">
                                        <i class="fa fa-plus" aria-hidden="true"></i>เพิ่มระดับชั้น</button>
                                     <button type="button" class="btn mb-3 btn-danger" id="delGrade" onClick="delGrade()">
                                        <i class="fa fa-minus" aria-hidden="true"></i>ลบระดับชั้น</button>
                                  </div>
                                  <div class="col-lg-4">
                                      <label>ชื่อข้อสอบ (บท)</label>
{{--                                      <input type="text" class="form-control" disabled value="{{$fixExam->cate_name}}">--}}
                                      <input type="hidden" id="cateValue" value="{{$fixExam->cate_id ?? null}}" />
                                      <select id="sel-cate" class="form-control form-control-sm mb-3">
                                          <option selected value="">เลือกชื่อข้อสอบ (บท)</option>
                                      </select>
                                      <button type="button" class="btn mb-3 btn-primary" id="addCate" onClick="addCate()">
                                        <i class="fa fa-plus" aria-hidden="true"></i>เพิ่มข้อสอบ (บท)</button>
                                     <button type="button" class="btn mb-3 btn-danger" id="delCate" onClick="delCate()">
                                        <i class="fa fa-minus" aria-hidden="true"></i>ลบข้อสอบ (บท)</button>
                                  </div>
{{--                                  <div class="col-lg-3">--}}
{{--                                      <label>ชุดข้อสอบ</label>--}}
{{--                                      <input type="text" class="form-control" disabled value="{{$fixExam->chap_name}}">--}}
{{--                                      <input type="hidden" id="chapValue" value="{{$fixExam->chap_id ?? null}}" />--}}
{{--                                      <select id="sel-chap" class="form-control form-control-sm mb-3">--}}
{{--                                          <option selected value="">เลือกชุดข้อสอบ</option>--}}
{{--                                      </select>--}}
{{--                                  </div>--}}
                              </div>
                              <div class="form-group row">
                                  <div class="col-9 align-content-center">
                                      <label class="float-right" for="price">
                                        ราคาข้อสอบ
                                      </label>
                                  </div>
                                  <div class="col-3">
                                      <div class="input-group">
                                          <input type="number" class="form-control text-right font-size-16 font-weight-bold float-right" id="price" aria-describedby="pricePrepend" value="{{$fixExam->fe_price ?? null}}">
                                          <div class="input-group-prepend">
                                              <span class="input-group-text" id="pricePrepend">บาท</span>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                              <div class="row">
                                  <div class="col-12">
                                      <button type="button" class="btn btn-primary btn-block" id="saveChapter">Create New Chapter</button>
                                      @if(session("user")->role !='A')
                                      <button type="button" class="btn btn-primary btn-block" id="sendAppr">Send Approve</button>
                                      @endif
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
 <!-- Wrapper END -->
 <script type="text/javascript" src="{{ asset('/assets-custom/test-fix-chap-new.js') }}"></script>
@endsection


