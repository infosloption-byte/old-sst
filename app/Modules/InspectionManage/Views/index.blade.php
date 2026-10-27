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
	.timeline-item {
	    padding: 0em 1em 0.5em;
	    position: relative;
	    border-left: 1px solid;
	}
	.timeline-item > .msg {
	    margin: 5px 0 !important;
	}
</style>
@stop

@section('content')
<div ng-app="ngApp" ng-controller="InspectionManageController" ng-init="loadInspectionData()">

	<div class="block-header">
        <div class="row">
            <div class="col-lg-8 col-md-6 col-sm-12 col-12">
                <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth">
                    <i class="fa fa-arrow-left"></i></a> Inspection Management</h2>
            </div>            
            <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                <div class="row">
                    <div class="col-md-12">
                        <ul class="breadcrumb float-right">
                            <li style="display: inline;" class="breadcrumb-item"><a href="index.html"><i class="icon-home"></i></a></li>                           
                            <li style="display: inline;" class="breadcrumb-item">Inspection Management</li>
                            <li style="display: inline;" class="breadcrumb-item active">Inspections</li>
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
                    <div class="row">
                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                            <label>Keyword</label>
                            <div class="input-group">
                                <input name="keyword" id="keyword" class="form-control" placeholder="Search here..." type="text">
                            </div>
                        </div>
                        
                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                            <label>Client</label>
                            <div class="input-group">
                                <select name="client" id="client" class="select2-container form-control show-tick ms select2" required="required">
                                    <option value="">-ALL-</option>
                                    <option ng-repeat="client in clients" value="@{{client.id}}">@{{client.first_name}} @{{client.last_name}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                            <label>Status</label>
                            <div class="input-group">
                                <select name="status" id="status" class="select2-container form-control show-tick ms select2" required="required">
                                    <option value="">-ALL-</option>
                                    <option value="0">-PENDING-</option>
                                    <option value="1">-IN-PROGRESS-</option>
                                    <option value="2">-FINISHED-</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <button class="btn btn-info btn-sm float-right" ng-click="find()"><i class="fa fa-search"></i>Find</button>
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
	                <h2>Inspections List</h2>
	                <ul class="header-dropdown">

	                	<li><a class="tab_btn table-btn" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="" data-original-title="Export Inspections List" ng-click="exportJobData()"><i class="fas fa-download "></i></a></li>

	                </ul>
	                <form method="GET" action="{{url('admin/job/export')}}">
	                	<input type="hidden" name="keyword" class="form-control" value="{{$request->keyword}}">
	                	<input type="hidden" name="status" class="form-control" value="{{$request->status}}">
		            </form>
	            </div>

	            <div class="body">
	                <div class="table-responsive">
		                <table class="table table-bordered table-hover mb-3 c_list">
		                    <thead>
		                        <tr>
		                            <th>#</th>
		                            <th>Reference No</th>
		                            <th>Job No</th>
		                            <th class="text-center">Status</th>
		                            <th>Inspect Date</th>
		                            <th>Inspect Manager</th>
		                            <th>Client</th>
		                            <th>Score</th>
		                            <th>Rating</th>
		                            <th>Created Date</th>
		                            <th class="text-right">Action</th>
		                        </tr>
		                    </thead>
	                        <tbody>
	                        	<tr ng-repeat="inspection in inspections.data track by $index">
	                        		<td>@{{$index+1}}</td>
	                        		<td>
	                        			@{{inspection.reference_no}}
	                        		</td>
	                        		<td>
	                        			@{{inspection.job.reference_no}}
	                        		</td>
	                        		<td class="text-center">
	                        			<span ng-show="inspection.status == 0" class="badge bg-danger text-light">Pending</span>
	                        			<span ng-show="inspection.status == 1" class="badge bg-primary text-light">In-progress</span>
	                        			<span ng-show="inspection.status == 2" class="badge bg-success text-light">Finished</span>
	                        		</td>
	                        		<td>
	                        			@{{inspection.inspection_date | date}}
	                        		</td>
	                        		<td>
	                        			@{{inspection.manager.first_name}} @{{inspection.manager.last_name}}
	                        		</td>
	                        		<td>
	                        			<strong>@{{inspection.job.client.first_name}} @{{inspection.job.client.last_name}}</strong>
	                        		</td>

	                        		<td>@{{inspection.scored_points}} / @{{inspection.total_points}}</td>

	                        		<td>
	                        			<span ng-show="!inspection.rating" class="badge bg-danger text-light">Not Rated</span>
	                        			<span ng-show="inspection.rating" class="badge bg-danger text-light">@{{inspection.rating}}</span>
	                        		</td>
	                        		<td class="text-center">
	                        			@{{inspection.created_at | amDateFormat:'MMM DD, YYYY'}}<br>@{{inspection.created_at | amDateFormat:'h:mm a z'}}</br>
	                        			@{{inspection.createdby.username}}
	                        		</td>
	                        		<td class="text-right">
	                        			<button type="button" class="btn btn-xs btn-dark btn-secondary btn-detail" title="View Inspection Details" data-id="@{{inspection.id}}" ng-click="viewInspectionData(inspection)">
	                        				<i class="fa fa-eye"></i>
	                        			</button>

	                        			@if(\Entrust::hasRole('Admin'))
	                        			<button ng-show="false" type="button" class="btn btn-xs btn-warning btn-secondary btn-edit" title="Edit Inspection Details" data-id="@{{inspection.id}}" ng-click="editInspectionDetails(inspection)">
	                        				<i class="fa fa-edit"></i>
	                        			</button>
	                        			<button ng-show="false" type="button" class="btn btn-xs btn-danger btn-secondary btn-delete" title="Delete Inspection" data-id="@{{inspection.id}}" ng-click="deleteInspection(inspection)">
	                        				<i class="fa fa-trash"></i>
	                        			</button>
                                        @endif
	                        		</td>
	                        	</tr>
	                    	</tbody>
		                </table>
		            </div>
		            <paging page="inspections.current_page" page-size="inspections.per_page" total="inspections.total" show-prev-next="true" show-first-last="true" ul-class="pagination" paging-action="find(page)">
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
    app.controller("InspectionManageController", function($scope,$http)
    {
    	$scope.clients = [];
    	
    	$scope.alljobs = [];

        $scope.edit_job = [];

    	$scope.inspections = [];

    	$scope.page = 1;

    	$.ajax({
            url: "{{url('admin/task/get-all-jobs')}}",
            type: 'GET',
            success: function (data) {
                $scope.alljobs = data;
                $scope.$apply();
            },
            error:function(data) {
              $('.dialog-loader').hide();
            }
        });

    	$.ajax({
            url: "{{url('admin/job/clientList')}}",
            type: 'GET',
            success: function (data) {
                $scope.clients = data;
                $scope.$apply();
            },
            error:function(data) {
              $('.dialog-loader').hide();
            }
        });

        $scope.loadInspectionData = function()
	    {
	        $.ajax({
	            url: "{{url('admin/inspection/get-inspections-list')}}",
	            type: 'GET',
	            success: function (data) {
	                $scope.inspections = data;
	                $scope.$apply();
	            },
	            error:function(data) {
	              $('.dialog-loader').hide();
	            }
	        });
	    };

	    $scope.find = function (page)
	    {
            $scope.page = page;

            keyword = $('#keyword').val();
            client = $('#client').val();
            status = $('#status').val();

            $.ajax({
	            url: "{{url('admin/inspection/get-inspections-list')}}",
	            type: 'GET',
	            data: {
	            	page: page,
	            	keyword : keyword,
					client : client,
					status : status
	            },
	            success: function (data) {
	                $scope.inspections = data;
	                $scope.$apply();
	            },
	            error:function(data) {
	              $('.dialog-loader').hide();
	            }
	        });
	    }

	    $scope.viewInspectionData = function(inspection)
    	{
    		$scope.inspection_data = inspection;

    		window.open('{{url('admin/inspection/view-details')}}?inspection_id='+inspection.id,'_blank');
    	}

        $scope.exportInspectionData = function ()
        {
            keyword = $('#keyword').val();
            client = $('#client').val();
            status = $('#status').val();

            window.open('{{url('admin/inspection/export-data')}}?keyword='+keyword+'&client='+client+'&status='+status,'_blank');

            $scope.find();
        }
    	
    });//end controller

</script>
@stop
