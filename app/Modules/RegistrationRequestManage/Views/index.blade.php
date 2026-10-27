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

<div ng-app="ngApp" ng-controller="RegistrationManageController" ng-init="loadRegistrationRequestData()"> 
    
    <div class="block-header">
        <div class="row">
            <div class="col-lg-6 col-md-8 col-sm-12">
                <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth">
                   </a> <i class="fas fa-bars"></i></a> Registration Request Manage</h2>
                
            </div>            
            <div class="col-lg-6 col-md-4 col-sm-12">
                <div class="row float-right mr-0">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html"><i class="icon-home"></i></a></li>                           
                        <li class="breadcrumb-item">Registration Request Manage</li>
                        <li class="breadcrumb-item active">Registration Request List</li>
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
                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="icon-magnifier"></i></span>
                                </div>
                                <input style="height: 40px" name="keyword" id="keyword" class="form-control" placeholder="Search here..." type="text">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="icon-magnifier"></i></span>
                                </div>
                                <input style="height: 40px" name="city" id="city" class="form-control" placeholder="City" type="text">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="icon-magnifier"></i></span>
                                </div>
                                <input style="height: 40px" name="state" id="state" class="form-control" placeholder="State" type="text">
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
                    <h2>Registration Request List</h2>
                </div>
                <div class="body">
                    <div class="table-responsive mb-3">
                        <table class="table table-bordered table-hover m-b-0 c_list">
                            <thead>
                                <tr>
                                    <th class="pr-0">#</th>
                                    <th></th>
                                    <th>Full Name</th>
                                    <th>Email / Contact No</th>
                                    <th>Address</th>
                                    <th class="text-center">City</th>
                                    <th class="text-center">State</th>
                                    <th class="text-right">Request Date</th>
                                    <th class="text-right">Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="detail in details.data">
                                    <td>
                                        @{{$index+1}}
                                    </td>
                                    <td>
                                        <img image="{{url('storage/attachments/profile_pics')}}/@{{detail.profile_pic}}" 
                                            image-loading="{{asset('assets/admin_panel/images/ajax-loader.gif')}}"  class="rounded-circle avatar " 
                                            data-title="@{{detail.first_name}} @{{detail.last_name}}" 
                                            data-toggle="tooltip" 
                                            data-placement="bottom" 
                                            data-title="@{{detail.first_name}} @{{detail.last_name}}"
                                            style="border:1px solid #ddd">
                                    </td>
                                    <td>
                                        @{{detail.first_name}} @{{detail.last_name}}
                                    </td>
                                    <td>
                                        @{{detail.email}}<br>
                                        @{{detail.contact_no}}
                                    </td>
                                    <td>
                                        @{{detail.street}}<br>
                                        @{{detail.building_no}}
                                    </td>
                                    <td>
                                        <span class="badge bg-dark text-light">@{{detail.city}}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-info text-light">@{{detail.state}}</span>
                                    </td>
                                    <td class="text-right">
                                        @{{detail.created_at}}
                                    </td>
                                    <td class="text-right">
                                        <span ng-show="detail.status==0" class="badge bg-primary text-light">Pending</span>
                                        <span ng-show="detail.status==1" class="badge bg-success text-light">Approved</span>
                                        <span ng-show="detail.status==2" class="badge bg-danger text-light">Rejected</span>
                                        <span ng-show="detail.status==3" class="badge bg-info text-light">Employee Created</span>
                                    </td>
                                    <td>
                                        <div ng-show="detail.status==0">
                                            <button title="Approve Request" class="btn btn-success btn-sm" ng-click="approveAction(detail.id)" style="font-size: 8px"><i class="fa fa-check"></i></button>
                                            <button title="Create Employee Disabled" class="btn btn-info btn-sm" disabled="disabled" style="font-size: 8px"><i class="fa fa-user"></i></button>
                                            <button title="Reject Request" class="btn btn-danger btn-sm" ng-click="rejectAction(detail.id)" style="font-size: 8px"><i class="fa fa-times"></i></button>
                                        </div>

                                        <div ng-show="detail.status==1">
                                            <button title="Approve Request Disabled" class="btn btn-success btn-sm" disabled="disabled" style="font-size: 8px"><i class="fa fa-check"></i></button>
                                            <button title="Create Employee" class="btn btn-info btn-sm btn-employee" ng-click="showEmployeeModal(detail)" style="font-size: 8px"><i class="fa fa-user"></i></button>
                                            <button title="Reject Request Disabled" class="btn btn-danger btn-sm" disabled="disabled" style="font-size: 8px"><i class="fa fa-times"></i></button>
                                        </div>

                                        <div ng-show="detail.status==2">
                                            <button title="Approve Request Disabled" class="btn btn-success btn-sm" disabled="disabled" style="font-size: 8px"><i class="fa fa-check"></i></button>
                                            <button title="Create Employee Disabled" class="btn btn-info btn-sm" disabled="disabled" style="font-size: 8px"><i class="fa fa-user"></i></button>
                                            <button class="btn btn-danger btn-sm" disabled="disabled" style="font-size: 8px"><i class="fa fa-times"></i></button>
                                        </div>

                                        <div ng-show="detail.status==3">
                                            <button title="Approve Request Disabled" class="btn btn-success btn-sm" disabled="disabled" style="font-size: 8px"><i class="fa fa-check"></i></button>
                                            <button title="Create Employee Disabled" class="btn btn-info btn-sm" disabled="disabled" style="font-size: 8px"><i class="fa fa-user"></i></button>
                                            <button title="Reject Request Disabled" class="btn btn-danger btn-sm" disabled="disabled" style="font-size: 8px"><i class="fa fa-times"></i></button>
                                        </div>
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

    <div class="modal fade" id="modal-employee" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="title" id="largeModalLabel">Create Employee</h4>
                </div>
                <form action="" method="POST" role="form" id="form-create" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="modal-body">
                        <input type="hidden" name="request_id" id="request_id" value="@{{temp_emp.id}}">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="" class="reuired">First Name</label>
                                <input type="text" class="form-control" name="first_name" placeholder="First Name" value="@{{temp_emp.first_name}}"
                                 >
                            </div>
                            <div class="form-group col-md-4">
                                <label for="">Last Name</label>
                                <input type="text" class="form-control" name="last_name" placeholder="Last Name" value="@{{temp_emp.last_name}}">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="">Employee No</label>
                                <input type="text" class="form-control" name="employee_no" placeholder="Employee No">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="">Phone</label>
                                <input type="text" class="form-control" name="phone" placeholder="Phone" value="@{{temp_emp.contact_no}}">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="">Email</label>
                                <input type="text" class="form-control" name="email" placeholder="Email" value="@{{temp_emp.email}}">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="">Gender</label>
                                <label class="fancy-radio" style="margin-top: 15px">
                                    <input name="gender" value="male" type="radio" ng-model="gender" ><span><i></i>Male</span>
                                </label>
                                <label class="fancy-radio">
                                    <input name="gender" value="female" type="radio" ng-model="gender" ><span><i></i>Female</span>
                                </label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="">Designation</label>
                                <select name="designation" id="designation" class="form-control show-tick ms select2">
                                    <option value="0" >- Select designation -</option>
                                    <option ng-repeat="designation in designations" value="@{{designation.id}}">@{{designation.name}}</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="">Department</label>
                                <select name="department" id="inputDepartment" class="form-control show-tick ms select2">
                                    <option value="0">- Select Department -</option>
                                    @foreach($departments as $department)
                                        <option value="{{$department->id}}">{{$department->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="">Supervisor</label>
                                <select name="supervisor" id="inputDepartment" class="form-control show-tick ms select2">
                                    <option value="0">- No Supervisor -</option>
                                    @foreach($supervisors as $supervisor)
                                        <option value="{{$supervisor->id}}">{{$supervisor->first_name}} {{$supervisor->last_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">CREATE</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">CLOSE</button>
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
    var app = angular.module("ngApp",['dualmultiselect','angularImgFallback','ui.bootstrap','ngSanitize','bw.paging']);


    app.config(['$tooltipProvider', function ($tooltipProvider) {
        $tooltipProvider.options({
            appendToBody: true, // 
            appendToBody: true, // 
            placement:'bottom' // Set Default Placement
        });
    }]);

    //controller
app.controller("RegistrationManageController", function($scope,$http)
{
    $scope.details = [];
    $scope.temp_emp = [];

    $scope.departments = [];
    $scope.designations = [];
    $scope.supervisors = [];

    $.ajax({
        url: '{{url('admin/employee/getDesignations')}}',
        type: 'get',
        success: function(reponse){
            $scope.designations  = reponse;
            $scope.$apply();
            $('.dialog-loader').hide();
        },
        error: function(Response){               
        }
    });

    $scope.loadRegistrationRequestData = function()
    {
        $.ajax({
            url: "{{url('admin/registration/get-registration-request-data')}}",
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
        city = $('#city').val();
        state = $('#state').val();

        $.ajax({
            url: "{{url('admin/registration/get-registration-request-data')}}",
            type: 'GET',
            data: {
                page: page,
                keyword : keyword,
                city : city,
                state : state
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

    $scope.approveAction = function(id)
    {
        showConfirmMessage('Accept','Would you like to Accept this?','Yes Accept','info',function(isConfirm) {
            if(isConfirm){
                $.ajax({
                    url: "{{url('admin/registration/approve')}}",
                    type: 'POST',
                    data: {
                        'id' : id
                    },
                    success: function (data)
                    {
                        if(data.status_code == 200)
                        {
                            swal({
                                title: data.message,
                                text: data.debug,
                            });

                            $scope.loadRegistrationRequestData();
                        }else{
                            swal({
                                title: data.message,
                                text: data.debug,
                            });
                        }
                    },
                    error:function(data)
                    {
                        swal({
                            title: data.message,
                            text: data.debug,
                        });
                    }
                });
            }
        });
    }

    $scope.rejectAction = function(id)
    {
        swal({
            title: "Reject!",
            text: "Enter reason to reject",
            type: "input",
            showCancelButton: true,
            closeOnConfirm: false,
            inputPlaceholder: "Write something"
        }, function (inputValue) {
            if (inputValue === false) return false;
            if (inputValue === "") {
                swal.showInputError("Write here...."); return false
            }

            $.ajax({
                url: "{{url('admin/registration/reject')}}",
                type: 'POST',
                data: {
                    'id' : id,
                    'reason' : inputValue
                },
                success: function (data)
                {
                    if(data.status_code == 200)
                    {
                        swal({
                            title: data.message,
                            text: data.debug,
                        });

                        $scope.loadRegistrationRequestData();
                    }else{
                        swal({
                            title: data.message,
                            text: data.debug,
                        });
                    }
                },
                error:function(data)
                {
                    swal({
                        title: data.message,
                        text: data.debug,
                    });
                }
            });

        });
    }

    $scope.showEmployeeModal = function(emp_req)
    {
        $scope.temp_emp = emp_req;

        $('#modal-employee').modal('show');
    }

    $("form#form-create").submit(function(e)
    {
        e.preventDefault();    
        var formData = new FormData(this);

        $('.dialog-loader').show();
        $.ajax({
            url: "{{url('admin/employee/create')}}",
            type: 'POST',
            dataType : 'json',
            data: formData,
            success: function (data)
            {
                $('.dialog-loader').hide();
                
                if(data.status == 1)
                {
                    $('#modal-employee').modal('hide');

                    swal({
                        title: 'Created',
                        text: 'Employee created successfully',
                    });

                    location.reload();
                }else{
                    swal({
                        title: 'Faild',
                        text: 'Something went wrong. Try again later',
                    });
                }
            },
            error:function(data) {
                $('.dialog-loader').hide();
                swal({
                    title: 'Faild',
                    text: 'Something went wrong. Try again later',
                });
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
