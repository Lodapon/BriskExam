@extends('layouts.mainlayout')

@section('content')
 <!-- Wrapper Start -->
 <div class="">
   <!-- Page Content  -->
   <div id="content-page" class="content-page">
    <div class="container-fluid">
       <div class="row">
          <div class="col-sm-12">
                <div class="iq-card">
                   <div class="iq-card-header d-flex justify-content-between">
                      <div class="iq-header-title">
                         <h4 class="card-title">User List</h4>
                      </div>
                   </div>
                   <div class="iq-card-body">
                      <div class="table-responsive">
                         <table class="table table-striped table-bordered mt-4 yajra-datatable" role="grid" aria-describedby="user-list-page-info">
                           <thead>
                               <tr>
                                  <th>No</th>
                                  <th>Name</th>
                                  <th>Email</th>
                                  <th>Role</th>
                                  <th>Status</th>
                                  <th>Join Date</th>
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
<script type="text/javascript">
   $(function () {
     
     var table = $('.yajra-datatable').DataTable({
         processing: true,
         serverSide: true,
         ajax: "{{ route('users.list') }}",
         columns: [
             {data: 'DT_RowIndex', name: 'DT_RowIndex'},
             {data: 'username', name: 'username'},
             {data: 'email', name: 'email'},
             {data: 'role', name: 'role'},
             {data: 'status', name: 'status'},
             {data: 'created_date', name: 'created_date'},
             {
                 data: 'action', 
                 name: 'action', 
                 orderable: true, 
                 searchable: true
             },
         ]
     });
     
   });
 </script>
 {{-- </html> --}}
<!-- Wrapper END -->
@endsection
