$(document).ready(function() {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).on("click", "#requestReset", function() {
        let formData = new FormData();
        formData.append("email", $("#email").val());
        $.ajax({
            method: "post",
            url: "/reset/request",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                // console.log(response);
                if (response) {
                    Swal.fire({
                        title: "ระบบส่งคำขอเปลี่ยนรหัสผ่านไปทางอีเมลที่ระบุ",
                        text: "กรุณาตรวจสอบกล่องข้อความ",
                        icon: 'success',
                        showConfirmButton: true,
                        allowOutsideClick: false
                    }).then((result) => {
                        window.location.href = "/"
                    });
                } else {
                    Swal.fire({
                        title: "ไม่พบอีเมลในระบบ",
                        text: "กรุณาตรวจสอบ",
                        icon: 'question',
                        allowOutsideClick: true
                    });
                }
            },
            error: function() {
                Swal.fire({
                    title: "เกิดข้อผิดพลาด กรุณาลองใหม่่อีกครั้ง",
                    icon: 'error',
                    allowOutsideClick: true
                });
            }
        });

    });

    $(document).on("click", "#confirmReset", function() {
        let formData = new FormData();
        formData.append("resetToken", $("#resetToken").val());
        formData.append("password1", $("#password1").val());
        formData.append("password2", $("#password2").val());
        $.ajax({
            method: "post",
            url: "/reset/confirm",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                // console.log(response);
                if (response) {
                    Swal.fire({
                        title: "เปลี่ยนรหัสผ่านเรียบร้อย",
                        text: "กรุณารอสักครู่ ระบบจะพาท่านกลับสู่หน้าหลัก",
                        icon: 'success',
                        showConfirmButton: true,
                        allowOutsideClick: false
                    }).then((result) => {
                        window.location.href = "/"
                    });
                } else {
                    Swal.fire({
                        title: "เกิดข้อผิดพลาด",
                        text: "ข้อมูลการเปลี่ยนรหัสผ่านไม่ถูกต้อง หรือลิงค์ไม่สมบูรณ์",
                        icon: 'warning',
                        allowOutsideClick: true
                    });
                }
            },
            error: function() {
                Swal.fire({
                    title: "เกิดข้อผิดพลาด กรุณาลองใหม่่อีกครั้ง",
                    icon: 'error',
                    allowOutsideClick: true
                });
            }
        });
    });
    //
    // $(document).on("click", "#updateChapter", function() {
    //     if (!isValidEditChapter()) {
    //         return;
    //     }
    //
    //     let formData = new FormData();
    //     formData.append("price", $("#price").val());
    //
    //     $.ajax({
    //         method: "post",
    //         url: "/testfix/chap/"+$("#feId").val()+"/save",
    //         data: formData,
    //         contentType: false,
    //         processData: false,
    //         success: function(response) {
    //             // console.log(response);
    //             if (response) {
    //                 Swal.fire({
    //                     title: "แก้ไขชุดข้อสอบเรียบร้อย",
    //                     icon: 'success',
    //                     showConfirmButton: true,
    //                     allowOutsideClick: false
    //                 });
    //             }
    //         },
    //         error: function(response) {
    //             Swal.fire({
    //                 title: "ไม่สามารถบันทึกได้ กรุณาลองใหม่",
    //                 icon: 'error',
    //                 allowOutsideClick: true
    //             });
    //         }
    //     });
    //
    // });
    //
    // $(document).on("click", "#sendAppr", function() {
    //     if (!isValidEditChapter()) {
    //         return;
    //     }
    //
    //     let formData = new FormData();
    //     formData.append("feId", $("#feId").val());
    //
    //     $.ajax({
    //         method: "post",
    //         url: "/testfix/sendAppr",
    //         data: formData,
    //         contentType: false,
    //         processData: false,
    //         success: function(response) {
    //             // console.log(response);
    //             if (response) {
    //                 Swal.fire({
    //                     title: "ส่งพิจารณาเรียบร้อย",
    //                     icon: 'success',
    //                     showConfirmButton: true,
    //                     allowOutsideClick: false
    //                 });
    //             }
    //         },
    //         error: function(response) {
    //             Swal.fire({
    //                 title: "ไม่สามารถทำรายการได้ กรุณาลองใหม่",
    //                 icon: 'error',
    //                 allowOutsideClick: true
    //             });
    //         }
    //     });
    //
    // });

});


