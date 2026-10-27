@extends('master.master')

@section('css')

<style type="text/css">
    .table-btn{
        background: #1e9cff  !important;
    }

    .table-btn .fas{

        font-size: 12px !important;
        color: white  !important;
    }

    .repeat:hover {
        background-color:#EFEFEF;
    }
    #scrollArea {
        height: 200px;
        overflow: auto;
    }
    .switch.switch-sm{
        width: 30px;
        height: 16px;
    }
    .switch :checked + span {

        border-color: #689A07;
        -webkit-box-shadow: #689A07 0px 0px 0px 21px inset;
        -moz-box-shadow: #2ecc71 0px 0px 0px 21px inset;
        box-shadow: #689A07 0px 0px 0px 21px inset;
        -webkit-transition: border 300ms, box-shadow 300ms, background-color 1.2s;
        -moz-transition: border 300ms, box-shadow 300ms, background-color 1.2s;
        -o-transition: border 300ms, box-shadow 300ms, background-color 1.2s;
        transition: border 300ms, box-shadow 300ms, background-color 1.2s;
        background-color: #689A07;

    }

    .bootstrap-tagsinput.error{
        border-color: #d96557;
    }

    .dualmultiselect h4{
            font-size: 17px;
    font-weight: 600;
    padding: 0;
    margin: 0 0 10px -2px;
    }

    .c_list .avatar {
        width: 45px;
    }

    #largeModalUpload .tooltip {
      font-size: 12px;
      font-style: normal;
      font-weight: normal;
      line-height: 1.42857143;
      text-align: left;
      text-align: start;
      text-decoration: none;
      text-shadow: none;
      text-transform: none;
      letter-spacing: normal;
      word-break: normal;
      word-spacing: normal;
      word-wrap: normal;
      white-space: normal;
      /* ... */
    }
    #largeModalUpload  .tooltip-inner {
      padding: 3px 8px;
      color: #fff;
      text-align: center;
      background-color: #000;
      border-radius: 4px;
    }

    .more .fancy-checkbox input[type="checkbox"]+span:before {
        display: none;
    }

    .more .fancy-checkbox input[type="checkbox"]+span {
        color: blue;
        text-decoration: underline;
    }

    .devi{
        margin-top: 1rem;
        margin-bottom: 1rem;
        border: 0;
        border-top: 1px solid rgba(0,0,0,.1);
        position: absolute;
        left: 70px;
        top: 0;
        width: 85%
    }

    .fa-check-circle{
        color: green;
    }

    .pointer{
        cursor: pointer;
    }

    .shadow{
        -moz-box-shadow:    inset 0 0 10px #000000;
        -webkit-box-shadow: inset 0 0 10px #000000;
        box-shadow:         inset 0 0 10px #000000;
    }

    .collapsing {
        position: relative;
        height: 0;
        overflow: hidden;
        transition: height .0001s ease;
    }

    .borderless td, .borderless th {
        border: none;
    }

    .light{
        color: #b1b1b1;
    }
    .category-img {
        width: 30px !important;
        height: 30px !important;
        border-radius: 20% !important;
        margin-right: 5px !important;
    }
</style>
@stop

@section('content')

<div ng-app="ngApp" ng-controller="CertificationManageController" ng-init="loadCertificationData()"> 
    
    <div class="block-header">
        <div class="row">
            <div class="col-lg-6 col-md-8 col-sm-12">
                <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth">
                   </a> <i class="fas fa-bars"></i></a> Certification Manage</h2>
                
            </div>            
            <div class="col-lg-6 col-md-4 col-sm-12">
                <div class="row float-right mr-0">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html"><i class="icon-home"></i></a></li>                           
                        <li class="breadcrumb-item">Certification Manage</li>
                        <li class="breadcrumb-item active">Certification List</li>
                    </ul>
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
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="icon-magnifier"></i></span>
                                </div>
                                <input style="height: 40px" name="keyword" id="keyword" class="form-control" placeholder="Search here..." type="text">
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

        <div class="col-lg-12 col-md-12">
            <div class="card planned_task">
                <div class="header">
                    <h2>Certification List</h2>
                    <ul class="header-dropdown">
                        <li>
                            <a class="tab_btn table-btn" href="#" data-toggle="tooltip" data-placement="top" title="" data-original-title="Create New Certificate" id="btn-create"><i class="fas fa-plus "></i>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="body">
                    <div class="table-responsive mb-3">
                        <table class="table table-bordered table-hover m-b-0 c_list">
                            <thead>
                                <tr>
                                    <th class="pr-0">#</th>
                                    <th>Certification</th>
                                    <th>Title</th>
                                    <th>Documents</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="detail in details.data">
                                    <td>@{{$index+1}}</td>
                                    <td>
                                        <img style="width: 100px" src="{{url('storage/uploads/certificates/')}}/@{{detail.certificate_image}}">
                                    </td>
                                    <td>@{{detail.title}}</td>
                                    <td>
                                        <div style="width: 50%;float: left;" ng-repeat="doc in detail.documents">
                                            <a href="{{url('storage/uploads/documents')}}/@{{doc.file_name}}" target="_blank">
                                                <img style="width: 50px" src="{{asset('assets/admin_panel/images/pdf.png')}}"><br>
                                                <span>@{{doc.file_name}}</span>
                                            </a>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-warning btn-sm" ng-click="editModalShow(detail)" style="font-size: 8px"><i class="fa fa-edit"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <paging page="details.current_page" page-size="details.per_page" total="details.total" show-prev-next="true" show-first-last="true" ul-class="pagination" paging-action="find(page)">
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-create">
        <div class="modal-dialog modal-md">
            <div class="dialog-loader">
                <div class="m-t-30 text-center"><div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div></div>
            </div>
            <div class="modal-content">
                <div class="modal-header text-left">
                    <h4 class="modal-title">Create Certification</h4>
                </div>
                <form action="" method="POST" role="form" id="form-create" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label>Certification Title</label>
                                    <input type="text" class="form-control" name="title" placeholder="Enter certification title">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label for="">Certificate Image</label>
                                    <input class="form-control" id="fileToUpload" type="file" name="certificate_image"> 
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label for="">Attach Documents</label>
                                    <input class="form-control" type="file" name="documents[]" multiple="multiple"> 
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-edit">
        <div class="modal-dialog modal-md">
            <div class="dialog-loader">
                <div class="m-t-30 text-center"><div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div></div>
            </div>
            <div class="modal-content">
                <div class="modal-header text-left">
                    <h4 class="modal-title">Edit Certification Details</h4>
                </div>
                <form action="" method="POST" role="form" id="form-edit" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="modal-body">
                        <input type="hidden" name="certificate_id" value="@{{edit_certificate.id}}">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label>Certification Title</label>
                                    <input type="text" class="form-control" name="edit_title" value="@{{edit_certificate.title}}" placeholder="Enter certification title">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label for="">Certificate Image</label>
                                    <input class="form-control" id="fileToUpload" type="file" name="edit_certificate_image"> 
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label for="">Attach Documents</label>
                                    <div class="mb-1" style="width: 50%;padding: 5px;border: 1px solid" ng-repeat="doc in edit_certificate.documents">
                                        <img style="width: 30px" src="{{asset('assets/admin_panel/images/pdf.png')}}">
                                        <span>@{{doc.file_name}}</span>
                                        <i ng-click="removeDocument(doc)" style="position: absolute;cursor: pointer;padding-left: 10px" class="fa fa-trash text-danger"></i>
                                    </div>
                                    <input class="form-control" type="file" name="edit_documents[]" multiple="multiple"> 
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

@stop


@section('js')

<script type="text/javascript">

    $(document).ready(function()
    {
        $('.select2').select2();

    });

    //initialize angular app
    var app = angular.module("ngApp",['angularImgFallback','ui.bootstrap','ngSanitize','bw.paging']);


    app.config(['$tooltipProvider', function ($tooltipProvider) {
        $tooltipProvider.options({
            appendToBody: true, // 
            appendToBody: true, // 
            placement:'bottom' // Set Default Placement
        });
    }]);

    //controller
app.controller("CertificationManageController", function($scope,$http)
{
    $scope.details = [];
    
    $scope.loadCertificationData = function()
    {
        $.ajax({
            url: "{{url('admin/certification/get-certification-data')}}",
            type: 'GET',
            success: function (data) {
                $scope.details = data;
                $scope.$apply();
            },
            error:function(data) {
              $('.dialog-loader').hide();
            }
        });
    };

    $scope.find = function (page)
    {
        keyword = $('#keyword').val();

        $.ajax({
            url: "{{url('admin/certification/get-certification-data')}}",
            type: 'GET',
            data: {
                page: page,
                keyword : keyword,
            },
            success: function (data) {
                $scope.details = data;
                $scope.$apply();
            },
            error:function(data) {
              $('.dialog-loader').hide();
            }
        });
    }

    $('#btn-create').on('click',function()
    {
        $('#modal-create').modal('show');
    });

    $("form#form-create").submit(function(e)
    {
        e.preventDefault();    
        var formData = new FormData(this);

        $('.dialog-loader').show();
        $.ajax({
            url: "{{url('admin/certification/create')}}",
            type: 'POST',
            dataType : 'json',
            data: formData,
            success: function (data)
            {
                $('.dialog-loader').hide();

                if(data.status_code == 200)
                {
                    $('#modal-create').modal('hide');

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
                swal({
                    title: data.message,
                    text: data.debug,
                });
            },
            cache: false,
            contentType: false,
            processData: false
        });
        return false;
    });

    $("form#form-edit").submit(function(e)
    {
        e.preventDefault();    
        var formData = new FormData(this);

        $('.dialog-loader').show();
        $.ajax({
            url: "{{url('admin/certification/update')}}",
            type: 'POST',
            dataType : 'json',
            data: formData,
            success: function (data)
            {
                $('.dialog-loader').hide();

                if(data.status_code == 200)
                {
                    $('#modal-create').modal('hide');

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
                swal({
                    title: data.message,
                    text: data.debug,
                });
            },
            cache: false,
            contentType: false,
            processData: false
        });
        return false;
    });

    $scope.editModalShow = function(edit_details)
    {
        $scope.edit_certificate = edit_details;
        $('#modal-edit').modal('show');
    }

    $scope.removeDocument = function(doc)
    {
        $.ajax({
            url: "{{url('admin/certification/remove-document')}}",
            type: 'GET',
            data: {
                certificate_id : doc.certification_id,
                doc_id : doc.id,
                file_name : doc.file_name
            },
            success: function (data) {
                // console.log(data);
                $scope.edit_certificate = data;
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
