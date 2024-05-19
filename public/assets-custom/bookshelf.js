$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    loadBookList();

    $(document).on("click", "#uploadCover_button", openFileBrowser);

    $(document).on("click", "#addBook", function() {
        if (!isValidAddBook()) {
            return;
        }

        let formData = new FormData();
        formData.append("bookName", $("#bookName").val());
        formData.append("bookDes", $("#bookDes").val());
        formData.append("year", $("#year").val());
        formData.append("probNum", $("#probNum").val());
        formData.append("price", $("#price").val());
        formData.append("coverImg", $('#coverImg')[0].files[0]);

        $.ajax({
            method: "post",
            url: "/admin/bookshelf/book/save",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                Swal.fire({
                    title: "บันทึกข้อมูลหนังสือเรียบร้อย",
                    icon: 'success',
                    showConfirmButton: true,
                    allowOutsideClick: false
                }).then((result) => {
                    loadBookList();
                    $('#addBookModal').modal('hide');
                    $('body').removeClass('modal-open');
                    $('.modal-backdrop').remove();
                });
            },
            error: function(response) {
                Swal.fire({
                    title: "ไม่สามารถบันทึกได้ กรุณาลองใหม่",
                    icon: 'error',
                    allowOutsideClick: true
                });
            }
        });

    });

    $(document).on("click", ".deleteButton", function() {
        Swal.fire({
            title: 'ต้องการลบข้อมูลหรือไม่ ?',
            icon: 'warning',
            showConfirmButton: false,
            showDenyButton: true,
            showCancelButton: true,
            denyButtonText: 'ลบ',
            cancelButtonText: 'ยกเลิก',
            allowOutsideClick: true
        }).then((result) => {
            if (result.isDenied) {
                let bookId = $(this).siblings(".bookId").val();
                $.ajax({
                    method: "delete",
                    url: "/admin/bookshelf/book/" + bookId,
                    contentType: false,
                    processData: false,
                    success: loadBookList
                });

            }
        });

    });

    $(document).on("click", ".previewBook", function(e) {
        e.preventDefault();

        let bookId = $(this).parents("tr").find(".bookId").val();

        $.ajax({
            method: "get",
            url: "/admin/bookshelf/book/" + bookId,
            contentType: false,
            processData: false,
            success: function(response) {
                $('#showBook').modal('show');
                console.log(response);
                $("#bookImagePreview").prop("src", "data:image/jpeg;base64,"+response.bookImage);
                $("#bookNamePreview").text(response.bookName);
                $("#bookDescPreview").text(response.bookDetail);
                $("#bookTotalPreview").text(response.bookTotal);
                $("#bookPricePreview").text(response.bookPrice);
            },
            error: function(response) {
                Swal.fire({
                    title: "เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง",
                    icon: 'error',
                    allowOutsideClick: true
                });
            }
        });

        // $('#addBookModal').modal('hide');
        // $('body').removeClass('modal-open');
        // $('.modal-backdrop').remove();
    });
});

function openFileBrowser() {
    document.getElementById('coverImg').click();
}

function loadBookList() {
    $('.yajra-datatable').DataTable({
        dom: 'lrtip',
        destroy: true,
        processing: true,
        serverSide: true,
        ajax: {
            url: '/admin/bookshelf/books',
            type: "GET"
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'bookName', name: '', orderable: false, searchable: false},
            {data: 'bookTotal', name: '', orderable: false, searchable: false},
            {data: 'bookPrice', name: '', orderable: false, searchable: false},
            {data: 'createdBy', name: '', orderable: false, searchable: false},
            {data: 'createdDate', name: '', orderable: false, searchable: false},
            {data: 'viewButton', name: '', orderable: false, searchable: false},
            {data: 'deleteButton', name: '', orderable: false, searchable: false}
        ]
    });
}

function loadBookDetail() {

    let formData = new FormData();
    formData.append("bookName", $("#bookName").val());
    formData.append("bookDes", $("#bookDes").val());
    formData.append("year", $("#year").val());
    formData.append("probNum", $("#probNum").val());
    formData.append("price", $("#price").val());
    formData.append("coverImg", $('#coverImg')[0].files[0]);

    $.ajax({
        method: "post",
        url: "/admin/bookshelf/book/save",
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            Swal.fire({
                title: "บันทึกข้อมูลหนังสือเรียบร้อย",
                icon: 'success',
                showConfirmButton: true,
                allowOutsideClick: false
            }).then((result) => {
                loadBookList();
                $('#addBookModal').modal('hide');
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();
            });
        },
        error: function(response) {
            Swal.fire({
                title: "ไม่สามารถบันทึกได้ กรุณาลองใหม่",
                icon: 'error',
                allowOutsideClick: true
            });
        }
    });
}
function isValidAddBook() {

    var validateText = "<ul style='border-top: 1px solid #eee;padding: 1em 0 0;display: block' class='invalid-feedback'>";
    if ($("#bookName").val() === "") {
        validateText += "<li>กรุณาระบุชื่อหนังสือ</li>"
    }

    if ($("#bookDes").val() === "") {
        validateText += "<li>กรุณาระบุรายละเอียด</li>"
    }

    if ($("#year").val() === "") {
        validateText += "<li>กรุณาระบุปีที่พิมพ์</li>"
    }

    if ($("#probNum").val() === "") {
        validateText += "<li>กรุณาระบุจำนวนข้อสอบ</li>"
    }

    if ($("#price").val() === "") {
        validateText += "<li>กรุณาระบุราคาหนังสือ</li>"
    }

    if ($("#coverImg").val() === "") {
        validateText += "<li>กรุณาอัพโหลดภาพหน้าปก</li>"
    }
    validateText += "</ul>"
    return isValidOrShowValidateText(validateText);
}

function isValidOrShowValidateText(validateText) {
    if (validateText !== "<ul style='border-top: 1px solid #eee;padding: 1em 0 0;display: block' class='invalid-feedback'></ul>") {
        Swal.fire({
            title: 'กรุณากรอกข้อมูลให้ครบถ้วน',
            icon: 'warning',
            html: validateText,
            confirmButtonText: `ตรวจสอบ`,
            allowOutsideClick: true
        })
        return false;
    }
    return true;
}

