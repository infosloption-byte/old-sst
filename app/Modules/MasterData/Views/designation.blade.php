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
<div ng-app="ngApp" ng-controller="DesignationController" ng-init="loadDesignationData()">

    <div class="block-header">
        <div class="row">
            <div class="col-lg-8 col-md-6 col-sm-12 col-12">
                <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth">
                    <i class="fa fa-arrow-left"></i></a> Designation Management</h2>
            </div>            
            <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                <div class="row">
                    <div class="col-md-12">
                        <ul class="breadcrumb float-right">
                            <li style="display: inline;" class="breadcrumb-item"><a href="index.html"><i class="icon-home"></i></a></li>                           
                            <li style="display: inline;" class="breadcrumb-item">Master Data Management</li>
                            <li style="display: inline;" class="breadcrumb-item active">Designations</li>
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
                    <h2>Designation List</h2>
                    <ul class="header-dropdown">

                        <li><a class="tab_btn table-btn" href="#" data-toggle="tooltip" data-placement="top" title="" data-original-title="Create New Designation" id="btn-add" ng-click="createDesignationModalView()"><i class="fas fa-plus "></i></a></li>

                    </ul>
                </div>

                <div class="body">
                    <div class="table-responsive mb-3">
                        <table class="table table-bordered table-hover m-b-0 c_list">
                            <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="50%">Designation</th>
                                    <th class="text-right">Created At</th>
                                    <th width="10%" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="designation in designations.data track by $index">
                                    <td>@{{$index+1}}</td>
                                    <td>
                                        <a href="#">@{{designation.name}}</a>
                                    </td>
                                    <td class="text-right">
                                        @{{designation.created_at | amDateFormat:'MMM DD, YYYY'}} @{{designation.created_at | amDateFormat:'h:mm a z'}}
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-xs btn-warning btn-secondary btn-detail" title="Edit Designation" data-id="@{{designation.id}}" ng-click="editDesignationDetails(designation)">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-xs btn-danger btn-secondary btn-detail" title="Delete Designation" data-id="@{{designation.id}}" ng-click="deleteDesignation(designation)">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <paging page="designations.current_page" page-size="designations.per_page" total="designations.total" show-prev-next="true" show-first-last="true" ul-class="pagination" paging-action="find(page)">
                </div>
            </div>
        </div>
        
    </div>

    <div class="modal fade" id="addDesignationModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="title" id="largeModalLabel">New Designation</h4>
                </div>
                
                <div class="modal-body">
                    <form role="form" class="form-validation" method="post" id="create-designation-form" name="create-designation-form" enctype="multipart/form-data">
                    {{csrf_field()}}
                        <div class="row" style="padding: 10px">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label>Designation</label>
                                    <input class="form-control" id="designation" name="designation" placeholder="Enter Designation...">
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

    <div class="modal fade" id="editDesignationModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="title" id="largeModalLabel">Edit Designation Details</h4>
                </div>
                
                <div class="modal-body">
                    <form role="form" class="form-validation" method="post" id="edit-designation-form" name="edit-designation-form" enctype="multipart/form-data">
                    {{csrf_field()}}
                        <input type="hidden" name="edit_designation_id" id="edit_designation_id" value="@{{edit_designation.id}}">
                        <div class="row" style="padding: 10px">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label>Designation</label>
                                    <input class="form-control" id="edit_designation" name="edit_designation" placeholder="Enter Designation..." value="@{{edit_designation.name}}">
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
    app.controller("DesignationController", function($scope,$http)
    {
        $scope.designations = [];

        $scope.edit_designation = [];

        $scope.page = 1;

        $scope.loadDesignationData = function()
        {
            $.ajax({
                url: "{{url('admin/master/get-designation-list')}}",
                type: 'GET',
                success: function (data) {
                    $scope.designations = data;
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
                url: "{{url('admin/master/get-designation-list')}}",
                type: 'GET',
                data: {
                    page: page
                },
                success: function (data) {
                    $scope.designations = data;
                    $scope.$apply();
                },
                error:function(data) {
                  $('.dialog-loader').hide();
                }
            });
        }

        $("form#create-designation-form").submit(function(e)
        {
            e.preventDefault();    
            var formData = new FormData(this);
            $('.dialog-loader').show();

            $.ajax({
                url: "{{url('admin/master/create-designation')}}",
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

                        $('#addDesignationModal').modal('hide');
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

        $scope.createDesignationModalView = function()
        {
            $('#addDesignationModal').modal('show');
        }

        $scope.editDesignationDetails = function(designation)
        {
            $scope.edit_designation = designation;

            $('#editDesignationModal').modal('show');
        }

        $("form#edit-designation-form").submit(function(e)
        {
            e.preventDefault();    
            var formData = new FormData(this);
            $('.dialog-loader').show();

            $.ajax({
                url: "{{url('admin/master/update-designation')}}",
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

                        $('#editDesignationModal').modal('hide');
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

        $scope.deleteDesignation = function(designation)
        {
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this designation!",
                icon: "warning",
                showCancelButton: true,
                closeOnConfirm: true,
            },function(willDelete){
                if (willDelete)
                {
                    $.ajax({
                        url: "{{url('admin/master/delete-designation')}}",
                        type: 'POST',
                        data: {
                            designation_id : designation.id
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
