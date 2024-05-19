@extends('layouts.mainlayout')

@section('content')
 <!-- Wrapper Start -->
<script type="text/javascript">
$(document).ready(function() {
    // loadSubjects();
    // loadMockNames();
    autoTags();
});
  var addSectionPressed = 1;
  function addSection() {
    // count when addSection button is pressed
    addSectionPressed = parseInt($('#sectionshow').text())+1;
    document.getElementById("sectionshow").innerHTML = addSectionPressed;

    let div = document.createElement('div');
    div.innerHTML = '<div class="form-group row"><div class="col-lg-4"><input type="text" id="numProbC' +addSectionPressed+ '"'+'class="form-control" placeholder="จำนวนข้อสอบตัวเลือก"></div><div class="col-lg-4"><input type="text" id="numC' +addSectionPressed+ '"'+'class="form-control" placeholder="จำนวนตัวเลือก"></div><div class="col-lg-4"><input type="text" id="numProbD' +addSectionPressed+ '"'+' class="form-control" placeholder="จำนวนข้อสอบเติมคำ"></div></div>';
    document.getElementById('setupexamform').appendChild(div);
  }

  var prefix1 = 'numProbC'; // number of problem with choices ans
  var prefix2 = 'numProbD'; // number of problem witn describtive ans
  var createPressed = 0;
  var existProbNum = 0;
  function createTagField() {
    addSectionPressed = parseInt($('#sectionshow').text());
    if (!isValid()) {
        return;
    }
    disableTemp();
    // For see how many time the button is pressed
    createPressed += 1;
    // document.getElementById("createPressed").innerHTML = createPressed;
    var probnum = 0;
    if (createPressed>1) { //to clear old tags field
      for (i=1; i<=existProbNum; i++){
        document.getElementById('tag'+parseInt(i)).remove();
      }
      existProbNum = 0;
    }
    for (i=1; i<=addSectionPressed; i++){
      probnum += parseInt(document.getElementById(prefix1+i).value)+parseInt(document.getElementById(prefix2+i).value)
    }
    document.getElementById("probnum").innerHTML = probnum;
    var start = parseInt($('#lastTags').val())+1;
    for (i=start; i<=probnum; i++){
      var div = document.createElement('div');
    //   div.innerHTML = '<div class="form-row"><div class="col-lg-1"><p>' +i+ '</p></div><div class="col-lg-11"><div class="bootstrap-tagsinput"><input type="text"  data-role="tagsinput" list="datalistOptions" id="tag'+i+'"'+' class="form-control texttag sr-only" placeholder="tags"></div><br></div></div>'
      div.innerHTML = '<div class="form-row" ><div class="col-lg-1"><p>' +i+ '</p></div><div class="col-lg-11"><input type="text" list="datalistOptions" id="tag'+i+'"'+' class="form-control texttag" placeholder="tags"><br></div></div>'
      document.getElementById('tagPanel').appendChild(div);
      $('#tag'+i).tagsinput('items');
      existProbNum +=1;
    }


    // var secrow = parseInt($("#sectionshow").text());
    // for (i=1; i<=secrow ; i++){
    //     var div = document.createElement('div');
    //     div.innerHTML =  '<div class="form-row" id="tag'+i+'"'+'><div class="col-lg-1"><p> Section ' +i+ '</p></div><div class="col-lg-11"><input type="text" class="form-control" id="tags'+i+'" placeholder="tags"><br></div></div>'
    //     document.getElementById('tagPanel').appendChild(div);
    // }
  }
  function disableTemp() {
    $('#sel-subject').prop('disabled', true);
    $('#sel-mname').prop('disabled', true);
    $('#time').prop('disabled', true);
    $("#temp input").prop('disabled', true);
    $("#addSubject").prop("disabled", true);
    $("#addMockname").prop("disabled", true);
    $("#addSection").prop("disabled", true);
    $("#createBtn").prop("disabled", true);
  }
  function enableTemp() {
    $('#sel-subject').prop('disabled', false);
    $('#sel-mname').prop('disabled', false);
    $('#time').prop('disabled', false);
    $("#temp input").prop('disabled', false);
    $("#addSubject").prop("disabled", false);
    $("#addMockname").prop("disabled", false);
    $("#addSection").prop("disabled", false);
    $("#createBtn").prop("disabled", false);
  }
  function timepattern(obj) {
        var pattern=new String("__:__:__"); // กำหนดรูปแบบในนี้
        var pattern_ex=new String(":"); // กำหนดสัญลักษณ์หรือเครื่องหมายที่ใช้แบ่งในนี้
        var returnText=new String("");
        var obj_l=obj.value.length;
        var obj_l2=obj_l-1;
        for(i=0;i<pattern.length;i++){
            if(obj_l2==i && pattern.charAt(i+1)==pattern_ex){
                returnText+=obj.value+pattern_ex;
                obj.value=returnText;
            }
        }
        if(obj_l>=pattern.length){
            obj.value=obj.value.substr(0,pattern.length);
        }
  }
  function isValid() {
    var validateText = "<ul style='border-top: 1px solid #eee;padding: 1em 0 0;display: block' class='invalid-feedback'>";
    if ($("#sel-subject").val() === "") {
        validateText += "<li>กรุณาเลือกรายวิชา</li>"
    }
    if ($("#sel-mname").val() === "") {
        validateText += "<li>กรุณาเลือกชื่อข้อสอบ</li>"
    }
    if ($("#time").val() === "") {
        validateText += "<li>กรุณาระบุเวลาที่ใช้ในการทำข้อสอบ</li>"
    }
    if ($("#numProbC1").val() === "") {
        validateText += "<li>กรุณาระบุจำนวนข้อสอบตัวเลือก</li>"
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
  function isValidTemp() {
    var validateText = "<ul style='border-top: 1px solid #eee;padding: 1em 0 0;display: block' class='invalid-feedback'>";
        $(".texttag").each(function(index){
            var i = index+1;
                if ($("#tag"+i).val() === "") {
                validateText += "<li>กรุณาระบุ tags"+i+"</li>"
            }
        });
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
                        //     Swal.fire({
                        //         title: 'Success',
                        //         text: "Add Success",
                        //         icon: 'success',
                        //         width: '550px',
                        //         showConfirmButton: true,
                        //     })
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
  function addMockname() {
        Swal.fire({
        title: 'ชื่อข้อสอบ',
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
                    url: '/api/mockname',
                    type: 'post',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        'mockname': result.value,
                    },
                    cache: false,
                    success: function(response) {
                        $("#sel-mname").append(
                            $('<option selected></option>')
                                .attr("value", ""+response.id)
                                .html(""+response.mx_name)
                        );
                    }
                });
            }
        })
  }
  function loadSubjects(){
    //PARAMETERS
    var url = "/api/subject";
    var callback = function(result){
        for(var i=0; i<result.length; i++){
            $("#sel-subject").append(
                $('<option></option>')
                    .attr("value", ""+result[i].sub_id)
                    .html(""+result[i].sub_name)
            );
        }
    };
    //CALL AJAX
    ajaxApi(url,callback);
    }
    function loadMockNames(){
    //PARAMETERS
    var url = "/api/mockname";
    var callback = function(result){
        for(var i=0; i<result.length; i++){
            $("#sel-mname").append(
                $('<option></option>')
                    .attr("value", ""+result[i].mx_id)
                    .html(""+result[i].mx_name)
            );
        }
    };
    //CALL AJAX
    ajaxApi(url,callback);
    }

    function saveTemplate() {
        if (!isValidTemp()) {
            return;
        }

        let formData = new FormData();
        formData.append("beId", window.location.pathname.split("/").pop());
        formData.append("subId", $("#sel-subject").val());
        formData.append("mxId", $("#sel-mname").val());
        var sections = parseInt($('#sectionshow').text());
        var probNum = parseInt($('#probnum').text());
        formData.append("sections",sections);
        for (i = 1; i <=  sections ; i++) {
            formData.append("numProbC"+i, $("#numProbC"+i).val());
            formData.append("numC"+i, $("#numC"+i).val());
            formData.append("numProbD"+i, $("#numProbD"+i).val());
        }
        for (i = 1; i <=  probNum ; i++) {
            formData.append("tag"+i, $("#tag"+i).val());
        }
        $.ajax({
            method: "post",
            url: "/admin/updtmp",
            headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: formData,
            contentType: false,
            processData: false,
            success: function(isOk) {
                if (isOk) {
                    Swal.fire({
                        title: "บันทึกเรียบร้อย",
                        icon: 'success',
                        showConfirmButton: true,
                        allowOutsideClick: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "/admin/print"
                        }
                    });
                }
            },
            error: function(response) {
                Swal.fire({
                    title: 'test',
                    icon: 'error',
                    allowOutsideClick: true
                });
            }
        });


    };

    function autoTags(){
    //PARAMETERS
    var url = "/api/tags/";
    var callback = function(result){
        for(var i=0; i<result.length; i++){
        $("#datalistOptions").append(
                $('<option></option>')
                    .attr("value", ""+result[i].me_tags)
                    .html(""+result[i].me_tags)
        );
        }
    };
    //CALL AJAX
    ajaxApi(url,callback);
    }

    function ajaxApi(url, callback){
    $.ajax({
        "url" : url,
        "type" : "GET",
        "dataType" : "json",
    }).done(callback); //END AJAX
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
  function delMockname() {
    if($('#sel-mname').val()===""){
        Swal.fire({
            // title: 'กรุณาระบุข้อวิชา',
            icon: 'warning',
            html: 'กรุณาระบุชื่อข้อสอบ',
            confirmButtonText: `ตรวจสอบ`,
            allowOutsideClick: true
        })
      }else{
    var mId = $('#sel-mname').val()
        Swal.fire({
        title: 'ลบชื่อข้อสอบ',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Delete',
        showLoaderOnConfirm: true,
        allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/api/mockname',
                    type: 'delete',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        'mId': mId,
                    },
                    cache: false,
                    success: function(response) {
                        if (response.status == 200) {
                            var x = document.getElementById("sel-mname");
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
                                text: "Failed to Delete Exam Name",
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

 <div class="wrapper">
    <!-- Sidebar  -->
    <!-- Page Content  -->
    <div id="content-page" class="content-page">
       <div class="container-fluid">
          <div class="row" id="temp">
            <div class="col-lg-12">
              <div class="iq-card">
                <div class="iq-card-header d-flex justify-content-between">
                    <div class="iq-header-title">
                        <h4 class="card-title">แก้ไข Template Book</h4>
                    </div>
                </div>
                <div class="iq-card-body">
                    <div class="iq-card-body">
                        <div class="form-group row">
                            @foreach ($tmp as $item)
                            <div class="col-lg-4">
                                <label>รายวิชา</label>
                                <select id="sel-subject" name="subject" class="form-control form-inline form-control-sm mb-3">
                                    <option value="">เลือกรายวิชา</option>
                                    @foreach ($sub as $ssel)
                                    <option value="{{$ssel->sub_id}}"
                                        @if($ssel->sub_id == $item->sub_id)
                                        selected=""
                                        @endif
                                        >{{$ssel->sub_name}}</option>
                                    @endforeach
                                </select>
                                {{-- <button type="button" class="btn mb-3 btn-primary" id="addSubject" onClick="addSubject()">
                                <i class="fa fa-plus" aria-hidden="true"></i>เพิ่มวิชา</button>
                                <button type="button" class="btn mb-3 btn-danger" id="delSubject" onClick="delSubject()">
                                    <i class="fa fa-minus" aria-hidden="true"></i>ลบรายวิชา</button> --}}
                            </div>
                            <div class="col-lg-4">
                                <label>ชื่อข้อสอบ</label>
                                <select  id="sel-mname" name="mockname" class="form-control form-control-sm mb-3">
                                    <option value="">เลือกชื่อข้อสอบ</option>
                                    @foreach ($mx as $smx)
                                    <option value="{{$smx->mx_id}}"
                                        @if($smx->mx_id == $item->mx_id)
                                        selected=""
                                        @endif
                                        >{{$smx->mx_name}}</option>
                                    @endforeach
                                </select>
                                {{-- <button type="button" class="btn mb-3 btn-primary" id="addMockname" onClick="addMockname()">
                                    <i class="fa fa-plus" aria-hidden="true"></i>เพิ่มชื่อข้อสอบ</button>
                                <button type="button" class="btn mb-3 btn-danger" id="delMockname" onClick="delMockname()">
                                    <i class="fa fa-minus" aria-hidden="true"></i>ลบชื่อข้อสอบ</button> --}}
                            </div>
                            <div class="col-lg-4">
                                {{-- <label>เวลาที่ใช้ในการทำข้อสอบ</label> --}}
                                {{-- <input type="text" id='time' class="form-control" placeholder="00:00:00" onkeyup="timepattern(this)" value="{{$item->me_time}}"> --}}
                            </div>
                            @endforeach
                        </div>
                        <div id="setupexamform">
                        @foreach ($secs as $item)
                          <div class="form-group row">
                              <div class="col-lg-4">
                                @if ($loop->first)
                                <label>จำนวนข้อสอบตัวเลือก</label>
                                @endif
                                <input type="text" id='numProbC{{ $loop->iteration }}' class="form-control" placeholder="จำนวนข้อสอบตัวเลือก" value="{{$item->be_choice_total}}">
                              </div>
                              <div class="col-lg-4">
                                @if ($loop->first)
                                <label>จำนวนตัวเลือก</label>
                                @endif
                                <input type="text" id='numC{{ $loop->iteration }}' class="form-control" placeholder="จำนวนตัวเลือก" value="{{$item->be_choice}}">
                              </div>
                              <div class="col-lg-4">
                                @if ($loop->first)
                                <label>จำนวนข้อสอบเติมคำ</label>
                                @endif
                                <input type="text" id='numProbD{{ $loop->iteration }}' class="form-control" placeholder="จำนวนข้อสอบเติมคำ" value="{{$item->be_write}}">
                              </div>
                          </div>
                          @endforeach
                        </div>

                        <div class="form-row-center">
                          <button type="button" class="btn mb-3 btn-primary" id="addSection" onClick="addSection()">
                            <i class="fa fa-plus" aria-hidden="true"></i>Add Section</button>
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary btn-block" id="createBtn" onClick="createTagField()">Create</button>
                </div>
              </div>
            </div>
          </div>
          <div class="row" id="tags">
            <div class="col-lg-12">
              <div class="iq-card">
                <div class="iq-card-header d-flex justify-content-between">
                    <div class="iq-header-title">
                        <h4 class="card-title">ใส่ Tags เพื่อกำหนด Template</h4>
                    </div>
                    Section: <a id="sectionshow">{{$secTotal}}</a> &nbsp; จำนวนข้อ: <a id="probnum">{{$probNum}}</a> <!-- &nbsp; Create Pressed: <a id="createPressed"></a> -->
                </div>
                  <div class="card-body text-primary">
                      <div id="tagPanel">
                        <!-- for tags field input -->
                        @foreach ($tags as $tag)
                        <div class="form-row" >
                            <div class="col-lg-1">
                                <p>{{ $loop->iteration }}</p>
                            </div>
                            <div class="col-lg-11">
                                <input type="text" list="datalistOptions" id="tag{{ $loop->iteration }}" data-role="tagsinput" class="form-control texttag" placeholder="tags" value="{{$tag->be_tags}}">
                                <br>
                            </div>
                        </div>
                        @if ($loop->last)
                            <input type="hidden" id="lastTags" value="{{ $loop->iteration }}" >
                        @endif
                        @endforeach
                      </div>
                      <br>
                      <div class="form-row-center">
                        <div class="btn-group" role="group" aria-label="Basic example">
                           <button type="button" onclick="saveTemplate()" class="btn btn-primary">Save</button>
                           {{-- <button type="button" class="btn btn-primary">Submit</button> --}}
                           <button type="button" class="btn btn-primary">Cancel</button>
                           {{-- <button type="button" class="btn btn-primary">Delete</button> --}}
                        </div>
                      </div>
                  </div>
               </div>
            </div>
            <datalist id="datalistOptions">
            </datalist>
          </div>
       </div>
    </div>
 </div>

&nbsp;


 <!-- Wrapper END -->
 <!-- Footer -->

@endsection