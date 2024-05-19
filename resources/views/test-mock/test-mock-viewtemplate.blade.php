@extends('layouts.mainlayout')

@section('content')
<script type="text/javascript">
    $(function () {
        $('.yajra-datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('mock.tmplist') }}",
                type: "GET"
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'mx_name', name: 'mx_name'},
                {data: 'me_time', name: 'me_time'},
                {data: 'me_sec', name: 'me_sec'},
                {data: 'me_choice', name: 'me_choice'},
                {data: 'me_write', name: 'me_write'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action'},
                
            ],
            columnDefs: [
            {
               targets: 0, // your case first column
               className: 'text-center',
               width: '4%'
            },
            {
               targets: 2,
               className: 'text-center',
            },
            {
               targets: 3,
               className: 'text-center',
            },
            {
               targets: 4,
               className: 'text-center',
            },
            {
               targets: 5,
               className: 'text-center',
            },
            {
               targets: 6,
               className: 'text-center',
               searchable: false,
            },
            {
               targets: 7,
               className: 'text-center',
               searchable: false,
            }
            ],
            drawCallback: function () {
            const elmList = document.querySelectorAll(".math-tex");
            for (let i = 0; i < elmList.length; i++) {
                MathJax.Hub.Queue(["Typeset", MathJax.Hub, elmList[i].id]);
            }
        }
        });
    });
   function changeStatus(meId){
      if($('#meStatus-'+meId).is(":checked")){
         //Active
         status = "A"
      }else{
         //InActive
         status = "I"
      }
      $.ajax({
         url: '/testmock/changeStatus',
         type: 'post',
         headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         },
         data: {
            'meId': meId,
            'status':status,
         },
         cache: false,
         success: function(response) {
            
         }
         });
            
        
   }
   function delMockTmp(meId){
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
                url: '/testmock/delmockTmp',
                type: 'delete',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    'meId': meId,
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
                            text: "Failed to Delete MockUp Template",
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
                         <h4 class="card-title">View Templates Mock Exam</h4>
                      </div>
                   </div>
                   <div class="iq-card-body">
                      <div class="table-responsive">
                         <table class="table table-striped table-bordered mt-4 yajra-datatable" role="grid" aria-describedby="user-list-page-info">
                           <thead>
                               <tr>
                                  <th style="width: 20px">No</th>
                                  <th>ชื่อข้อสอบ</th>
                                  <th>เวลา</th>
                                  <th>Section</th>
                                  <th>จำนวนข้อสอบตัวเลือก</th>
                                  <th>จำนวนข้อสอบเติมคำ</th>
                                  <th>Show/Hide to std</th>
                                  <th>Action</th>
                               </tr>
                           </thead>
                           <tbody>
                                {{-- <tr>
                                  <td style="width: 20px">1</td>
                                  <td>คณิตศาสตร์</td>
                                  <td>PAT1</td>
                                  <td>03:00:00</td>
                                  <td>50</td>
                                  <td>10</td>
                                  <td><i class="ri-edit-line"></i></td>
                                  <td>
                                    <div class="custom-control custom-switch custom-switch-text custom-switch-color custom-control-inline">
                                      <div class="custom-switch-inner">
                                         <input type="checkbox" class="custom-control-input bg-success" id="customSwitch-22" checked="">
                                         <label class="custom-control-label" for="customSwitch-22" data-on-label="Show" data-off-label="Hide">
                                         </label>
                                      </div>
                                    </div>   
                                  </td>
                                  <td>
                                    <button type="button" class="btn mb-3 btn-danger" id="delGrade" onclick="delGrade()">
                                        <i class="fa fa-minus" aria-hidden="true"></i>Delete</button>
                                  </td>
                               </tr> --}}
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
