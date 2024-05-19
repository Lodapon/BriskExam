@if(@isset($books))
    <div class="row m-5">
    @foreach($books as $book)
        <div class="col-sm-4">
            <div class="iq-card card border-primary">
                <div class="m-3">
                    <img src="data:image/jpeg;base64,{{base64_encode($book->book_img)}}" class="card-img-top d-block" alt="#" style="width: 200px; height: 200px; object-fit: scale-down; object-position: top">
                    <div class="card-body p-0">
                        <h4 class="card-title" style="text-overflow: ellipsis; overflow: hidden; height: 25px ">{{$book->book_name}}</h4>
                        <p style="text-overflow: ellipsis; overflow: hidden; height: 50px ">{{$book->book_detail}}</p>
                        <ul class="ratting-item d-flex p-0 mt-3 mb-3">
                            <li class="full"><i class="ri-star-fill"></i></li>
                            <li class="full"><i class="ri-star-fill"></i></li>
                            <li class="full"><i class="ri-star-fill"></i></li>
                            <li class="full"><i class="ri-star-fill"></i></li>
                            <li class="full"><i class="ri-star-line"></i></li>
                        </ul>

                        <div class="row">
                            <div class="col-6">
                                <button type="button" class="btn btn-primary addToCart" >
                                    <i class="ri-shopping-cart-line mr-0"></i>
                                </button>
                                <input type="hidden" value="{{$book->book_id}}"/>
                            </div>
                            <div class="col-6">
                                <p class="font-size-16 font-weight-bold float-right">{{$book->book_price}} ฿</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
    <div class="pagination justify-content-center">
        {{ $books->links() }}
    </div>
@endif
