@extends('layouts.mainlayout')
@section('content')
<script>
    $(document).ready(function() {
    // loadSubjects();
    loadMockNames();
    // autoTags();
    });
    function dotest(mid) {
        Swal.fire({
            title: 'โปรดอ่าน',
            html: '<p>ข้อสอบสามารถทำเกินเวลาที่กำหนดให้ได้ แต่ระบบจะคำนวณคะแนนให้เฉพาะข้อที่ทำเสร็จภายในเวลาที่กำหนด</p></br>' +
                '<p>(เพื่อจำลองบรรยากาศในการทำข้อสอบและฝึกบริหารเวลา)</p></br>',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ซื้อ และ เริ่มทำข้อสอบ',
            cancelButtonText: "ยกเลิก",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/std/chk/purchase',
                    type: 'post',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        'meId': mid,
                    },
                    cache: false,
                    success: function(response) {
                        if (response.status == 200) {
                            Swal.fire({
                                title: 'Success',
                                text: "Purchase Success",
                                icon: 'success',
                                width: '550px',
                                showConfirmButton: true,
                            })
                            setTimeout(function() {
                                swal.close();
                                $('#test-me-id').val(mid);
                                $('#do-test').submit();
                            }, 1500)
                        } else {
                            Swal.fire({
                                title: 'Error',
                                text: "Failed to purchase exam",
                                icon: 'error',
                                width: '550px',
                                showConfirmButton: true,
                                timer: 3000
                            })
                        }
                    }
                });
            }
        })
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
    function ajaxApi(url, callback){
    $.ajax({
        "url" : url,
        "type" : "GET",
        "dataType" : "json",
    }).done(callback); //END AJAX
    }
</script>
{{-- <script type="text/javascript" src="{{ asset('/assets-custom/test-mock.js') }}"></script> --}}

<div id="content-page" class="content-page">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="iq-card">
                    <div class="iq-card-header d-flex justify-content-between">
                        <div class="iq-header-title">
                            <h4 class="card-title">Mock Up Test</h4>
                        </div>
                    </div>
                    <div class="iq-card-body">
                        <div class="iq-card-body">
                            <form action="{{route('std.mocklist')}}" method="POST">
                                @csrf
                            <div class="form-group row">

                                <div class="col-lg-3">
                                    {{-- <label>รายวิชา</label> --}}
                                    <select  id="sel-mname" name="mockname" class="form-control form-control-sm mb-3">
                                        <option value="" selected="">เลือกชื่อข้อสอบ</option>
                                    </select>
                                </div>
                                <div class="col-lg-3">
                                    {{-- <label>ชื่อข้อสอบ (บท)</label> --}}
                                    {{-- <select id="sel-cate" name="cateId" class="form-control form-control-sm mb-3">
                                        <option selected="" value="">เลือกชื่อข้อสอบ (บท)</option>
                                    </select> --}}
                                </div>
                                <div class="col-lg-2">
                                    {{-- <label>ระดับชั้น</label>
                                    <select id="sel-grade" class="form-control form-control-sm mb-3">
                                        <option selected="">เลือกระดับชั้น</option>
                                    </select> --}}
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-row-center">
                                      <button type="submit" class="btn mb-3 btn-primary" id="search">
                                        <i class="fa fa-search" aria-hidden="true"></i>Search</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                @foreach ($libraly as $mock)
                <div class="iq-card">
                    <div class="iq-card-body">
                        <div class="form-group row">
                            <div class="col-lg-3">
                                <div class="profile-detail d-flex justify-content-center mt-3">
                                <h3 class="d-inline-block">{{ $mock->mx_name }}</h3>
                                {{-- <p class="d-inline-block pl-1">- {{ $fix->cate_name }}</p> --}}
                            </div>
                            </div>
                            <div class="col-lg-9">
                                <div class="iq-card">
                                    <div class="iq-card-header d-flex justify-content-between">
                                        <div class="iq-header-title">
                                            <h4 class="card-title">{{ $mock->choice_total }} Multiple Choice, {{ $mock->tags }} Subjective</h4>
                                        </div>
                                        {{-- <div class="iq-card-header-toolbar d-flex align-items-center">
                                            <a href="#" class="float-right mr-1 btn btn-sm btn-primary">Start</a>
                                        </div> --}}
                                    </div>
                                    <div class="iq-card-body">
                                        <div class="row">
                                            <div class="col-lg-9">
                                                <div class="row">
                                                    <div class="col-lg-3">
                                                        <div class="profile-detail mt-3">
                                                            <p class="d-inline-block">Max Score</p>
                                                            <p class="d-inline-block pl-1">: {{ $mock->max_all }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="profile-detail mt-3">
                                                            <p class="d-inline-block">Min Score</p>
                                                            <p class="d-inline-block pl-1">: {{ $mock->min_all }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="profile-detail mt-3">
                                                            <p class="d-inline-block">Your Best Time</p>
                                                            <p class="d-inline-block pl-1">: {{ $mock->best_time }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-3">
                                                        <div class="profile-detail mt-3">
                                                            <p class="d-inline-block">Mean</p>
                                                            <p class="d-inline-block pl-1">: {{ $mock->mean }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="profile-detail mt-3">
                                                            <p class="d-inline-block">STD</p>
                                                            <p class="d-inline-block pl-1">: {{ $mock->std_point }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="profile-detail mt-3">
                                                            <p class="d-inline-block">Your Best Score</p>
                                                            <p class="d-inline-block pl-1">: {{ $mock->max }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2">

                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-3">
                                                        <div class="profile-detail mt-3">
                                                            <p class="d-inline-block">Mean Time</p>
                                                            <p class="d-inline-block pl-1">: {{ $mock->avg_time_all }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="profile-detail mt-3">
                                                            <p class="d-inline-block">Popularity</p>
                                                            <p class="d-inline-block pl-1">: {{ $mock->do_all }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="profile-detail mt-3">
                                                            <p class="d-inline-block">Done</p>
                                                            <p class="d-inline-block pl-1">: {{ $mock->done }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="iq-card-header-toolbar d-flex align-items-center">
                                                    <a href="javascript:dotest({{ $mock->me_id }});" class="float-right mr-1 btn btn-sm btn-primary">Start</a>
                                                </div>
                                                <div class="profile-detail mt-3">
                                                    <h3>{{ $mock->me_price }} </h3>
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
                @endforeach
            </div>
            <div class="d-flex justify-content-center mt-3">
                {{-- {!! $libraly->links()!!} --}}
             </div>
             <div style="display: none;">
                 <form id="do-test" action="{{ route('std.mtest') }}" method="POST">
                    @csrf
                    <input type="hidden" id="test-me-id" name="test-me-id">
                 </form>
             </div>
        </div>
    </div>
</div>
@endsection
