@extends('layouts.mainlayout')

@section('content')
 <!-- Wrapper Start -->
 <div class="">
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
                    <div class="iq-card-body">
                        <div class="iq-card-body">
                            <form class="mr-3 position-relative">
                            <div class="form-group row">
                                <div class="col-lg-3">
                                    <label>รายวิชา</label>
                                    <select id="sel-subject" name="subject" class="form-control form-control-sm mb-3" onchange="loadCategories()">
                                    <option value="" selected="">เลือกรายวิชา</option>
                                    </select>
                                </div>
                                <div class="col-lg-3">
                                    <label>ระดับชั้น</label>
                                    <select id="sel-grade" name="grade" class="form-control form-control-sm mb-3">
                                        <option value="" selected="">เลือกระดับชั้น</option>
                                    </select>
                                </div>
                                <div class="col-lg-3">
                                    <label>ชื่อข้อสอบ (บท)</label>
                                    <select id="sel-cate" name="cate" class="form-control form-control-sm mb-3">
                                        <option value=""  selected="">เลือกชื่อข้อสอบ (บท)</option>
                                    </select>
                                </div>
                                <div class="col-lg-3">
                                    <label>ชุดข้อสอบ</label>
                                    <select id="sel-chap" name="chap" class="form-control form-control-sm mb-3">
                                        <option value="" selected="">เลือกชุดข้อสอบ</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-12 d-flex justify-content-center">
                                        <a href="javascript:loadTables();" class="float-center mr-1 btn btn-sm btn-primary"><i class="fa fa-search"></i>Search</a>
                                </div>
                             </div>
                          </form>
                        </div>
                    </div>
                </div>
            </div>

          <div class="col-sm-12">
                <div class="iq-card">
                   <div class="iq-card-header d-flex justify-content-between">
                      <div class="iq-header-title">
                         <h4 class="card-title">Fix Exam</h4>
                      </div>
                      <div class="iq-card-header-toolbar d-flex align-items-center">
                        <a href="{{route('fix.add')}}" class="float-right mr-1 btn btn-sm btn-primary"><i class="fa fa-plus-circle"></i>Add Exam</a>
                      </div>
                   </div>
                   <div class="iq-card-body">
                      <div class="table-responsive">
                         <table class="table table-striped table-bordered mt-4 yajra-datatable" role="grid" aria-describedby="user-list-page-info">
                           <thead>
                               <tr>
                                  <th style="width: 20px">No</th>
                                  <th>Subject</th>
                                  <th>Grade</th>
                                  <th>Category</th>
                                  <th>Chapter</th>
                                  <th>Created Date</th>
                                  <th style="width: 20px"></th>
                               </tr>
                           </thead>
                           <tbody>
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
<!-- Wrapper END -->
<script type="text/javascript" src="{{ asset('/assets-custom/test-fix.js') }}"></script>
@endsection
