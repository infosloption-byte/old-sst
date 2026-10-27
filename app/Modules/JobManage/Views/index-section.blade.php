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
<div ng-app="ngApp" ng-controller="SectionManageController" ng-init="loadSectionData()">

	<div class="block-header">
        <div class="row">
            <div class="col-lg-8 col-md-6 col-sm-12 col-12">
                <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth">
                    <i class="fa fa-arrow-left"></i></a> Section Management</h2>
            </div>            
            <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                <div class="row">
                    <div class="col-md-12">
                        <ul class="breadcrumb float-right">
                            <li style="display: inline;" class="breadcrumb-item"><a href="index.html"><i class="icon-home"></i></a></li>                           
                            <li style="display: inline;" class="breadcrumb-item">Section Management</li>
                            <li style="display: inline;" class="breadcrumb-item active">Sections</li>
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
	                <h2>Section List</h2>
	                <ul class="header-dropdown">

	                	<li><a class="tab_btn table-btn" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="" data-original-title="Download Section List" ng-click="exportSectionData()"><i class="fas fa-download "></i></a></li>
	                	@if(\Entrust::hasRole('Admin'))
	                	<li><a class="tab_btn table-btn" href="#" data-toggle="tooltip" data-placement="top" title="" data-original-title="Create New Section" id="btn-add" ng-click="viewSectionCreateModel()"><i class="fas fa-plus "></i></a></li>
	                	@endif
	                </ul>
	                <form method="GET" action="{{url('admin/section/export')}}">
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
		                            <th>Job</th>
		                            <th>Section</th>
		                            <th class="text-right">Task Count</th>
		                            <th class="text-left">Remark</th>
		                            <th class="text-center">Status</th>
		                            <th class="text-right">Action</th>
		                        </tr>
		                    </thead>
	                        <tbody>
	                        	<tr ng-repeat="section in sections.data track by $index">
	                        		<td>@{{$index+1}}</td>
	                        		<td class="text-left">
	                        			<a href="#">@{{section.job.reference_no}}</a>
	                        		</td>
	                        		<td style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;max-width: auto;">
	                        			<span>@{{section.name}}</span>
	                        		</td>
	                        		<td class="text-right">
	                        			<span title="@{{section.title}}">@{{section.tasks.length}}</span>
	                        		</td>
	                        		<td style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;max-width: 200px;">
	                        			<span title="@{{section.remark}}">@{{section.remark}}</span>
	                        		</td>
	                        		<td class="text-center">
	                        			<span ng-show="section.status == 0" class="badge bg-danger text-light">Not Started</span>
	                        			<span ng-show="section.status == 1" class="badge bg-primary text-light">In-progress</span>
	                        			<span ng-show="section.status == 2" class="badge bg-success text-light">Finished</span>
	                        		</td>
	                        		<td class="text-right">
                                        @if(\Entrust::hasRole('Admin'))
	                        			<button type="button" class="btn btn-xs btn-info btn-secondary btn-detail" title="Create New Task" data-job_id="@{{section.job_id}}" ng-click="createTaskView(section)">
	                        				<i class="fa fa-tasks"></i>
	                        			</button>	
	                        			<button type="button" class="btn btn-xs btn-warning btn-secondary btn-detail" title="Edit Section Details" data-id="@{{section.id}}" ng-click="editSection(section)">
	                        				<i class="fa fa-edit"></i>
	                        			</button>
	                        			<button type="button" class="btn btn-xs btn-danger btn-secondary btn-detail" title="Delete Section" data-id="@{{section.id}}" ng-click="deleteSection(section)">
	                        				<i class="fa fa-trash"></i>
	                        			</button>
	                        			@endif
	                        		</td>
	                        	</tr>
	                        	
	                    	</tbody>
		                </table>
		            </div>
		            <paging page="sections.current_page" page-size="sections.per_page" total="sections.total" show-prev-next="true" show-first-last="true" ul-class="pagination" paging-action="find(page)">
	            </div>
	        </div>
	    </div>
	    
	</div>

	<div class="modal fade" id="createSectionViewModel" tabindex="-1" role="dialog">
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
                                    <label>Job</label>
                                    <select name="job" id="job" class="select2-container form-control show-tick ms select2">
                                        <option value="">- Select Job -</option>
                                        <option ng-repeat="job in jobs" value="@{{job.id}}">@{{job.reference_no}} - @{{job.job_title}}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" class="form-control" id="section_name" name="section_name" placeholder="Enter section name..."/>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label>Remark</label>
                                    <textarea class="form-control" name="section_remark" id="section_remark" placeholder="Enter remark..."></textarea>
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

    <div class="modal fade" id="editSectionViewModel" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="title" id="largeModalLabel">Edit Section</h4>
                </div>
                
                <div class="modal-body">
                    <form action="" method="POST" role="form" id="edit-section-form" name="edit-section-form">
                        {{csrf_field()}}
                        <input type="hidden" name="edit_section_id" id="edit_section_id" value="@{{edit_section.id}}">
                        <div class="row" style="padding: 10px">
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
                                    <label>Name</label>
                                    <input type="text" class="form-control" id="edit_section_name" name="edit_section_name" placeholder="Enter section name..." value="@{{edit_section.name}}" />
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label>Remark</label>
                                    <textarea class="form-control" name="edit_section_remark" id="edit_section_remark" placeholder="Enter remark...">@{{edit_section.remark}}</textarea>
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
                                    <label>Job</label>
                                    <select name="_job" id="_job" class="select2-container form-control show-tick ms select2">
                                        <option value="">- Select Job -</option>
                                        <option ng-repeat="job in jobs" value="@{{job.id}}">@{{job.reference_no}} - @{{job.job_title}}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label>Section</label>
                                    <select name="_section" id="_section" class="select2-container form-control show-tick ms select2">
                                        <option value="">- Select Section -</option>
                                        <option ng-repeat="section in sections.data" value="@{{section.id}}">@{{section.name}}</option>
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
    app.controller("SectionManageController", function($scope,$http)
    {
    	$scope.sections = [];

    	$scope.jobs = [];

    	$scope.edit_section = [];

    	$scope.section_data = [];

    	$scope.page = 1;

    	$scope.technicians = [];
        $scope.task_categories = [];

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

        $.ajax({
            url: "{{url('admin/section/get-all-jobs')}}",
            type: 'GET',
            success: function (data) {
                $scope.jobs = data;
                $scope.$apply();
            },
            error:function(data) {
              $('.dialog-loader').hide();
            }
        });

        $scope.loadSectionData = function()
	    {
	        $.ajax({
	            url: "{{url('admin/section/get-all-sections')}}",
	            type: 'GET',
	            success: function (data) {
	                $scope.sections = data;
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
            status = $('#status').val();

            $.ajax({
	            url: "{{url('admin/section/get-all-sections')}}",
	            type: 'GET',
	            data: {
	            	page: page,
	            	job : job,
	            	keyword : keyword,
					status : status
	            },
	            success: function (data) {
	                $scope.sections = data;
	                $scope.$apply();
	            },
	            error:function(data) {
	              $('.dialog-loader').hide();
	            }
	        });
	    }

    	$scope.editSection = function(section)
    	{
    		$scope.edit_section = section;

    		$("#edit_job").val(section.job_id).trigger('change');
    	
    		$('#editSectionViewModel').modal('show');
    	}

    	$scope.deleteSection = function(section)
    	{
    		swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this section!",
                icon: "warning",
                showCancelButton: true,
                closeOnConfirm: true,
            },function(willDelete){
                if (willDelete)
                {
                    $.ajax({
                        url: "{{url('admin/section/delete')}}",
                        type: 'POST',
                        data: {
                            section_id : section.id
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

    	$scope.viewSectionCreateModel = function()
    	{
    		$('#createSectionViewModel').modal('show');
    	}

    	$("form#edit-section-form").submit(function(e)
    	{
            e.preventDefault();    
            var formData = new FormData(this);
            $('.dialog-loader').show();

            $.ajax({
                url: "{{url('admin/section/update')}}",
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

                        $('#editSectionModal').modal('hide');
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

        $scope.exportSectionData = function ()
        {
            keyword = $('#keyword').val();
            job = $('#job').val();
            status = $('#status').val();

            window.open('{{url('admin/section/export-data')}}?keyword='+keyword+'&job='+job+'&status='+status,'_blank');

            $scope.find();
        }

        $("form#create-section-form").submit(function(e)
        {
            e.preventDefault();    
            var formData = new FormData(this);
            $('.dialog-loader').show();

            $.ajax({
                url: "{{url('admin/section/create')}}",
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

        $("form#edit-section-form").submit(function(e)
        {
            e.preventDefault();    
            var formData = new FormData(this);
            $('.dialog-loader').show();

            $.ajax({
                url: "{{url('admin/section/update')}}",
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

        $scope.createTaskView = function(section)
    	{
    		$("#_job").val(section.job.id).trigger('change');
    		$("#_section").val(section.id).trigger('change');
    		$('#createTaskViewModal').modal('show');
    	}

    	$("form#create-task-form").submit(function(e)
        {
            e.preventDefault();    
            var formData = new FormData(this);

            formData.append('job', $("#_job").val());
            formData.append('section', $("#_section").val());

            $('.dialog-loader').show();

            $.ajax({
                url: "{{url('admin/job/task/create')}}",
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
