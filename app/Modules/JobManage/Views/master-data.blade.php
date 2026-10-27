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
<div ng-app="ngApp" ng-controller="MasterDataManageController" ng-init="loadMasterTaskData()">

	<div class="block-header">
        <div class="row">
            <div class="col-lg-8 col-md-6 col-sm-12 col-12">
                <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth">
                    <i class="fa fa-arrow-left"></i></a> Job Management</h2>
            </div>            
            <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                <div class="row">
                    <div class="col-md-12">
                        <ul class="breadcrumb float-right">
                            <li style="display: inline;" class="breadcrumb-item"><a href="index.html"><i class="icon-home"></i></a></li>                           
                            <li style="display: inline;" class="breadcrumb-item">Job Management</li>
                            <li style="display: inline;" class="breadcrumb-item active">Job Master Data</li>
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
                            <label>Section</label>
                            <div class="input-group">   
                                <select name="section" id="section" class="select2-container form-control show-tick ms select2" required="required">
                                    <option value="">-ALL-</option>
                                    <option ng-repeat="section in sections" value="@{{section.id}}">@{{section.name}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8" style="margin-top: 32px">
                            <button class="btn btn-warning btn-sm float-right" ng-click="createSectionView()"><i class="fa fa-plus"></i>Section</button>
                            <button class="btn btn-info btn-sm float-left" ng-click="find()"><i class="fa fa-search"></i>Find</button>
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
	                <h2>Master Sections & Tasks List</h2>
	                <ul class="header-dropdown">

	                	@if(\Entrust::hasRole('Admin'))
	                	<li><a class="tab_btn table-btn" href="#" data-toggle="tooltip" data-placement="top" title="" data-original-title="Create New Task" id="btn-task-add" ng-click="createTaskView()"><i class="fas fa-plus "></i></a></li>
	                	@endif
	                </ul>
	            </div>

	            <div class="body">
	                <div class="table-responsive">
		                <table class="table table-bordered table-hover mb-3 c_list">
		                    <thead>
		                        <tr>
		                            <th>#</th>
		                            <th>Section</th>
		                            <th>Task</th>
		                            <th>Inspection Task</th>
		                            <th class="text-center">Action</th>
		                        </tr>
		                    </thead>
	                        <tbody>
	                        	<tr ng-repeat="task in tasks.data track by $index">
	                        		<td style="vertical-align: top;">@{{$index+1}}</td>
	                        		<td style="vertical-align: top;">
	                        			@{{task.master_section.name}}
	                        		</td>
	                        		<td style="vertical-align: top">
	                        			<p class="mb-0">@{{task.name}}</p>
	                        			<span class="badge bg-primary text-light">@{{task.task_category.name}}</span>
	                        		</td>
	                        		<td style="vertical-align: top">
	                        			<p class="mb-0">@{{task.inspection_name}}</p>
	                        		</td>
	                        		<td style="vertical-align: top">
	                        			@if(\Entrust::hasRole('Admin'))
	                        			<button type="button" class="btn btn-xs btn-danger btn-secondary btn-detail" title="Delete Job" data-id="@{{job.id}}" ng-click="deleteMasterTask(task)">
	                        				<i class="fa fa-trash"></i>
	                        			</button>
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

    <div class="modal fade" id="createSectionViewModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="title" id="largeModalLabel">Create New Section</h4>
                </div>
                
                <div class="modal-body">
                    <form action="" method="POST" role="form" id="create-section-form" name="create-section-form">
                        {{csrf_field()}}
                        <div class="row" style="padding: 10px">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label>Section Name</label>
                                    <input type="text" class="form-control" id="section_name" name="section_name" placeholder="Enter name..."/>
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

    <div class="modal fade" id="createTaskViewModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="title" id="largeModalLabel">Create New Task</h4>
                </div>
                
                <div class="modal-body">
                    <form action="" method="POST" role="form" id="create-task-form" name="create-task-form">
                        {{csrf_field()}}
                        <div class="row" style="padding: 10px">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label>Section</label>
                                    <select name="master_section" id="master_section" class="select2-container form-control show-tick ms select2">
                                        <option value="">- Select Section -</option>
                                        <option ng-repeat="section in sections" value="@{{section.id}}">@{{section.name}}</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label>Task Category</label>
                                    <select name="task_category" id="task_category" class="select2-container form-control show-tick ms select2">
                                        <option value="">- Select Category -</option>
                                        <option ng-repeat="category in task_categories" value="@{{category.id}}">@{{category.name}}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label>Task Title</label>
                                    <textarea class="form-control" id="task_title" name="task_title" placeholder="Enter task title..."></textarea>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label>Inspection Title</label>
                                    <textarea class="form-control" id="inspection_title" name="inspection_title" placeholder="Enter inspection title..."></textarea>
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
    app.controller("MasterDataManageController", function($scope,$http)
    {
    	$scope.task_categories = [];
    	$scope.tasks = [];

    	$scope.sections = [];

    	$scope.page = 1;

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

        $.ajax({
            url: "{{url('admin/job/getMasterSectionList')}}",
            type: 'GET',
            success: function (data) {
                $scope.sections = data;
                $scope.$apply();
            },
            error:function(data) {
              $('.dialog-loader').hide();
            }
        });

        $scope.loadSections = function()
        {
        	$.ajax({
	            url: "{{url('admin/job/getMasterSectionList')}}",
	            type: 'GET',
	            success: function (data) {
	                $scope.sections = data;
	                $scope.$apply();
	            },
	            error:function(data) {
	              $('.dialog-loader').hide();
	            }
	        });
        }

        $scope.loadMasterTaskData = function()
	    {
	        $.ajax({
	            url: "{{url('admin/job/get-master-task-list')}}",
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

            section = $('#section').val();

            $.ajax({
	            url: "{{url('admin/job/get-master-task-list')}}",
	            type: 'GET',
	            data: {
	            	page: page,
	            	section : section
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

	    $scope.deleteMasterTask = function(task)
    	{
    		swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this data!",
                icon: "warning",
                showCancelButton: true,
                closeOnConfirm: true,
            },function(willDelete){
                if (willDelete)
                {
                    $.ajax({
                        url: "{{url('admin/job/deleteMasterTask')}}",
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
                                $scope.loadSections();
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

    	$scope.createSectionView = function()
    	{
    		$('#createSectionViewModal').modal('show');
    	}

    	$scope.createTaskView = function()
    	{
    		$('#createTaskViewModal').modal('show');
    	}

        $("form#create-section-form").submit(function(e)
        {
            e.preventDefault();    
            var formData = new FormData(this);
            $('.dialog-loader').show();

            $.ajax({
                url: "{{url('admin/job/master-section-create')}}",
                type: 'POST',
                data: formData,
                success: function (data)
                {
                    if(data.status_code == 200)
                    {
                    	$('#createSectionViewModal').modal('hide');

                        swal({
                            title: data.message,
                            text: data.debug,
                        });

                        $scope.find($scope.page);
                        $scope.loadSections();
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

        $("form#create-task-form").submit(function(e)
        {
            e.preventDefault();    
            var formData = new FormData(this);
            $('.dialog-loader').show();

            $.ajax({
                url: "{{url('admin/job/master-task-create')}}",
                type: 'POST',
                data: formData,
                success: function (data)
                {
                    if(data.status_code == 200)
                    {
                    	$('#createTaskViewModal').modal('hide');

                        swal({
                            title: data.message,
                            text: data.debug,
                        });

                        $scope.find($scope.page);
                        $scope.loadSections();
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
