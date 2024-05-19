@extends('layouts.mainlayout')

@section('content')
<script type="text/javascript">
    $(function () {
        $('.yajra-datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('mock.list') }}",
                type: "GET"
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'me_que', name: 'me_que'},
                {data: 'type_str', name: 'type_str'},
                {data: 'total_choice', name: 'total_choice'},
                {data: 'me_tags', name: 'me_tags'},
                {data: 'action', name: 'action'},
            ],
            drawCallback: function () {
            const elmList = document.querySelectorAll(".math-tex");
            for (let i = 0; i < elmList.length; i++) {
                MathJax.Hub.Queue(["Typeset", MathJax.Hub, elmList[i].id]);
            }
        }
        });
    });
    function delMock(meDetId){
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
                url: '/testmock/delmock',
                type: 'delete',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    'meDetId': meDetId,
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
 </script>
 <style>
 img {
    vertical-align: middle;
    border-style: none;
    max-width: 250px;
}
 </style>
 <!-- Wrapper Start -->
 <div class="wrapper">
    <!-- Page Content  -->
    <div id="content-page" class="content-page">
       <div class="container-fluid">
          <div class="row">
            <div class="col-sm-12">
                <div class="iq-card">
                   <div class="iq-card-header d-flex justify-content-between">
                      <div class="iq-header-title">
                         <h4 class="card-title">Edit Mock Exam Problem</h4>
                      </div>
                      <div class="iq-card-header-toolbar d-flex align-items-center">
                        <a href="{{route('mock.add')}}" class="float-right mr-1 btn btn-sm btn-primary"><i class="fa fa-plus-circle"></i>Add Exam</a>
                      </div>
                   </div>
                   <div class="iq-card-body">
                      <div class="table-responsive">
                         <table class="table table-striped table-bordered mt-4 yajra-datatable" role="grid" aria-describedby="user-list-page-info">
                           <thead>
                               <tr>
                                  <th style="width: 20px">No</th>
                                  <th>Question</th>
                                  <th>Exam Type</th>
                                  <th>Choice</th>
                                  <th>Tag</th>
                                  <th>Action</th>
                               </tr>
                           </thead>
                           <tbody>
                           </tbody>
                         </table>
                      </div>
                   </div>
                </div>
            </div>
          </div>
       </div>
    </div>
 </div>
 <!-- Wrapper END -->
@endsection
