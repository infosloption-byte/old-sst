@extends('master.master')


@section('css')

<link rel="stylesheet" href="{{asset('assets/admin_panel/dist/c3/c3.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/admin_panel/dist/bootsrap-fileinput/css/fileinput.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/admin_panel/dist/bootsrap-fileinput/themes/explorer-fa/theme.css')}}">

<style type="text/css">
    
    .excercise{
        background: #FCFDFA !important;
    }
    .hydrated{
        background: #F6F2FF !important;
    }
    .breakfast{
        background: #47DD9C !important;
    }

    input.largerCheckbox
    {
        width: 30px;
        height: 30px;
    }

    @media (max-width: 768px){
        .breadcrumb{
            float: left!important;
        }
    }

    .fab {
        width: 45px;
        height: 45px;
        background-color: black;
        border-radius: 50%;
        box-shadow: 0 6px 10px 0 #666;
        transition: all 0.1s ease-in-out;
        color: white;
        text-align: center;
       position: absolute;
       bottom: 10px;
      right: 10px;
      border: 0 !important;
    }
     
    .fab:hover {
       box-shadow: 0 6px 14px 0 #666;
       transform: scale(1.05);
    }

    .avatar {
      position: relative;
      display: inline-block;
    }

    .avatar img {
          width: 178px;
    height: 178px;
      margin-bottom:10px; 
      border-radius: 50%;
    }

    .avatar .btn:hover {
      background: #0cad9f;
    }

    .avatar .btn:active {
      bottom: 3px;
    }

    .health-box{
        padding: 10px;
        border-radius: .55rem;
        background: #fff;
        transition: .5s;
        border: 1px solid #ddd;
        margin-bottom: 30px;
        position: relative;
        width: 100%;
    }


    .health-box small{
        font-size: 12px;
    background: #FFF;
    /* margin-top: -30px; */
    position: absolute;
    top: -8px;
    left: 10px;
    padding-left: 10px;
    padding-right:10px;
    }
    
    .health{
        padding-top: 15px;
    }

     .health a{
        font-size: 12px
    }

    .scores img{
        width: 35%;
    }

    .profile-pic{
        border: 1px solid #ddd;
    padding: 10px;
    }



    .file_input_div {
      margin: auto;
      width: 250px;
      height: 40px;
    }

    .file_input {
      float: left;
    }

    #file_input_text_div {
      width: 200px;
      margin-top: -8px;
      margin-left: 5px;
    }

    .none {
      display: none;
    }



</style>
@stop


@section('content')
<div ng-app="ngApp" ng-controller="ProfileController">
    
    <div class="block-header">
        <div class="row">
            <div class="col-lg-8 col-md-6 col-sm-12 col-12">
                <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth">
                    <i class="fa fa-arrow-left"></i></a> Profile Management</h2>
                
            </div>            
            <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                <div class="row">
                    <div class="col-md-12">
                        <ul class="breadcrumb float-right">
                            <li style="display: inline;" class="breadcrumb-item"><a href="index.html"><i class="icon-home"></i></a></li>                           
                            <li style="display: inline;" class="breadcrumb-item">Profile Management</li>
                            <li style="display: inline;" class="breadcrumb-item active">My Profile</li>
                        </ul>                       
                    </div>
                </div>
            </div>
        </div>
    </div>

                
    <div class="row clearfix">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-4 col-md-12">
                    
                    <div class="card">
                        <div class="header">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5><strong>Profile</strong></h5>
                                </div>
                            </div>
                        </div>
                        <div class="body text-center">

                            <div class="avatar">
                                @if($user_details->image)
                                    <img style="object-fit: cover;" src="{{url('storage')}}/{{$user_details->image}}" class="rounded-circle avatar" alt="">
                                @else
                                    <img src="{{asset('assets/admin_panel/images/user-avatar.png')}}" class="rounded-circle avatar" alt="">
                                @endif
                              
                                <button type="button" class="fab" id="btn-edit-basic">
                                    <i class="fas fa-pen"></i>
                                </button>
                            </div>
                            <div>
                                <h5 class="m-b-0"><strong>{{$user_details->employee->first_name}}</strong> {{$user_details->employee->last_name}}</h5>
                                <p class="m-b-0">{{$user_details->employee->department->name}}</p>
                            </div>                          
                        </div>
                    </div>                 
                </div>
                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                    <div class="card">
                        <div class="header">
                            <h5><strong>Profile</strong></h5>
                        </div>
                        <div class="body">
                            <small class="text-muted">Employee No: </small>
                            <p>#{{$user_details->employee->employee_no}}</p>
                            <hr>
                            <small class="text-muted">Email address: </small>
                            <p>{{$user_details->employee->email}}</p>                            
                            <hr>
                            <small class="text-muted">Phone: </small>
                            <p>{{$user_details->employee->phone}}</p>
                            <div class="m-t-15 text-right">

                                <a class="btn btn-primary" href="{{url('logout')}}">Logout</a>
                                <button class="btn btn-outline-secondary" id="btnResetPassword">Reset Password</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>                
    </div>

    <div class="modal fade" id="profileEditModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="title" id="largeModalLabel">Edit Profile Basic Details</h4>
                </div>
                
                <div class="modal-body">
                    <form role="form" class="form-validation" method="post" id="edit_basic_form" name="edit_basic_form" enctype="multipart/form-data">
                    {{csrf_field()}}
                        <div class="row">
                            <div class="form-group col-12 col-sm-12 col-md-12 col-lg-12 text-center">
                                <div class="avatar">
                                    @if($user_details->image)
                                        <img style="object-fit: cover;" src="{{url('storage')}}/{{$user_details->image}}" class="rounded-circle avatar profile-pic" alt="">
                                    @else
                                        <img src="{{asset('assets/admin_panel/images/user-avatar.png')}}" class="rounded-circle avatar profile-pic" alt="">
                                    @endif
                                    <input id="fileToUpload" type="file" name="files" accept="image/jpeg, image/png" class="file-upload none"> 
                                    <button type="button" class="fab"  id="btn-edit-basic" 
                                            onclick="document.getElementById('fileToUpload').click()">
                                        <i class="fas fa-upload"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-12 col-sm-12 col-md-6 col-lg-6">
                                <label for="">First Name</label>
                                <input type="text" class="form-control" name="first_name" placeholder="First Name"
                                value="{{$user_details->employee->first_name}}"> 
                            </div>
                        
                            <div class="form-group col-12 col-sm-12 col-md-6 col-lg-6">
                                <label for="">Last Name</label>
                                <input type="text" class="form-control" name="last_name" placeholder="Last Name"
                                value="{{$user_details->employee->last_name}}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-12 col-sm-12 col-md-6 col-lg-6">
                                <label for="">Email</label>
                                <input type="text" class="form-control" name="email" placeholder="Email"
                                value="{{$user_details->employee->email}}">
                            </div>
                            <div class="form-group col-12 col-sm-12 col-md-6 col-lg-6">
                                <label for="">Contact</label>
                                <input type="text" class="form-control" name="contact" placeholder="Contact No"
                                value="{{$user_details->employee->phone}}">
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

    <div class="modal fade" id="passwordResetModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="title" id="largeModalLabel">Reset Password</h4>
                </div>
                
                <div class="modal-body">
                    <form role="form" class="form-validation" method="post" id="passwordResetForm" name="passwordResetForm">
                        {{csrf_field()}}
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label for="">Current Password</label>
                                    <input type="password" class="form-control" id="" name="old" placeholder="old password">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label for="">New Password</label>
                                    <input type="password" class="form-control" id="" name="new" placeholder="new password">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label for="">Confirm Password</label>
                                    <input type="password" class="form-control" id="" name="confirm" placeholder="cofirm password">
                                </div>
                            </div>
                        </div>
                        <div class="row text-right">
                            <div class="form-group col-md-12">
                                <button type="submit" class="btn btn-primary">Reset</button>
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
<script src="{{asset('/assets/dist/angular/angular/angular.min.js')}}"></script>
<script src="{{asset('/assets/admin_panel/dist/select2/select2.min.js')}}"></script>

<script src="{{asset('assets/admin_panel/dist/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
<script src="{{asset('assets/js/dialog.js')}}"></script>
<script src="{{asset('assets/admin_panel/dist/bootsrap-fileinput/js/fileinput.min.js')}}"></script>
<script src="{{asset('assets/admin_panel/dist/bootsrap-fileinput/themes/explorer-fa/theme.js')}}"></script>

<script src="{{asset('assets/dist/moment/moment.js')}}"></script>
<script src="{{asset('assets/dist/angular-moment/angular-moment.min.js')}}"></script>

<script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
<script src="https://www.amcharts.com/lib/3/serial.js"></script>

<script src="{{asset('assets/admin_panel/bundles/mainscripts.bundle.js')}}"></script>
<!-- <script src="{{asset('assets/admin_panel/js/pages/chart/c3.js')}}"></script> -->

<script type="text/javascript">

    $(document).ready(function(){

        $('.page-loader-wrapper').show();

        var readURL = function(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('.profile-pic').attr('src', e.target.result);
                }
        
                reader.readAsDataURL(input.files[0]);
            }
        }
        

        $(".file-upload").on('change', function(){
            readURL(this);
        });
        

        
        $(".select2").select2();

        $("#files").fileinput({
            theme: "fa",
            uploadAsync: false,
            showRemove: true,
            showUpload: false, // <------ just set this from true to false
            showCancel: false,
            layoutTemplates: {actions: ''},
            previewFileIcon: '<i class="fa fa-file"></i>',
            allowedPreviewTypes: ['image'], // set to empty, null or false to disable preview for all types
            previewFileIconSettings: {
                'docx': '<i class="fa fa-file-word-o text-primary"></i>',
                'xlsx': '<i class="fa fa-file-excel-o text-success"></i>',
                'pptx': '<i class="fa fa-file-powerpoint-o text-danger"></i>',
                'jpg': '<i class="fa fa-file-photo-o text-warning"></i>',
                'pdf': '<i class="fa fa-file-pdf-o text-danger"></i>',
                'zip': '<i class="fa fa-file-archive-o text-muted"></i>',
            }
        });

        $('#edit_basic_form').submit(function(e) {

            e.preventDefault();
            $('.page-loader-wrapper').show();
            
            var formData = new FormData(this);
            $.ajax({
                type: "POST",
                url: "{{url('admin/profile/save-basic-details')}}",
                data: formData,
                async: false,
                contentType: false,
                cache: false,
                processData:false,
                success: function(data){
                    if(data==1){
                        $('.page-loader-wrapper').hide();
                        swal({
                            title: "Success!",
                            text: "Profile Updated.",
                        });
                        window.location.reload();
                    }else{
                        $('.page-loader-wrapper').hide();
                        swal({
                            title: "Error!",
                            text: "Profile not updated.",
                        });
                    }
                },error: function(data){

                }
            });
        });

        $('#passwordResetForm').submit(function(e) {

            $('.page-loader-wrapper').show();
            
            e.preventDefault();
            
            var formData = new FormData(this);
            // console.log(formData);
            $.ajax({
                type: "POST",
                url: "{{url('admin/profile/resetPassword')}}",
                data: formData,
                async: false,
                contentType: false,
                cache: false,
                processData:false,
                success: function(data){
                    if(data.status>0){
                        $('.page-loader-wrapper').hide();
                        $('#passwordResetModal').modal('hide');
                        swal({
                            title: "Success!",
                            text: "Password reset success.",
                        });
                        window.location.reload();
                    }else{
                        $('.page-loader-wrapper').hide();
                        swal({
                            title: "Error!",
                            text: data.msg,
                        });
                    }
                },error: function(data){
                    swal({
                        title: "Error!",
                        text: 'error occured',
                    });
                }
            });
        });


     });

    //initialize angular app
    var app = angular.module("ngApp",['angularMoment']);

    //controller
    app.controller("ProfileController", function($scope,$http){

        $scope.measurements = null;
 
        $('#btn-edit-basic').on('click',function() {
            $('#profileEditModal').modal('show');
        }); 

        $('#btnResetPassword').on('click',function() {
            $('#passwordResetModal').modal('show');
        });

    });

</script>
@stop
