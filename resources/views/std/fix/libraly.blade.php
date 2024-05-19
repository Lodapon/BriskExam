@extends('layouts.mainlayout')
@section('content')
<script type="text/javascript" src="{{ asset('/assets-custom/test-fix.js') }}"></script>
<script>
    function dotest(fid) {
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
                        'feId': fid,
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
                                $('#test-fe-id').val(fid);
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
</script>
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
                            <form action="{{route('std.fixlist')}}" method="POST">
                                @csrf
                            <div class="form-group row">

                                <div class="col-lg-3">
                                    <label>รายวิชา</label>
                                    <select id="sel-subject" name="subId" class="form-control form-control-sm mb-3" onchange="loadCategories()">
                                       <option selected="" value="">เลือกรายวิชา</option>
                                    </select>
                                </div>
                                <div class="col-lg-3">
                                    <label>ชื่อข้อสอบ (บท)</label>
                                    <select id="sel-cate" name="cateId" class="form-control form-control-sm mb-3">
                                        <option selected="" value="">เลือกชื่อข้อสอบ (บท)</option>
                                    </select>
                                </div>
                                <div class="col-lg-2">
                                    <label>ผู้พิมพ์ข้อสอบ</label>
                                    <input type="text" class="form-control mb-0" id="creator" name="creator" placeholder="Enter Creator Name">
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-row-center">
                                    <label>ค้นหา</label>
                                    </div>
                                    <div class="form-row-center">
                                      
                                      <button type="submit" class="btn mb-3 btn-primary" id="addSubject">
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
                @foreach ($libraly as $fix)
                <div class="iq-card">
                    <div class="iq-card-body">
                        <div class="form-group row">
                            <div class="col-lg-3">
                                <div class="profile-detail d-flex justify-content-center mt-3">
                                <h4 class="d-inline-block">{{ $fix->ex_name }}</h4>
                                <p class="d-inline-block pl-1">- {{ $fix->created_name }}</p>
                            </div>
                            </div>
                            <div class="col-lg-9">
                                <div class="iq-card">
                                    <div class="iq-card-header d-flex justify-content-between">
                                        <div class="iq-header-title">
                                            <h4 class="card-title">{{ $fix->choice_total }} Multiple Choice, {{ $fix->tags }} Subjective</h4>
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
                                                            <p class="d-inline-block pl-1">: {{ $fix->max_all }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="profile-detail mt-3">
                                                            <p class="d-inline-block">Min Score</p>
                                                            <p class="d-inline-block pl-1">: {{ $fix->min_all }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="profile-detail mt-3">
                                                            <p class="d-inline-block">Your Best Time</p>
                                                            <p class="d-inline-block pl-1">: {{ $fix->best_time }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-3">
                                                        <div class="profile-detail mt-3">
                                                            <p class="d-inline-block">Mean</p>
                                                            <p class="d-inline-block pl-1">: {{ $fix->mean }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="profile-detail mt-3">
                                                            <p class="d-inline-block">STD</p>
                                                            <p class="d-inline-block pl-1">: {{ $fix->std_point }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="profile-detail mt-3">
                                                            <p class="d-inline-block">Your Best Score</p>
                                                            <p class="d-inline-block pl-1">: {{ $fix->max }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2">

                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-3">
                                                        <div class="profile-detail mt-3">
                                                            <p class="d-inline-block">Mean Time</p>
                                                            <p class="d-inline-block pl-1">: {{ $fix->avg_time_all }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="profile-detail mt-3">
                                                            <p class="d-inline-block">Popularity</p>
                                                            <p class="d-inline-block pl-1">: {{ $fix->do_all }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="profile-detail mt-3">
                                                            <p class="d-inline-block">Done</p>
                                                            <p class="d-inline-block pl-1">: {{ $fix->done }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="iq-card-header-toolbar d-flex align-items-center">
                                                    <a href="javascript:dotest({{ $fix->fe_id }});" class="float-right mr-1 btn btn-sm btn-primary">Start</a>
                                                </div>
                                                <div class="profile-detail mt-3">
                                                    <h3>{{ $fix->fe_price }} </h3>
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
                 <form id="do-test" action="{{ route('std.test') }}" method="POST">
                    @csrf
                    <input type="hidden" id="test-fe-id" name="test-fe-id">
                 </form>
             </div>
        </div>
    </div>
</div>
@endsection
