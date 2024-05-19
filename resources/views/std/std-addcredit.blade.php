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
        <div class="col-4"></div>
        <div class="col-4">
          <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
              <div class="iq-header-title">
                <h4 class="card-title">เติมเงินเข้าสู่ wallet</h4>
              </div>
            </div>
            <div class="iq-card-body">
                <div class="d-flex justify-content-between">
                    <label for="total">ระบุจำนวนเงินที่ต้องการเติม</label>
                    <span>(฿)</span>
                </div>
                <form method="post" action="https://www.thaiepay.com/epaylink/payment.aspx">
                    <input type="hidden" name="refno" value="{{ session("user")->account_id }}">
                    <input type="hidden" name="merchantid" value="41732578">
                    <input type="hidden" name="customeremail" value="{{ session("user")->email }}">
                    <input type="hidden" name="cc" value="00">
                    <input type="hidden" name="productdetail" value="{{ \App\Http\Utils\PaysolutionConstants::PRODUCT_DETAIL_STD_ADD_CREDIT }}">
                    <input type="number" class="form-control" id="total" name="total" />
                    <br>
                    <hr>
                    <br>
                    <button type="submit" class="btn btn-primary d-block mt-2 col mb-2">ชำระด้วย PaySolutions</button>
                    <a href="https://www.paysolutions.asia" target="_blank" rel="www.paysolutions.asia"><img src="https://s3-payso-images.s3.ap-southeast-1.amazonaws.com/image-logocode/all-3.png"></a>
                </form>
            </div>
          </div>
        </div>
        <div class="col-4"></div>
      </div>
    </div>
  </div>
<!-- Wrapper END -->
@endsection
