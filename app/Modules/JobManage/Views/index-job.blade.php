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
                            <li style="display: inline;" class="breadcrumb-item active">Jobs</li>
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
                    	<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                            <label>Job Category</label>
                            <div class="input-group">   
                                <select name="job_category" id="job_category" class="select2-container form-control show-tick ms select2" required="required">
                                    <option value="">-ALL-</option>
                                    <option ng-repeat="job_category in job_categories" value="@{{job_category.id}}">@{{job_category.name}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                            <label>Job Type</label>
                            <div class="input-group">   
                                <select name="job_type" id="job_type" class="select2-container form-control show-tick ms select2" required="required">
                                    <option value="0">-ALL-</option>
                                    <option value="1">-One Time Job-</option>
                                    <option value="2">-Regular Job-</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                            <label>Client</label>
                            <div class="input-group">
                                <select name="client" id="client" class="select2-container form-control show-tick ms select2" required="required">
                                    <option value="">-ALL-</option>
                                    <option ng-repeat="client in clients" value="@{{client.id}}">@{{client.first_name}} @{{client.last_name}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
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
	                <div class="table-responsive">
		                <table class="table table-bordered table-hover mb-3 c_list">
		                    <thead>
		                        <tr>
		                            <th>#</th>
		                            <th>Job</th>
		                            <th>QR Code</th>
		                            <th>Client</th>
		                            <th>Time Spent</th>
		                            <th>Created Date</th>
		                            <th class="text-center">Action</th>
		                        </tr>
		                    </thead>
	                        <tbody>
	                        	<tr ng-repeat="job in jobs.data track by $index">
	                        		<td>@{{$index+1}}</td>
	                        		<td style="vertical-align: top;">
	                        			<a href="#">@{{job.reference_no}}</a><span class="badge bg-info text-light">@{{job.category.name}}</span><br>
	                        			<span title="@{{job.job_title}}" style="word-break: break-word;white-space: normal;">@{{job.job_title}}</span>
	                        			<small>@{{job.start_date | date}} | @{{job.end_date | date}}</small><br>
	                        			<strong>@{{job.job_cost | number:2}}</strong>
	                        			
	                        			
	                        			<span ng-show="job.status == 0" class="badge bg-danger text-light">Pending</span>
	                        			<span ng-show="job.status == 1" class="badge bg-primary text-light">In-progress</span>
	                        			<span ng-show="job.status == 2" class="badge bg-success text-light">Finished</span>
	                        			
	                        			<span ng-show="job.job_type_id == 1" class="badge bg-danger text-light">One Time Job</span>
	                        			<span ng-show="job.job_type_id == 2" class="badge bg-dark text-light">Regular Job</span>
	                        		</td>
	                        		<td class="text-center">
	                        			<img ng-show="job.job_type_id == 2" src="http://chart.apis.google.com/chart?cht=qr&chl=@{{job.reference_no}}&chs=120">
	                        			<br>
	                        			<a ng-show="job.job_type_id == 2" href="#" ng-click="exportPdf(job.reference_no)">Print</a>
	                        		</td>
	                        		<td style="vertical-align: top">
	                        			<strong>@{{job.client.first_name}} @{{job.client.last_name}}</strong><br>
	                        			@{{job.client.phone}}<br>
	                        			@{{job.client.email}}
	                        			
	                        			</br></br>

	                        			<p class="mb-0" style="vertical-align: top;word-break: break-word;white-space: normal;">@{{job.address}}</p>
	                        			<!-- <p class="mb-0">@{{job.city}}, @{{job.state}}, @{{job.postalcode}}</p> -->
	                        		</td>
	                        		<td style="vertical-align: top;text-align: right;">
	                        			@{{job.spend_time}}
	                        		</td>
	                        		<td class="text-center" style="vertical-align: top">
	                        			@{{job.created_at | amDateFormat:'MMM DD, YYYY'}}<br>@{{job.created_at | amDateFormat:'h:mm a z'}}
	                        		</td>
	                        		<td style="vertical-align: top">
	                        			<button type="button" class="btn btn-xs btn-dark btn-secondary btn-detail" title="View Details" data-id="@{{job.id}}" ng-click="viewJobData(job)">
	                        				<i class="fa fa-eye"></i>
	                        			</button>

	                        			<button type="button" class="btn btn-xs btn-dark btn-secondary btn-master" title="Config Master Data" data-id="@{{job.id}}" ng-click="masterDataConfig(job)">
	                        				<i class="fa fa-cogs"></i>
	                        			</button>

	                        			@if(\Entrust::hasRole('Admin'))
	                        			<button ng-show="!job.inspection" type="button" class="btn btn-xs btn-success btn-secondary btn-inspection" title="Create Inspection" data-id="@{{job.id}}" ng-click="createInspection(job)">
	                        				<i class="fa fa-bug"></i>
	                        			</button>
	                        			<button ng-show="job.inspection && job.job_type_id==2" type="button" class="btn btn-xs btn-success btn-secondary btn-inspection" title="Create Inspection" data-id="@{{job.id}}" ng-click="createInspection(job)">
	                        				<i class="fa fa-bug"></i>
	                        			</button>
	                        			<button ng-show="job.inspection && job.job_type_id==1" type="button" class="btn btn-xs btn-success btn-secondary btn-inspection" title="Inspection Already created" data-id="@{{job.id}}" ng-click="createInspection(job)" disabled="disabled">
	                        				<i class="fa fa-bug"></i>
	                        			</button>
	                        			<br>
	                        			<button ng-show="false" type="button" class="btn btn-xs btn-info btn-secondary btn-detail" title="Create New Task" data-id="@{{job.id}}" ng-click="createTaskView(job)">
	                        				<i class="fa fa-tasks"></i>
	                        			</button>
	                        			<button type="button" class="btn btn-xs btn-warning btn-secondary btn-detail" title="Edit Job Details" data-id="@{{job.id}}" ng-click="editJobDetails(job)">
	                        				<i class="fa fa-edit"></i>
	                        			</button>
	                        			<button type="button" class="btn btn-xs btn-danger btn-secondary btn-detail" title="Delete Job" data-id="@{{job.id}}" ng-click="deleteJob(job)">
	                        				<i class="fa fa-trash"></i>
	                        			</button>
                                        <button type="button" class="btn btn-xs btn-gray btn-secondary btn-detail" title="Cost Log" data-id="@{{job.id}}" ng-click="viewCostLogModel(job)">
                                            <i class="fa fa-money-check-alt"></i>
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

	<div class="modal fade" id="editJobModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="title" id="largeModalLabel">Edit Job - @{{edit_job.reference_no}}</h4>
                </div>
                
                <div class="modal-body">
                    <form role="form" class="form-validation" method="post" id="edit-job-form" name="edit-job-form" enctype="multipart/form-data">
                    {{csrf_field()}}
                    	<input type="hidden" name="edit_job_id" id="edit_job_id" value="@{{edit_job.id}}">
                        <div class="row" style="padding: 10px">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label>Job Category</label>
                                            <select name="edit_job_category" id="edit_job_category" class="select2-container form-control show-tick ms select2">
                                                <option value="">- Select Job Category -</option>
                                                <option ng-repeat="category in job_categories" value="@{{category.id}}">@{{category.name}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label>Contract Value</label>
                                            <input class="form-control text-right" id="edit_job_cost" name="edit_job_cost" placeholder="Enter contract value..." value="@{{edit_job.job_cost}}">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="form-group">
                                            <label>Client</label>
                                            <select name="edit_client" id="edit_client" class="select2-container form-control show-tick ms select2">
                                                <option value="">- Select Client -</option>
                                                <option ng-repeat="client in clients" value="@{{client.id}}">@{{client.first_name}} @{{client.last_name}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="form-group">
                                            <label>Title</label>
                                            <input class="form-control" id="edit_job_title" name="edit_job_title" placeholder="Enter job title..." value="@{{edit_job.job_title}}">
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label>Start Date</label>
                                            <input class="form-control" id="edit_start_date" name="edit_start_date" placeholder="Select Date..." value="@{{edit_job.start_date}}">
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label>End Date</label>
                                            <input class="form-control" id="edit_end_date" name="edit_end_date" placeholder="Select Date..." value="@{{edit_job.end_date}}">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="form-group">
                                            <label>Job Note</label>
                                            <textarea style="height: 220px" class="form-control" name="edit_job_note" id="edit_job_note" placeholder="Enter note...">@{{edit_job.description}}</textarea>
                                        </div>
                                    </div>       
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">

                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="form-group">
                                            <label>Location Address</label>
                                            <textarea class="form-control" name="edit_address" id="edit_address" placeholder="Enter location address...">@{{edit_job.address}}</textarea>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="form-group">
                                            <label>City</label>
                                            <input type="text" class="form-control" name="edit_city" id="edit_city" placeholder="Enter city..." value="@{{edit_job.city}}">
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label>State</label>
                                            <input type="text" class="form-control" name="edit_state" id="edit_state" placeholder="Enter state..." value="@{{edit_job.state}}">
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label>Postal Code</label>
                                            <input type="text" class="form-control" name="edit_postalcode" id="edit_postalcode" placeholder="Enter postalcode..." value="@{{edit_job.postalcode}}">
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="form-group">
                                            <label>Pick Location</label>
                                            <div style="height: 200px;" id="map"></div>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label>Longitude</label>
                                            <input type="text" class="form-control" name="edit_lng" id="edit_lng" placeholder="Enter longitiude..." value="@{{edit_job.lng}}">
                                        </div>
                                    </div>

                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label>Latitude</label>
                                            <input type="text" class="form-control" name="edit_lat" id="edit_lat" placeholder="Enter latitude..." value="@{{edit_job.lat}}">
                                        </div>
                                    </div>
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

    <div class="modal fade" id="jobDetailViewModel" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                
                <div class="modal-body">

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
				                            		<small class="text-dark">Location Address <a href="https://www.google.com/maps/search/@{{job_data.lat}},@{{job_data.lng}}/@6.0941207,80.1540219,15z/data=!3m1!4b1" target="_blank">View Map</a></small><br>
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
		                            		<img src="http://chart.apis.google.com/chart?cht=qr&chl=@{{job_data.reference_no}}&chs=170">
		                            	</div>
		                            </div>
		                            <div class="row mt-2" ng-show="job_data.job_type_id==1">
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

							                <div class="table-responsive">
								                <table class="table table-bordered table-hover mb-3 c_list">
								                    <thead>
								                        <tr>
								                            <th>#</th>
								                            <th>Section</th>
								                            <th>Ref. No</th>
								                            <th>Task</th>
								                            <th>Category</th>
								                            <th>Status</th>
								                        </tr>
								                    </thead>
							                        <tbody>
							                        	<tr ng-repeat="task in job_data.tasks track by $index">
							                        		<td>@{{$index+1}} <i class="text-danger fa fa-trash" ng-click="removeJobTask(task)"></i> </td>
							                        		<td>@{{task.section.name}}</td>
							                        		<td>@{{task.reference_no}}</td>
							                        		<td>@{{task.title}}</td>
							                        		<td>
							                        			@{{task.category.name}}
							                        		</td>
							                        		<td>
							                        			<span ng-show="task.status==0" class="badge bg-danger text-light ml-0">Not Started</span>
							                        			<span ng-show="task.status==1" class="badge bg-primary text-light ml-0">In-progress</span>
							                        			<span ng-show="task.status==2" class="badge bg-success text-light ml-0">Finished</span>
							                        		</td>
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

    <div class="modal fade" id="jobConfigViewModel" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form action="" method="POST" role="form" id="job-config-form">
                {{csrf_field()}}
	                <div class="modal-header pr-0">
	                	<div class="row" style="width: 100%">
	                        <div class="col-md-8">
	                            <h4><strong>Create Sections & Tasks</strong></h4>
	                        </div>
	                        <div class="col-md-4 pull-right pr-0">
	                            <select name="assign_technician" id="assign_technician" class="select2-container form-control show-tick ms select2" required="required">
                                    <option value="0">-Select Technician-</option>
                                    <option ng-repeat="technician in technicians" value="@{{technician.id}}">@{{technician.employee_no}} - @{{technician.first_name}} @{{technician.last_name}}</option>
                                </select>
	                        </div>
	                    </div>
	                </div>
	                <div class="modal-body" style="max-height: 500px;overflow-y: scroll;">
	                	<div class="row">
                            <input type="hidden" id="job_config_id" name="job_config_id">
                            <div class="col-md-12" ng-repeat="section in master_sections">
                            	<table class="table table-bordered table-hover mb-3 c_list">
                            		<tr>
                            			<td style="width: 1%">
                            				<input type="checkbox" style="margin-right: 5px" name="section_@{{section.id}}" id="section_@{{section.id}}" value="@{{section.id}}" ng-click="toggle(this,section.id)" ng-checked="selected_sections.indexOf(section.id) !== -1">
                            			</td>
                            			<td>
                            				<h5 class="m-0">@{{section.name}}</h5>
                            			</td>
                            		</tr>

                            		<tr ng-repeat="task in section.master_tasks">
                            			<td style="width: 1%">
                            				<input type="checkbox" style="margin-right: 5px" name="task_@{{section.id}}" id="task_@{{section.id}}_@{{task.id}}" ng-click="toggleTask(section.id,task.id)" value="@{{task.id}}" ng-checked="selected_tasks.indexOf(task.id) !== -1">
                            			</td>
                            			<td>
                            				<p class="m-0">@{{task.name}}</p>
                            			</td>
                            		</tr>
                            	</table>
                            	
                            </div>
                        </div>
                    </div>
	                <div class="modal-footer">
	                	<div class="row">
	                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	                            <button type="submit" class="btn btn-primary float-right">Save</button>
	                        </div>
	                    </div>
	                </div>
                </form>
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
                                    <select name="job" id="job" class="select2-container form-control show-tick ms select2">
                                        <option value="">- Select Job -</option>
                                        <option ng-repeat="job in alljobs" value="@{{job.id}}">@{{job.reference_no}} - @{{job.job_title}}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label>Section</label>
                                    <select name="section" id="section" class="select2-container form-control show-tick ms select2">
                                        <option value="">- Select Section -</option>
                                        <option ng-repeat="section in sections" value="@{{section.id}}">@{{section.name}}</option>
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

    <div class="modal fade" id="costLogViewModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="title" id="largeModalLabel">Job Cost Logs - @{{cost_job_data.reference_no}}</h4>

                    <button type="button" class="btn btn-circle btn-xs btn-info btn-secondary" title="Cost Log" data-id="@{{job.id}}" ng-click="createCostLogModel(cost_job_data)" style="border-radius: 100%;width: 30px;height: 30px">
                        <i class="fa fa-plus"></i>
                    </button>
                </div>
                
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover mb-3 c_list">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Cost Type</th>
                                    <th>Remark</th>
                                    <th>Effective Date</th>
                                    <th>Created Date</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="cost_log in cost_logs track by $index">
                                    <td>@{{$index+1}}</td>
                                    <td class="text-left">
                                        @{{cost_log.cost_type.name}}
                                    </td>
                                    <td class="text-left">
                                        @{{cost_log.remark}}
                                    </td>
                                    <td class="text-left">
                                        @{{cost_log.effective_date | amDateFormat:'MMM DD, YYYY'}}
                                    </td>
                                    <td class="text-left">
                                        @{{cost_log.created_at | amDateFormat:'MMM DD, YYYY'}} @{{cost_log.created_at | amDateFormat:'h:mm a z'}}
                                    </td>
                                    <td class="text-right">
                                        @{{cost_log.cost_amount | number:2 }}
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5" class="text-right"><h5>Total</h5></td>
                                    <td class="text-right"><h5>@{{ getTotal() | number:2 }}</h5></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="createCostViewModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="title" id="largeModalLabel">Costing Log</h4>
                </div>
                
                <div class="modal-body">
                    <form action="" method="POST" role="form" id="create-cost-form" name="create-cost-form">
                        {{csrf_field()}}
                        <div class="row" style="padding: 10px">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label>Job</label>
                                    <select name="cost_job" id="cost_job" class="select2-container form-control show-tick ms select2">
                                        <option value="">- Select Job -</option>
                                        <option ng-repeat="job in alljobs" value="@{{job.id}}">@{{job.reference_no}} - @{{job.job_title}}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label>Cost Type</label>
                                    <select name="cost_type" id="cost_type" class="select2-container form-control show-tick ms select2">
                                        <option value="">- Select Cost Type -</option>
                                        <option ng-repeat="cost_type in cost_types" value="@{{cost_type.id}}">@{{cost_type.name}}</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label>Remark</label>
                                    <textarea class="form-control" id="remark" name="remark" placeholder="Enter task title..."></textarea>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label>Amount</label>
                                    <input type="text" class="form-control" name="cost_amount" id="cost_amount" placeholder="Enter amount..."/>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label>Effective Date</label>
                                    <input type="text" class="form-control" name="effective_date" id="effective_date" placeholder="Select effective date..."/>
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

    <div class="modal fade" id="createInspectionViewModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="title" id="largeModalLabel">Job Inspection Create</h4>
                </div>
                
                <div class="modal-body">
                    <form action="" method="POST" role="form" id="create-inspection-form" name="create-inspection-form">
                        {{csrf_field()}}
                        <div class="row" style="padding: 10px">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label>Inspect Manager</label>
                                    <select name="manager" id="manager" class="select2-container form-control show-tick ms select2">
                                        <option value="">- Select Manager -</option>
                                        <option ng-repeat="technician in technicians" value="@{{technician.id}}">@{{technician.employee_no}} - @{{technician.first_name}} @{{technician.last_name}}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label>Inspection Date</label>
                                    <input type="text" class="form-control" name="inspection_date" id="inspection_date" placeholder="Select inspection date..."/>
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

        $('#inspection_date').datepicker({
            format: 'yyyy-mm-dd',
            todayHighlight: true,
            autoclose: true
        });

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

    	$scope.sections = [];

    	$scope.alljobs = [];

        $scope.cost_types = [];
        $scope.cost_logs = [];
        $scope.cost_job_data = [];

    	$scope.edit_job = [];

    	$scope.job_data = [];

    	$scope.page = 1;

    	$scope.technicians = [];
        $scope.task_categories = [];

        $scope.master_sections  = [];
        $scope.selected_sections  = [];
        $scope.selected_tasks  = [];

        $scope.technicians  = [];

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
            job_type = $('#job_type').val();
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
					job_type : job_type,
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
            job_type = $('#job_type').val();
            client = $('#client').val();
            status = $('#status').val();

            from_date = $('#from_date').val();
            to_date = $('#to_date').val();

            window.open('{{url('admin/job/export-data')}}?keyword='+keyword+'&job_category='+job_category+'&job_type='+job_type+'&client='+client+'&status='+status+'&from_date='+from_date+'&to_date='+to_date,'_blank');

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

		$scope.loadSections = function(job)
    	{
    		$.ajax({
	            url: "{{url('admin/section/get-job-sections')}}",
	            type: 'GET',
	            data: {job:job},
	            success: function (data) {
	                $scope.sections = data;
	                $scope.$apply();
	            },
	            error:function(data) {
	              $('.dialog-loader').hide();
	            }
	        });
    	}

		$scope.createTaskView = function(job)
    	{
    		$scope.loadSections(job.id);

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
                    $scope.cost_logs = data.cost_logs;
                    $scope.cost_job_data = data;
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

        $scope.createInspection = function(job)
        {
        	$scope.inspection_job = job.id;
        	$('#createInspectionViewModal').modal('show');
        }

        $("form#create-inspection-form").submit(function(e)
        {
            e.preventDefault();    
            var formData = new FormData(this);
            $('.dialog-loader').show();

            formData.append('job',$scope.inspection_job);

            $.ajax({
                url: "{{url('admin/job/create-inspection')}}",
                type: 'POST',
                data: formData,
                success: function (data)
                {
                	if(data.status_code == 200)
                    {
                        $('#createInspectionViewModal').modal('hide');

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

        $scope.exportPdf = function (reference_no)
        {
            window.open('{{url('admin/job/export-qr-pdf')}}?job='+reference_no,'_blank');
        }

        $scope.masterDataConfig = function (job)
        {
        	$scope.loadMasterTaskData();
        	$('#job_config_id').val(job.id);

            $('#jobConfigViewModel').modal('show');

            $scope.loadJobTaskData(job);

            console.log($scope.selected_sections);
            console.log($scope.selected_tasks);
        }

        $scope.loadMasterTaskData = function ()
        {
        	$.ajax({
	            url: "{{url('admin/job/getMasterSectionWithTask')}}",
	            type: 'GET',
	            success: function (data) {
	                $scope.master_sections = data;
	                $scope.$apply();
	            },
	            error:function(data) {
	              $('.dialog-loader').hide();
	            }
	        });
        }

        $scope.loadJobTaskData = function (job)
        {
        	$.each(job.tasks,function(k,v)
        	{
        		if($scope.selected_sections.indexOf(v.master_section_id) == -1)
                {
                    $scope.selected_sections.push(v.master_section_id);
                }

                if($scope.selected_tasks.indexOf(v.master_task_id) == -1)
                {
                	$scope.selected_tasks.push(v.master_task_id);
                }
        	});
        }

        $scope.toggle = function(ele,section_id)
        {
            checkboxes = document.getElementsByName('task_'+section_id);
                
            if(!$('#section_'+section_id).is(':checked'))
            {
                if($scope.selected_sections.indexOf(section_id) != -1)
                {
                    $scope.selected_sections.splice($scope.selected_sections.indexOf(section_id), 1);
                }

                for(var i=0, n=checkboxes.length;i<n;i++) {
                    document.getElementById(checkboxes[i].id).checked = false;
                    $scope.selected_tasks.splice($scope.selected_tasks.indexOf(document.getElementById(checkboxes[i].id).value), 1);
                }
            }else{

                if($scope.selected_sections.indexOf(section_id) == -1)
                {
                    $scope.selected_sections.push(section_id);
                }

                for(var i=0, n=checkboxes.length;i<n;i++) {
                    document.getElementById(checkboxes[i].id).checked = true;
                    $scope.selected_tasks.push(document.getElementById(checkboxes[i].id).value);
                }
            }
        }

        $scope.toggleTask = function(section_id,task_id)
        {
            if(!$('#task_'+section_id+'_'+task_id).is(':checked'))
            {
                $scope.selected_tasks.splice($scope.selected_tasks.indexOf(task_id), 1);

            }else{

            	if($scope.selected_sections.indexOf(section_id) == -1)
                {
                    $scope.selected_sections.push(section_id);
                }

                $scope.selected_tasks.push(task_id);

            }
        }

        $("form#job-config-form").submit(function(e)
        {
            e.preventDefault();    
            var formData = new FormData(this);
            formData.append('selected_tasks',$scope.selected_tasks);
            formData.append('selected_sections',$scope.selected_sections);
            $('.dialog-loader').show();

            $.ajax({
                url: "{{url('admin/job/config')}}",
                type: 'POST',
                data: formData,
                success: function (data)
                {
                    if(data.status_code == 200)
                    {
                        $('#jobConfigViewModel').modal('hide');

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

        $scope.removeJobTask = function(task)
        {
        	$('#jobDetailViewModel').modal('hide');

            $.ajax({
                url: "{{url('admin/task/delete')}}",
                type: 'POST',
                data: {task_id:task.id},
                success: function (data)
                {
                	if(data.status_code == 200)
                    {
                    	swal({
                            title: data.message,
                            text: data.debug,
                        });

                        $scope.find($scope.page);

                        $.ajax({
				            url: "{{url('admin/job/get-job-details')}}",
				            type: 'GET',
				            data: {job:task.job_id},
				            success: function (data)
				            {
				                $scope.job_data = data;
				                $scope.$apply();

    							$('#jobDetailViewModel').modal('show');
				            },
				            error:function(data) {
				              $('.dialog-loader').hide();
				            }
				        });
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
        }
    	
    });//end controller

</script>
@stop
