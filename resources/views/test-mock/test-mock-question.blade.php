@extends('layouts.mainlayout')

@section('content')
 <!-- Wrapper Start -->
 <div class="wrapper">
    <!-- Page Content  -->
    <div id="content-page" class="content-page">
       <div class="container-fluid">
          <div class="row">

            <input type="hidden" id="meDetId" value="{{$question->me_det_id ?? ""}}" />

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
                                      <textarea class="form-control" id="questionText" rows="5" >{{$question->me_que ?? ""}}</textarea>
                                  </div>
                              </div>

                              <div class="form-group row">
                                  <div class="col-12"></div>
                              </div>

                              <div class="form-group row">
                                  <div class="col-12">
                                      <div class="list-group">
                                          <div id="answers-container">
                                              <input type="hidden" id="correctChoice" value="{{$question->me_no_ans ?? ""}}"/>
                                                @if($question->me_type =='C')
                                                    @include('test-mock.test-mock-answer')
                                                @else
                                                <div class="form-group row">
                                                    <div class="col-12">
                                                        <label for="ansW">Answer</label>
                                                        <input type="text" class="form-control" id="ansW" value="{{$answers[0]->me_ans ?? ""}}" />
                                                    </div>
                                                </div>
                                                @endif
                                          </div>
                                          @if($question->me_type =='C')
                                          <li class="list-group-item">
                                              <div class="form-group row">
                                                  <div class="col-12">
                                                      <button type="button" class="btn btn-outline-success rounded-pill mb-3" id="addAnswer">เพิ่มตัวเลือก</button>
                                                  </div>
                                              </div>
                                          </li>
                                          @endif
                                      </div>
                                  </div>
                              </div>

                              <div class="form-group row">
                                  <div class="col-12">
                                      <label for="tags">Tags</label>
                                      <input type="text" class="form-control" id="tags" data-role="tagsinput" value="{{$question->me_tags ?? ""}}"/>
                                  </div>
                              </div>

                              <div class="form-group row">
                                  <div class="col-12">
                                      <label for="solutionText">Your Solution</label>
                                      <textarea class="form-control" id="solutionText" rows="5">{{$question->me_soln ?? ""}}</textarea>
                                  </div>
                              </div>
                              <div class="form-group row mt-5">
                                  <div class="col-12 ">
                                      <button type="submit"
                                      @if($question->me_type =='C') id="saveQA"
                                      @else id="saveMockW"
                                      @endif class="btn btn-primary float-right">Save</button>
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
 <script type="text/javascript" src="{{ asset('/assets-custom/test-mock-question.js') }}"></script>
@endsection
