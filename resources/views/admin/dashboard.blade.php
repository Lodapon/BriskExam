@extends('layouts.mainlayout')

@section('content')
<script>
$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
if ($('#apex-m-user').length) {
  var options = {
      chart: {
          height: 350,
          type: 'bar',
      },
      plotOptions: {
          bar: {
              horizontal: false,
              columnWidth: '55%',
              endingShape: 'rounded'
          },
      },
      dataLabels: {
          enabled: false
      },
      stroke: {
          show: true,
          width: 2,
          colors: ['transparent']
      },
      colors: ['#4F6272'],
      series: [{
          name: 'total',
          enable: 'true',
          data: {!!json_encode($dby)!!}
      }],
      xaxis: {
          categories: {!!json_encode($dbx)!!},
      },
      // yaxis: {
      //     title: {
      //         text: 'Sold'
      //     }
      // },
      fill: {
          opacity: 1

      },
      // tooltip: {
      //     y: {
      //         formatter: function(val) {
      //             return val + " Sold"
      //         }
      //     }
      // }
  }

  var chart = new ApexCharts(
      document.querySelector("#apex-m-user"),
      options
  );

  chart.render();
  }

  if ($('#apex-m-sale').length) {
  var options = {
      series: [{
          name: 'Exam',
          data: {!!json_encode($dxe)!!}
      }, {
          name: 'Book',
          data: {!!json_encode($dxb)!!}
      }],
      colors: ['#f15773', '#4F6272'],
      chart: {
          height: 350,
          type: 'area'
      },
      dataLabels: {
          enabled: false
      },
      stroke: {
          curve: 'smooth'
      },
      xaxis: {
          type: 'datetime',
          categories: {!!json_encode($dyd)!!}
      },
      tooltip: {
          x: {
              format: 'dd/MM/yy'
          },
      },
  };

  var chart = new ApexCharts(document.querySelector("#apex-m-sale"), options);
  chart.render();
}
});

function viewFix(id) {
    $('#id').val(id);
       $('#fixExam').submit();
}
function viewMock(id) {
    $('#mid').val(id);
       $('#mockExam').submit();
}
function approve(type,id,status){
    var txt = "";
    if(status==='A')
    {
        txt ="Approve this Exam!";
    }else{
        txt ="Reject this Exam!";
    }
    Swal.fire({
      title: 'Are you sure?',
      text: txt,
      icon: 'info',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes!'
    }).then((result) => {
      if (result.isConfirmed) {
       $('#etype').val(type);
       $('#eid').val(id);
       $('#estatus').val(status);
       $('#appr').submit();
      }
    })

  }
  function deliver(id){
    var txt = "Clear this Order!";
    Swal.fire({
      title: 'Are you sure?',
      text: txt,
      icon: 'info',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes!'
    }).then((result) => {
      if (result.isConfirmed) {
       $('#hbId').val(id);
       $('#deliver').submit();
      }
    })

  }

  </script>
 <!-- Wrapper Start -->
 <div class="">
    <!-- Sidebar  -->
    <!-- Page Content  -->
    <div id="content-page" class="content-page">
       <div class="container-fluid">
         <div class="row">
            <div class="col-md-6 col-lg-4">
               <div class="iq-card iq-card-block iq-card-stretch iq-card-height overflow-hidden">
                  <div class="iq-card-body">
                     <div class="text-center mb-2">
                     <div class="rounded-circle iq-card-icon iq-bg-primary"><i class="ri-user-line"></i></div></div>
                     <div class="clearfix"></div>
                     <div class="text-center">
                        <h2 class="mb-0"><span class="counter">{{$totalUser}}</h2>
                        <h6 class="mb-2">Registered User</h6>
                        <p class="mb-0 text-secondary line-height"><i class="ri-arrow-up-line text-success mr-1"></i><span class="text-success">{{$userIn[0]->growth_rate}}%</span> Increased</p>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-md-6 col-lg-4">
               <div class="iq-card iq-card-block iq-card-stretch iq-card-height overflow-hidden">
                  <div class="iq-card-body">
                     <div class="text-center mb-2">
                     <div class="rounded-circle iq-card-icon iq-bg-danger"><i class="ri-file-list-3-line"></i></div></div>
                     <div class="clearfix"></div>
                     <div class="text-center">
                        <h2 class="mb-0"><span class="counter">{{$totalExam}}</h2>
                        <h6 class="mb-2">Exams Created</h6>
                        @if($examIn)
                           <p class="mb-0 text-secondary line-height"><i class="ri-arrow-up-line text-success mr-1"></i><span class="text-success">{{$examIn[0]->growth_rate}}%</span> Increased</p>
                         @else
                           <p class="mb-0 text-secondary line-height"><i class="ri-arrow-up-line text-success mr-1"></i><span class="text-success">0.00%</span> Increased</p>
                         @endif
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-md-6 col-lg-4">
               <div class="iq-card iq-card-block iq-card-stretch iq-card-height overflow-hidden">
                  <div class="iq-card-body">
                     <div class="text-center mb-2">
                     <div class="rounded-circle iq-card-icon iq-bg-success"><i class="ri-book-3-line"></i></div></div>
                     <div class="clearfix"></div>
                     <div class="text-center">
                        <h2 class="mb-0"><span class="counter">{{$totalBook}}</span><!-- <span>K</span> --></h2>
                        <h6 class="mb-2">Books in Shelf</h6>
                        @if($bookIn)
                           <p class="mb-0 text-secondary line-height"><i class="ri-arrow-up-line text-success mr-1"></i><span class="text-success">{{$bookIn[0]->growth_rate}}%</span> Increased</p>
                        @else
                           <p class="mb-0 text-secondary line-height"><i class="ri-arrow-up-line text-success mr-1"></i><span class="text-success">0.00%</span> Increased</p>
                        @endif
                        </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="row">
          <div class="col-lg-8">
           <div class="iq-card iq-card-block iq-card-stretch iq-card-height overflow-hidden">
              <div class="iq-card-header d-flex justify-content-between">
                 <div class="iq-header-title">
                    <h4 class="card-title"><i class="fa fa-money"></i>&nbsp;Sales & Income </h4>
                 </div>
              </div>
              <div class="iq-card-body pl-0" style="position: relative;">
                <div id="apex-m-sale"></div>
              <div class="resize-triggers">
                <div class="expand-trigger">
                  <div style="width: 613px; height: 421px;"></div>
                </div>
                <div class="contract-trigger"></div>
              </div>
            </div>
           </div>
          </div>
          <div class="col-md-6 col-lg-4">
           <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
              <div class="iq-card-header d-flex justify-content-between">
                 <div class="iq-header-title">
                    <h4 class="card-title"><i class="fa fa-users"></i>&nbsp;User Type</h4>
                 </div>
              </div>
              <div class="iq-card-body p-0" style="position: relative;">
                <div id="apex-m-user"></div>
              <div class="resize-triggers"><div class="expand-trigger"><div style="width: 292px; height: 416px;"></div></div><div class="contract-trigger"></div></div></div>
           </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
           <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
              <div class="iq-card-header d-flex justify-content-between">
                 <div class="iq-header-title">
                    <h4 class="card-title"><i class="fa fa-user-circle"></i>&nbsp;Latest User</h4>
                 </div>
              </div>
              <div class="iq-card-body pb-0">
                 <div class="table-responsive">
                    <table class="table mb-0 table-borderless">
                       <thead>
                          <tr>
                             <th scope="col">Email</th>
                             <th scope="col">Name</th>
                             <th scope="col">Signup Since</th>
                             <th scope="col">Role</th>
                             <th scope="col"></th>
                          </tr>
                       </thead>
                       <tbody>
                        @foreach ($userLate as $user)
                          <tr>
                             <td>{{$user->email}}</td>
                             <td>{{$user->name}}</td>
                             <td>{{ \Carbon\Carbon::parse($user->created_date)->format('d/m/Y')}}</td>
                             <td>
                               @if ($user->role_name === 'Creator')
                                <div class="badge badge-pill badge-success">
                               @elseif($user->role_name === 'Admin')
                                <div class="badge badge-pill badge-warning text-white">
                               @elseif($user->role_name === 'Graduated')
                                <div class="badge badge-pill badge-danger">
                               @else
                               <div class="badge badge-pill badge-info">
                               @endif
                                {{$user->role_name}}</div>
                             </td>
                             <td>
                              <a href="users/view/{{$user->account_id}}" class="btn btn-light mb-3">View</a>
                             </td>
                          </tr>
                        @endforeach
                       </tbody>
                    </table>
                 </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
           <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
              <div class="iq-card-header d-flex justify-content-between">
                 <div class="iq-header-title">
                    <h4 class="card-title"><i class="fa fa-file"></i>&nbsp;Creator's Content Review</h4>
                 </div>
              </div>
              <div class="iq-card-body pb-0">
                 <div class="table-responsive">
                    <table class="table mb-0 table-borderless">
                       <thead>
                          <tr>
                             <th scope="col">Create by</th>
                             <th scope="col">Exam Name</th>
                             <th scope="col">Price</th>
                             <th scope="col">Problem Num</th>
                             <th scope="col"></th>
                             <th scope="col"></th>
                             <th scope="col"></th>
                          </tr>
                       </thead>
                       <tbody>
                        @foreach ($examApp as $exam)
                          <tr>
                             <td>{{ $exam->name }}</td>
                             <td>{{ $exam->exam_name }} </td>
                             <td>{{ $exam->price }}</td>
                             <td>{{ $exam->choice_total }}</td>
                             <td>
                                @if ($exam->exam_type === 'Fix Exam')
                                <a href="javascript:viewFix( {{ $exam->id }})" class="btn btn-light mb-3">View</a>
                                @else
                                <a href="javascript:viewMock( {{ $exam->id }})" class="btn btn-light mb-3">View</a>
                                @endif
                             </td>
                             <td>
                                <a href="javascript:approve( '{{substr($exam->exam_type,0,1)}}' , {{ $exam->id }},'A')" class="btn btn-success mb-3">Approve</a>
                             </td>
                             <td>
                                <a href="javascript:approve( '{{substr($exam->exam_type,0,1)}}',{{ $exam->id }},'R')" class="btn btn-danger mb-3">Reject</a>
                             </td>
                          </tr>
                        @endforeach
                       </tbody>
                    </table>
                    <form id="fixExam" action="{{route('admin.vf')}}" method="POST">
                        @csrf
                        <input type="hidden" name="id" id="id">
                    </form>
                    <form id="mockExam" action="{{route('admin.vm')}}" method="POST">
                        @csrf
                        <input type="hidden" name="mid" id="mid">
                    </form>
                    <form id="appr" action="{{route('admin.appr')}}" method="POST">
                        @csrf
                        <input type="hidden" name="etype" id="etype">
                        <input type="hidden" name="eid" id="eid">
                        <input type="hidden" name="estatus" id="estatus">
                    </form>
                 </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
           <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
              <div class="iq-card-header d-flex justify-content-between">
                 <div class="iq-header-title">
                    <h4 class="card-title"><i class="fa fa-book"></i>&nbsp;Book Sold</h4>
                 </div>
              </div>
              <div class="iq-card-body pb-0">
                 <div class="table-responsive">
                    <table class="table mb-0 table-borderless">
                       <thead>
                          <tr>
                            <th scope="col">Ordered By</th> <!-- User's name -->
                            <th scope="col">Book's Name</th>
                            <th scope="col">Price</th>
                            <th scope="col">Date Purchased</th>
                            <th scope="col">Delivery Address</th>
                            <th scope="col"></th>
                          </tr>
                       </thead>

                       <tbody>
                        @foreach ($bookApp as $book)
                          <tr>
                            <td>{{ $book->order_by }}</td>

                                    <td> @foreach ($bookDetail as $detail)
                                            @if ($detail->hist_detail_id = $book->hist_detail_id)
                                                {{ $detail->book_name.' ('.$detail->hist_book_amount.')' }}
                                                @if(!$loop->last)
                                                    ,
                                                @endif
                                            @endif
                                        @endforeach
                                    </td>

                            <td>{{ $book->hist_paid }} THB</td>
                            <td>{{ \Carbon\Carbon::parse($book->created_date)->format('d/m/Y')}}</td>
                            <td>{{ $book->hist_sent_addr }} </td>
                            <td>
                              <a href="javascript:deliver( '{{$book->hist_id}}')" class="btn btn-light mb-3">Clear!</a>
                              {{-- <button type="button" class="btn btn-light mb-3">Clear!</button> --}}
                            </td>
                          </tr>
                          @endforeach
                       </tbody>
                    </table>
                 </div>
                 <form id="deliver" action="{{route('admin.deliver')}}" method="POST">
                    @csrf
                    <input type="hidden" name="hbId" id="hbId">
                </form>
              </div>
            </div>
          </div>
        </div>
    </div>
 </div>
 <!-- Wrapper END -->
@endsection
