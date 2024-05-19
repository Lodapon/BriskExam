@extends('layouts.mainlayout')
@section('content')
<script>
    // var time = 'time';
    // time = time.split(':');
    // var countDownDate = new Date();
    // countDownDate.setHours( countDownDate.getHours() + parseInt(time[0]) );
    // countDownDate.setMinutes ( countDownDate.getMinutes() + parseInt(time[1]) );
    // countDownTime = countDownDate.getTime();

    // var x = setInterval(function() {

    //     // Get today's date and time
    //     var now = new Date().getTime();

    //     // Find the distance between now and the count down date
    //     var distance = countDownTime - now;

    //     // Time calculations for days, hours, minutes and seconds
    //     var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    //     var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    //     var seconds = Math.floor((distance % (1000 * 60)) / 1000);
    //     if(hours < 10)
    //     hours = "0"+hours;
    //     if(minutes < 10)
    //     minutes = "0"+minutes;
    //     if(seconds < 10)
    //     seconds = "0"+seconds;
    //     // Display the result in the element with id="demo"
    //     document.getElementById("time").innerHTML = hours + ":"+ minutes + ":" + seconds;

    //     // If the count down is finished, write some text
    //     if (distance < 0) {
    //     clearInterval(x);
    //     document.getElementById("time").innerHTML = "Time Up!!";
    //     }
    // }, 1000);

    // var sec = 0;
    // function pad ( val ) { return val > 9 ? val : "0" + val; }
    // var y = setInterval( function(){
    //     $("#seconds").html(pad(++sec%60));
    //     $("#minutes").html(pad(parseInt(sec/60,10)));
    // }, 1000);
    var timerVar = setInterval(countTimer, 1000);
    var totalSeconds = '{{$time}}';
    function countTimer() {
            ++totalSeconds;
            var hour = Math.floor(totalSeconds /3600);
            var minute = Math.floor((totalSeconds - hour*3600)/60);
            var seconds = totalSeconds - (hour*3600 + minute*60);
            if(hour < 10)
                hour = "0"+hour;
            if(minute < 10)
                minute = "0"+minute;
            if(seconds < 10)
                seconds = "0"+seconds;
                document.getElementById("time").innerHTML = hour + ":"+ minute + ":" + seconds;
            }
    function stopTime() {
        clearInterval(timerVar);
        $('#btn-pause').hide();
        // clearInterval(y);
    }
    function finishTest() {
        var jsonObj = [];
        $(':radio:checked').each(function(){
            var res = $(this).val().split("_");
            var ans = {};
            ans ["fe_det_id"] = res[0];
            ans ["fe_ans_no"] = res[1];
        jsonObj.push(ans);
        });
        // alert(jsonObj)
        $("#fixexamAns").val(JSON.stringify(jsonObj));
        $("#fixtime").val( $("#time").text());
        $("#form-wizard1" ).submit();

    }
    function pauseTest() {
        Swal.fire({
            title: 'Are you sure?',
            // text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Pause!',
            allowOutsideClick: false
            }).then((result) => {
            if (result.isConfirmed) {
                stopTime();
                var jsonObj = [];
                $(':radio:checked').each(function(){
                    var res = $(this).val().split("_");
                    var ans = {};
                    ans ["fe_det_id"] = res[0];
                    ans ["fe_ans_no"] = res[1];
                jsonObj.push(ans);
                });
                // alert(jsonObj)
                $("#fixexamAns").val(JSON.stringify(jsonObj));
                $("#fixtime").val( $("#time").text());
                $('#form-wizard1').attr('action', '{{route('std.pause')}}');
                $("#form-wizard1" ).submit();
            }
        })
    }
</script>
<script type="text/javascript" src="{{ asset('/assets-custom/test-fix.js') }}"></script>
<style>.star-rating {
    line-height:32px;
    font-size:1.25em;
}

.star-rating .fa-star{color: orange;}</style>
<div id="content-page" class="content-page">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-lg-12">
                <div class="iq-card">
                    <div class="iq-card-header d-flex justify-content-between">
                        <div class="iq-header-title">
                            <h4 class="card-title">{{$exname}}</h4>
                        </div>
                        <div class="iq-card-header-toolbar d-flex align-items-center">
                            {{-- <p id="minutes"></+p>:<p id="seconds"></p><p>/</p> --}}
                                <p id="time" class="card-title">00:00:00</p>
                        </div>
                    </div>
                    <div class="iq-card-body">
                        <form id="form-wizard1" class="text-center mt-4" action="{{route('std.finish')}}" method="post">
                            @csrf
                            <input id="fixexamAns" name="fixexamAns" type="hidden" value="">
                            <input id="fixtime" name="fixtime" type="hidden" value="">
                            <input id="feId" name="feId" type="hidden" value="{{$feId}}">
                            {{-- <ul id="top-tab-list" class="p-0">
                                <li class="active" id="account">
                                    <a href="javascript:void();">
                                    <i class="ri-lock-unlock-line"></i><span>Account</span>
                                    </a>
                                </li>
                                <li id="personal">
                                    <a href="javascript:void();">
                                    <i class="ri-user-fill"></i><span>Personal</span>
                                    </a>
                                </li>
                                <li id="payment">
                                    <a href="javascript:void();">
                                    <i class="ri-camera-fill"></i><span>Image</span>
                                    </a>
                                </li>
                                <li id="confirm">
                                    <a href="javascript:void();">
                                    <i class="ri-check-fill"></i><span>Finish</span>
                                    </a>
                                </li>
                            </ul> --}}
                            <!-- fieldsets -->
                        @foreach($test as $fix => $exam)
                            <fieldset>
                                <div class="form-card text-left">
                                    <div class="row">
                                        <div class="col-7">
                                            <h3 class="mb-4">{{ $loop->iteration }}) {!!$fix!!}</h3>
                                        </div>
                                        <div class="col-5">
                                            <h2 class="steps">ข้อ {{ $loop->iteration }} - {{$total}}</h2>
                                        </div>
                                    </div>
                                    @foreach($exam as $ans)
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" class="custom-control-input" id="{{ $ans->fe_det_id }}_{{ $ans->fe_ans_no }}" name="answer{{$ans->fe_det_id}}"
                                                        @foreach($anws as $item)
                                                            @if($item->fe_det_id == $ans->fe_det_id)
                                                                @if($item->fe_ans_no == $ans->fe_ans_no)
                                                                checked
                                                                @endif
                                                            @endif
                                                        @endforeach
                                                        value="{{ $ans->fe_det_id }}_{{ $ans->fe_ans_no }}"/>
                                                        <label class="custom-control-label" for="{{ $ans->fe_det_id }}_{{ $ans->fe_ans_no }}">{!! $ans->fe_ans !!}</label>
                                                    </div>
                                                </div>
                                                {{-- <div class="col-10">

                                                </div> --}}
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                @if( $loop->iteration == $total)
                                    <button type="button" id="finish" class="btn btn-primary next action-button float-right" value="Next" onclick="stopTime()" >Finish</button>
                                @else
                                    <button type="button" id="next" class="btn btn-primary next action-button float-right" value="Next" >Next</button>
                                @endif
                                @if( $loop->iteration > 1)
                                    <button type="button" id="previous" class="btn btn-dark previous action-button-previous float-right mr-3" value="Previous" >Previous</button>
                                @endif
                            </fieldset>
                        @endforeach
                            <fieldset>
                                <div class="form-card">
                                    <div class="row">
                                        <div class="col-7">
                                            <h3 class="mb-4 text-left"></h3>
                                        </div>
                                        <div class="col-5">
                                            {{-- <h2 class="steps">Step 4 - 4</h2> --}}
                                        </div>
                                    </div>
                                    <br><br>
                                    <h2 class="text-success text-center"><strong>ความพึงพอใจต่อข้อสอบนี้</strong></h2>
                                    <br>
                                    <div class="row justify-content-center">
                                        <div class="col-3">
                                            <div class="star-rating">
                                                <span class="fa ri-star-line" data-rating="1"></span>
                                                <span class="fa ri-star-line" data-rating="2"></span>
                                                <span class="fa ri-star-line" data-rating="3"></span>
                                                <span class="fa ri-star-line" data-rating="4"></span>
                                                <span class="fa ri-star-line" data-rating="5"></span>

                                                <input type="hidden" name="examRating" class="rating-value" value="0">
                                                <br>
                                            </div>
                                            <br>
                                        </div>
                                    </div>
                                    <div class="row justify-content-center">
                                        <button type="button" class="btn btn-primary" onclick="finishTest()">สรุปคะแนน</button>
                                    </div>
                                    <br><br>
                                    <div class="row justify-content-center">
                                        <div class="col-7 text-center">
                                            <h5 class="purple-text text-center">You Have Successfully exam</h5>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            <div class="row justify-content-center">
                                <button type="button" id="btn-pause" class="btn btn-primary" onclick="pauseTest()">Pause</button>
                                <input type="hidden" name="status" value="{{$status}}">
                                <input type="hidden" name="exid" value="{{$exid}}">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
