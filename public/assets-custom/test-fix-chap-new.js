var ckeditorMap = {};

$(document).ready(function() {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    loadSubjects();
    loadGrades();
    loadCategories();


    // if ($("#feId").val() !== undefined && $("#feId").val() !== "") {
    //     loadQuestionList($("#feId").val());
    // }

    $(document).on("click", "#saveChapter", function() {
        if (!isValidAddChapter()) {
            return;
        }

        let formData = new FormData();
        formData.append("subject", $("#sel-subject").val());
        formData.append("grade", $("#sel-grade").val());
        formData.append("category", $("#sel-cate").val());
        // formData.append("chapter", $("#sel-chap").val());
        formData.append("price", $("#price").val());

        $.ajax({
            method: "post",
            url: "/testfix/chap/save",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                // console.log(response);
                if (response) {
                    Swal.fire({
                        title: "สร้างชุดข้อสอบเรียบร้อย",
                        text: "ชุดที่ " + response.chap_id,
                        icon: 'success',
                        showConfirmButton: true,
                        allowOutsideClick: false
                    }).then((result) => {
                        window.location.href = "chap/" + response.id
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
        if (!isValidAddChapter()) {
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

    // $(document).on("change", "#sel-subject, #sel-subject, #sel-grade, #sel-cate", function() {
    //
    //     if ($("#sel-subject").val() !== "" && $("#sel-grade").val() !== "" && $("#sel-cate").val() !== "" ) {
    //         loadChapters();
    //     }
    //
    //     console.debug("activated");
    //     // $("#sel-subject").val()
    //     // $("#sel-grade").val()
    //     // $("#sel-cate").val()
    //     // $("#sel-chap").val()
    //     // $("#price").val()
    //     // loadQuestionList($("#feId").val());
    //
    //
    // });


});

// function loadQuestionList(feId) {
//     $('.yajra-datatable').DataTable({
//         dom: 'lrtip',
//         destroy: true,
//         processing: true,
//         serverSide: true,
//         ajax: {
//             url: '/testfix/chap/questionListYajra/' + feId,
//             type: "GET"
//         },
//         columns: [
//             {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
//             {data: 'question', name: 'Question', orderable: false, searchable: false},
//             {data: 'action', name: 'action', orderable: false, searchable: false},
//         ],
//         drawCallback: function () {
//             const elmList = document.querySelectorAll(".math-tex");
//             for (let i = 0; i < elmList.length; i++) {
//                 MathJax.Hub.Queue(["Typeset", MathJax.Hub, elmList[i].id]);
//             }
//         }
//     });
// }


function ajaxApi(url, callback){
    $.ajax({
        "url" : url,
        "type" : "GET",
        "dataType" : "json",
    }).done(callback); //END AJAX
}

function loadSubjects(){
    //PARAMETERS
    var url = "/api/subject";
    var callback = function(result){
        for(var i=0; i<result.length; i++){
            $("#sel-subject").append(
                $('<option></option>')
                    .attr("value", ""+result[i].sub_id)
                    .html(""+result[i].sub_name)
            );
        }

        if ($("#subValue").val() !== "" || $("#subValue").val() !== undefined) {
            $("#sel-subject").val($("#subValue").val());
        }
    };
    //CALL AJAX
    ajaxApi(url,callback);
}

function loadGrades(){
    //PARAMETERS
    var url = "/api/grade";
    var callback = function(result){
        for(var i=0; i<result.length; i++){
            $("#sel-grade").append(
                $('<option></option>')
                    .attr("value", ""+result[i].g_id)
                    .html(""+result[i].g_name)
            );
        }

        if ($("#gradeValue").val() !== "" || $("#gradeValue").val() !== undefined) {
            $("#sel-grade").val($("#gradeValue").val());
        }
    };
    //CALL AJAX
    ajaxApi(url,callback);
}

function loadCategories(){
    //PARAMETERS
    var sub_id = $("#sel-subject").val();
    var url = "/api/category/" + sub_id;
    var callback = function(result){
        $("#sel-cate").empty();
        $("#sel-cate").append(
            $('<option></option>')
                .attr("value", "")
                .html("เลือกชื่อข้อสอบ (บท)")
        );
        for(var i=0; i<result.length; i++){
            $("#sel-cate").append(
                $('<option></option>')
                    .attr("value", ""+result[i].cate_id)
                    .html(""+result[i].cate_name)
            );
        }

        if ($("#cateValue").val() !== "" || $("#cateValue").val() !== undefined) {
            $("#sel-cate").val($("#cateValue").val());
        }
    };
    //CALL AJAX
    ajaxApi(url,callback);
}

function loadChapters(){
    //PARAMETERS
    var url = "/api/chapter";
    var callback = function(result){
        for(var i=0; i<result.length; i++){
            $("#sel-chap").append(
                $('<option></option>')
                    .attr("value", ""+result[i].chap_id)
                    .html(""+result[i].chap_name)
            );
        }

        if ($("#chapValue").val() !== "" || $("#chapValue").val() !== undefined) {
            $("#sel-chap").val($("#chapValue").val());
        }
    };
    //CALL AJAX
    ajaxApi(url,callback);
}

function isValidAddChapter() {
    var validateText = "<ul style='border-top: 1px solid #eee;padding: 1em 0 0;display: block' class='invalid-feedback'>";
    if ($("#sel-subject").val() === "") {
        validateText += "<li>กรุณาเลือกรายวิชา</li>"
    }

    if ($("#sel-grade").val() === "") {
        validateText += "<li>กรุณาเลือกระดับชั้น</li>"
    }

    if ($("#sel-cate").val() === "") {
        validateText += "<li>กรุณาเลือกชื่อข้อสอบ (บท)</li>"
    }

    if ($("#sel-chap").val() === "") {
        validateText += "<li>กรุณาเลือกชุดข้อสอบ</li>"
    }

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
