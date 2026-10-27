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
                            <li style="display: inline;" class="breadcrumb-item active">View Job</li>
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
	                <h2>Job View</h2>
	                <ul class="header-dropdown">

	                	<li><a class="tab_btn table-btn" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="" data-original-title="Export Job List" ng-click="exportJobData()"><i class="fas fa-download "></i></a></li>
	                	@if(\Entrust::hasRole('Admin'))
	                	<li><a class="tab_btn table-btn" href="{{url('admin/job/create')}}" data-toggle="tooltip" data-placement="top" title="" data-original-title="Create New Job" id="btn-add"><i class="fas fa-plus "></i></a></li>
	                	@endif
	                </ul>
	                <form method="GET" action="{{url('admin/job/export')}}">
	                	<input type="hidden" name="keyword" class="form-control" value="{{$request->keyword}}">
	                	<input type="hidden" name="status" class="form-control" value="{{$request->status}}">
		            </form>
	            </div>

	            <div class="body">
	                <div class="row">
                		<div class="col-md-12">
                			<div class="card">
		                        <div class="header">
		                            <div class="row">
		                                <div class="col-md-9">
		                                    <h6>
		                                    	<span class="badge bg-warning text-light ml-0">@{{job_data.category.name}}</span>
		                                    	<br>
		                                    	<h4><strong>@{{job_data.reference_no}} - @{{job_data.job_title}} </strong></h4>
		                                    </h6>
		                                </div>
		                                <div class="col-md-3 text-right qr-div">
		                                	<img src="http://chart.apis.google.com/chart?cht=qr&chl=@{{job_data.reference_no}}&chs=120">
		                                </div>
		                            </div>
		                        </div>
		                        <div class="body text-justify">
		                        	<div class="row">
		                            	<div class="col-md-12">
		                            		<p>@{{job_data.description}}</p>
		                            	</div>
		                            </div>
		                            <div class="row">
		                            	<div class="col-md-3 text-left">
		                            		<div class="row">
		                            			<div class="col-md-12">
				                            		<small class="text-dark">Job Start Date </small><br>
				                            		<p class="text-danger">@{{job_data.start_date}}</p>
				                            	</div>
		                            		</div>
		                            		<div class="row">
		                            			<div class="col-md-12">
				                            		<small class="text-dark">Job End Date </small><br>
		                            				<p class="text-danger">@{{job_data.end_date}}</p>
				                            	</div>
		                            		</div>
		                            		<div class="row">
		                            			<div class="col-md-12">
				                            		<small class="text-dark">Status </small><br>
		                            				<span ng-show="job_data.status == 0" class="badge bg-danger text-light ml-0">Pending</span>
		                            				<span ng-show="job_data.status == 1" class="badge bg-info text-light ml-0">In-Progress</span>
		                            				<span ng-show="job_data.status == 2" class="badge bg-success text-light ml-0">Finished</span>
				                            	</div>
		                            		</div>
		                            	</div>

		                            	<div class="col-md-3 text-left">
		                            		<div class="row">
		                            			<div class="col-md-12">
				                            		<small class="text-dark">Client Name </small><br>
				                            		<p class="text-muted">@{{job_data.client.first_name}} @{{job_data.client.last_name}}</p>
				                            	</div>
		                            		</div>
		                            		<div class="row">
		                            			<div class="col-md-12">
				                            		<small class="text-dark">Client Contact </small><br>
		                            				<p class="text-muted">@{{job_data.client.phone}}</p>
				                            	</div>
		                            		</div>
		                            		<div class="row">
		                            			<div class="col-md-12">
				                            		<small class="text-dark">Client Email </small><br>
		                            				<p class="text-muted">@{{job_data.client.email}}</p>
				                            	</div>
		                            		</div>
		                            	</div>

		                            	<div class="col-md-3 text-left">
		                            		<div class="row">
		                            			<div class="col-md-12">
				                            		<small class="text-dark">Location Address </small><br>
				                            		<p class="text-muted">@{{job_data.address}}</p>
				                            	</div>
		                            		</div>
		                            		<div class="row">
		                            			<div class="col-md-12">
				                            		<small class="text-dark">City / State </small><br>
		                            				<p class="text-muted">@{{job_data.city}} / @{{job_data.state}}</p>
				                            	</div>
		                            		</div>
		                            		<div class="row">
		                            			<div class="col-md-12">
				                            		<small class="text-dark">Postal Code </small><br>
		                            				<p class="text-muted">@{{job_data.postalcode}}</p>
				                            	</div>
		                            		</div>
		                            	</div>

		                            	<div class="col-md-3 text-left">
		                            		<div class="row">
		                            			<div class="col-md-12">
				                            		<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3274.057795454146!2d138.6571045151676!3d-34.854775080395186!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6ab0b594a93e4ee7%3A0x900d0fcc4ae04d15!2sLurline%20Ave%2C%20Gilles%20Plains%20SA%205086%2C%20Australia!5e0!3m2!1sen!2slk!4v1619856282029!5m2!1sen!2slk" width="160" height="160" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
				                            	</div>
		                            		</div>
		                            	</div>
		                            </div>
		                            <div class="row mt-2">
		                            	<div class="col-md-12">
		                            		<div class="row">
		                            			<div class="col-md-3">
		                            				<div class="card" style="background: #FDEDD3">
		                        						<div class="body text-center p-1">
		                        							<i class="fa fa-stopwatch p-2" style="font-size: 20px;color: #424242"></i>
		                        							<h4 style="color: #FF9E00;font-weight: bolder">@{{calculateTotalHours(job_data.start_date,job_data.end_date)}}</h4>
		                        						</div>
		                        						<div class="footer text-center">
		                        							<p style="color: #343434">Total Hours</p>
		                        						</div>
		                        					</div>
		                            			</div>

		                            			<div class="col-md-3">
		                            				<div class="card" style="background: #D1FAEA">
		                        						<div class="body text-center p-1">
		                        							<i class="fa fa-history p-2" style="font-size: 20px;color: #424242"></i>
		                        							<h4 style="color: #409875;font-weight: bolder">@{{calculateRemainingHours(job_data.start_date,job_data.end_date)}}</h4>
		                        						</div>
		                        						<div class="footer text-center">
		                        							<p style="color: #343434">Remaining Hours</p>
		                        						</div>
		                        					</div>
		                            			</div>

		                            			<div class="col-md-3">
		                            				<div class="card" style="background: #E3D4FF">
		                        						<div class="body text-center p-1">
		                        							<i class="fa fa-list p-2" style="font-size: 20px;color: #424242"></i>
		                        							<h4 style="color: #5B399A;font-weight: bolder">@{{job_data.tasks.length}}</h4>
		                        						</div>
		                        						<div class="footer text-center">
		                        							<p style="color: #343434">Total Task</p>
		                        						</div>
		                        					</div>
		                            			</div>

		                            			<div class="col-md-3">
		                            				<div class="card" style="background: #F8ECEC">
		                        						<div class="body text-center p-1">
		                        							<i class="fa fa-tasks p-2" style="font-size: 20px;color: #424242"></i>
		                        							<h4 style="color: #9F4040;font-weight: bolder">@{{countRemainingTask(job_data.tasks)}}</h4>
		                        						</div>
		                        						<div class="footer text-center">
		                        							<p style="color: #343434">Remaining Task</p>
		                        						</div>
		                        					</div>
		                            			</div>
		                            			
		                            		</div>
		                            	</div>
		                            </div>
		                        </div>
		                    </div>
		                    <div class="card">
		                    	<div class="body text-justify pt-1">
		                            <div class="row mt-2" ng-show="job_data.job_type_id==1">
		                            	<div class="col-md-6" style="max-height: 500px;overflow: scroll;">
		                            		<h6 style="margin-bottom: 1rem"><strong>Task List</strong></h6>
		                            		<div class="timeline-item" date-is="@{{task.created_at}}" ng-repeat="task in job_data.tasks track by $index">
				                                <h6>@{{task.reference_no}} - @{{task.title}}</h6>

				                                <div class="msg">
				                                	<span class="badge bg-info text-light ml-0">@{{task.category.name}}</span>

				                                	<span ng-show="task.status==0" class="badge bg-danger text-light ml-0">Not Started</span>
				                        			<span ng-show="task.status==1" class="badge bg-primary text-light ml-0">In-progress</span>
				                        			<span ng-show="task.status==2" class="badge bg-success text-light ml-0">Finished</span>
				                                </div>
				                                <span><a href="javascript:void(0);">Start At</a> @{{task.start_at}}</span>
				                                <span><a href="javascript:void(0);">End At</a> @{{task.start_at}}</span>
				                                <div class="msg">
				                                    <p>@{{task.remark}}</p>
				                                </div>                                
				                            </div>
		                            	</div>

		                            	<div class="col-md-6" style="max-height: 500px;overflow: scroll;">
		                            		<h6 style="margin-bottom: 1rem"><strong>Job Time Line</strong></h6>
		                            		<div class="timeline-item" date-is="@{{transaction.created_at}}" ng-repeat="transaction in job_data.transactions">
				                                <h6>@{{transaction.action}}</h6>
				                                <span><a href="javascript:void(0);">@{{transaction.actionby.username}}</a> @{{transaction.created_at}}</span>
				                                <div class="msg">
				                                    <p>@{{transaction.remark}}</p>
				                                </div>                                
				                            </div>
		                            	</div>
		                            </div>

		                            <div class="row mt-2" ng-show="job_data.job_type_id==2">
		                            	<div class="col-md-12" style="max-height: 500px;overflow: scroll;">
		                            		<h6 style="margin-bottom: 1rem"><strong>Transaction List</strong></h6>
		                            		<div class="table-responsive">
								                <table class="table table-bordered table-hover mb-3 c_list">
								                    <thead>
								                        <tr>
								                            <th>#</th>
								                            <th>Employee</th>
								                            <th>Checking At</th>
								                            <th>Checkout At</th>
								                            <th>Spend Time</th>
								                        </tr>
								                    </thead>
							                        <tbody>
							                        	<tr ng-repeat="transaction in job_data.regular_transactions track by $index">
							                        		<td>@{{$index+1}}</td>
							                        		<td>@{{transaction.actionby.username}}</td>
							                        		<td>@{{transaction.started_at}}</td>
							                        		<td>@{{transaction.ended_at}}</td>
							                        		<td>@{{transaction.spend_time}}</td>
							                        	</tr>
							                        </tbody>
							                    </table>
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
    app.controller("JobManageController", function($scope,$http)
    {
    	$scope.jobs = [];

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

        $scope.loadJobData = function()
	    {
	        $.ajax({
	            url: "{{url('admin/job/get-job-details')}}",
	            type: 'GET',
	            data: 
	            success: function (data) {
	                $scope.jobs = data;
	                $scope.$apply();
	            },
	            error:function(data) {
	              $('.dialog-loader').hide();
	            }
	        });
	    };

	    $scope.viewJobData = function(job)
    	{
    		$scope.job_data = job;
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

		$scope.exportPdf = function (reference_no)
        {
            window.open('{{url('admin/job/export-qr-pdf')}}?job='+reference_no,'_blank');
        }
    	
    });//end controller

</script>
@stop
