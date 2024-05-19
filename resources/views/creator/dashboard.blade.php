@extends('layouts.mainlayout')

@section('content')
<script>
  $(function () {

      var table = $('.yajra-datatable').DataTable({
          processing: true,
          serverSide: true,
          ajax: "{{ route('crt.tran') }}",
          columns: [
              {data: 'user_exam', name: 'user_exam'},
              {data: 'user_type', name: 'user_type'},
              {data: 'prod_name', name: 'prod_name'},
              {data: 'created_date', name: 'created_date'},
          ]
      });
    if ($('#apex-m-sold').length) {
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
            yaxis: {
                title: {
                    text: 'Sold'
                }
            },
            fill: {
                opacity: 1

            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return val + " Sold"
                    }
                }
            }
        }

        var chart = new ApexCharts(
            document.querySelector("#apex-m-sold"),
            options
        );

        chart.render();
        }
    });
  </script>
 <!-- Wrapper Start -->
 <div class="">
    <!-- Sidebar  -->
    <!-- Page Content  -->
    <div id="content-page" class="content-page">
       <div class="container-fluid">

        <div class="row">
            <div class="col-md-6 col-lg-3">
               <div class="iq-card iq-card-block iq-card-stretch iq-card-height overflow-hidden">
                  <div class="iq-card-body">
                     <div class="text-center mb-2">
                     <div class="rounded-circle iq-card-icon iq-bg-primary"><i class="ri-download-2-line"></i></div></div>
                     <div class="clearfix"></div>
                     <div class="text-center">
                        <h2 class="mb-0"><span class="counter">{{number_format($totalSold)}}</span></h2>
                        <h6 class="mb-2">Total Sold</h6>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-md-6 col-lg-3">
               <div class="iq-card iq-card-block iq-card-stretch iq-card-height overflow-hidden">
                  <div class="iq-card-body">
                     <div class="text-center mb-2">
                     <div class="rounded-circle iq-card-icon iq-bg-danger"><i class="ri-upload-2-line"></i></div></div>
                     <div class="clearfix"></div>
                     <div class="text-center">
                        <h2 class="mb-0"><span class="counter">{{number_format($osExam)}}</span></h2>
                        <h6 class="mb-2">Onshelf Exam</h6>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-md-6 col-lg-3">
               <div class="iq-card iq-card-block iq-card-stretch iq-card-height overflow-hidden">
                  <div class="iq-card-body">
                     <div class="text-center mb-2">
                     <div class="rounded-circle iq-card-icon iq-bg-info"><i class="ri-wallet-line"></i></div></div>
                     <div class="clearfix"></div>
                     <div class="text-center">
                        <h2 class="mb-0"><span class="counter">{{number_format($mEarn)}}</span></h2>
                        <h6 class="mb-2">This Month Earning</h6>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-md-6 col-lg-3">
               <div class="iq-card iq-card-block iq-card-stretch iq-card-height overflow-hidden">
                  <div class="iq-card-body">
                     <div class="text-center mb-2">
                     <div class="rounded-circle iq-card-icon iq-bg-success"><i class="ri-bit-coin-line"></i></div></div>
                     <div class="clearfix"></div>
                     <div class="text-center">
                        <h2 class="mb-0"><span class="counter">@isset($accBalance)
                            {{number_format($accBalance->balance_amt)}}
                            @endisset</span></h2>
                        <h6 class="mb-2">Credits</h6>
                     </div>
                  </div>
               </div>
            </div>
         </div>

         {{-- <div class="row">
          <div class="col-md-6 col-lg-12">
           <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
              <div class="iq-card-header d-flex justify-content-between">
                 <div class="iq-header-title">
                    <h4 class="card-title"><i class="fa fa-credit-card"></i>&nbsp;Monthly Sold</h4>
                 </div>
              </div>
              <div class="iq-card-body p-0" style="position: relative;">
                 <div id="bar-chart-6" style="min-height: 415px;">
                  <div id="apexcharts8teh3ziv" class="apexcharts-canvas apexcharts8teh3ziv light zoomable" style="width: 291px; height: 400px;">
                    <svg id="SvgjsSvg1438" width="291" height="400" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" class="apexcharts-svg" xmlns:data="ApexChartsNS" transform="translate(0, 0)" style="background-color: transparent; background-position: initial initial; background-repeat: initial initial;">
                      <foreignObject x="0" y="0" width="291" height="400">
                        <div class="apexcharts-legend center position-bottom" xmlns="http://www.w3.org/1999/xhtml" style="right: 0px; position: absolute; left: 0px; top: auto; bottom: 10px;">
                          <div class="apexcharts-legend-series" rel="1" data:collapsed="false" style="margin: 0px 5px;">
                            <span class="apexcharts-legend-marker" rel="1" data:collapsed="false" style="background-color: rgb(241, 87, 115); color: rgb(241, 87, 115); height: 12px; width: 12px; left: 0px; top: 0px; border-width: 0px; border-color: rgb(255, 255, 255); border-top-left-radius: 2px; border-top-right-radius: 2px; border-bottom-right-radius: 2px; border-bottom-left-radius: 2px; background-position: initial initial; background-repeat: initial initial;">

                            </span>
                            <span class="apexcharts-legend-text" rel="1" i="0" data:default-text="Mobile" data:collapsed="false" style="color: rgb(55, 61, 63); font-size: 12px; font-family: Helvetica, Arial, sans-serif;">Mobile
                            </span>
                          </div>
                          <div class="apexcharts-legend-series" rel="2" data:collapsed="false" style="margin: 0px 5px;">
                            <span class="apexcharts-legend-marker" rel="2" data:collapsed="false" style="background-color: rgb(79, 98, 114); color: rgb(79, 98, 114); height: 12px; width: 12px; left: 0px; top: 0px; border-width: 0px; border-color: rgb(255, 255, 255); border-top-left-radius: 2px; border-top-right-radius: 2px; border-bottom-right-radius: 2px; border-bottom-left-radius: 2px; background-position: initial initial; background-repeat: initial initial;">
                              /span><span class="apexcharts-legend-text" rel="2" i="1" data:default-text="Desktop" data:collapsed="false" style="color: rgb(55, 61, 63); font-size: 12px; font-family: Helvetica, Arial, sans-serif;">Desktop
                              </span>
                            </div>
                          </div>
                          <style type="text/css">

                            .apexcharts-legend {
                            display: flex;
                            overflow: auto;
                            padding: 0 10px;
                            }
                            .apexcharts-legend.position-bottom, .apexcharts-legend.position-top {
                            flex-wrap: wrap
                            }
                            .apexcharts-legend.position-right, .apexcharts-legend.position-left {
                            flex-direction: column;
                            bottom: 0;
                            }
                            .apexcharts-legend.position-bottom.left, .apexcharts-legend.position-top.left, .apexcharts-legend.position-right, .apexcharts-legend.position-left {
                            justify-content: flex-start;
                            }
                            .apexcharts-legend.position-bottom.center, .apexcharts-legend.position-top.center {
                            justify-content: center;
                            }
                            .apexcharts-legend.position-bottom.right, .apexcharts-legend.position-top.right {
                            justify-content: flex-end;
                            }
                            .apexcharts-legend-series {
                            cursor: pointer;
                            line-height: normal;
                            }
                            .apexcharts-legend.position-bottom .apexcharts-legend-series, .apexcharts-legend.position-top .apexcharts-legend-series{
                            display: flex;
                            align-items: center;
                            }
                            .apexcharts-legend-text {
                            position: relative;
                            font-size: 14px;
                            }
                            .apexcharts-legend-text *, .apexcharts-legend-marker * {
                            pointer-events: none;
                            }
                            .apexcharts-legend-marker {
                            position: relative;
                            display: inline-block;
                            cursor: pointer;
                            margin-right: 3px;
                            }

                            .apexcharts-legend.right .apexcharts-legend-series, .apexcharts-legend.left .apexcharts-legend-series{
                            display: inline-block;
                            }
                            .apexcharts-legend-series.no-click {
                            cursor: auto;
                            }
                            .apexcharts-legend .apexcharts-hidden-zero-series, .apexcharts-legend .apexcharts-hidden-null-series {
                            display: none !important;
                            }
                            .inactive-legend {
                            opacity: 0.45;
                            }
                          </style>
                        </foreignObject>
                        <g id="SvgjsG1440" class="apexcharts-inner apexcharts-graphical" transform="translate(55.359375, 40)">
                          <defs id="SvgjsDefs1439">
                            <linearGradient id="SvgjsLinearGradient1443" x1="0" y1="0" x2="0" y2="1">
                              <stop id="SvgjsStop1444" stop-opacity="0.4" stop-color="rgba(216,227,240,0.4)" offset="0">
                              </stop>
                              <stop id="SvgjsStop1445" stop-opacity="0.5" stop-color="rgba(190,209,230,0.5)" offset="1">
                              </stop>
                              <stop id="SvgjsStop1446" stop-opacity="0.5" stop-color="rgba(190,209,230,0.5)" offset="1">
                              </stop>
                            </linearGradient>
                            <clipPath id="gridRectMask8teh3ziv">
                              <rect id="SvgjsRect1448" width="230.640625" height="308.32271875" x="-2.5" y="-2.5" rx="0" ry="0" fill="#ffffff" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0">
                              </rect>
                            </clipPath>
                            <clipPath id="gridRectMarkerMask8teh3ziv">
                              <rect id="SvgjsRect1449" width="227.640625" height="305.32271875" x="-1" y="-1" rx="0" ry="0" fill="#ffffff" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0">
                              </rect>
                            </clipPath>
                          </defs>
                          <rect id="SvgjsRect1447" width="6.860694679054054" height="303.32271875" x="0" y="0" rx="0" ry="0" fill="url(#SvgjsLinearGradient1443)" opacity="1" stroke-width="0" stroke-dasharray="3" class="apexcharts-xcrosshairs" y2="303.32271875" filter="none" fill-opacity="0.9">
                          </rect>
                          <g id="SvgjsG1466" class="apexcharts-xaxis" transform="translate(0, 0)">
                            <g id="SvgjsG1467" class="apexcharts-xaxis-texts-g" transform="translate(0, -4)">
                              <text id="SvgjsText1468" font-family="Helvetica, Arial, sans-serif" x="0" y="332.32271875" text-anchor="middle" dominant-baseline="auto" font-size="12px" font-weight="400" fill="#373d3f" class="apexcharts-xaxis-label " style="font-family: Helvetica, Arial, sans-serif;">
                                <tspan id="SvgjsTspan1469" style="font-family: Helvetica, Arial, sans-serif;">1</tspan>
                                <title>1</title>
                              </text>
                              <text id="SvgjsText1470" font-family="Helvetica, Arial, sans-serif" x="112.8203125" y="332.32271875" text-anchor="middle" dominant-baseline="auto" font-size="12px" font-weight="400" fill="#373d3f" class="apexcharts-xaxis-label " style="font-family: Helvetica, Arial, sans-serif;">
                                <tspan id="SvgjsTspan1471" style="font-family: Helvetica, Arial, sans-serif;">3
                                </tspan>
                                <title>3</title>
                              </text>
                              <text id="SvgjsText1472" font-family="Helvetica, Arial, sans-serif" x="225.640625" y="332.32271875" text-anchor="middle" dominant-baseline="auto" font-size="12px" font-weight="400" fill="#373d3f" class="apexcharts-xaxis-label " style="font-family: Helvetica, Arial, sans-serif;">
                                <tspan id="SvgjsTspan1473" style="font-family: Helvetica, Arial, sans-serif;">6
                                </tspan>
                                <title>6</title>
                              </text>
                            </g>
                            <line id="SvgjsLine1474" x1="-15" y1="304.32271875" x2="225.640625" y2="304.32271875" stroke="#78909c" stroke-dasharray="0" stroke-width="1"></line>
                          </g>
                          <g id="SvgjsG1482" class="apexcharts-grid">
                            <g id="SvgjsG1483" class="apexcharts-gridlines-horizontal">
                              <line id="SvgjsLine1486" x1="0" y1="0" x2="225.640625" y2="0" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line>
                              <line id="SvgjsLine1487" x1="0" y1="75.8306796875" x2="225.640625" y2="75.8306796875" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line>
                              <line id="SvgjsLine1488" x1="0" y1="151.661359375" x2="225.640625" y2="151.661359375" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line>
                              <line id="SvgjsLine1489" x1="0" y1="227.4920390625" x2="225.640625" y2="227.4920390625" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line>
                              <line id="SvgjsLine1490" x1="0" y1="303.32271875" x2="225.640625" y2="303.32271875" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line>
                            </g>
                            <g id="SvgjsG1484" class="apexcharts-gridlines-vertical"></g>
                            <line id="SvgjsLine1485" x1="112.8203125" y1="304.32271875" x2="112.8203125" y2="310.32271875" stroke="#78909c" stroke-dasharray="0" class="apexcharts-xaxis-tick"></line>
                            <line id="SvgjsLine1492" x1="0" y1="303.32271875" x2="225.640625" y2="303.32271875" stroke="transparent" stroke-dasharray="0"></line>
                            <line id="SvgjsLine1491" x1="0" y1="1" x2="0" y2="303.32271875" stroke="transparent" stroke-dasharray="0"></line>
                          </g>
                          <g id="SvgjsG1451" class="apexcharts-bar-series apexcharts-plot-series">
                            <g id="SvgjsG1452" class="apexcharts-series" rel="1" seriesName="Mobile" data:realIndex="0">
                              <path id="SvgjsPath1454" d="M 14.864838471283782 303.32271875L 14.864838471283782 193.81956221143017Q 18.29518581081081 190.38921487190314 21.72553315033784 193.81956221143017L 21.72553315033784 303.32271875L 14.864838471283782 303.32271875" fill="rgba(241,87,115,1)" fill-opacity="1" stroke-opacity="1" stroke-linecap="butt" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMask8teh3ziv)" pathTo="M 14.864838471283782 303.32271875L 14.864838471283782 193.81956221143017Q 18.29518581081081 190.38921487190314 21.72553315033784 193.81956221143017L 21.72553315033784 303.32271875L 14.864838471283782 303.32271875" pathFrom="M 14.864838471283782 303.32271875L 14.864838471283782 303.32271875L 21.72553315033784 303.32271875L 21.72553315033784 303.32271875L 14.864838471283782 303.32271875" cy="192.10438854166665" cx="19.22553315033784" j="0" val="44" barHeight="111.21833020833333" barWidth="6.860694679054054"></path>
                              <path id="SvgjsPath1455" d="M 60.6028029983108 303.32271875L 60.6028029983108 77.54585335726352Q 64.03315033783782 74.1155060177365 67.46349767736486 77.54585335726352L 67.46349767736486 303.32271875L 60.6028029983108 303.32271875" fill="rgba(241,87,115,1)" fill-opacity="1" stroke-opacity="1" stroke-linecap="butt" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMask8teh3ziv)" pathTo="M 60.6028029983108 303.32271875L 60.6028029983108 77.54585335726352Q 64.03315033783782 74.1155060177365 67.46349767736486 77.54585335726352L 67.46349767736486 303.32271875L 60.6028029983108 303.32271875" pathFrom="M 60.6028029983108 303.32271875L 60.6028029983108 303.32271875L 67.46349767736486 303.32271875L 67.46349767736486 303.32271875L 60.6028029983108 303.32271875" cy="75.83067968750001" cx="64.96349767736486" j="1" val="90" barHeight="227.49203906249997" barWidth="6.860694679054054"></path>
                              <path id="SvgjsPath1456" d="M 106.34076752533782 303.32271875L 106.34076752533782 77.54585335726352Q 109.77111486486486 74.1155060177365 113.20146220439187 77.54585335726352L 113.20146220439187 303.32271875L 106.34076752533782 303.32271875" fill="rgba(241,87,115,1)" fill-opacity="1" stroke-opacity="1" stroke-linecap="butt" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMask8teh3ziv)" pathTo="M 106.34076752533782 303.32271875L 106.34076752533782 77.54585335726352Q 109.77111486486486 74.1155060177365 113.20146220439187 77.54585335726352L 113.20146220439187 303.32271875L 106.34076752533782 303.32271875" pathFrom="M 106.34076752533782 303.32271875L 106.34076752533782 303.32271875L 113.20146220439187 303.32271875L 113.20146220439187 303.32271875L 106.34076752533782 303.32271875" cy="75.83067968750001" cx="110.70146220439187" j="2" val="90" barHeight="227.49203906249997" barWidth="6.860694679054054"></path>
                              <path id="SvgjsPath1457" d="M 152.07873205236484 303.32271875L 152.07873205236484 153.3765330447635Q 155.50907939189187 149.94618570523647 158.9394267314189 153.3765330447635L 158.9394267314189 303.32271875L 152.07873205236484 303.32271875" fill="rgba(241,87,115,1)" fill-opacity="1" stroke-opacity="1" stroke-linecap="butt" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMask8teh3ziv)" pathTo="M 152.07873205236484 303.32271875L 152.07873205236484 153.3765330447635Q 155.50907939189187 149.94618570523647 158.9394267314189 153.3765330447635L 158.9394267314189 303.32271875L 152.07873205236484 303.32271875" pathFrom="M 152.07873205236484 303.32271875L 152.07873205236484 303.32271875L 158.9394267314189 303.32271875L 158.9394267314189 303.32271875L 152.07873205236484 303.32271875" cy="151.661359375" cx="156.4394267314189" j="3" val="60" barHeight="151.661359375" barWidth="6.860694679054054"></path>
                              <path id="SvgjsPath1458" d="M 197.8166965793919 303.32271875L 197.8166965793919 14.353620284346873Q 201.24704391891893 10.923272944819846 204.67739125844597 14.353620284346873L 204.67739125844597 303.32271875L 197.8166965793919 303.32271875" fill="rgba(241,87,115,1)" fill-opacity="1" stroke-opacity="1" stroke-linecap="butt" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMask8teh3ziv)" pathTo="M 197.8166965793919 303.32271875L 197.8166965793919 14.353620284346873Q 201.24704391891893 10.923272944819846 204.67739125844597 14.353620284346873L 204.67739125844597 303.32271875L 197.8166965793919 303.32271875" pathFrom="M 197.8166965793919 303.32271875L 197.8166965793919 303.32271875L 204.67739125844597 303.32271875L 204.67739125844597 303.32271875L 197.8166965793919 303.32271875" cy="12.638446614583358" cx="202.17739125844597" j="4" val="115" barHeight="290.6842721354166" barWidth="6.860694679054054"></path>
                              <g id="SvgjsG1453" class="apexcharts-datalabels"></g>
                            </g>
                            <g id="SvgjsG1459" class="apexcharts-series" rel="2" seriesName="Desktop" data:realIndex="1">
                              <path id="SvgjsPath1461" d="M 21.72553315033784 303.32271875L 21.72553315033784 216.56876611768016Q 25.155880489864867 213.13841877815312 28.586227829391895 216.56876611768016L 28.586227829391895 303.32271875L 21.72553315033784 303.32271875" fill="rgba(79,98,114,1)" fill-opacity="1" stroke-opacity="1" stroke-linecap="butt" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="1" clip-path="url(#gridRectMask8teh3ziv)" pathTo="M 21.72553315033784 303.32271875L 21.72553315033784 216.56876611768016Q 25.155880489864867 213.13841877815312 28.586227829391895 216.56876611768016L 28.586227829391895 303.32271875L 21.72553315033784 303.32271875" pathFrom="M 21.72553315033784 303.32271875L 21.72553315033784 303.32271875L 28.586227829391895 303.32271875L 28.586227829391895 303.32271875L 21.72553315033784 303.32271875" cy="214.85359244791664" cx="26.08622782939189" j="0" val="35" barHeight="88.46912630208332" barWidth="6.860694679054054"></path>
                              <path id="SvgjsPath1462" d="M 67.46349767736486 303.32271875L 67.46349767736486 102.82274658643018Q 70.89384501689189 99.39239924690315 74.3241923564189 102.82274658643018L 74.3241923564189 303.32271875L 67.46349767736486 303.32271875" fill="rgba(79,98,114,1)" fill-opacity="1" stroke-opacity="1" stroke-linecap="butt" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="1" clip-path="url(#gridRectMask8teh3ziv)" pathTo="M 67.46349767736486 303.32271875L 67.46349767736486 102.82274658643018Q 70.89384501689189 99.39239924690315 74.3241923564189 102.82274658643018L 74.3241923564189 303.32271875L 67.46349767736486 303.32271875" pathFrom="M 67.46349767736486 303.32271875L 67.46349767736486 303.32271875L 74.3241923564189 303.32271875L 74.3241923564189 303.32271875L 67.46349767736486 303.32271875" cy="101.10757291666667" cx="71.8241923564189" j="1" val="80" barHeight="202.2151458333333" barWidth="6.860694679054054"></path>
                              <path id="SvgjsPath1463" d="M 113.20146220439187 303.32271875L 113.20146220439187 52.268960128096865Q 116.6318095439189 48.83861278856984 120.06215688344592 52.268960128096865L 120.06215688344592 303.32271875L 113.20146220439187 303.32271875" fill="rgba(79,98,114,1)" fill-opacity="1" stroke-opacity="1" stroke-linecap="butt" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="1" clip-path="url(#gridRectMask8teh3ziv)" pathTo="M 113.20146220439187 303.32271875L 113.20146220439187 52.268960128096865Q 116.6318095439189 48.83861278856984 120.06215688344592 52.268960128096865L 120.06215688344592 303.32271875L 113.20146220439187 303.32271875" pathFrom="M 113.20146220439187 303.32271875L 113.20146220439187 303.32271875L 120.06215688344592 303.32271875L 120.06215688344592 303.32271875L 113.20146220439187 303.32271875" cy="50.55378645833335" cx="117.56215688344594" j="2" val="100" barHeight="252.76893229166663" barWidth="6.860694679054054"></path>
                              <path id="SvgjsPath1464" d="M 158.9394267314189 303.32271875L 158.9394267314189 128.09963981559684Q 162.36977407094594 124.66929247606981 165.80012141047297 128.09963981559684L 165.80012141047297 303.32271875L 158.9394267314189 303.32271875" fill="rgba(79,98,114,1)" fill-opacity="1" stroke-opacity="1" stroke-linecap="butt" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="1" clip-path="url(#gridRectMask8teh3ziv)" pathTo="M 158.9394267314189 303.32271875L 158.9394267314189 128.09963981559684Q 162.36977407094594 124.66929247606981 165.80012141047297 128.09963981559684L 165.80012141047297 303.32271875L 158.9394267314189 303.32271875" pathFrom="M 158.9394267314189 303.32271875L 158.9394267314189 303.32271875L 165.80012141047297 303.32271875L 165.80012141047297 303.32271875L 158.9394267314189 303.32271875" cy="126.38446614583333" cx="163.30012141047294" j="3" val="70" barHeight="176.93825260416665" barWidth="6.860694679054054"></path>
                              <path id="SvgjsPath1465" d="M 204.67739125844597 303.32271875L 204.67739125844597 64.9074067426802Q 208.107738597973 61.47705940315317 211.53808593750003 64.9074067426802L 211.53808593750003 303.32271875L 204.67739125844597 303.32271875" fill="rgba(79,98,114,1)" fill-opacity="1" stroke-opacity="1" stroke-linecap="butt" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="1" clip-path="url(#gridRectMask8teh3ziv)" pathTo="M 204.67739125844597 303.32271875L 204.67739125844597 64.9074067426802Q 208.107738597973 61.47705940315317 211.53808593750003 64.9074067426802L 211.53808593750003 303.32271875L 204.67739125844597 303.32271875" pathFrom="M 204.67739125844597 303.32271875L 204.67739125844597 303.32271875L 211.53808593750003 303.32271875L 211.53808593750003 303.32271875L 204.67739125844597 303.32271875" cy="63.19223307291668" cx="209.0380859375" j="4" val="95" barHeight="240.1304856770833" barWidth="6.860694679054054"></path>
                              <g id="SvgjsG1460" class="apexcharts-datalabels"></g>
                            </g>
                          </g>
                          <line id="SvgjsLine1493" x1="0" y1="0" x2="225.640625" y2="0" stroke="#b6b6b6" stroke-dasharray="0" stroke-width="1" class="apexcharts-ycrosshairs"></line>
                          <line id="SvgjsLine1494" x1="0" y1="0" x2="225.640625" y2="0" stroke-dasharray="0" stroke-width="0" class="apexcharts-ycrosshairs-hidden"></line>
                          <g id="SvgjsG1495" class="apexcharts-yaxis-annotations"></g>
                          <g id="SvgjsG1496" class="apexcharts-xaxis-annotations"></g>
                          <g id="SvgjsG1497" class="apexcharts-point-annotations"></g>
                          <rect id="SvgjsRect1498" width="0" height="0" x="0" y="0" rx="0" ry="0" fill="#fefefe" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" class="apexcharts-zoom-rect"></rect>
                          <rect id="SvgjsRect1499" width="0" height="0" x="0" y="0" rx="0" ry="0" fill="#fefefe" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" class="apexcharts-selection-rect"></rect>
                        </g>
                        <g id="SvgjsG1475" class="apexcharts-yaxis" rel="0" transform="translate(22.359375, 0)"><g id="SvgjsG1476" class="apexcharts-yaxis-texts-g">
                          <text id="SvgjsText1477" font-family="Helvetica, Arial, sans-serif" x="20" y="41.4" text-anchor="end" dominant-baseline="auto" font-size="11px" font-weight="regular" fill="#373d3f" class="apexcharts-yaxis-label " style="font-family: Helvetica, Arial, sans-serif;">120</text>
                          <text id="SvgjsText1478" font-family="Helvetica, Arial, sans-serif" x="20" y="117.3306796875" text-anchor="end" dominant-baseline="auto" font-size="11px" font-weight="regular" fill="#373d3f" class="apexcharts-yaxis-label " style="font-family: Helvetica, Arial, sans-serif;">90</text>
                          <text id="SvgjsText1479" font-family="Helvetica, Arial, sans-serif" x="20" y="193.26135937499998" text-anchor="end" dominant-baseline="auto" font-size="11px" font-weight="regular" fill="#373d3f" class="apexcharts-yaxis-label " style="font-family: Helvetica, Arial, sans-serif;">60</text>
                          <text id="SvgjsText1480" font-family="Helvetica, Arial, sans-serif" x="20" y="269.19203906249993" text-anchor="end" dominant-baseline="auto" font-size="11px" font-weight="regular" fill="#373d3f" class="apexcharts-yaxis-label " style="font-family: Helvetica, Arial, sans-serif;">30</text>
                          <text id="SvgjsText1481" font-family="Helvetica, Arial, sans-serif" x="20" y="345.12271874999993" text-anchor="end" dominant-baseline="auto" font-size="11px" font-weight="regular" fill="#373d3f" class="apexcharts-yaxis-label " style="font-family: Helvetica, Arial, sans-serif;">0</text>
                        </g>
                      </g>
                    </svg>
                    <div class="apexcharts-tooltip light">
                      <div class="apexcharts-tooltip-title" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"></div>
                      <div class="apexcharts-tooltip-series-group">
                        <span class="apexcharts-tooltip-marker" style="background-color: rgb(241, 87, 115);"></span>
                        <div class="apexcharts-tooltip-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;">
                          <div class="apexcharts-tooltip-y-group">
                            <span class="apexcharts-tooltip-text-label"></span>
                            <span class="apexcharts-tooltip-text-value"></span>
                          </div>
                          <div class="apexcharts-tooltip-z-group">
                            <span class="apexcharts-tooltip-text-z-label"></span>
                            <span class="apexcharts-tooltip-text-z-value"></span>
                          </div>
                        </div>
                      </div>
                      <div class="apexcharts-tooltip-series-group">
                        <span class="apexcharts-tooltip-marker" style="background-color: rgb(79, 98, 114);"></span>
                        <div class="apexcharts-tooltip-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;">
                          <div class="apexcharts-tooltip-y-group">
                            <span class="apexcharts-tooltip-text-label"></span>
                            <span class="apexcharts-tooltip-text-value"></span>
                          </div>
                          <div class="apexcharts-tooltip-z-group">
                            <span class="apexcharts-tooltip-text-z-label"></span>
                            <span class="apexcharts-tooltip-text-z-value"></span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              <div class="resize-triggers"><div class="expand-trigger"><div style="width: 292px; height: 416px;"></div></div><div class="contract-trigger"></div></div></div>
           </div>
          </div>
        </div> --}}

        <div class="row">
            <div class="col-md-6 col-lg-12">
             <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                <div class="iq-card-header d-flex justify-content-between">
                   <div class="iq-header-title">
                      <h4 class="card-title"><i class="fa fa-credit-card"></i>&nbsp;Monthly Sold</h4>
                   </div>
                </div>
                <div class="iq-card-body">
                  <div id="apex-m-sold"></div>
               </div>
             </div>
            </div>
        </div>

        <div class="row">
          <div class="col-sm-12">
                <div class="iq-card">
                   <div class="iq-card-header d-flex justify-content-between">
                      <div class="iq-header-title">
                         <h4 class="card-title"><i class="fa fa-check-square"></i>&nbsp;Latest Transaction</h4>
                      </div>
                   </div>
                   <div class="iq-card-body">
                      <div class="table-responsive">
                         <table class="table table-striped table-bordered mt-4 yajra-datatable" role="grid" aria-describedby="user-list-page-info">
                           <thead>
                               <tr>
                                  <th>Name</th>
                                  <th>User Type</th>
                                  <th>Product Sold</th>
                                  <th>Date</th>
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
                          <!-- <tr>
                             <th scope="col">Create by</th>
                             <th scope="col">Price</th>
                             <th scope="col">Problem Num</th>
                             <th scope="col"></th>
                             <th scope="col"></th>
                             <th scope="col"></th>
                          </tr> -->
                       </thead>
                       <tbody>
                        @foreach ($inproc as $item)
                          <tr>
                             <td>{{$item->ex_name}}</td>
                             <td>{{ \Carbon\Carbon::parse($item->created_date)->format('d/m/Y')}}</td>
                             <td>
                                 @if ($item->ex_status == 'A')
                                 <p class="text-success">Approved</p>
                                 @elseif($item->ex_status =='R')
                                 <p class="text-danger">Rejected</p>
                                 @else
                                 <p class="text-secondary">Waiting for Approval</p>
                                 @endif

                             </td>
                             <!-- <td>
                                <button type="button" class="btn btn-success mb-3">Approve</button>
                             </td>
                             <td>
                               <button type="button" class="btn btn-danger mb-3">Reject</button>
                             </td> -->
                          </tr>
                          @endforeach
                          {{-- <tr>
                             <td>ฟิสิกส์ ม.4 การเคลื่อนที่เส้นตรง</td>
                             <td>30/12/2019</td>
                             <td>

                             </td>
                              <td>
                                <button type="button" class="btn btn-success mb-3">Approve</button>
                             </td>
                             <td>
                               <button type="button" class="btn btn-danger mb-3">Reject</button>
                             </td>
                          </tr>
                          <tr>
                             <td>ฟิสิกส์ ม.5 คลื่น</td>
                             <td>30/12/2019</td>
                             <td>

                             </td>
                             <td>
                                <button type="button" class="btn btn-success mb-3">Approve</button>
                             </td>
                             <td>
                               <button type="button" class="btn btn-danger mb-3">Reject</button>
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
 <!-- Wrapper END -->
@endsection
