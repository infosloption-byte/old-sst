@extends('master.master')

@section('css')

<link rel="stylesheet" href="{{asset('assets/admin_panel/dist/c3/c3.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/admin_panel/dist/bootsrap-fileinput/css/fileinput.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/admin_panel/dist/bootsrap-fileinput/themes/explorer-fa/theme.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/admin_panel/dist/select2/select2.css')}}">
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
<div ng-app="ngApp" ng-controller="InquiryManageController" ng-init="loadInquiryData()">

	<div class="block-header">
        <div class="row">
            <div class="col-lg-8 col-md-6 col-sm-12 col-12">
                <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth">
                    <i class="fa fa-arrow-left"></i></a> Inquiry Management</h2>
            </div>            
            <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                <div class="row">
                    <div class="col-md-12">
                        <ul class="breadcrumb float-right">
                            <li style="display: inline;" class="breadcrumb-item"><a href="index.html"><i class="icon-home"></i></a></li>                           
                            <li style="display: inline;" class="breadcrumb-item">Inquiry Management</li>
                            <li style="display: inline;" class="breadcrumb-item active">Inquiries</li>
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
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="input-group">
                                <input name="inquiry_no" id="inquiry_no" class="form-control" placeholder="Inquiry No..." type="text">
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
	                <h2>Inquiry List</h2>
	                <form method="GET" action="{{url('admin/inquiries/export')}}">
	                	<ul class="header-dropdown">
	                		<li><a class="tab_btn table-btn" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="" data-original-title="Download Inquiry List" ng-click="export()"><i class="fas fa-download "></i></a></li>
		                	<li><a class="tab_btn table-btn" href="{{url('admin/inquiries/create')}}" data-toggle="tooltip" data-placement="top" title="" data-original-title="Create New Inquiry" id="btn-add"><i class="fas fa-plus "></i></a></li>
		                </ul>
		            </form>
	            </div>

	            <div class="body">
	                <div class="table-responsive">
		                <table class="table table-bordered table-hover mb-3 c_list">
		                    <thead>
		                        <tr>
		                            <th>#</th>
		                            <th>Inquiry</th>                                       
		                            <th>Name</th>                                       
		                            <th>Contact No</th>
		                            <th>Email</th>
		                            <th>Subject</th>
		                            <th>Notes</th>
		                            <th class="text-center">Status</th>
		                            <th>Action</th>
		                        </tr>
		                    </thead>
	                        <tbody>
	                        	<tr ng-repeat="inquiry in inquiries.data track by $index">
	                        		<td>@{{$index+1}}</td>
	                        		<td>
	                        			<span class="badge bg-info text-light">@{{inquiry.inq_no}}</span>
	                        		</td>
	                        		<td>
	                        			@{{inquiry.first_name}} @{{inquiry.last_name}}<br>
	                        			<span ng-show="inquiry.client_id" class="badge bg-success text-light" data-toggle="tooltip">Registered Client</span>
	                        			<span ng-show="inquiry.job_id" ng-click="viewJob(inquiry.job_id)" class="badge bg-primary text-light" data-toggle="tooltip">@{{inquiry.job.reference_no}}</span>
	                        		</td>
	                        		<td>
	                        			<strong>
	                        				@{{inquiry.contact_no}}
	                        			</strong>
	                        		</td>
	                        		<td>
	                        			<strong>
	                        				<a href="mailto:@{{inquiry.email}}?Subject=About:@{{inquiry.inq_no}}">@{{inquiry.email}}</a>
	                        			</strong>
	                        		</td>
	                        		<td style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;max-width: 200px;">
	                        			
	                        			<span ng-show="inquiry.title!=''" class="link" data-toggle="tooltip" data-placement="bottom" data-original-title="@{{inquiry.title}}">@{{inquiry.title}}</span>

	                        			<span ng-show="inquiry.title==''" class="link" data-toggle="tooltip" data-placement="bottom">--</span>
	                        		</td>
	                        		<td style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;max-width: 200px;">
	                        			<span ng-show="inquiry.notes!=''" class="link" data-toggle="tooltip" data-placement="bottom" data-original-title="@{{inquiry.notes}}">@{{inquiry.notes}}</span>
	                        			<span ng-show="inquiry.notes==''" class="link" data-toggle="tooltip" data-placement="bottom">--</span>
	                        		</td>
	                        		<td class="text-center">
	                        			<span ng-show="inquiry.status==0" class="badge bg-warning text-light">pending</span>
                					
                						<span ng-show="inquiry.status==1" class="badge bg-success text-light">Approved</span><br>
                						<small>@{{inquiry.approved_at}}</small>
                					
                						<span ng-show="inquiry.status==2" class="badge bg-danger text-light">Rejected</span> <br>
                						<small>@{{inquiry.rejected_at}}</small>
	                        		</td>
	                        		<td>
	                        			<button type="button" class="btn btn-xs btn-info btn-secondary btn-view" title="View Details" data-id="@{{inquiry.id}}" ng-click="viewDetails(inquiry)">
	                        				<i class="fa fa-eye"></i>
	                        			</button>

	                        			@if(\Entrust::can('inquiry.accept'))
	                        			<button ng-show="inquiry.status==0" type="button" class="btn btn-xs btn-success btn-secondary btn-accept" title="Approve"
	                        			 data-id="@{{inquiry.id}}" ng-click="inquiryAccept(inquiry)">
	                        				<i class="fa fa-check"></i>
	                        			</button>

	                        			<button ng-show="inquiry.status!=0" disabled="disabled" type="button" class="btn btn-xs btn-success btn-secondary btn-accept" title="Approve Disabled"
	                        			 data-id="@{{inquiry.id}}" ng-click="inquiryAccept(inquiry)">
	                        				<i class="fa fa-check"></i>
	                        			</button>
	                        			@endif

	                        			@if(\Entrust::can('inquiry.accept'))
	                        			<button style="display: none" type="button" class="btn btn-xs btn-primary btn-secondary btn-job" title="Create Job"
	                        			 data-id="@{{inquiry.id}}" ng-click="inquiryToJob(inquiry)">
	                        				<i class="fa fa-bars"></i>
	                        			</button>
	                        			@endif

	                        			@if(\Entrust::can('inquiry.reject'))
	                        			<button ng-show="inquiry.status==0" type="button" class="btn btn-xs btn-danger btn-secondary btn-reject" title="Reject" 
	                        			data-id="@{{inquiry.id}}" ng-click="inquiryReject(inquiry)">
	                        				<i class="fa fa-times"></i>
	                        			</button>

	                        			<button ng-show="inquiry.status!=0" type="button" class="btn btn-xs btn-danger btn-secondary btn-reject" title="Reject Disabled" 
	                        			data-id="@{{inquiry.id}}" ng-click="inquiryReject(inquiry)">
	                        				<i class="fa fa-times"></i>
	                        			</button>
	                        			@endif
	                        		</td>
	                        	</tr>
	                    	</tbody>
		                </table>
		            </div>
		            <paging page="inquiries.current_page" page-size="inquiries.per_page" total="inquiries.total" show-prev-next="true" show-first-last="true" ul-class="pagination" paging-action="find(page)">
	            </div>
	        </div>
	    </div>
	    
	</div>

	<div class="modal fade" id="inquiryModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-body">
                	<div class="row">
                    	<div class="col-md-12">
                    		<div class="card">
		                        <div class="header">
		                            <h5><strong>Inquiry Details</strong></h5>
		                        </div>
		                        <div class="body">

		                        	<small class="text-muted">Reference No: </small>
		                            <p>
		                            	<span class="badge bg-dark text-light">@{{inquiryDetails.inq_no}}</span>
		                            	<span ng-show="inquiryDetails.status == 0" class="badge bg-warning text-light">PENDING</span>
		                            	<span ng-show="inquiryDetails.status == 1" class="badge bg-primary text-light">APPROVED</span>
		                            	<span ng-show="inquiryDetails.status == 2" class="badge bg-danger text-light">REJECTED</span>
		                            </p>
		                            <hr>
		                            <small class="text-muted">Inquire By: </small>
		                            <p>
		                            	@{{inquiryDetails.first_name}} @{{inquiryDetails.last_name}}<br>
		                            	<span ng-show="inquiryDetails.client" class="badge bg-info text-light ml-0">Registered Client</span><span ng-show="!inquiryDetails.client" class="badge bg-info text-light ml-0">Unregistered Client</span>
		                            </p>
		                            <hr>
		                            <small class="text-muted">Title: </small>
		                            <p>@{{inquiryDetails.title}}</p>
		                            <hr>
		                            <small class="text-muted">Note: </small>
		                            <p>@{{inquiryDetails.notes}}</p>
		                            <hr>
		                            <small class="text-muted">Inquired Date: </small>
		                            <p>@{{inquiryDetails.created_at | amDateFormat:'MMM DD, YYYY'}} @{{inquiryDetails.created_at | amDateFormat:'h:mm a z'}}</p>
		                            <hr>
		                        </div>
		                    </div>
                    	</div>
                    	<div class="col-md-12">
                    		<div class="row">
                    			<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4" ng-repeat="img in inquiryDetails.attachments">
	                                <div class="card">
	                                    <div class="card-body p-0">
	                                        <img style="width: 100%" src="{{url('storage')}}/@{{img.image_url}}">
	                                    </div>
	                                    <div class="card-footer text-center">
	                                        <button style="font-size: 10px" type="button" class="img-view btn btn-sm btn-kv btn-info btn-outline-secondary" title="Remove image" ng-click="imageView(img)"><i class="glyphicon glyphicon-zoom-in"></i></button>
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
<script src="{{asset('assets/dist/moment/moment.js')}}"></script>
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
    app.controller("InquiryManageController", function($scope,$http)
    {
    	$scope.inquiries = [];

    	$scope.page = 1;

    	$scope.inquiryDetails = [];

    	$scope.loadInquiryData = function()
	    {
	        $.ajax({
	            url: "{{url('admin/inquiries/get-inquiry-list')}}",
	            type: 'GET',
	            success: function (data) {
	                $scope.inquiries = data;
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

	    $scope.viewDetails = function (inquiry)
	    {
	    	$scope.inquiryDetails = inquiry;

 			console.log($scope.inquiryDetails);

 			$('#inquiryModal').modal();
	    }

	    $scope.imageView = function(image)
        {
            window.open("{{url('storage/uploads/repairs')}}/"+image.file_name,'_blank');
        };

	    $scope.inquiryAccept = function (inquiry)
	    {
	    	id = inquiry.id;
	    	showConfirmMessage('Accept','Would you like to Accept this?','Yes Accept','info',function(isConfirm) {
 				if(isConfirm){
					$.ajax({
			            url: "{{url('admin/inquiries/approve')}}",
			            type: 'POST',
			            data: {
			            	'id' : id
			            },
			            success: function (data)
			            {
			              if(data.status_code = 200)
			              {
				              swal({title: "Success!",text: "Inquiry Approved."});

						      location.reload();
			              }else{
			              	swal({title: "Error!",text: "Error approving."});
			              }

			            },
			            error:function(data) {
			              swal({title: "Error!",text: "Error approving."});
			            }
			        });
	 			}
	 		});
	    }

	    $scope.inquiryToJob = function (inquiry)
	    {

	    }

	    $scope.inquiryReject = function (inquiry)
	    {
	    	id = inquiry.id;
       		swal({
		        title: "Reject!",
		        text: "Enter reason to reject",
		        type: "input",
		        showCancelButton: true,
		        closeOnConfirm: false,
		        inputPlaceholder: "Write something"
		    }, function (inputValue) {
		        if (inputValue === false) return false;
		        if (inputValue === "") {
		            swal.showInputError("Write here...."); return false
		        }

		        $.ajax({
		            url: "{{url('admin/inquiries/reject')}}",
		            type: 'POST',
		            data: {
		            	'id' : id,
		            	'reason' : inputValue
		        	},
		            success: function (data) {
		              if(data.status_code = 200)
		              {
			              swal({title: "Success!",text: "Inquiry Rejected."});

			              location.reload();
		              }else{
		              	swal({title: "Error!",text: "Error rejecting."});
		              }

		            },
		            error:function(data) {
		              swal({title: "Error!",text: "Error rejecting."});
		            }
		        });

		    });
	    }
    });//end controller

</script>
@stop
