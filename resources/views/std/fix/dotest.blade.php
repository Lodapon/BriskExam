@extends('layouts.mainlayout')
@section('content')
<script type="text/javascript" src="{{ asset('/assets-custom/test-fix.js') }}"></script>
<div id="content-page" class="content-page">
    <div class="container-fluid">
        <div class="row">
            <!--div class="col-sm-12">
                <div class="iq-card">
                    <div class="iq-card-body">
                        <div class="form-group row">
                            <div class="col-lg-3">
                                <div class="profile-detail d-flex justify-content-center mt-3">
                                <h3 class="d-inline-block">{ $fix->sub_name }}</h3>
                                <p class="d-inline-block pl-1">- { $fix->cate_name }}</p>
                            </div>
                            </div>
                            <div class="col-lg-9">
                                <div class="iq-card">
                                    <div class="iq-card-header d-flex justify-content-between">
                                        <div class="iq-header-title">
                                            <h4 class="card-title">60 Multiple Choice, 20 Subjective</h4>
                                        </div>
                                    </div>
                                    <div class="iq-card-body">
                                        <div class="row">
                                            <div class="col-lg-9">
                                                <div class="row">
                                                    <div class="col-lg-3">
                                                        <div class="profile-detail mt-3">
                                                            <p class="d-inline-block">Max Score</p>
                                                            <p class="d-inline-block pl-1">: 96</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="profile-detail mt-3">
                                                            <p class="d-inline-block">Min Score</p>
                                                            <p class="d-inline-block pl-1">: 96</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="profile-detail mt-3">
                                                            <p class="d-inline-block">Your Best Time</p>
                                                            <p class="d-inline-block pl-1">: 02:33:11</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-3">
                                                        <div class="profile-detail mt-3">
                                                            <p class="d-inline-block">Mean</p>
                                                            <p class="d-inline-block pl-1">: 96</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="profile-detail mt-3">
                                                            <p class="d-inline-block">STD</p>
                                                            <p class="d-inline-block pl-1">: 12.5</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="profile-detail mt-3">
                                                            <p class="d-inline-block">Your Best Score</p>
                                                            <p class="d-inline-block pl-1">: 80</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-3">
                                                        <div class="profile-detail mt-3">
                                                            <p class="d-inline-block">Mean Time</p>
                                                            <p class="d-inline-block pl-1">: 96</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="profile-detail mt-3">
                                                            <p class="d-inline-block">Popularity</p>
                                                            <p class="d-inline-block pl-1">: 12.5</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="profile-detail mt-3">
                                                            <p class="d-inline-block">Done</p>
                                                            <p class="d-inline-block pl-1">: 0</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="iq-card-header-toolbar d-flex align-items-center">
                                                    <a href="javascript:dotest({ $fix->fe_id }});" class="float-right mr-1 btn btn-sm btn-primary">Start</a> 
                                                </div>
                                                <div class="profile-detail mt-3">
                                                    <h3>50 </h3>
                                                    <p class="d-inline-block pl-1">THB</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div-->
            <div class="col-sm-12">
                <div class="row">
                    @foreach($test as $fix => $exam)
                    <div class="col-lg-12 profile-center">
                        <div class="iq-card">
                            <div class="iq-card-header d-flex justify-content-between">
                                <div class="iq-header-title">
                                    <h4 class="card-title">{{ $loop->iteration }} {!!$fix!!}</h4>
                                   
                                </div>
                                {{-- <div class="iq-card-header-toolbar d-flex align-items-center">
                                    <a href="#" class="float-right mr-1 btn btn-sm btn-primary"><i class="fa fa-pencil-square-o"></i>Update</a> 
                                </div> --}}
                            </div>
                            @foreach($exam as $ans)
                            <div class="iq-card-body">
                                <div class="row">
                                    <div class="col-md-9">

                                        <div class="mt-2">
                                             <h6>{{ $loop->iteration }}</h6><p id="{{$ans->fe_ans_no}}">{!! $ans->fe_ans !!}</p>
                                        </div>

                                
                                    </div>
                                    
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
