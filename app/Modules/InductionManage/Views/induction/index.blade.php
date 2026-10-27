@extends('master.master')

@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/dist/ng-multiselect/dualmultiselect.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/admin_panel/dist/select2/select2.css')}}">

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

<div ng-app="ngApp" ng-controller="InductionManageController" ng-init="loadInductionCertification()"> 
    
    <div class="block-header">
        <div class="row">
            <div class="col-lg-6 col-md-8 col-sm-12">
                <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth">
                   </a> <i class="fas fa-bars"></i></a> Induction Manage</h2>
                
            </div>            
            <div class="col-lg-6 col-md-4 col-sm-12">
                <div class="row float-right mr-0">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html"><i class="icon-home"></i></a></li>                           
                        <li class="breadcrumb-item">Induction Manage</li>
                        <li class="breadcrumb-item active">Induction Programme</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row clearfix">

        <div class="col-lg-12 col-md-12">
            <div class="card planned_task">
                <div class="header">
                    <h2>Induction Programme</h2>
                </div>
                <div class="body">
                    <div class="row">
                        <div class="col-md-3" ng-show="certification.length>0">
                            <div class="card" style="background: #F7F7F9">
                                <div class="body" style="padding-top: 10px">
                                    <div class="row">
                                        <div class="col-lg-12 text-center">
                                            <a href="{{url('admin/induction/view-induction-document')}}"><p style="margin-bottom: 15px;" class="mt-2"><strong>Certification Of Induction</strong></p></a>
                                        </div>
                                        <div class="col-lg-12">
                                            <img style="width: 100%;height: 300px" src="{{url('storage/uploads/certificates/induction_certificate.jpg')}}">
                                        </div>
                                        <div class="col-lg-12 mt-2 text-center">
                                            <a href="#" ng-click="showCertificate(certification[0])">Show Certificate</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3" ng-show="certification.length==0">
                            <div class="card" style="background: #F7F7F9">
                                <div class="body" style="padding-top: 10px">
                                    <div class="row">
                                        <div class="col-lg-12 text-center">
                                            <a href="{{url('admin/induction/view-induction-document')}}"><p style="margin-bottom: 15px;" class="mt-2"><strong>Certification Of Induction</strong></p></a>
                                        </div>
                                        <div class="col-lg-12">
                                            <img style="width: 100%;height: 300px" src="{{url('storage/uploads/certificates/induction_certificate.jpg')}}">
                                        </div>
                                        <div class="col-lg-12 mt-2 text-center">
                                            <a href="{{url('admin/induction/view-induction-document')}}" target="_blank">Read Documents</a>
                                        </div>
                                        <div class="col-lg-6 mt-2 text-left">
                                            <span class="badge bg-dark text-light"><i class="fa fa-clock"></i> 60 Min</span>
                                        </div>
                                        <div class="col-lg-6 mt-2 text-right">
                                            <button type="button" class="btn btn-xs btn-warning btn-secondary" ng-click="loadIntroModal(detail.questions)" title="Accept">Start Exam</button>
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

    <div class="modal fade" id="modal-intro">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="dialog-loader">
                <div class="m-t-30 text-center"><div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div></div>
            </div>
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 text-center">
                            <h3>
                                <span class="clearfix title">
                                    <span class="number left"></span> <span class="text">Before you start..!</span>
                                </span>
                            </h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <table class="table table-bordered">
                                <tr>
                                    <td>1</td>
                                    <td class="text-left"><p style="font-size: 14px" class="mb-0">25 question to answer</p></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td class="text-left"><p style="font-size: 14px" class="mb-0">You have got 2.4 min to answer each question</p></td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td class="text-left"><p style="font-size: 14px" class="mb-0">100% correct answers need to pass the exam</p></td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td class="text-left"><p style="font-size: 14px" class="mb-0">You cannot exit from this window until you finish the exam</p></td>
                                </tr>
                            </table>

                            <div class="margin-top-30 text-center">
                                <a href="#" class="btn btn-default" data-dismiss="modal"><i class="fa fa-arrow-left"></i> <span>Not Now</span></a>
                                <a href="#" class="btn btn-primary" ng-click="loadExamModal()"><i class="fa fa-clock"></i> <span>Start</span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-exam" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="dialog-loader">
                <div class="m-t-30 text-center"><div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div></div>
            </div>
            <div class="modal-content">
                <div class="modal-header text-left">
                    <h4 class="modal-title">Exam Began</h4>
                    <h4>
                        <i class="fa fa-clock"></i> <span id="countdown"></span>
                        <button title="Leave Exam" alt="Leave Exam" style="width: 28px;height: 27px;padding: 4px;" type="button" class="btn btn-danger" ng-click="leaveExam()">
                            <i class="fa fa-sign-out-alt"></i>
                        </button>
                    </h4>
                </div>
                <div class="modal-body">
                    <div class="row" ng-repeat="q in questions.data">
                        <div class="col-12">
                            <p style="font-size: 16px">@{{q.question.question}}</p>
                        </div>

                        <div class="col-12">
                            <div ng-repeat="ans in qanswers">
                                <input type="radio" value="@{{ans.id}}" name="answer_opt" id="true_answ_@{{ans.id}}" ng-model="q.given_answer" ng-change='saveAnswer(ans.id)'>
                                <label>@{{ans.answer}}</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-lg-12">
                            <paging class="float-right" page="questions.current_page" page-size="questions.per_page" total="questions.total" show-prev-next="true" show-first-last="true" ul-class="pagination" paging-action="loadUserExamQuestion(page)">
                        </div>
                        <div class="col-lg-12 text-right">
                            <button type="button" class="btn btn-success btn-finish" ng-click="finshExam()"><i class="fas fa-check"></i> Done</button>
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
        $scope.questions = [];
        $scope.qanswers = [];
        $scope.certification = [];

        $scope.showCertificate = function(certificate)
        {
            $.ajax({
                url: "{{url('admin/induction/get-user-image')}}",
                type: 'GET',
                success: function (data)
                {
                    if(data.status_code == 200)
                    {
                        window.open('{{url('admin/induction/view-certificate')}}/'+certificate.id,'_blank');
                    }else{
                        swal({title: "Profile image missing!",text: data.msg});
                    }
                },
                error:function(data) {
                  $('.dialog-loader').hide();
                }
            });

        };

        $scope.loadInductionCertification = function()
        {
            $.ajax({
                url: "{{url('admin/induction/get-user-induction-certificate')}}",
                type: 'GET',
                success: function (data)
                {
                    $scope.certification = data;
                    $scope.$apply();
                },
                error:function(data) {
                  $('.dialog-loader').hide();
                }
            });

        };

        $scope.loadIntroModal = function(questions)
        {
            $('#modal-intro').modal('show');

            $.ajax({
                url: "{{url('admin/induction/get-induction-questions')}}",
                type: 'GET',
                success: function (data) {
                    
                },
                error:function(data) {
                  $('.dialog-loader').hide();
                }
            });

        };

        $scope.loadUserExamQuestion = function(page)
        {
            $.ajax({
                url: "{{url('admin/induction/get-user-exam-questions')}}",
                type: 'GET',
                data: {
                    page: page
                },
                success: function (data) {
                    $scope.questions = data;
                    $scope.qanswers = $scope.questions.data[0].question.answers;
                    $scope.$apply();
                },
                error:function(data) {
                  $('.dialog-loader').hide();
                }
            });

            console.log($scope.qanswers);
        }

        $scope.saveAnswer = function(answer)
        {
            $.ajax({
                url: "{{url('admin/induction/save-user-exam-answer')}}",
                type: 'GET',
                data: {
                    question: $scope.questions.data[0].id,
                    given_answer : answer
                },
                success: function (data)
                {
                    console.log(data);
                },
                error:function(data) {
                  $('.dialog-loader').hide();
                }
            });
        }

        $scope.loadExamModal = function()
        {
            $('#modal-intro').modal('hide');

            $.ajax({
                url: "{{url('admin/induction/get-user-exam-questions')}}",
                type: 'GET',
                success: function (data) {
                    $scope.questions = data;
                    $scope.qanswers = $scope.questions.data[0].question.answers;
                    $scope.$apply();

                    console.log($scope.qanswers);
                },
                error:function(data) {
                  $('.dialog-loader').hide();
                }
            });

            $('#modal-exam').modal('show');

            var d1 = new Date ();
            var d2 = new Date ( d1 );
            d2.setMinutes ( d1.getMinutes() + 60 );

            var countDownDate = d2.getTime();

            var x = setInterval(function() {

                var now = new Date().getTime();

                var distance = countDownDate - now;

                var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                // Output the result in an element with id="countdown"
                document.getElementById("countdown").innerHTML = minutes + "m " + seconds + "s ";

                // If the count down is over, write some text
                if (distance < 0) {
                    clearInterval(x);
                    document.getElementById("countdown").innerHTML = "EXPIRED";
                }
            }, 1000);
        };

        $scope.leaveExam = function()
        {
            showConfirmMessage('Leave','Are you sure to leave the exam?','Yes Leave','info',function(isConfirm) {
                if(isConfirm){
                    $.ajax({
                        url: "{{url('admin/induction/reset-user-exam')}}",
                        type: 'POST',
                        success: function (data)
                        {
                            if(data.status_code = 200)
                            {
                                $('#modal-exam').modal('hide');
                                swal({title: "Success!",text: "You left the exam."});
                                location.reload();
                            }else{
                                swal({title: "Error!",text: "Error leaving."});
                            }
                        },
                        error:function(data) {
                            swal({title: "Error!",text: "Error leaving."});
                        }
                    });
                }
            });
        }

        $scope.finshExam = function()
        {
            $('.page-loader-wrapper').show();

            $.ajax({
                url: "{{url('admin/induction/check-user-exam-status')}}",
                type: 'GET',
                success: function (data)
                {
                    $('#modal-exam').modal('hide');
                    $('.page-loader-wrapper').hide();

                    if(data.status_code == 100){
                        swal({
                            title: data.message,
                            text: data.debug,
                        });
                    }else if(data.status_code == 300)
                    {
                        swal({
                            title: data.message,
                            text: data.debug,
                        });
                        setInterval(function() {
                            location.reload();
                        }, 1000);

                    }else if(data.status_code == 200){
                        swal({
                            title: data.message,
                            text: data.debug,
                        });

                        setInterval(function() {
                            location.reload();
                        }, 1000);
                    }
                },
                error:function(data) {
                  $('.dialog-loader').hide();
                }
            });
        }

    });//end controller

</script>
@stop
