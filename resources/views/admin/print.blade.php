@extends('layouts.mainlayout')

@section('content')
<script type="text/javascript">
    
</script>

    <!-- Wrapper Start -->
    <style>
        .aligncenter {
            text-align: center;
        }
    </style>
    <!-- Page Content  -->
    <div id="content-page" class="content-page">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="iq-card">
                        <div class="iq-card-header d-flex justify-content-between">
                            <div class="iq-header-title">
                                <h4 class="card-title">Create Template Book</h4>
                            </div>
                        </div>
                        <div class="iq-card-body">
                            <div class="iq-card-body">
                                <div class="form-group row">
                                    <div class="col-lg-4">
                                        <label>รายวิชา</label>
                                        <select id="sel-subject" name="subject" class="form-control form-inline form-control-sm mb-3">
                                            <option value="" selected="">เลือกรายวิชา</option>
                                        </select>
                                        <button type="button" class="btn mb-3 btn-primary" id="addSubject" onClick="addSubject()">
                                        <i class="fa fa-plus" aria-hidden="true"></i>เพิ่มวิชา</button>
                                    </div>
                                    <div class="col-lg-4">
                                        <label>ชื่อข้อสอบ</label>
                                        <select  id="sel-mname" name="mockname" class="form-control form-control-sm mb-3">
                                            <option value="" selected="">เลือกชื่อข้อสอบ</option>
                                        </select>
                                        <button type="button" class="btn mb-3 btn-primary" id="addMockname" onClick="addMockname()">
                                            <i class="fa fa-plus" aria-hidden="true"></i>เพิ่มชื่อข้อสอบ</button>
                                    </div>
                                    <div class="col-lg-4">
                                        {{-- <label>เวลาที่ใช้ในการทำข้อสอบ</label> --}}
                                        <input type="hidden" id='time' class="form-control" placeholder="00:00:00" onkeyup="timepattern(this)">
                                    </div>
                                </div>
                                <div id="setupexamform">
                                  <div class="form-group row">
                                      <div class="col-lg-4">
                                        <label>ข้อสอบตัวเลือก</label>
                                        <input type="text" id='numProbC1' class="form-control" placeholder="จำนวนข้อสอบตัวเลือก">
                                      </div>
                                      <div class="col-lg-4">
                                        <label> <br></label>
                                        <input type="text" id='numC1' class="form-control" placeholder="จำนวนตัวเลือก">
                                      </div>
                                      <div class="col-lg-4">
                                        <label>ข้อสอบเติมคำ</label>
                                        <input type="text" id='numProbD1' class="form-control" placeholder="จำนวนข้อสอบเติมคำ">
                                      </div>
                                  </div>
                                </div>

                                <div class="form-row-center">
                                  <button type="button" class="btn mb-3 btn-primary" id="addSection" onClick="addSection()">
                                    <i class="fa fa-plus" aria-hidden="true"></i>Add Section</button>
                                </div>
                            </div>
                            <button type="button" class="btn btn-primary btn-block" id="createBtn" onClick="createTagField()">Create</button>
                        </div>
                    </div>
                    <div class="iq-card">
                            <div class="iq-card-header d-flex justify-content-between">
                                <div class="iq-header-title">
                                    <h4 class="card-title">ใส่ Tags เพื่อกำหนด Template</h4>
                                </div>
                                Section: <a id="sectionshow">1</a> &nbsp; จำนวนข้อ: <a id="probnum"></a> <!-- &nbsp; Create Pressed: <a id="createPressed"></a> -->
                            </div>
                              <div class="card-body text-primary">
                                  <div id="tagPanel">
                                    <!-- for tags field input -->
                                  </div>
                                  <br>
                                  <div class="form-row-center">
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                       <button type="button" onclick="saveTemplate()" class="btn btn-primary">Save</button>
                                       {{-- <button type="button" class="btn btn-primary">Submit</button> --}}
                                       {{-- <button type="button" class="btn btn-primary">Cancel</button> --}}
                                       {{-- <button type="button" class="btn btn-primary">Delete</button> --}}
                                    </div>
                                  </div>
                              </div>
                        <datalist id="datalistOptions">
                        </datalist>
                      </div>
                    <div class="iq-card">
                        <div class="iq-card-header d-flex justify-content-between">
                            <div class="iq-header-title">
                                <h4 class="card-title">Exist Template Book</h4>
                            </div>
                        </div>
                        <div class="iq-card-body">
                            <div class="iq-card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered mt-4 yajra-datatable" role="grid" aria-describedby="user-list-page-info">
                                        <thead>
                                            <tr>
                                                <th style="width: 20px">No</th>
                                                <th>รายวิชา</th>
                                                <th>ชื่อข้อสอบ</th>
                                                <th>Section</th>
                                                <th>จำนวนข้อสอบตัวเลือก</th>
                                                <th>จำนวนข้อสอบเติมคำ</th>
                                                {{-- <th>Edit tag</th> --}}
                                                <th>View</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {{-- <tr>
                                                <td style="width: 20px">1</td>
                                                <td>คณิตศาสตร์</td>
                                                <td>PAT1</td>
                                                <td>03:00:00</td>
                                                <td>50</td>
                                                <td>10</td>
                                                <td><i class="ri-edit-line"></i></td>
                                                <td><a href="/viewprint"><i class="ri-eye-line"></i></a></td>
                                                <td>
                                                    <i class="ri-edit-line"></i>
                                                    <i class="ri-delete-bin-line"></i>
                                                </td>
                                           </tr> --}}
                                        </tbody>
                                    </table>
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
    <script type="text/javascript" src="{{ asset('/assets-custom/bookprint.js') }}"></script>
@endsection
