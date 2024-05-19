@extends('layouts.mainlayout')

@section('content')
<style>
    img {
       vertical-align: middle;
       border-style: none;
       max-width: 250px;
   }
    </style>
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

                      <input type="hidden" id="feId" value="{{$fixExam->fe_id}}" />

                      <div class="iq-card-body">
                          <div class="iq-card-body">
                              <div class="form-group row">
                                  <div class="col-lg-3">
                                      <label>รายวิชา</label>
                                      <input type="text" class="form-control" disabled value="{{$fixExam->sub_name}}">
                                  </div>
                                  <div class="col-lg-3">
                                      <label>ระดับชั้น</label>
                                      <input type="text" class="form-control" disabled value="{{$fixExam->g_name}}">
                                  </div>
                                  <div class="col-lg-3">
                                      <label>ชื่อข้อสอบ (บท)</label>
                                      <input type="text" class="form-control" disabled value="{{$fixExam->cate_name}}">
                                  </div>
                                  <div class="col-lg-3">
                                      <label>ชุดข้อสอบ</label>
                                      <input type="text" class="form-control" disabled value="{{$fixExam->chap_name}}">
                                  </div>
                              </div>
                              <div class="form-group row">
                                  <div class="col-9 align-content-center">
                                      <label class="float-right" for="price">
                                        ราคาข้อสอบ
                                      </label>
                                  </div>
                                  <div class="col-3">
                                      <div class="input-group">
                                          <input type="number" class="form-control text-right font-size-16 font-weight-bold float-right" id="price" aria-describedby="pricePrepend" value="{{$fixExam->fe_price}}">
                                          <div class="input-group-prepend">
                                              <span class="input-group-text" id="pricePrepend">บาท</span>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                              <div class="row">
                                  <div class="col-12">
                                      <button type="button" class="btn btn-primary btn-block" id="updateChapter">Save</button>
                                      @if(session("user")->role !='A')
                                      <button type="button" class="btn btn-primary btn-block" id="sendAppr">Send Approve</button>
                                      @endif
                                    </div>
                              </div>

                          </div>
                      </div>
                  </div>
              </div>

              <div class="col-lg-12">
                  <div class="iq-card">
                      <div class="iq-card-header d-flex justify-content-between">
                          <div class="iq-header-title">
                              <h4 class="card-title">รายการข้อสอบ</h4>
                          </div>
                          <div class="iq-card-header-toolbar d-flex align-items-center">
                              <a href="./{{$fixExam->fe_id}}/question" class="float-right mr-1 btn btn-sm btn-primary"><i class="fa fa-plus-circle"></i>Add Question</a>
                          </div>
                      </div>

                      <div class="iq-card-body">
                          <div class="table-responsive">
                              <table class="table table-striped table-bordered mt-4 yajra-datatable" role="grid" aria-describedby="user-list-page-info">
                                  <thead>
                                  <tr>
                                      <th style="width: 20px">No</th>
                                      <th>Question</th>
                                      <th style="width: 20px">Action</th>
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
 <script type="text/javascript" src="{{ asset('/assets-custom/test-fix-chap-edit.js') }}"></script>
@endsection


