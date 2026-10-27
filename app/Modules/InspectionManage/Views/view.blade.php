@extends('master.master')

@section('css')

<link rel="stylesheet" href="{{asset('assets/admin_panel/dist/c3/c3.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/admin_panel/dist/bootsrap-fileinput/css/fileinput.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/admin_panel/dist/bootsrap-fileinput/themes/explorer-fa/theme.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/admin_panel/dist/select2/select2.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/admin_panel/dist/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/admin_panel/css/timepicker.css')}}">

<link rel="stylesheet" href="https://www.wrraptheme.com/templates/lucid/html/assets/vendor/chartist/css/chartist.min.css">
<link rel="stylesheet" href="https://www.wrraptheme.com/templates/lucid/html/assets/vendor/chartist-plugin-tooltip/chartist-plugin-tooltip.css">

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
	.color-lowlight{
		color: #00000066;
	}
	.section-task{
		border-bottom: 1px dashed;
		padding-top: 20px;
		padding-bottom: 20px;
	}
</style>
@stop

@section('content')
<div ng-app="ngApp" ng-controller="JobManageController" ng-init="loadJobData()">

	<div class="block-header">
        <div class="row">
            <div class="col-lg-8 col-md-6 col-sm-12 col-12">
                <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth">
                    <i class="fa fa-arrow-left"></i></a> Inspection Management</h2>
            </div>            
            <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                <div class="row">
                    <div class="col-md-12">
                        <ul class="breadcrumb float-right">
                            <li style="display: inline;" class="breadcrumb-item"><a href="index.html"><i class="icon-home"></i></a></li>                           
                            <li style="display: inline;" class="breadcrumb-item">Inspection Management</li>
                            <li style="display: inline;" class="breadcrumb-item active">Inspection Details</li>
                        </ul>                       
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row clearfix">
		<div class="col-lg-12 col-md-12">
	        <div class="row">
            	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            		<div class="card mb-2">
                    	<div class="header pl-3 pr-3">
                    		<h4 class="float-left">
                    			Overall Score: @{{data.scored_points ? data.scored_points:0}} / @{{data.total_points}} (@{{data.percentage?data.percentage:0.00}}%)
                    		</h4>
                    		<button class="btn btn-info btn-sm float-right ml-2" ng-click="exportPdf()"><i class="fa fa-print"></i></button>
                    		<h4 class="float-right">Rating: @{{data.rating? data.rating: 'Not Rated'}}</h4>
                    	</div>
                    </div>
                </div>
            </div>

            <div class="row">
            	
            	<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                    <div class="card" style="height: 90%">
                    	<div class="body">
                    		<div class="row">
                    			<div class="col-lg-12 mb-2">
                    				<label class="mb-0 color-lowlight">Client</label>
		                            <div class="input-group">
		                                <h6 class="mb-0">@{{data.job.client.first_name}} @{{data.job.client.last_name}}</h6>
		                            </div>
		                            <p class="mb-0">@{{data.job.client.phone}}</p>
                    			</div>
                    			<div class="col-lg-12 mb-2">
                    				<label class="mb-0 color-lowlight">Location Address</label>
		                            <p class="mb-0">@{{data.job.client.address}}</p>
                    			</div>
                    			<div class="col-lg-12 mb-2">
                    				<label class="mb-0 color-lowlight">Inspection Manager</label>
		                            <div class="input-group">
		                                <h6>@{{data.manager.first_name}} @{{data.manager.last_name}}</h6>
		                            </div>
                    			</div>
                    			<div class="col-lg-12 mb-2">
                    				<label class="mb-0 color-lowlight">Inspection Date</label>
		                            <div class="input-group">
		                                <h6>@{{data.inspection_date | amDateFormat:'MMM DD, YYYY'}}</h6>
		                            </div>
                    			</div>

                    			<div class="col-lg-12 mb-2">
                    				<label class="mb-0 color-lowlight">Reference No</label>
		                            <div class="input-group">
		                                <h6>@{{data.reference_no}}</h6>
		                            </div>
                    			</div>
                    		</div>
                    	</div>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                    <div class="card">
                    	<div class="body">
                			<img style="width: 100%" src="@{{data.chart}}">
                    	</div>
                    </div>
                </div>

            </div>

            <div class="row" ng-repeat="section in data.sections track by $index" ng-init="rowIndex = $index">
            	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            		<div class="card mb-2">
                    	<div class="header pl-3 pr-3 pb-4">
                    		<h4 class="float-left">@{{rowIndex+1}}. @{{section.job_section.name}}</h4>
                    		<h4 class="float-right">@{{section.scored_points ? section.scored_points:0}} / @{{section.total_score}} (@{{section.percentage ? section.percentage:0}}%)</h4>
                    	</div>
                    	
                    	<div class="body">
                    		<div class="row" style="border-bottom: 1px dashed;"></div>
                    		<div class="row section-task" ng-repeat="task in section.tasks track by $index" ng-init="columnIndex = $index">
                    			<div class="col-lg-10 text-left" style="font-size: large;padding-top: 5px;padding-bottom: 5px;color: #5A5A5A;">@{{rowIndex+1}}. @{{columnIndex+1}} @{{task.title}}</div>
                    			<div class="col-lg-2 text-right" style="font-size: large;">@{{task.scored_points?task.scored_points:0}} / 10</div>
                    			<div class="col-lg-12 mt-2 ml-4">
                    				<label style="color: #00000066">Note by inspection officer</label>
                    				<br>
                    				<span>@{{task.note}}</span>
                    			</div>

                    			<div class="col-lg-4 mt-2 ml-4" ng-show="task.task.image">
                    				<label style="color: #00000066">Before</label>
                    				<img style="width: 100%;" src="{{url('storage')}}/@{{task.task.image}}">
                    			</div>
                    			<div class="col-lg-4 mt-2 ml-4" ng-show="task.image">
                    				<label style="color: #00000066">Now</label>
                    				<img style="width: 100%;" src="{{url('storage')}}/@{{task.image}}">
                    			</div>
                    			<div class="col-lg-4">
                    				
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
    	$scope.inspection_id = JSON.parse('{!!json_encode($inspection_id)!!}');

    	$scope.data = [];
    	$scope.chart_option = [];
    	$scope.chart_series = [];

    	$.ajax({
            url: "{{url('admin/inspection/get-inspections-data')}}",
            type: 'GET',
            data: {
            	inspection_id : $scope.inspection_id
            },
            success: function (data)
            {
            	$.each(data.sections,function(key,value)
            	{
            		$scope.chart_option.push(value.job_section.name);

            		if(value.scored_points)
            		{
            			$scope.chart_series.push(value.scored_points);
            		}else{
            			$scope.chart_series.push(0);
            		}
            	});

            	$scope.data = data;
                $scope.$apply();

       //          console.log($scope.chart_option);
       //          console.log($scope.chart_series);

       //          var options;

			    // var data = {
			    //     labels: $scope.chart_option,
			    //     series: [
			    //         $scope.chart_series,
			    //     ]
			    // };

		    	// // area chart
			    // options = {
			    //     height: "270px",
			    //     showArea: true,
			    //     showLine: false,
			    //     showPoint: true,
			    //     axisX: {
			    //         showGrid: false
			    //     },
			    //     lineSmooth: false,
			    // };

			    // new Chartist.Bar('#bar-chart', data, options);
            },
            error:function(data) {
              $('.dialog-loader').hide();
            }
        });

	    $scope.exportPdf = function ()
        {
            window.open('{{url('admin/inspection/export-pdf')}}?inspection_id='+$scope.inspection_id,'_blank');
        }
    	
    });//end controller

</script>
@stop
