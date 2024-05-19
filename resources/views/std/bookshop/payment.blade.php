@extends('layouts.mainlayout')

@section('content')
 <!-- Wrapper Start -->
<style>
  .aligncenter {
      text-align: center;
  }
</style>

   <!-- Page Content  -->
  <div id="content-page" class="content-page">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-12">
          <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
              <div class="iq-header-title">
                <h4 class="card-title">Checkout</h4>
              </div>
            </div>
            <div class="iq-card-body">

              <ul id="progressbar" class="text-center">
                <a href="/std/bookshop/checkout"><li class="active step0" id="step1">ตะกร้าสินค้า</li></a>
                <a href="/std/bookshop/delivery"><li class="active step0" id="step2"> ที่อยู่จัดส่ง</li></a>
                <li class="active step0" id="step3">ชำระเงิน</li>
              </ul>

              <div id="payment" class="card-block show b-0">
                 <div class="row">
                    <div class="col-lg-4"></div>

                    <div class="col-lg-4">
                       <div class="iq-card">
                          <div class="iq-card-body">
                              @include("std.bookshop.subview-address")

                              @include("std.bookshop.subview-sumprice")

                              <form method="post" action="https://www.thaiepay.com/epaylink/payment.aspx">
                                  <input type="hidden" name="refno" value="{{ session("user")->account_id }}">
                                  <input type="hidden" name="merchantid" value="41732578">
                                  <input type="hidden" name="customeremail" value="{{ session("user")->email }}">
                                  <input type="hidden" name="cc" value="00">
                                  <input type="hidden" name="productdetail" value="{{ \App\Http\Utils\PaysolutionConstants::PRODUCT_DETAIL_BOOKSHOP }}">
                                  <input type="hidden" name="total" value="{{ $summary["booksPrice"] + $summary["shippingPrice"]  ?? 0 }}">
                                  <br>
                                  <button type="button" id="walletPayment" class="btn btn-primary d-block mb-4 col">ชำระด้วย wallet</button>
                                  <button type="submit" class="btn btn-primary d-block mt-2 col mb-2">ชำระด้วย PaySolutions</button>
                                  <a href="https://www.paysolutions.asia" target="_blank" rel="www.paysolutions.asia"><img src="https://s3-payso-images.s3.ap-southeast-1.amazonaws.com/image-logocode/all-3.png"></a>
                              </form>

                          </div>
                       </div>
                    </div>

                     <div class="col-lg-4"></div>
                 </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<!-- Wrapper END -->
 <script type="text/javascript" src="{{ asset('/assets-custom/bookshop-payment.js') }}"></script>
@endsection
