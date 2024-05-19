@extends('layouts.mainlayout')

@section('content')
    <!-- Wrapper Start -->

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
                                <a href="/std/bookshop/checkout">
                                    <li class="active step0" id="step1">ตะกร้าสินค้า</li>
                                </a>
                                <li class="active step0" id="step2">ที่อยู่จัดส่ง</li>
                                <li class="step0" id="step3">ชำระเงิน</li>
                            </ul>

                            <div id="address" class="card-block show b-0">
                                <div class="row">
                                    <div class="col-lg-2"></div>
                                    <div class="col-lg-4">
                                        <div class="iq-card">
                                            <div class="iq-card-header d-flex justify-content-between">
                                                <div class="iq-header-title">
                                                    <h4 class="card-title">ระบุข้อมูลสถานที่จัดส่งใหม่</h4>
                                                </div>
                                            </div>
                                            <div class="iq-card-body">
                                                <div class="row mt-3">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="newName">ชื่อ นามสกุล: *</label>
                                                            <input type="text" class="form-control" id="newName" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="newTel">เบอร์โทรศัพท์: *</label>
                                                            <input type="text" class="form-control" id="newTel" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="newAddr">ที่อยู่จัดส่ง: *</label>
                                                            <input type="text" class="form-control" id="newAddr" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <button id="deliver-new-address" class="btn btn-primary btn-block mt-1">
                                                    <i class="fa fa-save"></i>
                                                    บันทึกและจัดส่งไปยังที่อยู่ที่ระบุ
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="iq-card">
                                            <div class="iq-card-header d-flex justify-content-between">
                                                <div class="iq-header-title">
                                                    <h4 class="card-title">ที่อยู่จัดส่งครั้งล่าสุด</h4>
                                                </div>
                                            </div>
                                            @if(isset($recentDelivery))
                                                <div class="iq-card-body">
                                                    @include("std.bookshop.subview-address")
                                                    <button id="deliver-old-address" class="btn btn-primary btn-block mt-1">
                                                        <i class="fa fa-clock-o"></i>
                                                        จัดส่งไปยังที่อยู่ครั้งล่าสุด
                                                    </button>
                                                </div>
                                            @else
                                                <div class="iq-card-body">
                                                    <h4 class="mb-2"></h4>
                                                    <div class="shipping-address">
                                                        <p><span>ไม่มีที่อยู่จัดส่งก่อนหน้า</span></p>
                                                    </div>
                                                    <hr />
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-2"></div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Wrapper END -->
    <script type="text/javascript" src="{{ asset('/assets-custom/bookshop-delivery.js') }}"></script>
@endsection
