@extends('master.master')

@section('css')

<link rel="stylesheet" href="{{asset('assets/admin_panel/dist/c3/c3.min.css')}}">
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
<div ng-app="ngApp" ng-controller="JobManageController">

	<div class="block-header">
        <div class="row">
            <div class="col-lg-8 col-md-6 col-sm-12 col-12">
                <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth">
                    <i class="fa fa-arrow-left"></i></a> Repiar Management</h2>
            </div>            
            <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                <div class="row">
                    <div class="col-md-12">
                        <ul class="breadcrumb float-right">
                            <li style="display: inline;" class="breadcrumb-item"><a href="index.html"><i class="icon-home"></i></a></li>                           
                            <li style="display: inline;" class="breadcrumb-item">Repiar Management</li>
                            <li style="display: inline;" class="breadcrumb-item active">Create Repiar</li>
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
	                <h2>Create Repair</h2>
	                <ul class="header-dropdown">

	                	<li><a class="tab_btn table-btn" href="{{url('admin/repair/index')}}" data-toggle="tooltip" data-placement="top" title="" data-original-title="Repair List"><i class="fas fa-bars "></i></a></li>
	                </ul>
	            </div>

	            <div class="body">
                    <form role="form" class="form-validation" method="post" id="create-form" name="create-form" enctype="multipart/form-data">
                    {{csrf_field()}}
                        <div class="row" style="padding: 10px">
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Repair Type</label>
                                    <select name="repair_type" id="repair_type" class="select2-container form-control show-tick ms select2">
                                        <option value="">- Select Type -</option>
                                        <option ng-repeat="repair_type in repair_types" value="@{{repair_type.id}}">@{{repair_type.name}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Asset Detail</label>
                                    <input class="form-control" id="asset" name="asset" placeholder="Enter asset detail...">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label>Remark</label>
                                    <textarea class="form-control" name="remark" id="remark" placeholder="Enter remark..."></textarea>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label>Location</label>
                                    <textarea class="form-control" id="location" name="location" placeholder="Enter location of incident..."></textarea>
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
                                <button type="submit" class="btn btn-primary"><i class="fa fa-upload"></i> Report</button>
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
    var app = angular.module("ngApp",['dualmultiselect','angularImgFallback','ui.bootstrap','ngSanitize','bw.paging']);


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
    	$scope.repair_types  = [];
    	
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

        $("form#create-form").submit(function(e)
        {
            e.preventDefault();    
            var formData = new FormData(this);
            $('.dialog-loader').show();

            $.ajax({
                url: "{{url('admin/repair/create')}}",
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

    });//end controller

</script>
@stop
