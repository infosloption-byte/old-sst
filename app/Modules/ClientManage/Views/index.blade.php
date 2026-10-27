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
</style>
@stop


@section('content')

<div ng-app="ngApp" ng-controller="EmployeeController"> 
	
	<div class="block-header">
	    <div class="row">
	        <div class="col-lg-6 col-md-8 col-sm-12">
	            <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth">
	                <i class="fa fa-arrow-left"></i></a> Client Management</h2>
	            
	        </div>            
	        <div class="col-lg-6 col-md-4 col-sm-12">
	            <div class="row float-right mr-0">
	                <ul class="breadcrumb pull-right">
	                    <li class="breadcrumb-item"><a href="index.html"><i class="icon-home"></i></a></li>                           
	                    <li class="breadcrumb-item">Client Management</li>
	                    <li class="breadcrumb-item active">Client List</li>
	                </ul>
	            </div>
	        </div>
	    </div>
	</div>

	<div class="row clearfix">

	    <div class="col-lg-12 col-md-12">
	        <div class="card planned_task">
	            <div class="header">
	                <h2>Client List</h2>
	                <ul class="header-dropdown">

	                	<!-- CHECK PERM -->
	                	<li><a class="tab_btn table-btn" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="" data-original-title="Create New Client" id="btn-add"><i class="fas fa-plus "></i></a></li>
						<!-- CHECK PERM -->
	                </ul>
	            </div>
	            <div class="body">
	                <div class="table-responsive">
		                <table class="table table-hover m-b-0 c_list">
		                    <thead>
		                        <tr>
		                        	<td></td>
		                            <th>Name</th>                                    
		                            <th>Client No</th>                                   
		                            <th>Company</th>                                   
		                            <th>Phone</th>
		                            <th>Created at</th>
		                            <th>Role</th>
		                            <th>User Account</th>
		                            <th>Action</th>
		                        </tr>
		                    </thead>
		                        <tbody>
		                        @foreach($employee_list as $employee)	
		                        <tr>
                                    <td>
                                        @if(isset($employee->user) && $employee->user->image==null)
											@if($employee->gender=='male')
	                                        <img src="{{asset('assets/admin_panel/images/002-boy.png')}}" 
	                                        		class="rounded-circle avatar" alt="">
	                                        @endif

	                                        @if($employee->gender=='female')
	                                        <img src="{{asset('assets/admin_panel/images/001-woman.png')}}" 
	                                        		class="rounded-circle avatar" alt="">
	                                        @endif
                                        @else
                                        	@if(isset($employee->user->image))
											<img src="{{url('storage')}}/{{$employee->user->image}}" 
	                                        		class="rounded-circle avatar" alt="">
	                                       	@else
	                                       		@if($employee->gender=='male')
		                                        <img src="{{asset('assets/admin_panel/images/002-boy.png')}}" 
		                                        		class="rounded-circle avatar" alt="">
		                                        @endif

		                                        @if($employee->gender=='female')
		                                        <img src="{{asset('assets/admin_panel/images/001-woman.png')}}" 
		                                        		class="rounded-circle avatar" alt="">
		                                        @endif
	                                        @endif
                                        @endif
                                    </td>
                                    <td>
                                        <h6 class="mb-0"><a href="">{{$employee->first_name}} {{$employee->last_name}}</a></h6>
                                        <span>{{$employee->email}}</span>
                                    </td>
                                    <td>
                                    	<span>#{{$employee->employee_no}}</span><br> <span class="badge badge-danger">{{$employee->type}}</span>
                                    </td>
                                    <td>
                                    	<span>{{$employee->company}}</span>
                                    </td>
                                    <td><span>{{$employee->phone}}</span></td>
                                    <td>{{$employee->created_at->format('Y-m-d')}}</td>
                                    <td>
                                    	@if($employee->user)
	                                    	@foreach($employee->user->roles as $role)
	                                    	<span class="badge badge-danger">{{$role->name}}</span>
	                                    	@endforeach
                                    	@else
                                    		not assigned
                                    	@endif
                                    </td>
                                    <td>
                                    	@if($employee->user)
                                    		<span class="badge badge-success">created</span><br>
                                    		<small>Username {{$employee->user->username}}</small>
                                    	@else
                                    		---
                                    	@endif
                                    </td>
                                    <td>
                                        <!-- <button type="button" class="btn btn-success btn-mail" title="Send Mail" data-id="{{$employee->id}}"><i class="fa fa-paper-plane"></i></button> -->
                                        <button type="button" class="btn btn-info btn-edit" title="Edit" data-id="{{$employee->id}}"><i class="fa fa-edit"></i></button>
		                                <button type="button" data-type="confirm" class="btn btn-danger js-sweetalert btn-delete" title="Delete"
		                                data-id="{{$employee->id}}"><i class="fa fa-trash"></i></button>
		                                @if($user->employee_id==1)
	                                        <button type="button" class="btn btn-sm btn-success btn-reset" title="Password Reset" data-id="{{$employee}}">
	                                        	<i class="fa fa-user-shield"></i>
	                                        </button>
	                                    @endif
                                    </td>
                                </tr>
                                @endforeach
		                    </tbody>
		                </table>
		            </div>

	            </div>
	        </div>
	    </div>

	</div>

	<div class="modal fade" id="largeModalAdd" tabindex="-1" role="dialog">
	    <div class="modal-dialog modal-lg" role="document">
	    	<div class="dialog-loader">
	    		<div class="m-t-30 text-center"><div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div></div>
	    	</div>
	        <div class="modal-content">
	            <div class="modal-header">
	                <h4 class="title" id="largeModalLabel">Add New Client</h4>
	            </div>
	            <form action="" method="POST" role="form" id="role-add-form">
	            	{{csrf_field()}}
		            <div class="modal-body"> 

	            		<div class="row">
	            			<div class="form-group col-md-4">
		            			<label for="" class="reuired">First Name</label>
		            			<input type="text" class="form-control" name="first_name" placeholder="First Name"
		            			 ng-model="first_name"
		            			 >
		            		</div>
		            		<div class="form-group col-md-4">
		            			<label for="">Last Name</label>
		            			<input type="text" class="form-control" name="last_name" placeholder="Last Name"
		            			 ng-model="last_name">
		            		</div>
		            		<div class="form-group col-md-4">
		            			<label for="">Client No</label>
		            			<input type="text" class="form-control" name="employee_no" placeholder="Client No"
		            			 ng-model="employee_no">
		            		</div>
	            		</div>

	            		<div class="row">
	            			<div class="form-group col-lg-12">
	            				<label for="">Company Name</label>
		            			<input type="text" class="form-control" name="company" placeholder="Company name"
		            			 ng-model="company">
	            			</div>
	            		</div>

	            		<div class="row">
	            			<div class="form-group col-md-4">
		            			<label for="">Phone</label>
		            			<input type="text" class="form-control" name="phone" placeholder="Phone"
		            			ng-model="phone">
		            		</div>
		            		<div class="form-group col-md-4">
		            			<label for="">Email</label>
		            			<input type="text" class="form-control" name="email" placeholder="Email" ng-model="email">
		            		</div>
	            			<div class="form-group col-md-4">
		            			<label for="">Department</label>
		            			<select name="department" id="inputDepartment" class="form-control show-tick ms select2"
		            			ng-model="department" >
		            				<option value="">- Select Department -</option>
		            				@foreach($departments as $department)
		            					<option value="{{$department->id}}">{{$department->name}}</option>
		            				@endforeach
		            			</select>
		            		</div>
	            		</div>

	            		<div class="row">
	            			<div class="form-group col-md-10">
		            			<label for="">Address</label>
		            			<textarea type="text" class="form-control" name="address" placeholder="Address"
		            			ng-model="address"></textarea>
		            		</div>
		            		<div class="form-group col-md-2">
		            			<label for="">Gender</label>
		            			<label class="fancy-radio">
		            				<input name="gender" value="male" type="radio" ng-model="gender" ><span><i></i>Male</span>
		            			</label>
		            			<label class="fancy-radio">
		            				<input name="gender" value="female" type="radio" ng-model="gender" ><span><i></i>Female</span>
		            			</label>
		            		</div>
	            		</div>

	            		<div class="row">
	            			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	            				<div class="form-group 	">
			            			<label class="fancy-checkbox " ng-init="is_user=0">
	                                    <input class="checkbox" type="checkbox" name="is_user" ng-model="is_user" value="1">
	                                    <span>Create User Account</span>
	                                </label>
			            		</div>
	            			</div>
	            		</div>

	            		<div class="row" ng-show="is_user==1">

	            			<div class="form-group col-md-4">
		            			<label for="">Username</label>
		            			<input type="text" class="form-control" name="username" placeholder="Username" 
		            			ng-model="username" >
		            		</div>
		            		<div class="form-group col-md-4">
		            			<label for="">Password</label>
		            			<input type="text" class="form-control" name="password" placeholder="Password">
		            		</div>
		            		<div class="form-group col-md-4">
		            			<label for="">Conf Password</label>
		            			<input type="text" class="form-control" name="conf_password" placeholder="Conf. Password">
		            		</div>


	            			<div class="form-group col-md-12">
		            			<dualmultiselect options="addRoles"> </dualmultiselect>
		            		</div>

	            		</div>



		            </div>
		            <div class="modal-footer">
		                <button type="submit" class="btn btn-primary">SAVE CHANGES</button>
		                <button type="button" class="btn btn-danger" data-dismiss="modal">CLOSE</button>
		            </div>
	            </form>
	        </div>
	    </div>
	</div>

	<div class="modal fade" id="largeModalEdit" tabindex="-1" role="dialog">
	    <div class="modal-dialog modal-lg" role="document">
	    	<div class="dialog-loader">
	    		<div class="m-t-30 text-center"><div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div></div>
	    	</div>
	        <div class="modal-content">
	            <div class="modal-header">
	                <h4 class="title" id="largeModalLabel">Edit Client</h4>
	            </div>
	            <form action="" method="POST" role="form" id="role-edit-form">
	            	{{csrf_field()}}
		            <div class="modal-body"> 

		            	<input type="hidden" class="form-control" name="employee_id" ng-model="edit.id"
		            	value="@{{edit.id}}">

		            	<input type="hidden" class="form-control" name="user_id" ng-model="edit.user_id"
		            	value="@{{edit.user_id}}">

	            		<div class="row">
	            			<div class="form-group col-md-4">
		            			<label for="" class="reuired">First Name</label>
		            			<input type="text" class="form-control" name="first_name" placeholder="First Name"
		            			 ng-model="edit.first_name"
		            			>
		            		</div>
		            		<div class="form-group col-md-4">
		            			<label for="">Last Name</label>
		            			<input type="text" class="form-control" name="last_name" placeholder="Last Name"
		            			 ng-model="edit.last_name">
		            		</div>
		            		<div class="form-group col-md-4">
		            			<label for="">Employee No</label>
		            			<input type="text" class="form-control" name="employee_no" placeholder="Employee No"
		            			 ng-model="edit.employee_no">
		            		</div>
	            		</div>

	            		<div class="row">
	            			<div class="form-group col-lg-12">
	            				<label for="">Company Name</label>
		            			<input type="text" class="form-control" name="company" placeholder="Company name"
		            			 ng-model="edit.company">
	            			</div>
	            		</div>

	            		<div class="row">
	            			<div class="form-group col-md-4">
		            			<label for="">Phone</label>
		            			<input type="text" class="form-control" name="phone" placeholder="Phone"
		            			ng-model="edit.phone">
		            		</div>
		            		<div class="form-group col-md-4">
		            			<label for="">Email</label>
		            			<input type="text" class="form-control" name="email" placeholder="Email" 
		            			ng-model="edit.email">
		            		</div>
		            		<div class="form-group col-md-4">
		            			<label for="">Department</label>
		            			<select name="department" id="inputDepartment" class="form-control show-tick ms select2"
		            			ng-model="edit.department_id" ng-selected="0">
		            				<option value="" >- Select Department -</option>
		            				<option ng-value="department.id" ng-repeat="department in departments"
		            				ng-selected="department.id==edit.department_id">@{{department.name}}</option>
		            			</select>
		            		</div>
	            		</div>

	            		<div class="row">
	            			
		            		<div class="form-group col-md-10">
		            			<label for="">Address</label>
		            			<textarea type="text" class="form-control" name="address" placeholder="Address"
		            			ng-model="edit.address"></textarea>
		            		</div>
		            		<div class="form-group col-md-2">
		            			<label for="">Gender</label>
		            			<label class="fancy-radio" style="margin-top: 15px">
		            				<input name="gender" value="male" type="radio" ng-model="edit.gender" ><span><i></i>Male</span>
		            			</label>
		            			<label class="fancy-radio">
		            				<input name="gender" value="female" type="radio" ng-model="edit.gender" ><span><i></i>Female</span>
		            			</label>
		            		</div>
	            		</div>

	            		<div class="row">
	            			<div class="form-group col-md-12" ng-show="edit.can_edit_user==0">
		            			<label class="fancy-checkbox " >
                                    <input class="checkbox" type="checkbox" name="is_user" ng-model="edit.is_user" value="1">
                                    <span>Create User Account</span>
                                </label>
		            		</div>
		            		<div class="form-group col-md-12" ng-show="edit.can_edit_user>0">
		            			<label class="fancy-checkbox " >
                                    <input class="checkbox" type="checkbox" name="reset_password" 
                                    ng-model="edit.reset_password" value="1">
                                    <span>Tick this if you want to change username and password</span>
                                </label>
		            		</div>
	            		</div>

	            		<div class="row" ng-show="edit.is_user==1">

	            			<div class="form-group col-md-4" ng-show="edit.reset_password==1 || edit.is_user==1">
		            			<label for="">Username</label>
		            			<input type="text" class="form-control" name="username" placeholder="Username" 
		            			ng-model="edit.username" >
		            		</div>
		            		<div class="form-group col-md-4" ng-show="edit.reset_password==1 || edit.is_user==1">
		            			<label for="">Password</label>
		            			<input type="text" class="form-control" name="password" placeholder="Password">
		            		</div>
		            		<div class="form-group col-md-4" ng-show="edit.reset_password==1 || edit.is_user==1">
		            			<label for="">Conf Password</label>
		            			<input type="text" class="form-control" name="conf_password" placeholder="Conf. Password">
		            		</div>

	            			<div class="form-group col-md-12">
		            			<dualmultiselect options="editRoles"> </dualmultiselect>
		            		</div>

	            		</div>



		            </div>
		            <div class="modal-footer">
		                <button type="submit" class="btn btn-primary">SAVE CHANGES</button>
		                <button type="button" class="btn btn-danger" data-dismiss="modal">CLOSE</button>
		            </div>
	            </form>
	        </div>
	    </div>
	</div>

	<div class="modal fade" id="largeModalPasswordReset" tabindex="-1" role="dialog">
	    <div class="modal-dialog modal-md" role="document">
	        <div class="modal-content">
	            <div class="modal-header">
	                <h4 class="title" id="largeModalLabel">Reset Password</h4>
	            </div>
	            <form action="" method="POST" role="form" id="reset-form">
	            	{{csrf_field()}}
	            	<input type="hidden" name="reset_employee_id" id="reset_employee_id">
		            <div class="modal-body">
		            	<div class="row">
		            		<div class="form-group col-md-12">
		            			<label for="">Username</label>
		            			<input type="text" class="form-control" name="reset_username" id="reset_username" placeholder="Username">
		            		</div>
		            		<div class="form-group col-md-12">
		            			<label for="">New Password</label>
		            			<input type="password" class="form-control" name="reset_password1" id="reset_password1" placeholder="Password">
		            		</div>
		            		<div class="form-group col-md-12">
		            			<label for="">Conf Password</label>
		            			<input type="password" class="form-control" name="reset_conf_password1" id="reset_conf_password1" placeholder="Conf. Password">
		            		</div>
		            	</div>
	            	</div>
		            <div class="modal-footer">
		                <button type="submit" class="btn btn-primary">Reset</button>
		                <button type="button" class="btn btn-danger" data-dismiss="modal">CLOSE</button>
		            </div>
	            </form>
	        </div>
	    </div>
	</div>

</div>

@stop


@section('js')

<script src="{{asset('/assets/dist/angular/angular/angular.min.js')}}"></script>
<script src="{{asset('/assets/dist/ng-multiselect/dualmultiselect.js')}}"></script>
<script src="{{asset('/assets/admin_panel/dist/select2/select2.min.js')}}"></script>
<script src="{{asset('/assets/js/dialog.js')}}"></script>

<script type="text/javascript">

	$(document).ready(function()
	{
		$(".select2").select2();
	});

	//initialize angular app
	var app = angular.module("ngApp",['dualmultiselect']);

	//controller
	app.controller("EmployeeController", function($scope,$http)
	{

		$scope.edit = {};
		$scope.departments = [];
		$scope.supervisors = [];

		$scope.addRoles = {
			labelAll: 'All Items',
			labelSelected: 'Selected Items',
			helpMessage: 'Select roles to assign , search roles from below',
			/* angular will use this to filter your lists */
			orderProperty: 'name',
			/* this contains the initial list of all items (i.e. the left side) */
			items: [],
			/* this list should be initialized as empty or with any pre-selected items */
			selectedItems: [] 
		};	

		$scope.editRoles = {
			labelAll: 'All Items',
			labelSelected: 'Selected Items',
			helpMessage: 'Select roles to assign , search roles from below',
			/* angular will use this to filter your lists */
			orderProperty: 'name',
			/* this contains the initial list of all items (i.e. the left side) */
			items: [],
			/* this list should be initialized as empty or with any pre-selected items */
			selectedItems: [] 
		};

		$('.btn-reset').on('click',function()
	 	{
	 		emp_detail = $(this).data('id');

	 		$('#reset_employee_id').val(emp_detail.id);
	 		if(emp_detail.user){
	 			$('#reset_username').val(emp_detail.user.username);
	 			$('#largeModalPasswordReset').modal('show');
	 		}else{
	 			swal({
	            	title: "Faild!",
	            	text: "Create user account before reset.",
	            });
	 		}
	 	});

		$('#btn-add').on('click',function()
		{
	 		$('#largeModalAdd').modal('show');

	        $scope.addRoles.items = [];
	        $scope.addRoles.selectedItems = [];


	        $.ajax({
		        url: '{{url('admin/client/getroles')}}',
		        type: 'get',
		        success: function(reponse)
		        {
		            $scope.addRoles.items  = reponse;
		            $scope.$apply();

		            $('.dialog-loader').hide();
		        },
		        error: function(Response){               
		        }
		    });	
	 	});

	 	$('.btn-mail').on('click',function()
		{
			var id = $(this).data('id');
			$.ajax({
		        url: '{{url('admin/client/send-account-details')}}',
		        type: 'get',
		        data: {id:id},
		        success: function(reponse)
		        {
		            $('.dialog-loader').hide();

		            swal({
		            	title: "Send!",
		            	text: "Mail sent successfuly to client.",
		            });
		        },
		        error: function(Response){               
		        }
		    });	
	 	});

	 	$('.btn-edit').on('click',function()
	 	{
			$('#largeModalEdit').modal('show');
			var id = $(this).data('id');

			$scope.editRoles.items = [] ;
	        $scope.editRoles.selectedItems = [] ;
			$scope.edit = {};
			$scope.edit.user_id =0;

	 		$.ajax({
		        url: '{{url('admin/client/getDepartments')}}',
		        type: 'get',
		        success: function(reponse){
		            $scope.departments  = reponse;
		            $scope.$apply();
		  			$('.dialog-loader').hide();
		        },
		        error: function(Response){               
		        }
		    });	

	 		$.ajax({
		        url: '{{url('admin/client/getSupervisors')}}',
		        type: 'get',
		        success: function(reponse){
		            $scope.supervisors  = reponse;
		            $scope.$apply();
		  			$('.dialog-loader').hide();
		        },
		        error: function(Response){               
		        }
		    });	

	 		$.ajax({
		        url: '{{url('admin/client/getemployee')}}',
		        type: 'get',
		        data:{'id':id},
		        success: function(reponse){
		            $scope.edit  = reponse.employee;
		            $scope.editRoles.items  = reponse.roles;
		            $scope.edit.is_user = reponse.employee.user?true:false;
		            $scope.edit.can_edit_user = reponse.employee.user?true:false;

		            if(reponse.employee.user){
		            	$scope.editRoles.selectedItems  = reponse.employee.user.roles;
		            	$scope.edit.username  = reponse.employee.user.username;
		            	$scope.edit.user_id  = reponse.employee.user.id;
		            }else{
						$scope.edit.user_id =0;
		            }
		            
		            $scope.$apply();
		            $('.select2').trigger('change');

		            $('.dialog-loader').hide();
		        },
		        error: function(Response){               
		        }
		    });
		});

		$("form#role-add-form").submit(function(e)
		{
	        e.preventDefault();    
	        var formData = new FormData(this); 
	        formData.append('roles',angular.toJson($scope.addRoles.selectedItems));

	        $('.dialog-loader').show();

	        $.ajax({
	            url: "{{url('admin/client/create')}}",
	            type: 'POST',
	            dataType : 'json',
	            data: formData,
	            success: function (data) {
	            	$('.dialog-loader').hide();

	            	swal({
	            		title: "Success!",
	            		text: "New client addedd successfuly.",
	            	});
	            	location.reload();
	            },
	            error:function(data) {
	            	$('.dialog-loader').hide();
	            	swal({
	            		title: "Error!",
	            		text: "Error adding new client.",
	            	});
	            },
	            cache: false,
	            contentType: false,
	            processData: false
	        });
	        return false;
	    });

	    $("form#role-edit-form").submit(function(e)
	    {
	        e.preventDefault();    
	        var formData = new FormData(this); 
	        formData.append('roles',angular.toJson($scope.editRoles.selectedItems));

	        $('.dialog-loader').show();

	        $.ajax({
	            url: "{{url('admin/client/update')}}",
	            type: 'POST',
	            dataType : 'json',
	            data: formData,
	            success: function (data){
	            	$('.dialog-loader').hide();
	            	swal({
	            		title: "Success!",
	            		text: "Client updated successfuly.",
	            	});
	            	location.reload();
	            },
	            error:function(data) {
	            	$('.dialog-loader').hide();
	            	swal({
	            		title: "Error!",
	            		text: "Error occured while updating client.",
	            	});
	            },
	            cache: false,
	            contentType: false,
	            processData: false
	        });
	        return false;
	    });

	    $('.btn-delete').on('click',function()
	    {
	    	var id = $(this).data('id');

	    	showConfirmMessage('Delete','Would you like to delete this?','yes delete','error',function(isConfirm)
	    	{
	 			if(isConfirm)
	 			{
	 				$.ajax({
				        url: '{{url('admin/client/delete')}}',
				        type: 'POST',
				        data:{'id':id,'releated':false},
				        success: function(response){
				            if(response.success){
								swal("Deleted","All records deleted ", "success");
								location.reload();
				            }else{
				            	if(response.error.code=="5000"){
				            		showCancelMessage("Releated Data", response.error.message, "error",function(isConfirm) {
				            			if (isConfirm) {
								            $.ajax({
										        url: '{{url('admin/client/deleteWithRelations')}}',
										        type: 'POST',
										        data:{'id':id,'releated':false},
										        success: function(response){
										            if(response.success){
														showWithTitleMessage("Deleted", "All data has been deleted with relations");
														location.reload();
										            }else{
										            	showWithTitleMessage("Cancelled", "Clear Related data");
										            }
										        },
										        error: function(reponse){
												    
												}
										    });	
								        } else {
								            showWithTitleMessage("Cancelled", "Clear Related data");
								        }
				            		});
					            }
				            }
				        },
				        error: function(reponse){
						    
						}
				    });
	 			}
	 		});
	    });

	    $("form#reset-form").submit(function(e)
	    {
	        e.preventDefault();

	        if($('#reset_password1').val() != $('#reset_conf_password1').val())
	        {
	        	swal({
	         		title: "Faild!",
	         		text: "Password not matched.",
	         	});
	        	return false;
	        }

	        var formData = new FormData(this);
	        $('.dialog-loader').show();
	        
	        $.ajax({
	            url: "{{url('admin/client/resetPassword')}}",
	            type: 'POST',
	            data: formData,
	            success: function (data) {
	             	$('.dialog-loader').hide();
	             	if(data.status==1){
		             	swal({
		             		title: "Success!",
		             		text: "Password reset successfuly.",
		             	});
		             	location.reload();
		            }else{
		            	swal({
		             		title: "Faild!",
		             		text: "Password reset faild. Try Again.",
		             	});
		            }
	            },
	            error:function(data) {
	             	
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