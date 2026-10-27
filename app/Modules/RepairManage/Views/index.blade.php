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
<div ng-app="ngApp" ng-controller="RepairController" ng-init="loadRepairData()">

	<div class="block-header">
        <div class="row">
            <div class="col-lg-8 col-md-6 col-sm-12 col-12">
                <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth">
                    <i class="fa fa-arrow-left"></i></a> Repair Management</h2>
            </div>            
            <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                <div class="row">
                    <div class="col-md-12">
                        <ul class="breadcrumb float-right">
                            <li style="display: inline;" class="breadcrumb-item"><a href="index.html"><i class="icon-home"></i></a></li>                           
                            <li style="display: inline;" class="breadcrumb-item">Repair Management</li>
                            <li style="display: inline;" class="breadcrumb-item active">Repairs</li>
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
                            <label>Type</label>
                            <div class="input-group">
                                <select name="repair_type" id="repair_type" class="select2-container form-control show-tick ms select2">
                                    <option value="">- ALL -</option>
                                    <option ng-repeat="repair_type in repair_types" value="@{{repair_type.id}}">@{{repair_type.name}}</option>
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
                                    <option value="2">-REPAIRED-</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                            <label>Date Range(From)</label>
                            <div class="input-group">
                                <input name="from_date" id="from_date" class="form-control" placeholder="From Date..." type="text">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                            <label>Date Range(To)</label>
                            <div class="input-group">
                                <input name="to_date" id="to_date" class="form-control" placeholder="To Date..." type="text">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                            <label>Reported User</label>
                            <div class="input-group">
                                <select name="reported_user" id="reported_user" class="select2-container form-control show-tick ms select2" required="required">
                                    <option value="">-ALL-</option>
                                    <option ng-repeat="reported_user in reported_users" value="@{{reported_user.id}}">@{{reported_user.employee.employee_no}} - @{{reported_user.employee.first_name}} @{{reported_user.employee.last_name}}</option>
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
	                <h2>Repair List</h2>
	                <ul class="header-dropdown">

	                	<li><a class="tab_btn table-btn" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="" data-original-title="Export Repair List" ng-click="exportRepairData()"><i class="fas fa-download "></i></a></li>

	                	<li><a class="tab_btn table-btn" href="{{url('admin/repair/create')}}" data-toggle="tooltip" data-placement="top" title="" data-original-title="Create New Repair" id="btn-add"><i class="fas fa-plus "></i></a></li>

	                </ul>
	                <form method="GET" action="{{url('admin/repair/export')}}">
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
		                            <th>Reference</th>
		                            <th class="text-left">Reported By</th>
		                            <th class="text-left">Remark</th>
		                            <th class="text-left">Reported Date</th>
		                            <th>Location</th>
		                            <th>Asset</th>
		                            <th>Attachments</th>
		                            <th>Action</th>
		                        </tr>
		                    </thead>
	                        <tbody>
	                        	<tr ng-repeat="repair in repairs.data track by $index">
	                        		<td>@{{$index+1}}</td>
	                        		<td>
	                        			<a href="#">@{{repair.reference_no}}</a>
	                        		</td>
	                        		<td class="text-left">
	                        			@{{repair.createdby.name}}
	                        		</td>
	                        		<td style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;max-width: 200px;">
	                        			@{{repair.remark}}
	                        		</td>
	                        		<td>
	                        			@{{repair.created_at | amDateFormat:'MMM DD, YYYY'}}<br>@{{repair.created_at | amDateFormat:'h:mm a z'}}
	                        		</td>
	                        		<td>
	                        			@{{repair.location}}<br>
	                        			@{{repair.lat}}<br>
	                        			@{{repair.lng}}<br>
	                        		</td>
	                        		<td>@{{repair.asset}}</td>
	                        		<td>
	                        			<a href="{{url('storage')}}/@{{attachment.image_url}}" target="_blank" ng-repeat="attachment in repair.attachments">
	                        				<img src="{{url('storage')}}/@{{attachment.image_url}}" style="width: 100px;margin-right: 5px;">
	                        			</a>
	                        		</td>
	                        		<td>
	                        			<button type="button" class="btn btn-xs btn-dark btn-secondary btn-detail" title="View Details"
	                        			 data-id="@{{repair.id}}" ng-click="viewRepairData(repair)">
	                        				<i class="fa fa-eye"></i>
	                        			</button>
	                        			<button type="button" class="btn btn-xs btn-warning btn-secondary btn-detail" title="Edit Repair Details" data-id="@{{repair.id}}" ng-click="editRepairDetails(repair)">
	                        				<i class="fa fa-edit"></i>
	                        			</button>
	                        			<button type="button" class="btn btn-xs btn-danger btn-secondary btn-detail" title="Delete Repair" data-id="@{{repair.id}}" ng-click="deleteRepair(repair)">
	                        				<i class="fa fa-trash"></i>
	                        			</button>
	                        		</td>
	                        	</tr>
	                    	</tbody>
		                </table>
		            </div>
		            <paging page="repairs.current_page" page-size="repairs.per_page" total="repairs.total" show-prev-next="true" show-first-last="true" ul-class="pagination" paging-action="find(page)">
	            </div>
	        </div>
	    </div>
	    
	</div>

	<div class="modal fade" id="repairDetailViewModel" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                
                <div class="modal-body">
                    <div class="row">
                    	<div class="col-md-6">
                    		<div class="card">
		                        <div class="header">
		                            <h5><strong>Repair Details</strong></h5>
		                        </div>
		                        <div class="body">

		                        	<small class="text-muted">Reference No: </small>
		                            <p>@{{repair_data.reference_no}}</p>
		                            <hr>
		                            <small class="text-muted">Reported By: </small>
		                            <p>@{{repair_data.createdby.name}}</p>
		                            <hr>
		                            <small class="text-muted">Reported Date: </small>
		                            <p>@{{repair_data.created_at | amDateFormat:'MMM DD, YYYY'}} @{{repair_data.created_at | amDateFormat:'h:mm a z'}}</p>
		                            <hr>
		                            <small class="text-muted">Repair Type: </small>
		                            <p><span class="badge bg-info text-light ml-0">@{{repair_data.repair_type.name}}</span></p>
		                            <hr>
		                            <small class="text-muted">Status: </small>
		                            <p>
		                            	<span ng-show="repair_data.status == 0" class="badge bg-danger text-light">Not Started</span>
		                            	<span ng-show="repair_data.status == 1" class="badge bg-primary text-light">In-progress</span>
		                            	<span ng-show="repair_data.status == 2" class="badge bg-success text-light">REPAIRED</span>
		                            </p>
		                            <hr>
		                            <small class="text-muted">Remark: </small>
		                            <p>@{{repair_data.remark}}</p>
		                            <hr>

		                        </div>
		                    </div>
                    	</div>
                    	<div class="col-md-8">
                    		<div class="row">
                    			<div class="col-md-12">
                    				<div class="card">
				                        <div class="header">
				                            <h5><strong>Location</strong></h5>
				                        </div>
				                        <div class="body">
				                            <div class="row">
		                            			<div class="col-md-12">
		                            				<p>@{{repair_data.location}}</p>
				                            		<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3274.057795454146!2d138.6571045151676!3d-34.854775080395186!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6ab0b594a93e4ee7%3A0x900d0fcc4ae04d15!2sLurline%20Ave%2C%20Gilles%20Plains%20SA%205086%2C%20Australia!5e0!3m2!1sen!2slk!4v1619856282029!5m2!1sen!2slk" width="100%" height="200" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
				                            	</div>
		                            		</div>
				                        </div>
				                    </div>
                    			</div>
                    			<div class="col-md-12">
                    				<div class="row">
                            			<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4" ng-repeat="img in repair_data.attachments">
			                                <div class="card">
			                                    <div class="card-body p-0">
			                                        <img style="width: 100%" src="{{url('storage')}}/@{{img.image_url}}">
			                                    </div>
			                                    <div class="card-footer text-center">
			                                        <button style="font-size: 10px" type="button" class="img-remove btn btn-sm btn-kv btn-danger btn-outline-secondary" title="Remove image" ng-click="imageRemove(img.id)"><i class="glyphicon glyphicon-trash"></i></button>
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
    </div>

    <div class="modal fade" id="editRepairModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="title" id="largeModalLabel">Edit Repair Details</h4>
                </div>
                
                <div class="modal-body">
                    <form role="form" class="form-validation" method="post" id="edit-repair-form" name="edit-repair-form" enctype="multipart/form-data">
                    {{csrf_field()}}
                    	<input type="hidden" name="edit_repair_id" id="edit_repair_id" value="@{{edit_repair.id}}">
                        <div class="row" style="padding: 10px">
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Repair Type</label>
                                    <select name="edit_repair_type" id="edit_repair_type" class="select2-container form-control show-tick ms select2">
                                        <option value="">- Select Type -</option>
                                        <option ng-repeat="repair_type in repair_types" value="@{{repair_type.id}}">@{{repair_type.name}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Report By</label>
                                    <select name="edit_report_by" id="edit_report_by" class="select2-container form-control show-tick ms select2">
                                        <option value="">- Select User -</option>
                                        <option ng-repeat="reported_user in reported_users" value="@{{reported_user.id}}">@{{reported_user.name}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label>Asset Detail</label>
                                    <input class="form-control" id="edit_asset" name="edit_asset" placeholder="Enter asset detail..." value="@{{edit_repair.asset}}">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label>Remark</label>
                                    <textarea class="form-control" name="edit_remark" id="edit_remark" placeholder="Enter remark...">@{{edit_repair.remark}}</textarea>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label>Location</label>
                                    <textarea class="form-control" id="edit_location" name="edit_location" placeholder="Enter location of incident...">@{{edit_repair.location}}</textarea>
                                </div>
                            </div>

                        	<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4" ng-repeat="img in edit_repair.attachments">
                                <div class="card">
                                    <div class="card-body p-0">
                                        <img style="width: 100%" src="{{url('storage')}}/@{{img.image_url}}">
                                    </div>
                                    <div class="card-footer text-center">
                                        <button style="font-size: 10px" type="button" class="img-remove btn btn-sm btn-kv btn-danger btn-outline-secondary" title="Remove image" ng-click="imageRemove(img.id)"><i class="glyphicon glyphicon-trash"></i></button>
                                        <button style="font-size: 10px" type="button" class="img-view btn btn-sm btn-kv btn-info btn-outline-secondary" title="Remove image" ng-click="imageView(img)"><i class="glyphicon glyphicon-zoom-in"></i></button>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label>Attachments</label>
                                    <div class="file-loading">
                                        <input id="repair_images" name="repair_images[]" multiple type="file" data-show-upload="false" data-show-remove="false" data-show-upload-indicator="false">
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

        $('#from_date').datepicker({
            format: 'yyyy-mm-dd',
            todayHighlight: true
        });

        $('#to_date').datepicker({
            format: 'yyyy-mm-dd',
            todayHighlight: true
        });

        $("#repair_images").fileinput({
            uploadUrl: "/file-upload-batch/2",
            previewFileIcon: '<i class="fas fa-file"></i>',
            allowedPreviewTypes: ['image', 'text'], // allow only preview of image & text files
            previewFileIconSettings: {
                'docx': '<i class="fas fa-file-word text-primary"></i>',
                'xlsx': '<i class="fas fa-file-excel text-success"></i>',
                'pptx': '<i class="fas fa-file-powerpoint text-danger"></i>',
                'pdf': '<i class="fas fa-file-pdf text-danger"></i>',
                'zip': '<i class="fas fa-file-archive text-muted"></i>',
            }
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
    app.controller("RepairController", function($scope,$http)
    {
    	$scope.reported_users = [];
    	$scope.repair_types = [];
    	$scope.repairs = [];

    	$scope.edit_repair = [];

    	$scope.page = 1;

    	$.ajax({
            url: "{{url('admin/repair/get-users')}}",
            type: 'GET',
            success: function (data) {
                $scope.reported_users = data;
                $scope.$apply();
            },
            error:function(data) {
              $('.dialog-loader').hide();
            }
        });

        $.ajax({
            url: "{{url('admin/repair/repairTypeList')}}",
            type: 'GET',
            success: function (data) {
                $scope.repair_types = data;
                $scope.$apply();
            },
            error:function(data) {
              $('.dialog-loader').hide();
            }
        });

        $scope.loadRepairData = function()
	    {
	        $.ajax({
	            url: "{{url('admin/repair/get-repair-list')}}",
	            type: 'GET',
	            success: function (data) {
	                $scope.repairs = data;
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
            repair_type = $('#repair_type').val();
            reported_user = $('#reported_user').val();
            status = $('#status').val();

            from_date = $('#from_date').val();
            to_date = $('#to_date').val();

	        $.ajax({
	            url: "{{url('admin/repair/get-repair-list')}}",
	            type: 'GET',
	            data: {
	            	page: page,
	            	keyword : keyword,
					repair_type : repair_type,
					reported_user : reported_user,
					status : status,
					from_date : from_date,
					to_date : to_date
	            },
	            success: function (data) {
	                $scope.repairs = data;
	                $scope.$apply();
	            },
	            error:function(data) {
	              $('.dialog-loader').hide();
	            }
	        });
	    }

	    $scope.editRepairDetails = function(repair)
    	{
    		$scope.edit_repair = repair;

    		$("#edit_repair_type").val(repair.repair_type_id).trigger('change');
    		$("#edit_report_by").val(repair.created_by).trigger('change');

    		$('#editRepairModal').modal('show');
    	}

    	$scope.deleteRepair = function(repair)
    	{
    		swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this repair!",
                icon: "warning",
                showCancelButton: true,
                closeOnConfirm: true,
            },function(willDelete){
                if (willDelete)
                {
                    $.ajax({
                        url: "{{url('admin/repair/delete')}}",
                        type: 'POST',
                        data: {
                            repair_id : repair.id
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

    	$scope.viewRepairData = function(repair)
    	{
    		$scope.repair_data = repair;

    		$('#repairDetailViewModel').modal('show');
    	}

    	$("form#edit-repair-form").submit(function(e)
    	{
            e.preventDefault();    
            var formData = new FormData(this);
            $('.dialog-loader').show();

            $.ajax({
                url: "{{url('admin/repair/update')}}",
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

                        $('#editRepairModal').modal('hide');
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

        $scope.exportRepairData = function ()
        {
            keyword = $('#keyword').val();
            repair_type = $('#repair_type').val();
            reported_user = $('#reported_user').val();
            status = $('#status').val();

            from_date = $('#from_date').val();
            to_date = $('#to_date').val();

            window.open('{{url('admin/repair/export-data')}}?keyword='+keyword+'&repair_type='+repair_type+'&reported_user='+reported_user+'&status='+status+'&from_date='+from_date+'&to_date='+to_date,'_blank');

            $scope.find();
        }

        $scope.imageRemove = function(id)
        {
            showConfirmMessage('Image Delete','Are you sure to delete this image?','Yes delete','info',function(isConfirm) {
                if(isConfirm)
                {
                    $.ajax({
                        url: "{{url('admin/repair/delete-repair-image')}}",
                        type: 'POST',
                        data: {image_id: id},
                        success: function (data)
                        {
                            if(data.status_code == 200)
                            {
                                swal(data.message,data.debug,'success');

                                $scope.find($scope.page);
                            }else{
                                swal(data.message,data.debug,'error');
                            }
                        },
                        error:function(data) {
                          $('.dialog-loader').hide();
                        }
                    });
                }
            });
        };

        $scope.imageView = function(image)
        {
            window.open("{{url('storage/uploads/repairs')}}/"+image.file_name,'_blank');
        };
    });//end controller

</script>
@stop
