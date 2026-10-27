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
<div ng-app="ngApp" ng-controller="JobManageController">

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
                            <li style="display: inline;" class="breadcrumb-item active">Create Task</li>
                        </ul>                       
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row clearfix">
		<div class="col-lg-12 col-md-12">
	        <div class="card">
	        	<div class="header">
	                <h2>Create Task</h2>
	                <ul class="header-dropdown">

	                	<li><a class="tab_btn table-btn" href="{{url('admin/task/index')}}" data-toggle="tooltip" data-placement="top" title="" data-original-title="Task List"><i class="fas fa-bars "></i></a></li>
	                </ul>
	            </div>

	            <div class="body">
                    <form action="" method="POST" role="form" id="create-task-form" name="create-task-form">
                        {{csrf_field()}}
                        <div class="row" style="padding: 10px">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label>Job</label>
                                    <select name="job" id="job" class="select2-container form-control show-tick ms select2">
                                        <option value="">- Select Job -</option>
                                        <option ng-repeat="job in jobs" value="@{{job.id}}">@{{job.reference_no}} - @{{job.job_title}}</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label>Title</label>
                                    <textarea class="form-control" id="task_title" name="task_title" placeholder="Enter task title..."></textarea>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Task Category</label>
                                    <select name="category" id="category" class="select2-container form-control show-tick ms select2">
                                        <option value="">- Select Category -</option>
                                        <option ng-repeat="category in task_categories" value="@{{category.id}}">@{{category.name}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Task Assign To</label>
                                    <select name="assignto" id="assignto" class="select2-container form-control show-tick ms select2">
                                        <option value="">- Select Assign To -</option>
                                        <option ng-repeat="technician in technicians" value="@{{technician.id}}">@{{technician.employee_no}} - @{{technician.first_name}} @{{technician.last_name}}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Start Date</label>
                                    <input class="form-control" id="start_at" name="start_at" placeholder="Select Start Date...">
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Start Time</label>
                                    <div class="bootstrap-timepicker">
                                        <input id="start_time" name="start_time" type="text" class="input-small form-control" placeholder="Enter start time...">
                                        <i class="icon-time"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>End Date</label>
                                    <input class="form-control" id="end_at" name="end_at" placeholder="Select End Date...">
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>End Time</label>
                                    <div class="bootstrap-timepicker">
                                        <input id="end_time" name="end_time" type="text" class="input-small form-control" placeholder="Enter end time...">
                                        <i class="icon-time"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label>Remark</label>
                                    <textarea class="form-control" name="task_note" id="task_note" placeholder="Enter note..."></textarea>
                                </div>
                            </div>

                        </div>
                        <div class="row text-right">
                            <div class="form-group col-md-12">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-upload"></i> Save</button>
                            </div>
                        </div>
                    </form>
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

        $('#start_at').datepicker({
            format: 'yyyy-mm-dd',
            todayHighlight: true
        });

        $('#end_at').datepicker({
            format: 'yyyy-mm-dd',
            todayHighlight: true
        });

        $('#start_time').timepicker({
            template: false,
            showInputs: false,
            minuteStep: 5,
            defaultTime: false,
            showMeridian: false
        });

        $('#end_time').timepicker({
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
    app.controller("JobManageController", function($scope,$http)
    {
    	$scope.technicians = [];
        $scope.task_categories = [];
        
        $scope.jobs = [];

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

        $("form#create-task-form").submit(function(e)
        {
            e.preventDefault();    
            var formData = new FormData(this);
            $('.dialog-loader').show();

            $.ajax({
                url: "{{url('admin/task/create')}}",
                type: 'POST',
                data: formData,
                success: function (data)
                {
                    if(data.status_code == 200)
                    {
                        swal({
                            title: data.message,
                            text: data.debug,
                        });

                        location.reload();
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

    });//end controller

</script>
@stop
