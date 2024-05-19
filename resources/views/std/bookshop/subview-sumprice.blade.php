<p><b>รายการสินค้า</b></p>
<div class="d-flex justify-content-between">
    <span>ราคารวม</span>
    <span>{{ $summary["booksPrice"] ?? 0 }} ฿</span>
</div>
<div class="d-flex justify-content-between">
    <span>ค่าจัดส่ง</span>
    @if($summary["shippingPrice"] == 0)
        <span class="text-success">Free</span>
    @else
        <span>{{ $summary["shippingPrice"] }} ฿</span>
    @endif
</div>
<hr>
<div class="d-flex justify-content-between">
    <span class="text-dark"><strong>Total</strong></span>
    <span class="text-dark"><strong><span id="total">{{ $summary["booksPrice"] + $summary["shippingPrice"]  ?? 0 }} ฿</span></strong></span>
</div>
