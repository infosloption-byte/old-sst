@extends('master.master')

@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/dist/ng-multiselect/dualmultiselect.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/admin_panel/dist/select2/select2.css')}}">

<style type="text/css">
    .thumb_image{
        border: 1px solid;
        width: 100%;
        height: auto;
        cursor: pointer;
    }

    .thumb_image:hover{
        border-color: #4aa636;
    }

    .thumb_image_active{
        border: 2px solid;
        border-color: #4aa636;
    }
</style>
@stop

@section('content')

<div ng-app="ngApp" ng-controller="InductionManageController" ng-init="loadInductionData()">
    
    <div class="block-header">
        <div class="row">
            <div class="col-lg-6 col-md-8 col-sm-12">
                <h2>
                    <a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"></a>
                    <i class="fas fa-bars"></i> Induction Manage
               </h2>
            </div>            
            <div class="col-lg-6 col-md-4 col-sm-12">
                <div class="row float-right mr-0">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html"><i class="icon-home"></i></a></li>                           
                        <li class="breadcrumb-item">Induction Manage</li>
                        <li class="breadcrumb-item active">Induction List</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row clearfix">

        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="header">
                    <h2>Read Document</h2>
                </div>
                <div class="body pb-0">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card" style="max-height: 550px;overflow-y: scroll;box-shadow: 0px 0px 1px 1px rgba(0,0,0,0.1)">
                                <div class="body pb-0">
                                    <div class="row">
                                        <div class="col-md-6 text-center" ng-repeat="detail in details track by $index">
                                            <img class="thumb_image" id="thumb_@{{detail.id}}" ng-click="loadDoc(detail)" src="{{url('storage/uploads/induction')}}/@{{detail.cover_image}}">
                                            <p style="width: 100%;font-size: x-small;margin-top: 5px"><strong>@{{$index+1}}. @{{detail.topic}}</strong></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="card" style="height: 550px;overflow-y: scroll;box-shadow: 0px 0px 1px 1px rgba(0,0,0,0.1)">
                                <div class="body pb-0">
                                    <div class="row">
                                        <div class="col-md-12 text-center">
                                            <!-- <img style="width: 100%;height: 100%;padding-bottom: 20px" src="{{url('storage/uploads/documents/cert_1.pdf')}}"> -->
                                            <iframe id="doc_viewer" style="height: 550px" src="{{url('storage/uploads/induction/Accident Incident Procedure.pdf')}}" width="100%" height="100%"></iframe>
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
    app.controller("InductionManageController", function($scope,$http)
    {
        $scope.details = [];
        $scope.selected_doc = null;

        $scope.loadInductionData = function()
        {
            $.ajax({
                url: "{{url('admin/induction/get-induction-data')}}",
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

        $scope.loadDoc = function(doc)
        {
            $(".thumb_image").removeClass('thumb_image_active');

            $('#thumb_'+doc.id).addClass('thumb_image_active');
            $scope.selected_doc  = doc.document;
            var $iframe = $('#doc_viewer');
            if ( $iframe.length ) {
                $iframe.attr('src',"{{url('storage/uploads/induction')}}/"+doc.document);   
                return false;
            }
            return true;
        }

    });//end controller

</script>
@stop
