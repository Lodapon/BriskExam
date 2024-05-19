@if(@isset($answerAmount))
    @for ($i = 0,$j = 1; $i < $answerAmount; $i++, $j=$i+1)
        <li class="list-group-item" >
            <input type="hidden" id="answer{{$j}}" value="{{$j}}"/>
            <div class="row">
                <div class="col-2">
                    <div class="custom-control custom-radio">
                        <input type="radio" class="custom-control-input" id="answerNo{{$j}}" name="radio-answer" value="{{$j}}"/>
                        <label class="custom-control-label" for="answerNo{{$j}}">{{$j}})</label>
                    </div>
                </div>
                <div class="col-8"></div>
                <div class="col-2">
                    <button type="button" class="btn btn-outline-danger rounded-pill mb-3 answerDeleteButton float-right" id="answerNoDelete{{$j}}">ลบตัวเลือก</button>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-12">
                    <textarea class="form-control ckEditorSetupNeed" rows="5" id="answerText{{$j}}">{{sizeof($answers) == 0 ? '' : $answers[$i]->fe_ans}}</textarea>
                </div>
            </div>
        </li>
    @endfor
@endif
