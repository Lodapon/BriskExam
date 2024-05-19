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
                 <li class="active step0" id="step1">ตะกร้าสินค้า</li>
                 <li class="step0" id="step2">ที่อยู่จัดส่ง</li>
                 <li class="step0" id="step3">ชำระเงิน</li>
              </ul>

              <div id="checkoutItemContainer">
                  @include('std.bookshop.checkout-item')
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<!-- Wrapper END -->
 <script type="text/javascript" src="{{ asset('/assets-custom/bookshop-checkout.js') }}"></script>
@endsection
