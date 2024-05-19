@extends('layouts.mainlayout')

@section('content')
<script>
  function resume(exId,feId){
    Swal.fire({
      title: 'Are you sure?',
      text: "Resume this test!",
      icon: 'info',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes!'
    }).then((result) => {
      if (result.isConfirmed) {
       $('#exid').val(exId);
       $('#feid').val(feId);
       $('#resume').submit();
      }
    })

  }

  $(function () {

    var table = $('.yajra-datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('std.exhist') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'ex_name', name: 'ex_name'},
            {data: 'created_date', name: 'created_date'},
            {data: 'updated_date', name: 'updated_date'},
            {data: 'total_time', name: 'total_time'},
            {data: 'ex_point', name: 'ex_point'},
            {data: 'ex_dev_point', name: 'ex_dev_point'},
            {data: 'action', name: 'action'},
        ]
    });
  if ($('#apex-reshist').length) {
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
              name: 'Exam',
              data: {!!json_encode($dby)!!}
          }],
          xaxis: {
              categories: {!!json_encode($dbx)!!},
          },
          yaxis: {
              title: {
                  text: 'Points'
              }
          },
          fill: {
              opacity: 1

          },
          tooltip: {
              y: {
                  formatter: function(val) {
                      return val + " Points"
                  }
              }
          }
      }

      var chart = new ApexCharts(
          document.querySelector("#apex-reshist"),
          options
      );

      chart.render();
      }
  });
  function viewFix(id,exId) {
    $('#id').val(id);
    $('#eid').val(exId);
       $('#fixExam').submit();
  }
  function viewMock(id,exId) {
      $('#mid').val(id);
      $('#xid').val(exId);
        $('#mockExam').submit();
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
                     <div class="rounded-circle iq-card-icon iq-bg-primary"><i class="ri-file-list-3-line"></i></div></div>
                     <div class="clearfix"></div>
                     <div class="text-center">
                        <h2 class="mb-0"><span class="counter">{{$lastExam}}</span></h2>
                        <h6 class="mb-2">Recently Exam</h6>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-md-6 col-lg-4">
               <div class="iq-card iq-card-block iq-card-stretch iq-card-height overflow-hidden">
                  <div class="iq-card-body">
                     <div class="text-center mb-2">
                     <div class="rounded-circle iq-card-icon iq-bg-danger"><i class="ri-folder-2-line"></i></div></div>
                     <div class="clearfix"></div>
                     <div class="text-center">
                        <h2 class="mb-0"><span class="counter">{{number_format($utExam)}}</span></h2>
                        <h6 class="mb-2">Total Exam</h6>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-md-6 col-lg-4">
               <div class="iq-card iq-card-block iq-card-stretch iq-card-height overflow-hidden">
                  <div class="iq-card-body">
                     <div class="text-center mb-2">
                     <div class="rounded-circle iq-card-icon iq-bg-success"><i class="ri-bit-coin-line"></i></div></div>
                     <div class="clearfix"></div>
                     <div class="text-center">
                        <h2 class="mb-0"><span class="counter">{{number_format($accBalance->balance_amt)}}</span></h2>
                        <h6 class="mb-2">Account Balance</h6>
                     </div>
                  </div>
               </div>
            </div>
         </div>


        <div class="row">
          <div class="col-md-6 col-lg-12">
           <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
              <div class="iq-card-header d-flex justify-content-between">
                 <div class="iq-header-title">
                    <h4 class="card-title"><i class="fa fa-area-chart"></i>&nbsp;Result History</h4>
                 </div>
              </div>
              <div class="iq-card-body">
                <div id="apex-reshist"></div>
             </div>
           </div>
          </div>
        </div>


        <div class="row">
          <div class="col-sm-12">
                <div class="iq-card">
                   <div class="iq-card-header d-flex justify-content-between">
                      <div class="iq-header-title">
                         <h4 class="card-title"><i class="fa fa-check-square"></i>&nbsp;Exam History</h4>
                      </div>
                   </div>
                   <div class="iq-card-body">
                      <div class="table-responsive">
                         <table class="table table-striped table-bordered mt-4 yajra-datatable" role="grid" aria-describedby="user-list-page-info">
                           <thead>
                               <tr>
                                  <th>No</th>
                                  <th>Exam</th>
                                  <th>Test Start Date</th>
                                  <th>Finish Date</th>
                                  <th>Total Time</th>
                                  <th>Score</th>
                                  <th>Remark</th>
                                  <th>Solution</th>
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

        <div class="row">
          <div class="col-lg-12">
           <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
              <div class="iq-card-header d-flex justify-content-between">
                 <div class="iq-header-title">
                    <h4 class="card-title"><i class="fa fa-spinner"></i>&nbsp;In Progress</h4>
                 </div>
              </div>
              <div class="iq-card-body pb-0">
                 <div class="table-responsive">
                    <table class="table mb-0 table-borderless">
                       <thead>
                       </thead>
                       <tbody>
                        @foreach ($inproc as $item)
                          <tr>
                             <td>{{$item->ex_name}}</td>
                             <td>{{$item->total_time}}</td>
                             <td>{{ \Carbon\Carbon::parse($item->created_date)->format('d/m/Y')}}</td>
                             <td>
                                <button type="button" class="btn btn-light mb-3" onclick="resume({{$item->ex_id}},{{$item->fe_id}})">Resume</button>
                             </td>
                          
                          </tr>
                        @endforeach
                       
                       </tbody>
                    </table>
                    <form id="resume" action="{{route('std.resume')}}" method="POST">
                        @csrf
                        <input type="hidden" name="exid" id="exid">
                        <input type="hidden" name="feid" id="feid">
                    </form>
                    <form id="fixExam" action="{{route('std.vf')}}" method="POST">
                      @csrf
                      <input type="hidden" name="eid" id="eid">
                      <input type="hidden" name="id" id="id">
                  </form>
                  <form id="mockExam" action="{{route('std.vm')}}" method="POST">
                      @csrf
                      <input type="hidden" name="xid" id="xid">
                      <input type="hidden" name="mid" id="mid">
                  </form>
                 </div>
              </div>
            </div>
          </div>
        </div>
    </div>
 </div>
 <!-- Wrapper END -->
@endsection
