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
		                            <th>#</th>
		                            <th>Job</th>
		                            <th class="text-center">Status</th>
		                            <th>Client</th>
		                            <th>Location</th>
		                            <th>Raised / Due Date</th>
		                            <th>Created Date</th>
		                            <th>Action</th>
		                        </tr>
		                    </thead>
	                        <tbody>
	                        	<tr ng-repeat="job in jobs.data track by $index">
	                        		<td>@{{$index+1}}</td>
	                        		<td style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;max-width: 200px;">
	                        			<a href="#">@{{job.reference_no}}</a><span class="badge bg-info text-light">@{{job.category.name}}</span><br>
	                        			<span title="@{{job.job_title}}">@{{job.job_title}}</span>
	                        		</td>
	                        		<td class="text-center">
	                        			
	                        			<span ng-show="job.status == 0" class="badge bg-danger text-light">Pending</span>
	                        			<span ng-show="job.status == 1" class="badge bg-primary text-light">In-progress</span>
	                        			<span ng-show="job.status == 2" class="badge bg-success text-light">Finished</span>
	                        		</td>
	                        		<td>
	                        			<strong>@{{job.client.first_name}} @{{job.client.last_name}}</strong><br>
	                        			@{{job.client.phone}}<br>
	                        			@{{job.client.email}}
	                        		</td>
	                        		<td>
	                        			<p class="mb-0">@{{job.address}}</p>
	                        			<p class="mb-0">@{{job.city}}, @{{job.state}}, @{{job.postalcode}}</p>
	                        		</td>
	                        		<td>
	                        			@{{job.start_date | date}}<br>@{{job.end_date | date}}
	                        		</td>
	                        		<td class="text-center">
	                        			@{{job.created_at | amDateFormat:'MMM DD, YYYY'}}<br>@{{job.created_at | amDateFormat:'h:mm a z'}}
	                        		</td>
	                        		<td>
	                        			<button type="button" class="btn btn-xs btn-dark btn-secondary btn-detail" title="View Details" data-id="@{{job.id}}" ng-click="viewJobData(job)">
	                        				<i class="fa fa-eye"></i>
	                        			</button>

	                        			@if(\Entrust::hasRole('Admin'))
	                        			<button type="button" class="btn btn-xs btn-info btn-secondary btn-detail" title="Create New Task" data-id="@{{job.id}}" ng-click="createTaskView(job)">
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
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="form-group">
                                            <label>Job Category</label>
                                            <select name="edit_job_category" id="edit_job_category" class="select2-container form-control show-tick ms select2">
                                                <option value="">- Select Job Category -</option>
                                                <option ng-repeat="category in job_categories" value="@{{category.id}}">@{{category.name}}</option>
                                            </select>
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
		                                <div class="col-md-12">
		                                    <h6>
		                                    	<span class="badge bg-warning text-light ml-0">@{{job_data.category.name}}</span>
		                                    	<strong>@{{job_data.reference_no}} - @{{job_data.job_title}} </strong>
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
		                            <div class="row mt-2">
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
		                        </div>
		                    </div>
                		</div>
                	</div>
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
                                    <select name="job" id="job" class="select2-container form-control show-tick ms select2">
                                        <option value="">- Select Job -</option>
                                        <option ng-repeat="job in alljobs" value="@{{job.id}}">@{{job.reference_no}} - @{{job.job_title}}</option>
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
