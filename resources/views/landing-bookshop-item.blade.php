@if(@isset($books))
    <div class="iq-card card m-5 pl-5 pr-5 pt-2 pb-0">
        <img src="data:image/jpeg;base64,{{base64_encode($book->book_img)}}" class="card-img-top d-block" alt="#" style="width: 200px; height: 200px; object-fit: scale-down; object-position: top">
        <div class="card-body pt-2">
            <h4 class="card-title" style="text-overflow: ellipsis; overflow: hidden; height: 25px ">{{$book->book_name}}</h4>
            <p style="text-overflow: ellipsis; overflow: hidden; height: 50px ">{{$book->book_detail}}</p>
        </div>
    </div>
@endif
