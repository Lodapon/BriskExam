@extends('layouts.mainlayout')
@section('content')
<script>
    function showSol(){
        $('#sol').show();
    }
</script>
<style>
    p {display:inline;}
</style>
<!-- Page Content  -->
<div id="content-page" class="content-page">
    <div class="container-fluid">
       <div class="row">
          <div class="col-sm-12">
                <div class="iq-card">
                   <div class="iq-card-header d-flex justify-content-center">
                      <div class="iq-header-title">
                         <h4 class="card-title">สิ้นสุดการทำข้อสอบ</h4>
                      </div>
                   </div>
                   <div class="iq-card-body" style="text-align: center;">
                    <div><label>{{$exname}}</label></div>
                    <div><label>ทำเป็นครั้งที่ : {{$doTotal}}</label></div>
                    <div><label>เวลาที่ใช้ : {{$timediff}}</label></div>
                    <div><label>คะแนนที่ได้ : {{$pointTotal}}/{{$total}} คะแนน คิดเป็น {{$percent}} %</label></div>
                    <div><label>จุดที่ต้องพัฒนา : {{$tags}}
                    </label></div>
                    <div><label>คะแนนเฉลี่ยของผู้เข้าสอบทุกคน : {{$allpTotal}} คะแนน
                    โดยมีคะแนนสูงสุด : {{$max}} คะแนน คะแนนต่ำสุด : {{$min}} คะแนน</label></div>
                    <div><label>ส่วนเบี่ยงเบน : {{$std->std_point}} เวลาในการทำข้อสอบเฉลี่ยของผู้เข้าสอบทุกคน : {{$avgtimediff}} </label></div>
                    <div><label>จำนวนผู้ทำข้อสอบ : {{$utotal->c_user}} </label></div>
                    <div><button type="button" id="result" class="btn btn-primary next action-button float-center" value="result" onclick="showSol()" >ดูเฉลย</button></div>
                   </div>
                </div>
                <div id="sol" style="display: none">
                    @foreach($test as $mock => $exam)
                    <div class="iq-card">
                        <div class="iq-card-header d-flex">
                           <div class="iq-header-title">
                              <h5 class="card-title">{{ $loop->iteration }}) {!!$mock!!}</h5>
                           </div>
                        </div>
                        <div class="iq-card-body">

                                <div class="row">
                                    <div class="col-7">
                                        <h3 class="mb-4"></h3>
                                    </div>
                                </div>
                                @foreach($exam as $ans)
                                    {{-- <div class="row"> --}}
                                        <div class="col-md-12">
                                                @if($ans->me_no_ans == $ans->me_ans_no)
                                                    <div class="row alert alert-success">{{ $loop->iteration }}) {!! $ans->me_ans !!}</div>
                                                @else
                                                    <div class="row alert"> <label>{{ $loop->iteration }}) {!! $ans->me_ans !!}</label></div>
                                                @endif
                                        </div>
                                        @if ($loop->last)
                                        <div class="col-md-12"><div class="row"><label> ตอบเพราะ   {!! $ans->me_soln !!}</label></div></div>
                                        @endif
                                    {{-- </div> --}}
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
