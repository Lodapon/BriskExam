@extends('layouts.mainlayout')

@section('content')
 <!-- Wrapper Start -->
 <div class="wrapper">
    <!-- Page Content  -->
    <div id="content-page" class="content-page">
       <div class="container-fluid">
          <div class="row">

            <input type="hidden" id="feDetId" value="{{$question->fe_det_id ?? ""}}" />

            <div class="col-lg-12">
                  <div class="iq-card">
                      <div class="iq-card-header d-flex justify-content-between">
                          <div class="iq-header-title">
                              <h4 class="card-title">สร้างข้อสอบ</h4>
                          </div>
                      </div>
                      <div class="iq-card-body">
                          <div class="iq-card-body">
                              <div class="form-group row">
                                  <div class="col-12">
                                      <label for="questionText">Your Problem</label>
                                      <textarea class="form-control" id="questionText" rows="5" >{{$question->fe_que ?? ""}}</textarea>
                                  </div>
                              </div>

                              <div class="form-group row">
                                  <div class="col-10"></div>
                                  <div class="col-2">
                                      <input type="hidden" id="levelValue" value="{{$question->lv_id ?? ""}}" />
                                      <select id="difficultLevel" class="form-control form-control-sm">
                                          <option selected="" value="">เลือกระดับความยาก</option>
                                          {{-- <option value="1">One</option>
                                          <option value="2">Two</option>
                                          <option value="3">Three</option> --}}
                                      </select>
                                  </div>
                              </div>

                              <div class="form-group row">
                                  <div class="col-12">
                                      <div class="list-group">
                                          <div id="answers-container">
                                              <input type="hidden" id="correctChoice" value="{{$question->fe_no_ans ?? ""}}"/>
                                              @include('test-fix.test-fix-answer')
                                          </div>

                                          <li class="list-group-item">
                                              <div class="form-group row">
                                                  <div class="col-12">
                                                      <button type="button" class="btn btn-outline-success rounded-pill mb-3" id="addAnswer">เพิ่มตัวเลือก</button>
                                                  </div>
                                              </div>
                                          </li>
                                      </div>
                                  </div>
                              </div>

                              <div class="form-group row">
                                  <div class="col-12">
                                      <label for="tags">Tags</label>
                                      <input type="text" class="form-control" id="tags" data-role="tagsinput" value="{{$question->fe_tags ?? ""}}"/>
                                  </div>
                              </div>

                              <div class="form-group row">
                                  <div class="col-12">
                                      <label for="solutionText">Your Solution</label>
                                      <textarea class="form-control" id="solutionText" rows="5">{{$question->fe_soln ?? ""}}</textarea>
                                  </div>
                              </div>
                              <div class="form-group row mt-5">
                                  <div class="col-12 ">
                                      <button type="submit" id="saveQA" class="btn btn-primary float-right">Save</button>
                                  </div>
                              </div>
                          </div>
                          <button type="button" class="btn btn-outline-success rounded-pill mb-3 fixed-bottom" style="margin-left: 30px;width: 100px;" id="testClear">clear text</button>
                      </div>
                  </div>
              </div>
          </div>
       </div>
    </div>
 </div>
 <!-- Wrapper END -->
 <script type="text/javascript" src="{{ asset('/assets-custom/test-fix-question.js') }}"></script>
@endsection
