<div id="cart" class="card-block show b-0">
    <div class="row">
        <div class="col-lg-8">
            @foreach($books as $book)
                <div class="iq-card">
                    <input type="hidden" value="{{$book->book_id}}" class="bookId"/>
                    <div class="iq-card-body">
                        <div class="ckeckout-product-lists">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <div class="ckeckout-product">
                                        <img src="data:image/jpeg;base64,{{base64_encode($book->book_img)}}" width="100" height="150">
                                    </div>
                                    <div class="checkout-product-details ml-3">
                                        <h5 id="name1">{{ $book->book_name }}</h5>
                                        @if($book->book_available)
                                            <p class="text-success">In stock</p>
                                        @else
                                            <p class="text-danger">Out of stock</p>
                                        @endif

                                        <p class="mb-0"><b>Quantity</b></p>
                                        <div class="input-box">
                                            <input type="number" min="1" value="{{ $book->countEachBook }}" class="bookAmount" />
                                        </div>

                                        <p class="mb-0 mt-2">Delivery by, {{ Date('D M d', strtotime('+3 days')) }} </p> <!-- 3 days after purchased -->
                                    </div>
                                </div>
                                <div class="checkout-amount-data text-center">
                                    <div class="price">
                                        <h5>{{ $book->sumBookPrice ?? 0}} ฿</h5>
                                        <h8>{{ $book->book_price ?? 0}} ฿ per item</h8>
                                    </div>
                                    <div class="checkout-button">
                                        <button type="button" class="btn btn-light d-block removeBook"><i class="ri-close-line mr-1"></i>Remove</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="col-lg-4">
            <div class="iq-card">
                <div class="iq-card-body">
                    @include("std.bookshop.subview-sumprice")
                    <button id="place-order" class="btn btn-primary d-block mt-2 col">ดำเนินการต่อ</button>
                </div>
            </div>
        </div>

    </div>
</div>
