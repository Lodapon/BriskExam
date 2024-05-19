@extends('layouts.mainlayout')

@section('content')
<script type="text/javascript" src="{{ asset('/assets-custom/test-mock.js') }}"></script>
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
                              <h4 class="card-title">Input ข้อสอบ Mockup</h4>
                          </div>
                      </div>
                      <div class="iq-card-body">
                          <div class="iq-card-body">
                              <div class="form-group row">
                                  <div class="col-12">
                                      <label for="questionText">Your Problem</label>
                                      <textarea class="form-control" id="questionText" rows="5"></textarea>
                                  </div>
                              </div>

                              <div class="form-group row">
                                  <div class="col-10">
                                    {{-- <div class="iq-card-body"> --}}
                                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                           <li class="nav-item">
                                              <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Optional exam</a>
                                           </li>
                                           <li class="nav-item">
                                              <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Written exam</a>
                                           </li>
                                        </ul>

                                     {{-- </div> --}}
                                  </div>
                                  <div class="col-2">
                                  </div>
                              </div>
                              <div class="tab-content" id="pills-tabContent-2">
                                <div class="tab-pane fade active show" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                                    <div class="form-group row">
                                        <div class="col-12">
                                            <div class="list-group">
                                                <div id="answers-container">
                                                    @include('test-mock.test-mock-answer')
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
                                            <input type="text" class="form-control" data-role="tagsinput" id="tags" />
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-12">
                                            <label for="solutionText">Your Solution</label>
                                            <textarea class="form-control" id="solutionText" rows="5"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row mt-5">
                                        <div class="col-12 ">
                                            <button type="submit" id="saveMock" class="btn btn-primary float-right">Add</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">

                                    <div class="form-group row">
                                        <div class="col-12">
                                            <label for="ansW">Answer</label>
                                            <input type="text" class="form-control" id="ansW" />
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-12">
                                            <label for="tags">Tags</label>
                                            <input type="text" class="form-control" data-role="tagsinput" id="tagW" />
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-12">
                                            <label for="solutionTextW">Your Solution</label>
                                            <textarea class="form-control" id="solutionTextW" rows="5"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row mt-5">
                                        <div class="col-12 ">
                                            <button type="submit" id="saveMockW" class="btn btn-primary float-right">Add</button>
                                        </div>
                                    </div>
                                </div>
                             </div>
                             <button type="button" class="btn btn-outline-success rounded-pill mb-3 fixed-bottom" style="margin-left: 30px;width: 100px;" id="testClear">clear text</button>
                          </div>
                      </div>
                  </div>
              </div>

              {{-- <div class="col-lg-12">
                  <div class="iq-card">
                      <div class="iq-card-header d-flex justify-content-between">
                          <div class="iq-header-title">
                              <h4 class="card-title">รายการข้อสอบ</h4>
                          </div>
                      </div>

                      <div class="iq-card-body">
                          @include('test-mock.test-mock-table')
                      </div>

{{--                      <div class="iq-card-body">--}}
{{--                          <div class="table-responsive">--}}
{{--                              <table class="table table-striped table-bordered mt-4 yajra-datatable" role="grid" aria-describedby="user-list-page-info">--}}
{{--                                  <thead>--}}
{{--                                  <tr>--}}
{{--                                      <th>No</th>--}}
{{--                                      <th>Question</th>--}}
{{--                                  </tr>--}}
{{--                                  </thead>--}}
{{--                                  <tbody>--}}
{{--                                  </tbody>--}}
{{--                              </table>--}}
{{--                          </div>--}}
{{--                      </div>-}}
                  </div>
              </div> --}}


          </div>
       </div>
    </div>
 </div>
 <!-- Wrapper END -->
@endsection
