var ckeditorMap = {};

$(document).ready(function() {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    loadLevels();
    setupRatingComponent();

    FilePond.registerPlugin(FilePondPluginImagePreview);
    $('.my-pond').filepond();

    setupCKEditor(['#questionText', '#solutionText','#solutionTextW','.ckEditorSetupNeed']);
    $('textarea.ckEditorSetupNeed').removeClass('ckEditorSetupNeed');
    
    $(document).on("click", "#testClear", function() {
        $("div.wrs_tickContainer").remove();
    });
    
    $(document).on("click", "#saveMock", function() {

        if (!isValidAddTestMock()) {
            return;
        }

        let formData = new FormData();
        formData.append("questionText", ckeditorMap["questionText"].getData());
        for (var key of Object.keys(ckeditorMap)) {
            formData.append(key , ckeditorMap[key].getData());
        }
        formData.append("tags", $("#tags").val());
        formData.append("solutionText", ckeditorMap["solutionText"].getData());
        formData.append("answerNo", $("[name='radio-answer']:checked").val());
        formData.append("difficultLevel", $("#difficultLevel").val());

        $.ajax({
            method: "post",
            url: "/testmock/save",
            data: formData,
            contentType: false,
            processData: false,
            success: function(isOk) {
                if (isOk) {
                    Swal.fire({
                        title: "บันทึกข้อสอบเรียบร้อย",
                        icon: 'success',
                        showConfirmButton: true,
                        allowOutsideClick: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "/testmock"
                        }
                    });
                }
            },
            error: function(response) {
                Swal.fire({
                    title: response.responseJSON.errors.questionText,
                    icon: 'error',
                    allowOutsideClick: true
                });
            }
        });


    });
    $(document).on("click", "#saveMockW", function() {

        if (!isValidAddTestMockW()) {
            return;
        }

        let formData = new FormData();
        formData.append("questionText", ckeditorMap["questionText"].getData());
        for (var key of Object.keys(ckeditorMap)) {
            formData.append(key , ckeditorMap[key].getData());
        }
        formData.append("tags", $("#tagW").val());
        formData.append("solutionText", ckeditorMap["solutionTextW"].getData());
        formData.append("ansW", $("#ansW").val());

        $.ajax({
            method: "post",
            url: "/testmock/saveW",
            data: formData,
            contentType: false,
            processData: false,
            success: function(isOk) {
                if (isOk) {
                    Swal.fire({
                        title: "บันทึกข้อสอบเรียบร้อย",
                        icon: 'success',
                        showConfirmButton: true,
                        allowOutsideClick: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "/testmock"
                        }
                    });
                }
            },
            error: function(response) {
                Swal.fire({
                    title: response.responseJSON.errors.questionText,
                    icon: 'error',
                    allowOutsideClick: true
                });
            }
        });


    });
    //active only one list item
    $(document).on("click", ".list-group > a", function(e) {
        $(".list-group > a").removeClass("active");
        $(this).addClass("active");
    });

    $(document).on("click", "#addAnswer", function() {
        let $answerNoHidden = $("#answers-container > li.list-group-item > input:hidden");
        let lastAnsNo = ($answerNoHidden.last().val() === undefined ? 0 : parseInt($answerNoHidden.last().val())) + 1;

        $("#answers-container").append('        <li class="list-group-item">' +
            '            <input type="hidden" id="answer' + lastAnsNo + '" value="' + lastAnsNo + '" />' +
            '            <div class="row">' +
            '                <div class="col-2">' +
            '                    <div class="custom-control custom-radio">' +
            '                        <input type="radio" class="custom-control-input" id="answerNo' + lastAnsNo + '" name="radio-answer" value="' + lastAnsNo + '" />' +
            '                        <label class="custom-control-label" for="answerNo' + lastAnsNo + '">' + lastAnsNo + ')</label>' +
            '                    </div>' +
            '                </div>' +
            '                <div class="col-9"></div>' +
            '                <div class="col-1">' +
            '                    <button type="button" class="btn btn-outline-danger rounded-pill mb-3 answerDeleteButton" id="answerNoDelete' + lastAnsNo + '">ลบตัวเลือก</button>' +
            '                </div>' +
            '            </div>' +
            '            <div class="form-group row">' +
            '                <div class="col-12">' +
            '                    <textarea class="form-control ckEditorSetupNeed" rows="5" id="answerText' + lastAnsNo + '"></textarea>' +
            '                </div>' +
            '            </div>' +
            '        </li>');

        setupCKEditor(['textarea.ckEditorSetupNeed']);
        $('textarea.ckEditorSetupNeed').removeClass('ckEditorSetupNeed');
    });

    $(document).on("click", ".answerDeleteButton", function() {
        $(this).parents("li.list-group-item").remove();

        var rowId = $(this)[0].id.substring("answerNoDelete".length)
        delete ckeditorMap["answerText"+rowId];
    });



});

function setupCKEditor(selectors) {
    selectors.forEach(function(selector) {

        if (selector.includes("#")) {
            let elm = document.querySelector(selector)
            setupCKEditorById(elm.id);
        } else {
            let elmList = document.querySelectorAll(selector)
            for (let i = 0; i < elmList.length; i++) {
                setupCKEditorById(elmList[i].id);
            }
        }
    });
}

function setupCKEditorById(id) {
    ClassicEditor.create(document.getElementById(id), {
        toolbar: {
            items: [
                'heading',
                '|',
                'bold',
                'italic',
                'link',
                'bulletedList',
                'numberedList',
                '|',
                'outdent',
                'indent',
                '|',
                'imageUpload',
                'blockQuote',
                'insertTable',
                'mediaEmbed',
                'undo',
                'redo',
                '|',
                'math',
                'MathType',
                'ChemType',
            ]
        },
        math: {
            engine: 'mathjax',
            outputType: 'script',
            forceOutputType: false,
            enablePreview: true
        }
    })
    .then(editor => {
        ckeditorMap[id] = editor;

        // window.ckeditor = editor;
        // getEditorData();
        // editor.model.document.on('change:data', () => {
        //     // getEditorData();
        //     // console.log(editor.getData());
        // });
    })
    .catch(err => {
        console.error(err);
    });
}

function ajaxApi(url, callback){
    $.ajax({
        "url" : url,
        "type" : "GET",
        "dataType" : "json",
    }).done(callback); //END AJAX
}

function loadLevels(){
    //PARAMETERS
    var url = "/api/level";
    var callback = function(result){
        for(var i=0; i<result.length; i++){
            $("#difficultLevel").append(
                $('<option></option>')
                    .attr("value", ""+result[i].lv_id)
                    .html(""+result[i].lv_name)
            );
        }
    };
    //CALL AJAX
    ajaxApi(url,callback);
}

function loadTables(){
    var filter = {};
    filter.subid = $('#sel-subject').val();
    filter.gid = $('#sel-grade').val();
    filter.cateid = $('#sel-cate').val();
    filter.chapid = $('#sel-chap').val();
    // alert(JSON.stringify(filter));

    var table = $('.yajra-datatable').DataTable({
        dom: 'lrtip',
        destroy: true,
        processing: true,
        serverSide: true,
        // ajax: "/testfix/search",
        ajax: {
            url: '/testfix/search',
            data: filter,
            type: "POST"
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex' , orderable: false, searchable: false},
            {data: 'subject.sub_name', name: 'subName', orderable: false, searchable: false},
            {data: 'grade.g_name', name: 'gName', orderable: false, searchable: false},
            {data: 'chapter.chap_name', name: 'chapName', orderable: false, searchable: false},
            {data: 'category.cate_name', name: 'cateName', orderable: false, searchable: false},
            {data: 'created_date', name: 'created_date'},
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },
        ]
    });
}

function isValidAddTestMock() {
    var validateText = "<ul style='border-top: 1px solid #eee;padding: 1em 0 0;display: block' class='invalid-feedback'>";
    if (ckeditorMap["questionText"].getData() === "") {
        validateText += "<li>กรุณากรอกโจทย์</li>"
    }
    if ($("#tags").val() === "") {
        validateText += "<li>กรุณากรอก tags</li>"
    }
    for (var key of Object.keys(ckeditorMap)) {
        if(key.includes("answerText")) {
            if(!ckeditorMap[key].getData()){
                validateText += "<li>" + key.replace(/answerText/, "กรุณากรอกคำตอบข้อที่ ") + "</li>";
            }
        }
    }
    if ($("[name='radio-answer']:checked").val() === undefined) {
        validateText += "<li>กรุณาเลือกคำตอบ</li>"
    }
    validateText += "</ul>"

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

function isValidAddTestMockW() {
    var validateText = "<ul style='border-top: 1px solid #eee;padding: 1em 0 0;display: block' class='invalid-feedback'>";
    if (ckeditorMap["questionText"].getData() === "") {
        validateText += "<li>กรุณากรอกโจทย์</li>"
    }
    if ($("#ansW").val() === "") {
        validateText += "<li>กรุณากรอกคำตอบ</li>"
    }
    if ($("#tagW").val() === "") {
        validateText += "<li>กรุณากรอก tags</li>"
    }
    validateText += "</ul>"

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

function setupRatingComponent() {
    var $star_rating = $('.star-rating .fa');

    var SetRatingStar = function() {
        return $star_rating.each(function() {
            if (parseInt($star_rating.siblings('input.rating-value').val()) >= parseInt($(this).data('rating'))) {
                return $(this).removeClass('ri-star-line').addClass('ri-star-fill');
            } else {
                return $(this).removeClass('ri-star-fill').addClass('ri-star-line');
            }
        });
    };

    $star_rating.on('click', function() {
        $star_rating.siblings('input.rating-value').val($(this).data('rating'));
        return SetRatingStar();
    });

    SetRatingStar();
}
