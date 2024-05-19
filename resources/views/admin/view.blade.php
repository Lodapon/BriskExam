@extends('layouts.mainlayout')

@section('content')
<script>
    function goBack() {
        window.history.back();
    }
</script>
<div id="content-page" class="content-page">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
            </div>
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-lg-3 profile-left">
                        <div class="iq-card">
                            <div class="iq-card-header d-flex justify-content-between">
                                <div class="iq-header-title">
                                <h4 class="card-title">Profile</h4>
                                </div>
                            </div>
                            <div class="iq-card-body">
                                {{-- <div class="row"> --}}
                                    <div class="col-md-12">
                                        <div class="user-detail">
                                            <div class="user-profile">
                                                <img src="{{'data:'.$userdata->profile_img_type.';base64,'.base64_encode( $userdata->profile_img )}}" alt="profile-img" class="avatar-130 img-fluid">
                                            </div>
                                            <div class="profile-detail mt-3">
                                                <h3 class="d-inline-block">{{ $userdata->username }}</h3>
                                                <p class="d-inline-block pl-1">- {{ $userdata->role_name }}</p>
                                            </div>
                                        </div>
                                    </div>
                                {{-- </div> --}}
                                 <!-- <ul class="m-0 p-0">
                                   <li class="d-flex mb-2">
                                        <div class="news-icon"><i class="ri-calendar-2-line"></i></div>
                                        <p class="news-detail mb-0">there is a meetup in your city on fryday at 19:00. <a href="#">see details</a></p>
                                    </li>
                                    <li class="d-flex">
                                        <div class="news-icon mb-0"><i class="ri-calendar-2-line"></i></div>
                                        <p class="news-detail mb-0">20% off coupon on selected items at pharmaprix </p>
                                    </li> -->

                                    {{-- @if( isset($userdata->appointment) && count($userdata->appointment) > 0)
                                        @foreach($userdata->appointment as $appointment)
                                            <li class="d-flex">
                                                <div class="news-icon mb-0" ><i class="ri-calendar-2-line" ></i></div>
                                                <p class="news-detail mb-0 mt-1"> {{ optional($appointment->service)->name }} ({{ date('d-M-Y',strtotime($appointment->date)) }} ) </p>
                                            </li>
                                        @endforeach
                                    @else --}}
                                    {{-- <li class="d-flex">
                                        <h6 class="news-detail mb-0">{{ trans('messages.no_record',['form' => trans('messages.appointment')]) }} </h6>
                                    </li>
                                    @endif
                                </ul>--}}
                            </div> 
                        </div>
                    </div>
                    <div class="col-lg-9 profile-center">
                        {{-- <div class="iq-card">
                            <div class="iq-card-header d-flex justify-content-between">
                                <div class="iq-header-title">
                                    <h4 class="card-title">Profile</h4>
                                </div>
                            </div>
                            <div class="iq-card-body">
                                <div class="user-detail text-center">
                                    <div class="user-profile">
                                        <img src="{{'data:'.$userdata->profile_img_type.';base64,'.base64_encode( $userdata->profile_img )}}" alt="profile-img" class="avatar-130 img-fluid">
                                    </div>
                                    <div class="profile-detail mt-3">
                                        <h3 class="d-inline-block">{{ $userdata->username }}</h3>
                                        <p class="d-inline-block pl-3"> - {{ $userdata->role_name }}</p>
                                        
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                        <div class="iq-card">
                            <div class="iq-card-header d-flex justify-content-between">
                                <div class="iq-header-title">
                                    <h4 class="card-title">About User</h4>
                                </div>
                                <div class="iq-card-header-toolbar d-flex align-items-center">
                                    <a href="javascript:goBack()" class="float-right mr-1 btn btn-sm btn-primary"><i class="ri-arrow-drop-left-line"></i>Back</a> 
                                </div>
                            </div>
                            <div class="iq-card-body">
                                <div class="row">
                                    <div class="col-md-9">

                                        <div class="mt-2">
                                            <h6>Name :</h6>
                                            <p>{{ $userdata->first_name }} {{ $userdata->last_name }}</p>
                                        </div>

                                        <div class="mt-2">
                                            <h6>Email :</h6>
                                            <p>{{ $userdata->email }}</p>
                                        </div>
                                        
                                        

                                        <div class="mt-2">
                                            <h6>Birth date :</h6>
                                            <p class="text-capitalize"> {{ \Carbon\Carbon::parse($userdata->birth_date)->format('d/m/Y')}}</p>
                                        </div>

                                        <div class="mt-2">
                                            <h6>Address :</h6>
                                            <p> {{ $userdata->address }}</p>
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
</div>
@endsection
