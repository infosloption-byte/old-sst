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
	    padding: 0em 2em 0.5em;
	    position: relative;
	    border-left: 1px solid;
	}

	.timeline-item > .msg {
	    margin: 5px 0 !important;
	}
</style>
@stop

@section('content')
<div ng-app="ngApp" ng-controller="TaskManageController" ng-init="loadTaskData()">

	<div class="block-header">
        <div class="row">
            <div class="col-lg-8 col-md-6 col-sm-12 col-12">
                <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth">
                    <i class="fa fa-arrow-left"></i></a> Task Management</h2>
            </div>            
            <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                <div class="row">
                    <div class="col-md-12">
                        <ul class="breadcrumb float-right">
                            <li style="display: inline;" class="breadcrumb-item"><a href="index.html"><i class="icon-home"></i></a></li>                           
                            <li style="display: inline;" class="breadcrumb-item">Task Management</li>
                            <li style="display: inline;" class="breadcrumb-item active">Tasks</li>
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
                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                            <label>Keyword</label>
                            <div class="input-group">
                                <input name="keyword" id="keyword" class="form-control" placeholder="Search here..." type="text">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                            <label>Job</label>
                            <div class="input-group">
                                <select name="job" id="job" class="select2-container form-control show-tick ms select2">
                                    <option value="">- ALL -</option>
                                    <option ng-repeat="job in jobs" value="@{{job.id}}">@{{job.reference_no}} - @{{job.job_title}}</option>
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

                    <div class="row mt-3">
                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                            <label>Date Range(From)</label>
                            <div class="input-group">
                                <input name="from_date" id="from_date" class="form-control" placeholder="From Date..." type="text">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                            <label>Date Range(To)</label>
                            <div class="input-group">
                                <input name="to_date" id="to_date" class="form-control" placeholder="To Date..." type="text">
                            </div>
                        </div>

                    	<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                            <label>Task Category</label>
                            <div class="input-group">   
                                <select name="task_category" id="task_category" class="select2-container form-control show-tick ms select2" required="required">
                                    <option value="">-ALL-</option>
                                    <option ng-repeat="task_category in task_categories" value="@{{task_category.id}}">@{{task_category.name}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                            <label>Technician</label>
                            <div class="input-group">
                                <select name="technician" id="technician" class="select2-container form-control show-tick ms select2" required="required">
                                    <option value="">-ALL-</option>
                                    <option ng-repeat="technician in technicians" value="@{{technician.id}}">@{{technician.employee_no}} - @{{technician.first_name}} @{{technician.last_name}}</option>
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
	                <h2>Task List</h2>
	                <ul class="header-dropdown">

	                	<li><a class="tab_btn table-btn" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="" data-original-title="Download Task List" ng-click="exportTaskData()"><i class="fas fa-download "></i></a></li>
	                	@if(\Entrust::hasRole('Admin'))
	                	<li><a class="tab_btn table-btn" href="{{url('admin/task/create')}}" data-toggle="tooltip" data-placement="top" title="" data-original-title="Create New Task" id="btn-add"><i class="fas fa-plus "></i></a></li>
	                	@endif
	                </ul>
	                <form method="GET" action="{{url('admin/task/export')}}">
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
		                            <th>Task</th>
		                            <th>Job</th>
		                            <th>Section</th>
		                            <th>Status</th>
		                            <th class="text-right">Time Spent</th>
		                            <th>Assigned To</th>
		                            <th>Remark</th>
		                            <th>Action</th>
		                        </tr>
		                    </thead>
	                        <tbody>
	                        	<tr ng-repeat="task in tasks.data track by $index">
	                        		<td>@{{$index+1}}</td>
	                        		<td style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;max-width: auto;">
	                        			<a href="#">@{{task.reference_no}}</a><br>
	                        			<span title="@{{task.title}}" style="word-break: break-word;white-space: normal;">@{{task.title}}</span><br>
	                        			<span class="badge bg-info text-light ml-0">@{{task.category.name}}</span><br>
	                        			<small>@{{task.start_at}} | @{{task.end_at}}</small>
	                        		</td>
	                        		<td class="text-center">
	                        			<span class="badge bg-dark text-light">@{{task.job.reference_no}}</span>
	                        		</td>
	                        		<td class="text-left">
	                        			@{{task.section.name}}
	                        		</td>
	                        		<td class="text-center">
	                        			<span ng-show="task.status == 0" class="badge bg-danger text-light">Not Started</span>
	                        			<span ng-show="task.status == 1" class="badge bg-primary text-light">In-progress</span>
	                        			<span ng-show="task.status == 2" class="badge bg-success text-light">Finished</span>
	                        		</td>
	                        		<td class="text-right">@{{task.spend_time}}</td>
	                        		<td>
	                        			<strong>@{{task.assign_to.first_name}} @{{task.assign_to.last_name}}</strong>
	                        		</td>
	                        		<td style="word-break: break-word;white-space: normal;">
	                        			<small>@{{task.remark}}</small>
	                        		</td>
	                        		<td>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <button type="button" class="btn btn-xs btn-dark btn-secondary btn-detail" title="View Details" data-id="@{{task.id}}" ng-click="viewTaskData(task)">
        	                        				<i class="fa fa-eye"></i>
        	                        			</button>
        	                        			@if(\Entrust::hasRole('Admin'))
        	                        			<button type="button" class="btn btn-xs btn-info btn-secondary btn-detail" title="Assign Technician" data-id="@{{task.id}}" ng-click="showAssignTechnician(task)">
        	                        				<i class="fa fa-exchange-alt"></i>
        	                        			</button>
        	                        			<button type="button" class="btn btn-xs btn-warning btn-secondary btn-detail" title="Edit Task Details" data-id="@{{task.id}}" ng-click="editTaskDetails(task)">
        	                        				<i class="fa fa-edit"></i>
        	                        			</button>
        	                        			<button type="button" class="btn btn-xs btn-danger btn-secondary btn-detail" title="Delete Task" data-id="@{{task.id}}" ng-click="deleteTask(task)">
        	                        				<i class="fa fa-trash"></i>
        	                        			</button>
        	                        			@endif
                                            </div>
                                        </div>
                                        @if(\Entrust::hasRole('Admin'))
                                        <div class="row mt-2">
                                            <div class="col-md-12">
                                                <button ng-show="task.status==0" type="button" class="btn btn-xs btn-success btn-secondary btn-detail" title="Start Task" data-id="@{{task.id}}" ng-click="startTask(task)">
                                                    <i class="fa fa-play mr-2"></i>Start
                                                </button>

                                                <button ng-show="task.status==1 || task.status==2" type="button" class="btn btn-xs btn-success btn-secondary btn-detail disabled" title="Start Task Disabled" data-id="@{{task.id}}" ng-click="startTask(task)" disabled="disabled">
                                                    <i class="fa fa-play mr-2"></i>Start
                                                </button>

                                                <button ng-show="task.status==1" type="button" class="btn btn-xs btn-grey btn-secondary btn-detail" title="End Task" data-id="@{{task.id}}" ng-click="endTask(task)">
                                                    <i class="fa fa-check mr-2"></i>Done
                                                </button>

                                                <button ng-show="task.status==0 || task.status==2" type="button" class="btn btn-xs btn-grey btn-secondary btn-detail disabled" title="End Task Disabled" data-id="@{{task.id}}" ng-click="endTask(task)" disabled="disabled">
                                                    <i class="fa fa-check mr-2"></i>Done
                                                </button>
                                            </div>
                                        </div>
                                        @endif
	                        		</td>
	                        	</tr>
	                        	
	                    	</tbody>
		                </table>
		            </div>
		            <paging page="tasks.current_page" page-size="tasks.per_page" total="tasks.total" show-prev-next="true" show-first-last="true" ul-class="pagination" paging-action="find(page)">
	            </div>
	        </div>
	    </div>
	    
	</div>

	<div class="modal fade" id="assignTechnicianModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="title" id="largeModalLabel">Assign Technician</h4>
                </div>
                
                <div class="modal-body">
                    <form role="form" class="form-validation" method="post" id="assign-technician-form" name="assign-technician-form" enctype="multipart/form-data">
                    {{csrf_field()}}
                    	<input type="hidden" name="task_id" id="task_id">
                        <div class="row">
                            <div class="form-group col-12 col-sm-12 col-md-12 col-lg-12">
                                <label for="">Technician</label>
                                <select name="assign_technician" id="assign_technician" class="select2-container form-control show-tick ms select2" required="required">
                                    <option value="">-Select Technician-</option>
                                    <option ng-repeat="technician in technicians" value="@{{technician.id}}">@{{technician.employee_no}} - @{{technician.first_name}} @{{technician.last_name}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="row text-right">
                            <div class="form-group col-md-12">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-upload"></i> Assign</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editTaskModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="title" id="largeModalLabel">Edit Task</h4>
                </div>
                
                <div class="modal-body">
                    <form role="form" class="form-validation" method="post" id="edit-task-form" name="edit-task-form" enctype="multipart/form-data">
                    {{csrf_field()}}
                    	<input type="hidden" name="edit_task_id" id="edit_task_id" value="@{{edit_task.id}}">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label>Job</label>
                                    <select name="edit_job" id="edit_job" class="select2-container form-control show-tick ms select2">
                                        <option value="">- Select Job -</option>
                                        <option ng-repeat="job in jobs" value="@{{job.id}}">@{{job.reference_no}} - @{{job.job_title}}</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label>Title</label>
                                    <textarea class="form-control" id="edit_task_title" name="edit_task_title" placeholder="Enter task title...">@{{edit_task.title}}</textarea>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Task Category</label>
                                    <select name="edit_category" id="edit_category" class="select2-container form-control show-tick ms select2">
                                        <option value="">- Select Category -</option>
                                        <option ng-repeat="category in task_categories" value="@{{category.id}}">@{{category.name}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Task Assign To</label>
                                    <select name="edit_assignto" id="edit_assignto" class="select2-container form-control show-tick ms select2">
                                        <option value="">- Select Assign To -</option>
                                        <option ng-repeat="technician in technicians" value="@{{technician.id}}">@{{technician.employee_no}} - @{{technician.first_name}} @{{technician.last_name}}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Start Date</label>
                                    <input class="form-control" id="edit_start_at" name="edit_start_at" placeholder="Select Start Date..." value="@{{edit_task.start_at}}">
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Start Time</label>
                                    <div class="bootstrap-timepicker">
							            <input id="edit_start_time" name="edit_start_time" type="text" class="input-small form-control" value="@{{edit_task.start_time}}" placeholder="Enter start time...">
							            <i class="icon-time"></i>
							        </div>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>End Date</label>
                                    <input class="form-control" id="edit_end_at" name="edit_end_at" placeholder="Select End Date..." value="@{{edit_task.end_at}}">
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>End Time</label>
                                    <div class="bootstrap-timepicker">
							            <input id="edit_end_time" name="edit_end_time" type="text" class="input-small form-control" value="@{{edit_task.end_time}}" placeholder="Enter end time...">
							            <i class="icon-time"></i>
							        </div>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label>Remark</label>
                                    <textarea class="form-control" name="edit_task_note" id="edit_task_note" placeholder="Enter note...">@{{edit_task.remark}}</textarea>
                                </div>
                            </div>

                        </div>
                        <div class="row text-right">
                            <div class="form-group col-md-12">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-upload"></i> Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="taskDetailViewModel" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                
                <div class="modal-body">
                    <div class="row">
                    	<div class="col-md-4">
                    		<div class="card">
		                        <div class="header">
		                            <h5><strong>Task Details</strong></h5>
		                        </div>
		                        <div class="body">

		                        	<small class="text-muted">Task Reference: </small>
		                            <p>@{{task_data.reference_no}}</p>
		                            <hr>
		                            <small class="text-muted">Job Reference: </small>
		                            <p>@{{task_data.job.reference_no}}</p>
		                            <hr>
		                            <small class="text-muted">Title: </small>
		                            <p>@{{task_data.title}}</p>
		                            <hr>
		                            <small class="text-muted">Task Category: </small>
		                            <p><span class="badge bg-info text-light ml-0">@{{task_data.category.name}}</span></p>
		                            <hr>
		                            <small class="text-muted">Status: </small>
		                            <p>
		                            	<span ng-show="task_data.status == 0" class="badge bg-danger text-light">Not Started</span>
		                            	<span ng-show="task_data.status == 1" class="badge bg-primary text-light">In-progress</span>
		                            	<span ng-show="task_data.status == 2" class="badge bg-success text-light">Finished</span>
		                            </p>
		                            <hr>
		                            <small class="text-muted">Assigned To: </small>
		                            <p class="mb-0"><strong>@{{task_data.assign_to.name}}</strong></p>
	                        		<p class="mb-0">@{{task_data.assign_to.email}}</p>
		                            <hr>
		                            <small class="text-muted">Remark: </small>
		                            <p>@{{task_data.remark}}</p>
		                            <hr>

		                        </div>
		                    </div>
                    	</div>
                    	<div class="col-md-8">
                    		<div class="card">
		                        <div class="header">
		                            <h5><strong>Time Line</strong></h5>
		                        </div>
		                        <div class="body" style="height: 570px;overflow: scroll;">
		                            <div class="timeline-item" date-is="@{{transaction.created_at}}" ng-repeat="transaction in task_data.transactions">
		                                <h5>@{{transaction.action}}</h5>
		                                <span><a href="javascript:void(0);">@{{transaction.actionby.username}}</a> @{{transaction.created_at}}</span>
		                                <div class="msg">
		                                    <p>@{{transaction.remark}}</p>
		                                </div>                                
		                            </div>
		                        </div>
		                    </div>
                    	</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@stop

@section('js')
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

        $('#edit_start_at').datepicker({
        	format: 'yyyy-mm-dd',
        });

        $('#edit_end_at').datepicker({
        	format: 'yyyy-mm-dd',
        });

        $('#edit_start_time').timepicker({
            template: false,
            showInputs: false,
            minuteStep: 5,
            defaultTime: false,
            showMeridian: false
        });

        $('#edit_end_time').timepicker({
            template: false,
            showInputs: false,
            minuteStep: 5,
            defaultTime: false,
            showMeridian: false
        });

    });

    //initialize angular app
    var app = angular.module("ngApp",['dualmultiselect','angularImgFallback','ui.bootstrap','ngSanitize','bw.paging']);


    app.config(['$tooltipProvider', function ($tooltipProvider) {
        $tooltipProvider.options({
            appendToBody: true, // 
            appendToBody: true, // 
            placement:'bottom' // Set Default Placement
        });
    }]);

    //controller
    app.controller("TaskManageController", function($scope,$http)
    {
    	$scope.technicians = [];
    	$scope.task_categories = [];
    	$scope.tasks = [];

    	$scope.jobs = [];

    	$scope.edit_task = [];

    	$scope.task_data = [];

    	$scope.page = 1;

        $scope.lat = null;
        $scope.lng = null;

    	$.ajax({
            url: "{{url('admin/task/get-all-jobs')}}",
            type: 'GET',
            success: function (data) {
                $scope.jobs = data;
                $scope.$apply();
            },
            error:function(data) {
              $('.dialog-loader').hide();
            }
        });

        $.ajax({
            url: "{{url('admin/task/get-technicians')}}",
            type: 'GET',
            success: function (data) {
                $scope.technicians = data;
                $scope.$apply();
            },
            error:function(data) {
              $('.dialog-loader').hide();
            }
        });

        $.ajax({
            url: "{{url('admin/task/taskCategoryList')}}",
            type: 'GET',
            success: function (data) {
                $scope.task_categories = data;
                $scope.$apply();
            },
            error:function(data) {
              $('.dialog-loader').hide();
            }
        });

        $scope.loadTaskData = function()
	    {
	        $.ajax({
	            url: "{{url('admin/task/get-all-tasks')}}",
	            type: 'GET',
	            success: function (data) {
	                $scope.tasks = data;
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
            job = $('#job').val();
            task_category = $('#task_category').val();
            technician = $('#technician').val();
            status = $('#status').val();

            from_date = $('#from_date').val();
            to_date = $('#to_date').val();

	        $.ajax({
	            url: "{{url('admin/task/get-all-tasks')}}",
	            type: 'GET',
	            data: {
	            	page: page,
	            	job : job,
	            	keyword : keyword,
					task_category : task_category,
					technician : technician,
					status : status,
					from_date : from_date,
					to_date : to_date
	            },
	            success: function (data) {
	                $scope.tasks = data;
	                $scope.$apply();
	            },
	            error:function(data) {
	              $('.dialog-loader').hide();
	            }
	        });
	    }

    	$scope.showAssignTechnician = function(task)
    	{
    		if(task.assign_to)
    		{
    			$("#assign_technician").val(task.assign_to.id).trigger('change');
    		}

    		$('#task_id').val(task.id);

    		$('#assignTechnicianModal').modal('show');
    	}

    	$scope.editTaskDetails = function(task)
    	{
    		$scope.edit_task = task;

    		if(task.assign_to){
				$("#edit_assignto").val(task.assign_to.id).trigger('change');
    		}
    		$("#edit_job").val(task.job_id).trigger('change');
    		$("#edit_category").val(task.task_category_id).trigger('change');

    		$('#editTaskModal').modal('show');
    	}

    	$scope.deleteTask = function(task)
    	{
    		swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this task!",
                icon: "warning",
                showCancelButton: true,
                closeOnConfirm: true,
            },function(willDelete){
                if (willDelete)
                {
                    $.ajax({
                        url: "{{url('admin/task/delete')}}",
                        type: 'POST',
                        data: {
                            task_id : task.id
                        },
                        success: function (data)
                        {
                            if(data.status_code==200)
                            {
                                swal({
                                    title: data.message,
                                    text: data.debug,
                                });

                                $scope.find($scope.page);
                            }else{
                                swal({
                                    title: data.message,
                                    text: data.debug,
                                });
                            }
                        },
                        error:function(data) {
                            $('.dialog-loader').hide();
                        }
                    });

                    return false;
                }
            });
    	}

    	$scope.viewTaskData = function(task)
    	{
    		$scope.task_data = task;

    		$('#taskDetailViewModel').modal('show');
    	}

    	$("form#edit-task-form").submit(function(e)
    	{
            e.preventDefault();    
            var formData = new FormData(this);
            $('.dialog-loader').show();

            $.ajax({
                url: "{{url('admin/task/update')}}",
                type: 'POST',
                data: formData,
                success: function (data)
                {
                    if(data.status_code==200)
                    {
                        swal({
                            title: data.message,
                            text: data.debug,
                        });

                        $scope.find($scope.page);

                        $('#editTaskModal').modal('hide');
                    }else{
                        swal({
                            title: data.message,
                            text: data.debug,
                        });
                    }
                },
                error:function(data) {
                    $('.dialog-loader').hide();
                },
                cache: false,
                contentType: false,
                processData: false
            });

            return false;
        });

        $scope.exportTaskData = function ()
        {
            keyword = $('#keyword').val();
            job = $('#job').val();
            task_category = $('#task_category').val();
            technician = $('#technician').val();
            status = $('#status').val();

            from_date = $('#from_date').val();
            to_date = $('#to_date').val();

            window.open('{{url('admin/task/export-data')}}?keyword='+keyword+'&job='+job+'&task_category='+task_category+'&technician='+technician+'&status='+status+'&from_date='+from_date+'&to_date='+to_date,'_blank');

            $scope.find();
        }

        $("form#assign-technician-form").submit(function(e)
        {
            e.preventDefault();    
            var formData = new FormData(this);
            $('.dialog-loader').show();

            $.ajax({
                url: "{{url('admin/task/assign-technician')}}",
                type: 'POST',
                data: formData,
                success: function (data)
                {
                    if(data.status_code==200)
                    {
                    	$('#assignTechnicianModal').modal('hide');

                        swal({
                            title: data.message,
                            text: data.debug,
                        });

                        $scope.find($scope.page);
                    }else{
                        swal({
                            title: data.message,
                            text: data.debug,
                        });
                    }
                },
                error:function(data) {
                    $('.dialog-loader').hide();
                },
                cache: false,
                contentType: false,
                processData: false
            });

            return false;
        });

        $scope.initGeolocation = function()
        {
            if ("geolocation" in navigator)
            {
               // Call getCurrentPosition with success and failure callbacks
               navigator.geolocation.getCurrentPosition( $scope.show_location, $scope.show_error, {timeout:2000, enableHighAccuracy: true});
            }else
            {
                swal({
                    title: 'Location faild',
                    text: 'Sorry, your browser does not support geolocation services',
                });
            }
        }

        $scope.show_location = function(position)
        {
            $scope.lat = position.coords.latitude;
            $scope.lng = position.coords.longitude;

            $scope.$apply();
        }

        $scope.show_error = function(error)
        {
            switch(error.code) {
                case error.PERMISSION_DENIED:
                    swal({
                        title: 'Location faild',
                        text: 'Permission denied by user',
                    });
                    break;
                case error.POSITION_UNAVAILABLE:
                    swal({
                        title: 'Location faild',
                        text: 'Location position unavailable.',
                    });
                    break;
                case error.TIMEOUT:
                    swal({
                        title: 'Location faild',
                        text: 'Request timeout.',
                    });
                    break;
                case error.UNKNOWN_ERROR:
                    swal({
                        title: 'Location faild',
                        text: 'Unknown error.',
                    });
                    break;
            }
        }

        $scope.startTask = function(task)
        {
            $scope.initGeolocation();
            
            swal({
                title: "Are you sure?",
                text: "Do you want to start this task!",
                icon: "warning",
                showCancelButton: true,
                closeOnConfirm: true,
            },function(willDelete){
                if (willDelete)
                {
                    $.ajax({
                        url: "{{url('admin/task/start')}}",
                        type: 'POST',
                        data: {
                            task_id : task.id,
                            lat : $scope.lat,
                            lng : $scope.lng
                        },
                        success: function (data)
                        {
                            if(data.status_code==200)
                            {
                                swal({
                                    title: data.message,
                                    text: data.debug,
                                });

                                $scope.find($scope.page);
                            }else{
                                swal({
                                    title: data.message,
                                    text: data.debug,
                                });
                            }
                        },
                        error:function(data) {
                            $('.dialog-loader').hide();
                        }
                    });

                    return false;
                }
            });
        }

        $scope.endTask = function(task)
        {
            $scope.initGeolocation();

            swal({
                title: "Are you sure?",
                text: "Do you want to end this task!",
                icon: "warning",
                showCancelButton: true,
                closeOnConfirm: true,
            },function(willDelete){
                if (willDelete)
                {
                    $.ajax({
                        url: "{{url('admin/task/end')}}",
                        type: 'POST',
                        data: {
                            task_id : task.id,
                            lat : $scope.lat,
                            lng : $scope.lng
                        },
                        success: function (data)
                        {
                            if(data.status_code==200)
                            {
                                swal({
                                    title: data.message,
                                    text: data.debug,
                                });

                                $scope.find($scope.page);
                            }else{
                                swal({
                                    title: data.message,
                                    text: data.debug,
                                });
                            }
                        },
                        error:function(data) {
                            $('.dialog-loader').hide();
                        }
                    });

                    return false;
                }
            });
        }

    });//end controller

</script>
@stop
