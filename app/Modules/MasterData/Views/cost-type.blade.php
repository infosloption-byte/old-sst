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
<div ng-app="ngApp" ng-controller="CostTypeController" ng-init="loadCostTypeData()">

    <div class="block-header">
        <div class="row">
            <div class="col-lg-8 col-md-6 col-sm-12 col-12">
                <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth">
                    <i class="fa fa-arrow-left"></i></a> Cost Type Management</h2>
            </div>            
            <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                <div class="row">
                    <div class="col-md-12">
                        <ul class="breadcrumb float-right">
                            <li style="display: inline;" class="breadcrumb-item"><a href="index.html"><i class="icon-home"></i></a></li>                           
                            <li style="display: inline;" class="breadcrumb-item">Master Data Management</li>
                            <li style="display: inline;" class="breadcrumb-item active">Cost Type</li>
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
                    <h2>Cost Type List</h2>
                    <ul class="header-dropdown">

                        <li><a class="tab_btn table-btn" href="#" data-toggle="tooltip" data-placement="top" title="" data-original-title="Create Cost Type" id="btn-add" ng-click="createCostTypeModalView()"><i class="fas fa-plus "></i></a></li>

                    </ul>
                </div>

                <div class="body">
                    <div class="table-responsive mb-3">
                        <table class="table table-bordered table-hover m-b-0 c_list">
                            <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="50%">Cost Type</th>
                                    <th class="text-right">Created At</th>
                                    <th width="10%" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="costType in costTypes.data track by $index">
                                    <td>@{{$index+1}}</td>
                                    <td>
                                        <a href="#">@{{costType.name}}</a>
                                    </td>
                                    <td class="text-right">
                                        @{{costType.created_at | amDateFormat:'MMM DD, YYYY'}} @{{costType.created_at | amDateFormat:'h:mm a z'}}
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-xs btn-warning btn-secondary btn-detail" title="Edit Cost Type" data-id="@{{costType.id}}" ng-click="editCostTypeDetails(costType)">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-xs btn-danger btn-secondary btn-detail" title="Delete Cost Type" data-id="@{{costType.id}}" ng-click="deleteCostType(costType)">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <paging page="costTypes.current_page" page-size="costTypes.per_page" total="costTypes.total" show-prev-next="true" show-first-last="true" ul-class="pagination" paging-action="find(page)">
                </div>
            </div>
        </div>
        
    </div>

    <div class="modal fade" id="addCostTypeModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="title" id="largeModalLabel">New Cost type</h4>
                </div>
                
                <div class="modal-body">
                    <form role="form" class="form-validation" method="post" id="create-cost-type-form" name="create-cost-type-form" enctype="multipart/form-data">
                    {{csrf_field()}}
                        <div class="row" style="padding: 10px">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label>Cost Type</label>
                                    <input class="form-control" id="cost_type" name="cost_type" placeholder="Enter Cost Type...">
                                </div>
                            </div>
                        </div>
                        <div class="row text-right">
                            <div class="form-group col-md-12">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editCostTypeModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="title" id="largeModalLabel">Edit Cost Type</h4>
                </div>
                
                <div class="modal-body">
                    <form role="form" class="form-validation" method="post" id="edit-cost-type-form" name="edit-cost-type-form" enctype="multipart/form-data">
                    {{csrf_field()}}
                        <input type="hidden" name="edit_cost_type_id" id="edit_cost_type_id" value="@{{edit_cost_type.id}}">
                        <div class="row" style="padding: 10px">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label>Cost Type</label>
                                    <input class="form-control" id="edit_cost_type" name="edit_cost_type" placeholder="Enter Cost Type..." value="@{{edit_cost_type.name}}">
                                </div>
                            </div>
                        </div>
                        <div class="row text-right">
                            <div class="form-group col-md-12">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-update"></i> Update</button>
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
    app.controller("CostTypeController", function($scope,$http)
    {
        $scope.costTypes = [];

        $scope.edit_cost_type = [];

        $scope.page = 1;

        $scope.loadCostTypeData = function()
        {
            $.ajax({
                url: "{{url('admin/master/get-cost-type-list')}}",
                type: 'GET',
                success: function (data) {
                    $scope.costTypes = data;
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

            $.ajax({
                url: "{{url('admin/master/get-cost-type-list')}}",
                type: 'GET',
                data: {
                    page: page
                },
                success: function (data) {
                    $scope.costTypes = data;
                    $scope.$apply();
                },
                error:function(data) {
                  $('.dialog-loader').hide();
                }
            });
        }

        $("form#create-cost-type-form").submit(function(e)
        {
            e.preventDefault();    
            var formData = new FormData(this);
            $('.dialog-loader').show();

            $.ajax({
                url: "{{url('admin/master/create-cost-type')}}",
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

                        $('#addCostTypeModal').modal('hide');
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

        $scope.createCostTypeModalView = function()
        {
            $('#addCostTypeModal').modal('show');
        }

        $scope.editCostTypeDetails = function(costType)
        {
            $scope.edit_cost_type = costType;

            $('#editCostTypeModal').modal('show');
        }

        $("form#edit-cost-type-form").submit(function(e)
        {
            e.preventDefault();    
            var formData = new FormData(this);
            $('.dialog-loader').show();

            $.ajax({
                url: "{{url('admin/master/update-cost-type')}}",
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

                        $('#editCostTypeModal').modal('hide');
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

        $scope.deleteCostType = function(costType)
        {
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this cost type!",
                icon: "warning",
                showCancelButton: true,
                closeOnConfirm: true,
            },function(willDelete){
                if (willDelete)
                {
                    $.ajax({
                        url: "{{url('admin/master/delete-cost-type')}}",
                        type: 'POST',
                        data: {
                            cost_type_id : costType.id
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
    });//end controller

</script>
@stop
