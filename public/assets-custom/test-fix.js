var ckeditorMap = {};

$(document).ready(function() {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    loadSubjects();
    loadGrades();
    loadChapters();
    setupRatingComponent();

    setupCKEditor(['#questionText', '#solutionText','.ckEditorSetupNeed']);
    $('textarea.ckEditorSetupNeed').removeClass('ckEditorSetupNeed');

});

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

        // showAmphoes();
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
            {data: 'sub_name', name: 'sub_name', searchable: false},
            {data: 'g_name', name: 'g_name',  searchable: false},
            {data: 'cate_name', name: 'cate_name', searchable: false},
            {data: 'chap_name', name: 'chap_name', searchable: false},
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
