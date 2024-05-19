<table class="table table-hover">
    <tbody>
    @if(@isset($questions))
        @foreach($questions as $q)
            <tr>
                <th scope="row">{{$loop->index+1}}) <input type="hidden" name="me_det_id" value="{{$q->me_det_id}}"/></th>
                <td>{!! $q->me_que !!}</td>
            </tr>
        @endforeach
    @endif
    </tbody>
</table>
