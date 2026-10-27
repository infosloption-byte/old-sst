@extends('master.master')

@section('css')
<link rel="stylesheet" href="{{('assets/admin_panel/dist/morrisjs/morris.min.css')}}" />
<style type="text/css">
    
    .excercise{
        background: #FCFDFA !important;
    }
    .hydrated{
        background: #F6F2FF !important;
    }
    .breakfast{
        background: #47DD9C !important;
    }

    input.largerCheckbox
    {
        width: 30px;
        height: 30px;
    }
 

</style>
@stop


@section('content')
<div ng-app="ngApp" ng-controller="DashboardController" ng-init="loadData()">

    <div class="block-header">
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-12">
                <h2>
                    <a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth">
                    <i class="fa fa-arrow-left"></i></a> Dashboard
                </h2>
                
            </div>            
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="row">
                    <div class="col-md-12">
                        <ul class="breadcrumb float-right">
                            <li style="display: inline;" class="breadcrumb-item"><a href="index.html"><i class="icon-home"></i></a></li>                           
                            <li style="display: inline;" class="breadcrumb-item">Dashboard</li>
                        </ul>                       
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
<script src="{{asset('assets/admin_panel/bundles/morrisscripts.bundle.js')}}"></script><!-- Morris Plugin Js -->
<script src="{{asset('assets/admin_panel/bundles/knob.bundle.js')}}"></script> <!-- Jquery Knob-->
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.3.0/dist/chart.min.js"></script> <!-- Jquery Knob-->

<script type="text/javascript">

    $(document).ready(function()
    {
        
    });

    var app = angular.module("ngApp",['angularMoment','dualmultiselect','angularImgFallback','ui.bootstrap','ngSanitize','bw.paging']);


    app.config(['$tooltipProvider', function ($tooltipProvider) {
        $tooltipProvider.options({
            appendToBody: true, // 
            appendToBody: true, // 
            placement:'bottom' // Set Default Placement
        });
    }]);

    //controller
    app.controller("DashboardController", function($scope,$http)
    {
        $scope.job_data = [];
        $scope.job_chart_data = [];
        
        $scope.task_data = [];
        $scope.task_chart_data = [];

        $scope.cost_chart_data = [];
        $scope.cost_type_chart_data = [];

        $scope.current = 0;
        $scope.last_3 = 0;
        $scope.last_6 = 0;
        $scope.last_12 = 0;

        $scope.loadData = function()
        {
            $scope.loadJobData();
            $scope.loadTaskData();
            $scope.loadCostData();
            $scope.loadCostTypeData();
        }

        $scope.loadJobData = function()
        {
            $.ajax({
                url: "{{url('admin/jobSumeryJson')}}",
                type: 'GET',
                success: function (data) {
                    $scope.job_data = data.json;
                    $scope.job_chart_data = data.chart;
                    $scope.$apply();

                    Morris.Bar({
                        element: 'job_m_bar_chart',
                        data: $scope.job_chart_data,
                        xkey: 'a',
                        ykeys: ['b', 'c', 'd'],
                        labels: ['Total', 'Pending', 'Completed'],
                        barColors: ['#4978b1', '#7e9bc8', '#b6c3dc'],
                        hideHover: 'auto',
                        gridLineColor: '#eef0f2',
                        resize: true
                    });

                },
                error:function(data) {
                  $('.dialog-loader').hide();
                }
            });    
        }

        $scope.loadTaskData = function()
        {
            $.ajax({
                url: "{{url('admin/taskSumeryJson')}}",
                type: 'GET',
                success: function (data) {
                    $scope.task_data = data.json;
                    $scope.task_chart_data = data.chart;
                    $scope.$apply();

                    Morris.Bar({
                        element: 'task_m_bar_chart',
                        data: $scope.task_chart_data,
                        xkey: 'a',
                        ykeys: ['b', 'c', 'd'],
                        labels: ['Total', 'Pending', 'Completed'],
                        barColors: ['#43aaa5','#5d9895','#778685'],
                        hideHover: 'auto',
                        gridLineColor: '#eef0f2',
                        resize: true
                    });
                },
                error:function(data) {
                  $('.dialog-loader').hide();
                }
            });    
        }

        $scope.loadCostData = function()
        {
            $.ajax({
                url: "{{url('admin/costSumeryChartJson')}}",
                type: 'GET',
                success: function (data) {
                    $scope.cost_chart_data = data;
                    $scope.current = data.others.current_month;
                    $scope.last_3 = data.others.last_three_month;
                    $scope.last_6 = data.others.last_six_month;
                    $scope.last_12 = data.others.last_year;
                    $scope.$apply();

                    var ctx = document.getElementById('cost_chart').getContext('2d');
                    var myChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: $scope.cost_chart_data.labels,
                            
                            datasets: $scope.cost_chart_data.jsonData
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });

                },
                error:function(data) {
                  $('.dialog-loader').hide();
                }
            });

            // var dataset = [{
            //     type: 'bar',
            //     label: 'Month Cost',
            //     data: [10, 20, 30, 40],
            //     backgroundColor: 'rgb(255, 99, 132, 0.2)'
            // },{
            //     type: 'bar',
            //     label: 'Month Cost',
            //     data: [100, 60, 70, 20],
            //     backgroundColor: 'rgb(25, 80, 32, 0.2)'
            // }, {
            //     type: 'line',
            //     label: 'Month Task Count',
            //     data: [20, 15, 55, 18],
            //     fill: false,
            //     borderColor: 'rgb(54, 162, 235)'
            // }, {
            //     type: 'line',
            //     label: 'Month Task Count',
            //     data: [30, 40, 20, 38],
            //     fill: false,
            //     borderColor: 'rgb(90, 62, 35)'
            // }];  
        }

        $scope.loadCostTypeData = function()
        {
            $.ajax({
                url: "{{url('admin/costTypeSumeryChartJson')}}",
                type: 'GET',
                success: function (data)
                {
                    $scope.cost_type_chart_data = data;
                    $scope.$apply();

                    Morris.Donut({
                        element: 'm_donut_chart',
                        data: $scope.cost_type_chart_data.jsonData,

                        resize: true,
                        colors: $scope.cost_type_chart_data.colors
                    });
                },
                error:function(data) {
                  $('.dialog-loader').hide();
                }
            });

            // [{
            //     label: "Online Sales",
            //     value: 45,
            // }, {
            //     label: "Store Sales",
            //     value: 35
            // },{
            //     label: "Email Sales",
            //     value: 8
            // }, {
            //     label: "Agent Sales",
            //     value: 12
            // }]
        }

    });//end controller

</script>

@stop
