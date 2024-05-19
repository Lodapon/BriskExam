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
                    <div class="col-lg-12  profile-center">
                        <div class="iq-card">
                            <div class="iq-card-header d-flex justify-content-between">
                                <div class="iq-header-title">
                                    <h4 class="card-title">{{$exname}}</h4>
                                </div>
                                <div class="iq-card-header-toolbar d-flex align-items-center">
                                    <a href="javascript:goBack()" class="float-right mr-1 btn btn-sm btn-primary"><i class="ri-arrow-drop-left-line"></i>Back</a>
                                </div>
                            </div>
                            <div class="iq-card-body">

                                    @foreach($test as $fix => $exam)
                                    <div class="iq-card">
                                        <div class="iq-card-header d-flex">
                                           <div class="iq-header-title">
                                              <h5 class="card-title">  <div class="row">{{ $loop->iteration }}) {!!$fix!!}</div></h5>
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
                                                            
                                                                @if($ans->fe_no_ans == $ans->fe_ans_no)
                                                                    <div class="row alert alert-success">{{ $loop->iteration }}) {!! $ans->fe_ans !!}</div>
                                                                @else
                                                                <div class="row alert @foreach($anws as $item) @if($item->fe_det_id == $ans->fe_det_id) @if($item->fe_ans_no == $ans->fe_ans_no)alert-danger @endif @endif @endforeach">{{ $loop->iteration }}) {!! $ans->fe_ans !!}</div>
                                                                @endif
                                                        </div>
                                                        @if ($loop->last)
                                                        <div class="col-md-12"><div class="row"><label> ตอบเพราะ   {!! $ans->fe_soln !!}</label></div></div>
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
        </div>
    </div>
</div>
@endsection
