@extends('layouts.mainlayout')

@section('content')
 <!-- Wrapper Start -->
<script type="text/javascript">
 $(function () {
     var table = $('.yajra-datatable').DataTable({
         processing: true,
         serverSide: true,
         ajax: "{{ route('usercr.list') }}",
         columns: [
             {data: 'DT_RowIndex', name: 'DT_RowIndex'},
             {data: 'user_cr', name: 'user_cr'},
             {data: 'email', name: 'email'},
             {data: 'role_name', name: 'role_name'},
             {data: 'join_date', name: 'join_date'},
             {data: 'balance_amt', name: 'balance_amt'},
             {
                 data: 'action',
                 name: 'action',
                 orderable: true,
                 searchable: true
             },
            //  {defaultContent: "<button type='button' onclick='addCredit()' class='btn btn-outline-dark rounded-pill mb-3'>Add</button>"},
         ]
     });
    //  $('.yajra-datatable tbody').on( 'click', 'button', function () {
    //     var currentRow=$(this).closest("tr");
    //     var username = currentRow.find("td:eq(1)").text();
    //     var email = currentRow.find("td:eq(2)").text();
    //     var role = currentRow.find("td:eq(3)").text();
    //     // alert(username + "   " + email+ "   " +role);
    //     document.getElementById('edittable').innerHTML+=('<tr><td>' + username + '</td><td> ' + email + ' </td><td> ' + role + ' </td><td> Show Available Credit </td><td> <input type="text" name=""> </td></tr>');
    //   });
   });

function addCredit(accId) {
        Swal.fire({
        title: 'เพิ่ม Credit',
        icon: 'info',
        input: 'text',
        inputAttributes: {
            autocapitalize: 'off'
        },
        showCancelButton: true,
        confirmButtonText: 'Add',
        showLoaderOnConfirm: true,
        allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/api/addCredit',
                    type: 'post',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        'credit': result.value,
                        'accId': accId,
                    },
                    cache: false,
                    success: function(response) {
                        if (response.status == 200) {
                            $('.yajra-datatable').DataTable().ajax.reload();
                            Swal.fire({
                                title: 'Success',
                                text: "Add Success",
                                icon: 'success',
                                width: '550px',
                                showConfirmButton: true,
                            })
                        }
                        //     // setTimeout(function() {
                        //     //     swal.close();
                        //     //     $('#test-fe-id').val(fid);
                        //     //     $('#do-test').submit();
                        //     // }, 1500)
                        // } else {
                        //     Swal.fire({
                        //         title: 'Error',
                        //         text: "Failed to Add subject",
                        //         icon: 'error',
                        //         width: '550px',
                        //         showConfirmButton: true,
                        //         timer: 3000
                        //     })
                        // }
                    }
                });
            }
        })
  }
</script>

 <div class="">
    <!-- Sidebar  -->
    <!-- Page Content  -->
    <div id="content-page" class="content-page">
       <div class="container-fluid">
        <!-- <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
              <div class="iq-card-header d-flex justify-content-between">
                 <div class="iq-header-title">
                    <h4 class="card-title" align="text-center">Admin's Dashboard</h4>
                 </div>
               </div>
        </div> -->
        <div class="row">
          <div class="col-sm-12">
                <div class="iq-card">
                   <div class="iq-card-header d-flex justify-content-between">
                      <div class="iq-header-title">
                         <h4 class="card-title">Add Credits</h4>
                      </div>
                   </div>
                   <div class="iq-card-body">
                      <div class="table-responsive">
                         <table class="table table-striped table-bordered mt-4 yajra-datatable" role="grid" aria-describedby="user-list-page-info">
                           <thead>
                               <tr>
                                  <th>No</th>
                                  <th>User Name</th>
                                  <th>Email</th>
                                  <th>Role</th>
                                  <th>Join Date</th>
                                  <th>Credit</th>
                                  {{-- <th>View</th> --}}
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

        {{-- <div class="row">
          <div class="col-lg-12">
           <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
              <div class="iq-card-header d-flex justify-content-between">
                 <div class="iq-header-title">
                    <h4 class="card-title">Add Credit</h4>
                 </div>
              </div>
              <div class="iq-card-body pb-0">
                  <div class="table-responsive">
                    <table class="table table-striped table-bordered mt-4" role="grid" id="edittable">
                        <thead>
                          <tr>
                            <th>User Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Available Credit</th>
                            <th>Input Credit</th>
                          </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                  </div>
                  <div class="form-group row">
                    <div class="col-lg-12 d-flex justify-content-center">
                      <button class="float-center btn btn-primary">Submit</button>
                    </div>
                  </div>
              </div>
            </div>
          </div>
        </div> --}}
    </div>
 </div>
 <!-- Wrapper END -->



@endsection
