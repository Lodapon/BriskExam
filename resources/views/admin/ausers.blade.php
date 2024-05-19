@extends('layouts.mainlayout')

@section('content')
<script>
   function finduser() {
       var input, filter, table, tr, td, i, txtValue;
       input = document.getElementById("srh");
       filter = input.value.toUpperCase();
       table = document.getElementById("user-list-table");
       tr = table.getElementsByTagName("tr");
       for (i = 0; i < tr.length; i++) {
         //   if(id==1){
               td = tr[i].getElementsByTagName("td")[2];
         //   }else{
         //       td = tr[i].getElementsByTagName("td")[1];
         //   }
         if (td) {
           txtValue = td.textContent || td.innerText;
           if (txtValue.toUpperCase().indexOf(filter) > -1) {
             tr[i].style.display = "";
           } else {
             tr[i].style.display = "none";
           }
         }       
       }
     }
</script>
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
                         <div class="row justify-content-between">
                            <div class="col-sm-12 col-md-6">
                               <div id="user_list_datatable_info" class="dataTables_filter">
                                  <form class="mr-3 position-relative">
                                     <div class="form-group mb-0">
                                        <input type="search" onkeyup="finduser()" class="form-control" id="srh" placeholder="Search" aria-controls="user-list-table">
                                     </div>
                                  </form>
                               </div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                               {{-- <div class="user-list-files d-flex float-right">
                                  <a href="javascript:void();" class="chat-icon-phone">
                                     Print
                                   </a>
                                  <a href="javascript:void();" class="chat-icon-video">
                                     Excel
                                   </a>
                                   <a href="javascript:void();" class="chat-icon-delete">
                                     Pdf
                                   </a>
                                 </div> --}}
                            </div>
                         </div>
                         <table id="user-list-table" class="table table-striped table-bordered mt-4" role="grid" aria-describedby="user-list-page-info">
                           <thead>
                               <tr>
                                  <th>Profile</th>
                                  <th>Name</th>
                                  <th>Email</th>
                                  <th>Type</th>
                                  <th>Status</th>
                                  <th>Join Date</th>
                                  <th>Action</th>
                               </tr>
                           </thead>
                           <tbody>
                              @foreach ($users as $user)
                               <tr>
                                  <td class="text-center"><img class="rounded-circle img-fluid avatar-40" src="{{'data:'.$user->profile_img_type.';base64,'.base64_encode( $user->profile_img )}}" alt="profile"></td>
                                  <td>{{$user->first_name}} {{$user->last_name}}</td>
                                  <td>{{$user->email}}</td>
                                  <td>{{$user->role_name}}</td>
                                  <td><span class="badge iq-bg-primary">{{$user->status}}</span></td>
                                  <td>{{ \Carbon\Carbon::parse($user->created_date)->format('d/m/Y')}}</td>
                                  <td>
                                     <div class="flex align-items-center list-user-action">
                                        {{-- <a data-toggle="tooltip" data-placement="top" title="" data-original-title="Add" href="#"><i class="ri-user-add-line"></i></a> --}}
                                        <a data-toggle="tooltip" data-placement="top" title="" data-original-title="View" href="#{{$user->account_id}}"><i class="ri-pencil-line"></i></a>
                                        {{-- <a data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" href="#"><i class="ri-delete-bin-line"></i></a> --}}
                                     </div>
                                  </td>
                               </tr> 
                              @endforeach
                               
                           </tbody>
                         </table>
                      </div>
                         {{-- <div class="row justify-content-between mt-3"> --}}
                             {{-- <div id="user-list-page-info" class="col-md-6">
                               <span>Showing 1 to 5 of 5 entries</span>
                            </div> --}}
                            
                               {{-- <nav aria-label="Page navigation example"> --}}
                                
                                  {{-- <ul class="pagination justify-content-end mb-0">
                                     <li class="page-item disabled">
                                        <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                                     </li>
                                     <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                     <li class="page-item"><a class="page-link" href="#">2</a></li>
                                     <li class="page-item"><a class="page-link" href="#">3</a></li>
                                     <li class="page-item">
                                        <a class="page-link" href="#">Next</a>
                                     </li>
                                  </ul> --}}
                               {{-- </nav> --}}
                        <div class="d-flex justify-content-center mt-3">
                           {!! $users->links()!!}
                        </div>
                         {{-- </div> --}}
                   </div>
                </div>
          </div>
       </div>
    </div>
 </div>
</div>
<!-- Wrapper END -->
@endsection
