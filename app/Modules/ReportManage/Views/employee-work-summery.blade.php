@extends('master.master')

@section('css')

<link rel="stylesheet" href="{{asset('assets/admin_panel/dist/c3/c3.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/admin_panel/dist/bootsrap-fileinput/css/fileinput.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/admin_panel/dist/bootsrap-fileinput/themes/explorer-fa/theme.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/admin_panel/dist/select2/select2.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/admin_panel/dist/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')}}">

<link rel="stylesheet" type="text/css" href="{{asset('assets/admin_panel/css/timepicker.css')}}">
<style type="text/css">
	.file-drop-zone-title {
	    color: #aaa;
	    font-size: 1.6em;
	    padding: 50px 10px;
	    cursor: default;
	}

	.krajee-default .file-other-icon {
	    font-size: 2em;
	}
	.krajee-default.file-preview-frame .kv-file-content {
	    width: 150px;
	    height: 50px;
	}

	.krajee-default.file-preview-frame {
	    margin: 8px;
	    border: 1px solid rgba(0,0,0,.2);
	    box-shadow: none; 
	    padding: 6px;
	    float: left;
	    text-align: center;
	}

	.file-preview {
	    border-radius: 5px;
	    border: 0 !important;
	    padding:0; 
	    width: 100%;
	    margin-bottom: 5px;
	}

	.file-preview .fileinput-remove {
	    top: 8px;
	    right: 8px;
	    line-height: 10px;
	}

	.file-drop-zone {
	    border: 3px dashed #aaa;
	    border-radius: 4px;
	    height: 100%;
	    text-align: center;
	    vertical-align: middle;
	    margin: 0; 
	    padding: 0; 
	}

	.select2-container{
		height: 36px;
	}
</style>
@stop

@section('content')
<div ng-app="ngApp" ng-controller="ReportController" ng-init="loadReportData()">

	<div class="block-header">
        <div class="row">
            <div class="col-lg-8 col-md-6 col-sm-12 col-12">
                <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth">
                    <i class="fa fa-arrow-left"></i></a> Report Management</h2>
            </div>            
            <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                <div class="row">
                    <div class="col-md-12">
                        <ul class="breadcrumb float-right">
                            <li style="display: inline;" class="breadcrumb-item"><a href="index.html"><i class="icon-home"></i></a></li>                           
                            <li style="display: inline;" class="breadcrumb-item">Report Management</li>
                            <li style="display: inline;" class="breadcrumb-item active">Employee Work Summery</li>
                        </ul>                       
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row clearfix">
    	<div class="col-lg-12 col-md-12">
            <div class="card " style="margin-bottom: 20px">
                <div class="body" style="padding: 10px;">
                    <div class="row mt-3">
                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                            <label>Date Range(From)</label>
                            <div class="input-group">
                                <input name="from_date" id="from_date" class="form-control" placeholder="From Date..." type="text">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                            <label>Date Range(To)</label>
                            <div class="input-group">
                                <input name="to_date" id="to_date" class="form-control" placeholder="To Date..." type="text">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        	<button class="btn btn-info btn-sm float-left" ng-click="find()" style="margin-top: 30px;"><i class="fa fa-search"></i>Find</button>
                        </div>
                    </div>
                </div>
            </div>   
        </div>
	</div>

	<div class="row clearfix">
		<div class="col-lg-12 col-md-12">
	        <div class="card">
	        	<div class="header">
	                <h2>Summery List</h2>
	                <ul class="header-dropdown">

	                	<li><a class="tab_btn table-btn" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="" data-original-title="Export Report List" ng-click="exportReportData()"><i class="fas fa-download "></i></a></li>
	                </ul>
	                <form method="GET" action="{{url('admin/report/export')}}">
	                	<input type="hidden" name="keyword" class="form-control" value="{{$request->keyword}}">
	                	<input type="hidden" name="status" class="form-control" value="{{$request->status}}">
		            </form>
	            </div>

	            <div class="body">
	                <div class="table-responsive mb-3">
		                <table class="table table-bordered table-hover m-b-0 c_list">
		                    <thead>
		                        <tr>
		                            <th>#</th>
		                            <th>Employee</th>
		                            <th class="text-right">Worked Days</th>
		                            <th class="text-right">Worked Hours</th>
		                            <th class="text-right">Regular Job Hours</th>
		                            <th class="text-right">OneTime Job Hours</th>
		                            <th class="text-right">Completed Task Count</th>
		                            <th class="text-right">Performance </br><small>(hrs/task count)</small></th>
		                        </tr>
		                    </thead>
	                        <tbody>
	                        	<tr ng-repeat="detail in details track by $index">
	                        		<td>@{{$index+1}}</td>
	                        		<td class="text-left">@{{detail.employee}}</td>
	                        		<td class="text-right">@{{detail.worked_days}}</td>
	                        		<td class="text-right">@{{detail.worked_hours}}</td>
	                        		<td class="text-right">@{{detail.regular}}</td>
	                        		<td class="text-right">@{{detail.onetime}}</td>
	                        		<td class="text-right">@{{detail.completed_tasks}}</td>
	                        		<td class="text-right">@{{detail.performance | number:2}}</td>
	                        	</tr>
	                    	</tbody>
		                </table>
		            </div>
	            </div>
	        </div>
	    </div>
	    
	</div>

</div>

@stop

@section('js')
<script src="{{asset('assets/js/dialog.js')}}"></script>
<script src="{{asset('assets/dist/moment/moment.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/js/timepicker.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/admin_panel/dist/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
<script type="text/javascript">

    $(document).ready(function()
    {
        $(".select2").select2();

        $('#from_date').datepicker({
            format: 'yyyy-mm-dd',
            todayHighlight: true
        });

        $('#to_date').datepicker({
            format: 'yyyy-mm-dd',
            todayHighlight: true
        });

    });

    //initialize angular app
    var app = angular.module("ngApp",['angularMoment','dualmultiselect','angularImgFallback','ui.bootstrap','ngSanitize','bw.paging']);


    app.config(['$tooltipProvider', function ($tooltipProvider) {
        $tooltipProvider.options({
            appendToBody: true, // 
            appendToBody: true, // 
            placement:'bottom' // Set Default Placement
        });
    }]);

    //controller
    app.controller("ReportController", function($scope,$http)
    {
    	$scope.details = [];

    	$scope.edit_repair = [];

    	$scope.page = 1;

    	$scope.loadReportData = function()
	    {
	        $.ajax({
	            url: "{{url('admin/report/employee-work-summery-json-list')}}",
	            type: 'GET',
	            success: function (data) {
	                $scope.details = data;
	                $scope.$apply();
	            },
	            error:function(data) {
	              $('.dialog-loader').hide();
	            }
	        });
	    };

	    $scope.find = function (page)
	    {
            from_date = $('#from_date').val();
            to_date = $('#to_date').val();

	        $.ajax({
	            url: "{{url('admin/report/employee-work-summery-json-list')}}",
	            type: 'GET',
	            data: {
	            	from_date : from_date,
					to_date : to_date
	            },
	            success: function (data) {
	                $scope.details = data;
	                $scope.$apply();
	            },
	            error:function(data) {
	              $('.dialog-loader').hide();
	            }
	        });
	    }

	    $scope.exportReportData = function ()
        {
            from_date = $('#from_date').val();
            to_date = $('#to_date').val();

            window.open('{{url('employee-work-summery-export-list')}}?from_date='+from_date+'&to_date='+to_date,'_blank');

            $scope.find();
        }
    });//end controller

</script>
@stop
