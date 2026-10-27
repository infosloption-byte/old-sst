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
<div ng-app="ngApp" ng-controller="AppointmentManageController" ng-init="loadAppointmentData()">

	<div class="block-header">
        <div class="row">
            <div class="col-lg-8 col-md-6 col-sm-12 col-12">
                <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth">
                    <i class="fa fa-arrow-left"></i></a> Appointment Management</h2>
            </div>            
            <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                <div class="row">
                    <div class="col-md-12">
                        <ul class="breadcrumb float-right">
                            <li style="display: inline;" class="breadcrumb-item"><a href="index.html"><i class="icon-home"></i></a></li>                           
                            <li style="display: inline;" class="breadcrumb-item">Appointment Management</li>
                            <li style="display: inline;" class="breadcrumb-item active">Appointments</li>
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
	                <form method="GET" action="{{url('admin/appointments/export')}}">
	                	<ul class="header-dropdown">
	                		<li><a class="tab_btn table-btn" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="" data-original-title="Download Inquiry List" ng-click="export()"><i class="fas fa-download "></i></a></li>
		                	<li><a class="tab_btn table-btn" href="{{url('admin/appointments/create')}}" data-toggle="tooltip" data-placement="top" title="" data-original-title="Create New Inquiry" id="btn-add"><i class="fas fa-plus "></i></a></li>
		                </ul>
		            </form>
	            </div>

	            <div class="body">
	                <div class="table-responsive">
		                <table class="table table-bordered table-hover mb-3 c_list">
		                    <thead>
		                        <tr>
		                            <th>#</th>
		                            <th>Code</th>                                       
		                            <th>Name</th>                                       
		                            <th>Contact No</th>
		                            <th>Email</th>
		                        </tr>
		                    </thead>
	                        <tbody>
	                        	<tr ng-repeat="appointment in appointments.data track by $index">
	                        		<td>@{{$index+1}}</td>
	                        		<td>
	                        			<span class="badge bg-info text-light">@{{appointment.code}}</span>
	                        		</td>
	                        		<td>
	                        			@{{appointment.first_name}} @{{appointment.last_name}}
	                        		</td>
	                        		<td>
	                        			<strong>
	                        				@{{appointment.contact_no}}
	                        			</strong>
	                        		</td>
	                        		<td>
	                        			<strong>
	                        				<a href="mailto:@{{appointment.email}}?Subject=About:@{{appointment.code}}">@{{appointment.email}}</a>
	                        			</strong>
	                        		</td>
	                        	</tr>
	                    	</tbody>
		                </table>
		            </div>
		            <paging page="appointments.current_page" page-size="appointment.per_page" total="appointment.total" show-prev-next="true" show-first-last="true" ul-class="pagination" paging-action="find(page)">
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
    app.controller("AppointmentManageController", function($scope,$http)
    {
    	$scope.appointments = [];

    	$scope.page = 1;

    	$scope.loadAppointmentData = function()
	    {
	        $.ajax({
	            url: "{{url('admin/appointments/get-appointment-list')}}",
	            type: 'GET',
	            success: function (data) {
	                $scope.appointments = data;
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

            from_date = $('#from_date').val();
            to_date = $('#to_date').val();

	        $.ajax({
	            url: "{{url('admin/appointments/get-appointment-list')}}",
	            type: 'GET',
	            data: {
	            	page: page,
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

    });//end controller

</script>
@stop
