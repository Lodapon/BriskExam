$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).on("click", ".addToCart", function() {
        let bookId = $(this).siblings("input[type='hidden']").val();
        $.ajax({
            method: "post",
            url: "/std/bookshop/" + bookId,
            contentType: false,
            processData: false,
            success: function(response) {
                $('.toast').toast('show');
                $("#cartCounter").text(response.countItemsInCart);
                // $('#showBook').modal('show');
                // console.log(response);
                // $("#bookImagePreview").prop("src", "data:image/jpeg;base64,"+response.bookImage);
                // $("#bookNamePreview").text(response.bookName);
                // $("#bookDescPreview").text(response.bookDetail);
                // $("#bookTotalPreview").text(response.bookTotal);
                // $("#bookPricePreview").text(response.bookPrice);
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

    $(document).on("keyup", "#book-search", function (){
        $.ajax({
            method: "get",
            url: "/std/bookshop/search?filter="+$(this).val(),
            contentType: false,
            processData: false,
            success: function(response) {
                $("div#bookItemContainer").html(response);
            }
        });
    });

});



