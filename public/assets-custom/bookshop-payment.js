$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).on("click", "#walletPayment", function() {
        $.ajax({
            method: "post",
            url: "/std/bookshop/payment/wallet",
            data: JSON.stringify({'price':$("input[name='total']").val()}),
            contentType: 'application/json',
            processData: false,
            success: function(isOk) {
                if (isOk) {
                    Swal.fire({
                        title: "ชำระเงินสำเร็จ",
                        icon: 'success',
                        showConfirmButton: true,
                        allowOutsideClick: false
                    }).then((result) => {
                        postback();
                        window.location.href = "/"
                    });
                } else {
                    Swal.fire({
                        title: "ยอดเงินใน wallet ไม่เพียงพอ",
                        text: "กรุณาเติมเงินหรือชำระผ่านช่องทางอื่น",
                        icon: 'warning',
                        allowOutsideClick: true
                    });
                }
            },
            error: function(response) {
                Swal.fire({
                    title: "เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง",
                    icon: 'error',
                    allowOutsideClick: true
                });
            }
        });

    });
});

function postback() {
    $.ajax({
        method: "post",
        url: "/postback",
        data: JSON.stringify({
            'refno': $("input[name='refno']").val(),
            'total': $("input[name='total']").val(),
            'productdetail': $("input[name='productdetail']").val()
        }),
        contentType: 'application/json',
        processData: false,
    });
}
