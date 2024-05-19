@extends('layouts.mainlayout')

@section('content')
 <!-- Wrapper Start -->
<script type="text/javascript">
  function addSubject() {
    var subjectToAdd = document.getElementById("subjectToAdd").value;
    let opt = document.createElement("option");
    opt.text = subjectToAdd;
    opt.value = subjectToAdd;
    document.getElementById('subjectList').add(opt,undefined);
  }
  function deleteSubject() {
    var subjectToDelete = document.getElementById("subjectList").value;
    $("#subjectList option:selected").remove();
  }

  function addGrade() {
    var gradeToAdd = document.getElementById("gradeToAdd").value;
    let opt = document.createElement("option");
    opt.text = gradeToAdd;
    opt.value = gradeToAdd;
    document.getElementById('gradeList').add(opt,undefined);
  }
  function deleteGrade() {
    var gradeToDelete = document.getElementById("gradeList").value;
    $("#gradeList option:selected").remove();
  }

  function addChaptor() {
    var chaptorToAdd = document.getElementById("chaptorToAdd").value;
    let opt = document.createElement("option");
    opt.text = chaptorToAdd;
    opt.value = chaptorToAdd;
    document.getElementById('chaptorList').add(opt,undefined);
  }
  function deleteChaptor() {
    var chaptorToDelete = document.getElementById("chaptorList").value;
    $("#chaptorList option:selected").remove();
  }


</script>

 <div class="wrapper">
    <!-- Sidebar  -->
    <!-- Page Content  -->
    <div id="content-page" class="content-page">
       <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
              <div class="iq-card">
                <div class="iq-card-header d-flex justify-content-between">
                    <div class="iq-header-title">
                        <h4 class="card-title">กำหนดรายการสำหรับข้อสอบ Fix</h4>
                    </div>
                </div>
                <div class="iq-card-body">
                    <div class="iq-card-body">
                      <label>วิชา</label>
                      <div class="form-group row">
                          <div class="col-lg-4">
                              <input type="text" id='subjectToAdd' class="form-control" placeholder="กรอกวิชาที่ต้องการเพิ่ม">
                          </div>
                          <div class="col-lg-2">
                            <div class="form-row-center">
                              <button type="button" class="btn mb-3 btn-primary" id="addSubject" onClick="addSubject()">
                                <i class="fa fa-plus" aria-hidden="true"></i>Add</button>
                            </div>
                          </div>
                          <div class="col-lg-4">
                            <select class="form-control form-control-sm mb-3" id="subjectList">
                                <option selected="none">เลือกรายวิชา</option>

                            </select>
                          </div>
                          <div class="col-lg-2">
                            <div class="form-row-center">
                              <button type="button" class="btn mb-3 btn-danger" id="deleteSubject" onClick="deleteSubject()">Delete</button>
                            </div>
                          </div>
                      </div>

                      <label>ระดับชั้น</label>
                      <div class="form-group row">
                          <div class="col-lg-4">
                              <input type="text" id='gradeToAdd' class="form-control" placeholder="กรอกระดับชั้นที่ต้องการเพิ่ม">
                          </div>
                          <div class="col-lg-2">
                            <div class="form-row-center">
                              <button type="button" class="btn mb-3 btn-primary" id="addGrade" onClick="addGrade()">
                                <i class="fa fa-plus" aria-hidden="true"></i>Add</button>
                            </div>
                          </div>
                          <div class="col-lg-4">
                            <select class="form-control form-control-sm mb-3" id="gradeList">
                                <option selected="none">เลือกระดับชั้น</option>

                            </select>
                          </div>
                          <div class="col-lg-2">
                            <div class="form-row-center">
                              <button type="button" class="btn mb-3 btn-danger" id="deleteGrade" onClick="deleteGrade()">Delete</button>
                            </div>
                          </div>
                      </div>
                      <label>บท</label>
                      <div class="form-group row">
                          <div class="col-lg-4">
                              <input type="text" id='chaptorToAdd' class="form-control" placeholder="กรอกบทที่ต้องการเพิ่ม">
                          </div>
                          <div class="col-lg-2">
                            <div class="form-row-center">
                              <button type="button" class="btn mb-3 btn-primary" id="addChaptor" onClick="addChaptor()">
                                <i class="fa fa-plus" aria-hidden="true"></i>Add</button>
                            </div>
                          </div>
                          <div class="col-lg-4">
                            <select class="form-control form-control-sm mb-3" id="chaptorList">
                                <option selected="none">เลือกบท</option>

                            </select>
                          </div>
                          <div class="col-lg-2">
                            <div class="form-row-center">
                              <button type="button" class="btn mb-3 btn-danger" id="deleteChaptor" onClick="deleteChaptor()">Delete</button>
                            </div>
                          </div>
                      </div>
                    </div>
                    <button type="button" class="btn btn-primary btn-block" onClick="">Save</button>
                </div>
              </div> 
            </div>
          </div>
       </div>
    </div>
 </div>

&nbsp;


 <!-- Wrapper END -->
 <!-- Footer -->

@endsection
