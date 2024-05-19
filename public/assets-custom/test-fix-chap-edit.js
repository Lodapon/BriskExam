var ckeditorMap = {};

$(document).ready(function() {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    loadQuestionList()

    $(document).on("click", "#updateChapter", function() {
        if (!isValidEditChapter()) {
            return;
        }

        let formData = new FormData();
        formData.append("price", $("#price").val());

        $.ajax({
            method: "post",
            url: "/testfix/chap/"+$("#feId").val()+"/save",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                // console.log(response);
                if (response) {
                    Swal.fire({
                        title: "แก้ไขชุดข้อสอบเรียบร้อย",
                        icon: 'success',
                        showConfirmButton: true,
                        allowOutsideClick: false
                    });
                }
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

    $(document).on("click", "#sendAppr", function() {
        if (!isValidEditChapter()) {
            return;
        }

        let formData = new FormData();
        formData.append("feId", $("#feId").val());

        $.ajax({
            method: "post",
            url: "/testfix/sendAppr",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                // console.log(response);
                if (response) {
                    Swal.fire({
                        title: "ส่งพิจารณาเรียบร้อย",
                        icon: 'success',
                        showConfirmButton: true,
                        allowOutsideClick: false
                    });
                }
            },
            error: function(response) {
                Swal.fire({
                    title: "ไม่สามารถทำรายการได้ กรุณาลองใหม่",
                    icon: 'error',
                    allowOutsideClick: true
                });
            }
        });

    });

});

function loadQuestionList() {
    $('.yajra-datatable').DataTable({
        dom: 'lrtip',
        destroy: true,
        processing: true,
        serverSide: true,
        ajax: {
            url: '/testfix/chap/questionListYajra/' + $("#feId").val(),
            type: "GET"
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'question', name: 'Question', orderable: false, searchable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        drawCallback: function () {
            const elmList = document.querySelectorAll(".math-tex");
            for (let i = 0; i < elmList.length; i++) {
                MathJax.Hub.Queue(["Typeset", MathJax.Hub, elmList[i].id]);
            }
        }
    });
}


function isValidEditChapter() {
    var validateText = "<ul style='border-top: 1px solid #eee;padding: 1em 0 0;display: block' class='invalid-feedback'>";
    if ($("#price").val() === "") {
        validateText += "<li>กรุณาระบุราคาข้อสอบ</li>"
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

function delFix(feDetId){
    Swal.fire({
    title: 'ยืนยันการลบข้อสอบ',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Delete',
    showLoaderOnConfirm: true,
    allowOutsideClick: () => !Swal.isLoading()
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '/testfix/delfix',
                type: 'delete',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    'feDetId': feDetId,
                },
                cache: false,
                success: function(response) {
                    if (response.status == 200) {
                        $('.yajra-datatable').DataTable().ajax.reload();
                        Swal.fire({
                            title: 'Success',
                            text: "Delete Success",
                            icon: 'success',
                            width: '550px',
                            showConfirmButton: true,
                        })
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: "Failed to Delete Question",
                            icon: 'error',
                            width: '550px',
                            showConfirmButton: true
                        })
                    }
                }
            });
        }
    })
}

