$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).on("click", ".removeBook", function() {
        let bookId = $(this).parents(".iq-card").children(".bookId").val();
        $.ajax({
            method: "delete",
            url: "/std/bookshop/checkout/" + bookId,
            contentType: false,
            processData: false,
            success: function(response) {
                $("div#checkoutItemContainer").html(response);
            },
            error: function(response) {
                Swal.fire({
                    title: "เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง",
                    icon: 'error',
                    allowOutsideClick: true
                });
            }
        });
        // alert(bookId);

    });

    $(document).on("change", ".bookAmount", function (){
        $(this).prop("disabled", true)
        let bookId = $(this).parents(".iq-card").children(".bookId").val();
        $.ajax({
            method: "put",
            url: "/std/bookshop/checkout/update",
            data: JSON.stringify({bookId: bookId, amount: $(this).val()}),
            contentType: 'application/json',
            success: function(response) {
                $("div#checkoutItemContainer").html(response);
            }
        });
    });

    $(document).on("click", "#place-order", function() {
        window.location.href = "/std/bookshop/delivery";
    });

});



