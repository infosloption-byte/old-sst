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
<div ng-app="ngApp" ng-controller="JobManageController" ng-init="loadJobData()">

	<div class="block-header">
	    <div class="row">
	        <div class="col-lg-6 col-md-8 col-sm-12">
	            <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth">
	                <i class="fa fa-arrow-left"></i></a> Employee Management</h2>
	            
	        </div>            
	        <div class="col-lg-6 col-md-4 col-sm-12">
	            <div class="row float-right mr-0">
	                <ul class="breadcrumb pull-right">
	                    <li class="breadcrumb-item"><a href="index.html"><i class="icon-home"></i></a></li>                           
	                    <li class="breadcrumb-item">Employee Management</li>
	                    <li class="breadcrumb-item active">Employee List</li>
	                </ul>
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
                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                            <label>Date Range(From)</label>
                            <div class="input-group">
                                <input name="from_date" id="from_date" class="form-control" placeholder="From Date..." type="text">
                            </div>
                        </div>
                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                            <label>Date Range(To)</label>
                            <div class="input-group">
                                <input name="to_date" id="to_date" class="form-control" placeholder="To Date..." type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                    	<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                            <label>Job Category</label>
                            <div class="input-group">   
                                <select name="job_category" id="job_category" class="select2-container form-control show-tick ms select2" required="required">
                                    <option value="">-ALL-</option>
                                    <option ng-repeat="job_category in job_categories" value="@{{job_category.id}}">@{{job_category.name}}</option>
                                </select>
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
	                <h2>Job List</h2>
	                <ul class="header-dropdown">

	                	<li><a class="tab_btn table-btn" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="" data-original-title="Export Job List" ng-click="exportJobData()"><i class="fas fa-download "></i></a></li>

	                	<li><a class="tab_btn table-btn" href="{{url('admin/job/create')}}" data-toggle="tooltip" data-placement="top" title="" data-original-title="Create New Job" id="btn-add"><i class="fas fa-plus "></i></a></li>

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
		                            <td></td>
		                            <th>Name</th>                                    
		                            <th>Employee No</th>                                   
		                            <th>Department</th>                                   
		                            <th>Phone</th>
		                            <th>Created at</th>
		                            <th>Role</th>
		                            <th>User Account</th>
		                            <th>Action</th>
		                        </tr>
		                    </thead>
	                        <tbody>
	                        	<tr ng-repeat="employee in employees.data track by $index">
	                        		<td>
                                        @if(isset($employee->user) && $employee->user->image==null)
											<img src="{{asset('assets/admin_panel/images/user-avatar.png')}}" 
	                                        		class="rounded-circle avatar" alt="">
                                        @else
                                        	@if(isset($employee->user->image))
											<img src="{{url('storage')}}/{{$employee->user->image}}" 
	                                        		class="rounded-circle avatar" alt="">
	                                       	@else
	                                       		<img src="{{asset('assets/admin_panel/images/user-avatar.png')}}" 
	                                        		class="rounded-circle avatar" alt="">
	                                        @endif
                                        @endif
                                    </td>
                                    <td>
                                        <h6 class="mb-0"><a href="">{{$employee->first_name}} {{$employee->last_name}}</a></h6>
                                        <span>{{$employee->email}}</span>
                                        @if($employee->designation)
                                        <br><strong class="text-info">{{$employee->designation->name}}</strong>
                                    	@endif
                                    </td>
                                    <td>
                                    	<span>#{{$employee->employee_no}}</span><br> <span class="badge badge-danger">{{$employee->type}}</span>
                                    </td>
                                    <td>
                                    	<span class="badge badge-success">{{$employee->department->name}}</span>
                                    	@if($employee->is_hod)
                                    	<span class="badge badge-danger">HOD</span>
                                    	@endif
                                    </td>
                                    <td><span>{{$employee->phone}}</span></td>
                                    <td>{{$employee->created_at->format('Y-m-d')}}</td>
                                    <td>
                                    	@if($employee->user)
	                                    	@foreach($employee->user->roles as $role)
	                                    	<span class="badge badge-danger">{{$role->name}}</span>
	                                    	@endforeach
                                    	@else
                                    		not assigned
                                    	@endif
                                    </td>
                                    <td>
                                    	@if($employee->user)
                                    		<span class="badge badge-success">created</span><br>
                                    		<small>Username {{$employee->user->username}}</small>
                                    	@else
                                    		---
                                    	@endif
                                    </td>
                                    <td>
                                        <!-- <button type="button" class="btn btn-success btn-mail" title="Send Mail" data-id="{{$employee->id}}"><i class="fa fa-paper-plane"></i></button> -->
                                        <button type="button" class="btn btn-info btn-edit" title="Edit" data-id="{{$employee->id}}"><i class="fa fa-edit"></i></button>
                                        <button type="button" class="btn btn-primary btn-profile" title="Change Profile Picture" data-id="{{$employee->id}}"><i class="fa fa-camera"></i></button>
		                                <button type="button" data-type="confirm" class="btn btn-danger js-sweetalert btn-delete" title="Delete"
		                                data-id="{{$employee->id}}"><i class="fa fa-trash"></i></button>
		                                @if($user->employee_id==1)
	                                        <button type="button" class="btn btn-sm btn-success btn-reset" title="Password Reset" data-id="{{$employee}}">
	                                        	<i class="fa fa-user-shield"></i>
	                                        </button>
	                                    @endif
                                    </td>
	                        	</tr>
	                    	</tbody>
		                </table>
		            </div>
		            <paging page="jobs.current_page" page-size="jobs.per_page" total="jobs.total" show-prev-next="true" show-first-last="true" ul-class="pagination" paging-action="find(page)">
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

        $('#effective_date').datepicker({
            format: 'yyyy-mm-dd',
            todayHighlight: true
        });

        $('#from_date').datepicker({
            format: 'yyyy-mm-dd',
            todayHighlight: true
        });

        $('#to_date').datepicker({
            format: 'yyyy-mm-dd',
            todayHighlight: true
        });

        $('#start_date').datepicker({
            format: 'yyyy-mm-dd',
            todayHighlight: true
        });

        $('#end_date').datepicker({
            format: 'yyyy-mm-dd',
            todayHighlight: true
        });

        $('#edit_start_date').datepicker({
            format: 'yyyy-mm-dd',
            todayHighlight: true
        });

        $('#edit_end_date').datepicker({
            format: 'yyyy-mm-dd',
            todayHighlight: true
        });

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
    var app = angular.module("ngApp",['angularMoment','dualmultiselect','angularImgFallback','ui.bootstrap','ngSanitize','bw.paging']);


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
    	$scope.clients = [];
    	$scope.job_categories = [];
    	$scope.jobs = [];

    	$scope.alljobs = [];

        $scope.cost_types = [];
        $scope.cost_logs = [];
        $scope.cost_job_data = [];

    	$scope.edit_job = [];

    	$scope.job_data = [];

    	$scope.page = 1;

    	$scope.technicians = [];
        $scope.task_categories = [];

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

        $.ajax({
            url: "{{url('admin/job/categoryList')}}",
            type: 'GET',
            success: function (data) {
                $scope.job_categories = data;
                $scope.$apply();
            },
            error:function(data) {
              $('.dialog-loader').hide();
            }
        });

        $.ajax({
            url: "{{url('admin/job/get-cost-types')}}",
            type: 'GET',
            success: function (data) {
                $scope.cost_types = data;
                $scope.$apply();
            },
            error:function(data) {
              $('.dialog-loader').hide();
            }
        });

        $scope.loadJobData = function()
	    {
	        $.ajax({
	            url: "{{url('admin/job/get-job-list')}}",
	            type: 'GET',
	            success: function (data) {
	                $scope.jobs = data;
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
            job_category = $('#job_category').val();
            client = $('#client').val();
            status = $('#status').val();

            from_date = $('#from_date').val();
            to_date = $('#to_date').val();

	        $.ajax({
	            url: "{{url('admin/job/get-job-list')}}",
	            type: 'GET',
	            data: {
	            	page: page,
	            	keyword : keyword,
					job_category : job_category,
					client : client,
					status : status,
					from_date : from_date,
					to_date : to_date
	            },
	            success: function (data) {
	                $scope.jobs = data;
	                $scope.$apply();
	            },
	            error:function(data) {
	              $('.dialog-loader').hide();
	            }
	        });
	    }

	    $scope.editJobDetails = function(job)
    	{
    		$scope.edit_job = job;

    		$("#edit_client").val(job.client_id).trigger('change');
    		$("#edit_job_category").val(job.job_category_id).trigger('change');

    		$('#editJobModal').modal('show');
    	}

	    $scope.deleteJob = function(job)
    	{
    		swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this job!",
                icon: "warning",
                showCancelButton: true,
                closeOnConfirm: true,
            },function(willDelete){
                if (willDelete)
                {
                    $.ajax({
                        url: "{{url('admin/job/delete')}}",
                        type: 'POST',
                        data: {
                            job_id : job.id
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

    	$scope.viewJobData = function(job)
    	{
    		$scope.job_data = job;

    		$('#jobDetailViewModel').modal('show');
    	}

    	$("form#edit-job-form").submit(function(e)
    	{
            e.preventDefault();    
            var formData = new FormData(this);
            $('.dialog-loader').show();

            $.ajax({
                url: "{{url('admin/job/update')}}",
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

                        $('#editJobModal').modal('hide');
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

        $scope.exportJobData = function ()
        {
            keyword = $('#keyword').val();
            job_category = $('#job_category').val();
            client = $('#client').val();
            status = $('#status').val();

            from_date = $('#from_date').val();
            to_date = $('#to_date').val();

            window.open('{{url('admin/job/export-data')}}?keyword='+keyword+'&job_category='+job_category+'&client='+client+'&status='+status+'&from_date='+from_date+'&to_date='+to_date,'_blank');

            $scope.find();
        }

        $scope.calculateTotalHours = function(start,end)
        {
		    let date = new Date(start);
		    let currentDate = new Date(end);

		    let days = Math.floor((currentDate.getTime() - date.getTime()) / 1000 / 60 / 60 / 24);
		    
		    return ((days+1)*8);
		}

		$scope.calculateRemainingHours = function(start,end)
        {
		    let startdate = new Date(start);
		    let endDate = new Date(end);
		    let currentDate = new Date(end);

		    let totaldays = Math.floor((endDate.getTime() - startdate.getTime()) / 1000 / 60 / 60 / 24);

		    let spenddays = Math.floor((currentDate.getTime() - startdate.getTime()) / 1000 / 60 / 60 / 24);
		    
		    return (((totaldays+1) - spenddays)*8);
		}

		$scope.countRemainingTask = function(tasks)
		{
			var tmp = [];

			$.each(tasks,function(k,v)
			{
				if(v.status != 2)
				{
					tmp.push(v);
				}
			});

			return tmp.length;
		}

		$scope.createTaskView = function(job)
    	{
    		$("#job").val(job.id).trigger('change');
    		$('#createTaskViewModal').modal('show');
    	}

        $scope.getTotal = function()
        {
            var total = 0;
            for(var i = 0; i < $scope.cost_logs.length; i++){
                var tmp = $scope.cost_logs[i].cost_amount;
                total += tmp;
            }

            return total;
        }

        $scope.viewCostLogModel = function(job)
        {
            $scope.cost_logs = job.cost_logs;
            $scope.cost_job_data = job;
            $('#costLogViewModal').modal('show');
        }

        $scope.createCostLogModel = function(job)
        {
            $scope.cost_logs = job.cost_logs;
            $scope.cost_job_data = job;

            $('#costLogViewModal').modal('hide');
            $("#cost_job").val(job.id).trigger('change');
            $('#createCostViewModal').modal('show');
        }

        $scope.loadJobCostLogData = function(job)
        {
            $.ajax({
                url: "{{url('admin/job/get-job-cost-log-data')}}",
                type: 'GET',
                data: {
                    job_id : job.id
                },
                success: function (data) {
                    $scope.cost_logs = job.cost_logs;
                    $scope.cost_job_data = job;
                    $scope.$apply();
                },
                error:function(data) {
                  $('.dialog-loader').hide();
                }
            });
        }

		$("form#create-task-form").submit(function(e)
        {
            e.preventDefault();    
            var formData = new FormData(this);
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

        $("form#create-cost-form").submit(function(e)
        {
            e.preventDefault();    
            var formData = new FormData(this);
            $('.dialog-loader').show();

            $.ajax({
                url: "{{url('admin/job/create-log-cost')}}",
                type: 'POST',
                data: formData,
                success: function (data)
                {
                    if(data.status_code == 200)
                    {
                        $('#createCostViewModal').modal('hide');

                        swal({
                            title: data.message,
                            text: data.debug,
                        });

                        $scope.find($scope.page);

                        $scope.loadJobCostLogData($scope.cost_job_data);
                        $scope.viewCostLogModel($scope.cost_job_data);
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
