@extends('layouts.mainlayout')

@section('content')
 <!-- Wrapper Start -->
<style>
  .aligncenter {
      text-align: center;
  }
</style>

 <div aria-live="polite" aria-atomic="true" style="position: fixed; min-height: 200px; z-index: 1">
     <div class="toast bg-success" style="position: fixed; top: 100px; right: 20px;" data-autohide="true" data-delay="2000">
         <div class="toast-body text-white">
             เพิ่มสินค้าสำเร็จ
         </div>
     </div>
 </div>

   <!-- Page Content  -->
  <div id="content-page" class="content-page">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-12">
          <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
              <div class="iq-header-title">
                <h4 class="card-title">BriskExam's Bookshop</h4>
              </div>
                <div class="iq-card-header-toolbar d-flex align-items-center">
                    <a href="/std/bookshop/checkout">
                        <i class="ri-shopping-cart-2-line" style="font-size: 24px"></i>
                        <span id="cartCounter" class="badge badge-pill badge-dark" style="animation: shadow-pulse 1s infinite">{{ $countItemsInCart }}</span>
                    </a>
                </div>
            </div>
            <div class="iq-card-body">
              <div class="chat-searchbar mt-4">
                <div class="form-group chat-search-data m-0">
                  <input type="text" class="form-control round" id="book-search" placeholder="Search" style="padding-left: 40px">
                  <i class="ri-search-line"></i>
                </div>
              </div>
            </div>

            <div id="bookItemContainer">
              @include('std.bookshop.bookshop-item')
            </div>

          </div>
        </div>
      </div>

    </div>
  </div>

<!-- Wrapper END -->
 <script type="text/javascript" src="{{ asset('/assets-custom/bookshop.js') }}"></script>
@endsection
