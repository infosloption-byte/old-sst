@extends('master.master')

@section('css')

<link rel="stylesheet" href="{{asset('assets/admin_panel/dist/c3/c3.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/admin_panel/dist/bootsrap-fileinput/css/fileinput.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/admin_panel/dist/bootsrap-fileinput/themes/explorer-fa/theme.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/admin_panel/dist/select2/select2.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/admin_panel/dist/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')}}">
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
                    <i class="fa fa-arrow-left"></i></a> Job Management</h2>
            </div>            
            <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                <div class="row">
                    <div class="col-md-12">
                        <ul class="breadcrumb float-right">
                            <li style="display: inline;" class="breadcrumb-item"><a href="index.html"><i class="icon-home"></i></a></li>                           
                            <li style="display: inline;" class="breadcrumb-item">Job Management</li>
                            <li style="display: inline;" class="breadcrumb-item active">Config Job</li>
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
	                <h2>Config Job</h2>
	                <ul class="header-dropdown">

	                	<li><a class="tab_btn table-btn" href="{{url('admin/job/index')}}" data-toggle="tooltip" data-placement="top" title="" data-original-title="Job List"><i class="fas fa-bars "></i></a></li>
	                </ul>
	            </div>

	            <div class="body">
                    <form action="" method="POST" role="form" id="job-config-form">
                        {{csrf_field()}}
                        <div class="row" style="padding: 10px">
                            <input type="hidden" name="job_id" value="{{$request->job}}">
                            <div class="col-md-6" ng-repeat="section in master_sections">
                                <div class="card">
                                    <div class="header">
                                        <h2><input type="checkbox" style="margin-right: 5px" name="section_@{{section.id}}" id="section_@{{section.id}}" value="@{{section.id}}" ng-click="toggle(this,section.id)">@{{section.name}}</h2>
                                    </div>
                                    <div class="body">
                                        <div class="row" ng-repeat="task in section.master_tasks">
                                            <div class="col-md-12">
                                                <p><input type="checkbox" style="margin-right: 5px" name="task_@{{section.id}}" id="task_@{{section.id}}_@{{task.id}}" ng-click="toggleTask(section.id,task.id)" value="@{{task.id}}">@{{task.name}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <button type="submit" class="btn btn-primary float-right">Save</button>
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
<script type="text/javascript" src="{{asset('assets/admin_panel/dist/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>

<script type="text/javascript">

    $(document).ready(function()
    {
        $(".select2").select2();

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
    	$scope.master_sections  = [];
        $scope.selected_sections  = [];
        $scope.selected_tasks  = [];

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


        $scope.toggle = function(ele,section_id)
        {
            console.log(section_id);
            console.log(ele);
            console.log($('#section_'+section_id).is(':checked'));

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
                    // $('#'+).attr('checked');
                }
            }else{

                if($scope.selected_sections.indexOf(section_id) == -1)
                {
                    $scope.selected_sections.push(section_id);
                }


                for(var i=0, n=checkboxes.length;i<n;i++) {
                    document.getElementById(checkboxes[i].id).checked = true;
                    $scope.selected_tasks.push(document.getElementById(checkboxes[i].id).value);
                    // $('#'+).attr('checked');
                }
            }
        }

        $scope.toggleTask = function(section_id,task_id)
        {
            if(!$('#task_'+section_id+'_'+task_id).is(':checked'))
            {
                $scope.selected_tasks.splice($scope.selected_tasks.indexOf(task_id), 1);
            }else{
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
                    // console.log(data);

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

    });//end controller

</script>
@stop
