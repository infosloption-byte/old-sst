@extends('master.master')

@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/admin_panel/dist/bootsrap-fileinput/css/fileinput.css')}}">
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

	.file-drop-zone{
		height: 270px;
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

<div ng-app="ngApp" ng-controller="EmployeeController"> 
	
	<div class="block-header">
	    <div class="row">
	        <div class="col-lg-6 col-md-8 col-sm-12">
	            <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth">
	                <i class="fa fa-arrow-left"></i></a> Employee Management</h2>
	            
	        </div>            
	        <div class="col-lg-6 col-md-4 col-sm-12">
	            <div class="row float-right mr-0">
	                <ul class="breadcrumb pull-right">
	                    <li class="breadcrumb-item"><a href="index.html"><i class="icon-home"></i></a></li>                           
	                    <li class="breadcrumb-item">Employee Management</li>
	                    <li class="breadcrumb-item active">Employee List</li>
	                </ul>
	            </div>
	        </div>
	    </div>
	</div>

	<div class="row clearfix">

	    <div class="col-lg-12 col-md-12">
	        <div class="card planned_task">
	            <div class="header">
	                <h2>Employee List</h2>
	                <ul class="header-dropdown">

	                	<!-- CHECK PERM -->
	                	<li><a class="tab_btn table-btn" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="" data-original-title="Create New Employee" id="btn-add"><i class="fas fa-plus "></i></a></li>
	                </ul>
	            </div>
	            <div class="body">
	                <div class="table-responsive">
		                <table class="table table-hover m-b-0 c_list">
		                    <thead>
		                        <tr>
		                        	<td></td>
		                            <th>Name</th>                                    
		                            <th>Employee No</th>                                   
		                            <th>Department</th>                                   
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
											<img src="{{asset('assets/admin_panel/images/user-avatar.png')}}" 
	                                        		class="rounded-circle avatar" alt="">
                                        @else
                                        	@if(isset($employee->user->image))
											<img src="{{url('storage')}}/{{$employee->user->image}}" 
	                                        		class="rounded-circle avatar" alt="">
	                                       	@else
	                                       		<img src="{{asset('assets/admin_panel/images/user-avatar.png')}}" 
	                                        		class="rounded-circle avatar" alt="">
	                                        @endif
                                        @endif
                                    </td>
                                    <td>
                                        <h6 class="mb-0"><a href="">{{$employee->first_name}} {{$employee->last_name}}</a></h6>
                                        <span>{{$employee->email}}</span>
                                        @if($employee->designation)
                                        <br><strong class="text-info">{{$employee->designation->name}}</strong>
                                    	@endif

                                    	@if($employee->certification)
                                    		<br><span class="ml-0 badge badge-success">CERTIFIED</span>
                                        @else
                                        	<br><span class="ml-0 badge badge-danger">NOT-CERTIFIED</span>
                                    	@endif
                                    </td>
                                    <td>
                                    	<span>#{{$employee->employee_no}}</span><br> <span class="badge badge-danger">{{$employee->type}}</span>
                                    </td>
                                    <td>
                                    	<span class="badge badge-success">{{$employee->department->name}}</span>
                                    	@if($employee->is_hod)
                                    	<span class="badge badge-danger">HOD</span>
                                    	@endif
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
                                        <button type="button" class="btn btn-primary btn-profile" title="Change Profile Picture" data-id="{{$employee->id}}"><i class="fa fa-camera"></i></button>
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
	                <h4 class="title" id="largeModalLabel">Add New Employee</h4>
	            </div>
	            <form action="" method="POST" role="form" id="role-add-form">
	            	{{csrf_field()}}
		            <div class="modal-body"> 

	            		<div class="row">
	            			<div class="form-group col-md-6">
		            			<label for="" class="reuired">First Name</label>
		            			<input type="text" class="form-control" name="first_name" placeholder="First Name"
		            			 ng-model="first_name"
		            			 >
		            		</div>
		            		<div class="form-group col-md-6">
		            			<label for="">Last Name</label>
		            			<input type="text" class="form-control" name="last_name" placeholder="Last Name"
		            			 ng-model="last_name">
		            		</div>
	            		</div>

	            		<div class="row">
		            		<div class="form-group col-md-4">
		            			<label for="">Employee No</label>
		            			<input type="text" class="form-control" name="employee_no" placeholder="Employee No"
		            			 ng-model="employee_no">
		            		</div>
	            			<div class="form-group col-md-4">
		            			<label for="">Phone</label>
		            			<input type="text" class="form-control" name="phone" placeholder="Phone"
		            			ng-model="phone">
		            		</div>
		            		<div class="form-group col-md-4">
		            			<label for="">Email</label>
		            			<input type="text" class="form-control" name="email" placeholder="Email" ng-model="email">
		            		</div>
		            		
	            		</div>

	            		<div class="row">
	            			<div class="form-group col-md-4">
		            			<label for="">Designation</label>
		            			<select name="designation" id="designation" class="form-control show-tick ms select2">
		            				<option value="0" >- Select designation -</option>
		            				@foreach($designations as $designation)
		            					<option value="{{$designation->id}}">{{$designation->name}}</option>
		            				@endforeach
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

		            		<div class="form-group col-md-4">
		            			<p>Make this employee as HOD</p>
		            			<label class="fancy-checkbox " >
                                    <input class="checkbox" type="checkbox" name="is_hod" ng-model="is_hod" value="1"
                                    ng-model="is_hod" ng-disabled="!is_user" ng-checked="is_user && 0">
                                    <span>Head Of Department</span>
                                </label>
		            		</div>
		            		<div class="form-group col-md-2">
		            			<label class="fancy-radio" style="margin-top: 15px">
		            				<input name="gender" value="male" type="radio" ng-model="gender" ><span><i></i>Male</span>
		            			</label>
		            			<label class="fancy-radio">
		            				<input name="gender" value="female" type="radio" ng-model="gender" ><span><i></i>Female</span>
		            			</label>
		            		</div>
		            		<div class="form-group col-md-2">
		            			<label class="fancy-radio" style="margin-top: 15px">
		            				<input name="type" value="employee" type="radio" ng-model="type" ><span><i></i>Employee</span>
		            			</label>
		            			<label class="fancy-radio">
		            				<input name="type" value="client" type="radio" ng-model="type" ><span><i></i>Client</span>
		            			</label>
		            		</div>
	            		</div>

	            		<div class="row">
	            			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	            				<div class="form-group 	">
			            			<label class="fancy-checkbox " ng-init="is_user=0">
	                                    <input class="checkbox" type="checkbox" name="is_user" ng-model="is_user" value="1">
	                                    <span>Create User Account (User Account needed to make as HOD)</span>
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
	                <h4 class="title" id="largeModalLabel">Edit Employee</h4>
	            </div>
	            <form action="" method="POST" role="form" id="role-edit-form">
	            	{{csrf_field()}}
		            <div class="modal-body"> 

		            	<input type="hidden" class="form-control" name="employee_id" ng-model="edit.id"
		            	value="@{{edit.id}}">

		            	<input type="hidden" class="form-control" name="user_id" ng-model="edit.user_id"
		            	value="@{{edit.user_id}}">

		            	<div class="row">
	            			<div class="form-group col-md-6">
		            			<label for="" class="reuired">First Name</label>
		            			<input type="text" class="form-control" name="first_name" placeholder="First Name"
		            			 ng-model="edit.first_name"
		            			>
		            		</div>
		            		<div class="form-group col-md-6">
		            			<label for="">Last Name</label>
		            			<input type="text" class="form-control" name="last_name" placeholder="Last Name"
		            			 ng-model="edit.last_name">
		            		</div>
	            		</div>

	            		<div class="row">
	            			<div class="form-group col-md-4">
		            			<label for="">Employee No</label>
		            			<input type="text" class="form-control" name="employee_no" placeholder="Employee No"
		            			 ng-model="edit.employee_no">
		            		</div>
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
		            	</div>
		            	<div class="row">
		            		<div class="form-group col-md-4">
		            			<label for="">Designation</label>
		            			<select name="edit_designation" id="edit_designation" class="form-control show-tick ms select2">
		            				<option value="0" >- Select designation -</option>
		            				<option ng-value="designation.id" ng-repeat="designation in designations"
		            				ng-selected="designation.id==edit.designation_id">@{{designation.name}}</option>
		            			</select>
		            		</div>
		            		<div class="form-group col-md-4">
		            			<label for="">Department</label>
		            			<select name="department" id="inputDepartment" class="form-control show-tick ms select2">
		            				<option value="0" >- Select Department -</option>
		            				<option ng-value="department.id" ng-repeat="department in departments"
		            				ng-selected="department.id==edit.department_id">@{{department.name}}</option>
		            			</select>
		            		</div>
		            		<div class="form-group col-md-4">
		            			<label for="">Supervisor</label>
		            			<select name="supervisor" id="inputDepartment" class="form-control show-tick ms select2">
		            				<option value="0">- No Supervisor -</option>
		            				<option value="@{{supervisor.id}}" ng-repeat="supervisor in supervisors"
		            				ng-selected="supervisor.id==edit.parent_id">@{{supervisor.first_name}} @{{supervisor.last_name}}</option>
		            			</select>
		            		</div>
	            		</div>

	            		<div class="row">
	            			
		            		<div class="form-group col-md-4" ng-show="edit.can_edit_user==0">
		            			<p>Make this employee as HOD</p>
		            			<label class="fancy-checkbox ">
                                    <input class="checkbox" type="checkbox" name="is_hod" ng-model="edit.is_hod" value="1"ng-disabled="!edit.is_user" ng-checked="edit.is_user && 0">
                                    <span>Head Of Department</span>
                                </label>
		            		</div>

		            		<div class="form-group col-md-4" ng-show="edit.can_edit_user==1">
		            			<p>Update this employee as HOD</p>
		            			<label class="fancy-checkbox ">
                                    <input class="checkbox" type="checkbox" name="is_hod" ng-model="edit.is_hod" value="1"ng-checked="edit.is_hod==1">
                                    <span>Head Of Department</span>
                                </label>
		            		</div>
		            		
		            		<div class="form-group col-md-2">
		            			<label class="fancy-radio" style="margin-top: 15px">
		            				<input name="gender" value="male" type="radio" ng-model="edit.gender" ><span><i></i>Male</span>
		            			</label>
		            			<label class="fancy-radio">
		            				<input name="gender" value="female" type="radio" ng-model="edit.gender" ><span><i></i>Female</span>
		            			</label>
		            		</div>
		            		<div class="form-group col-md-2">
		            			<label class="fancy-radio" style="margin-top: 15px">
		            				<input name="type" value="employee" type="radio" ng-model="edit.type"><span><i></i>Employee</span>
		            			</label>
		            			<label class="fancy-radio">
		            				<input name="type" value="client" type="radio" ng-model="edit.type" ><span><i></i>Client</span>
		            			</label>
		            		</div>
	            		</div>

	            		<div class="row">
	            			<div class="form-group col-md-12" ng-show="edit.can_edit_user==0">
		            			<label class="fancy-checkbox " >
                                    <input class="checkbox" type="checkbox" name="is_user" ng-model="edit.is_user" value="1">
                                    <span>Create User Account (User Account needed to make as HOD)</span>
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

	<div class="modal fade" id="largeModalChangeProfilePic" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="title" id="largeModalLabel">Edit Profile Basic Details</h4>
                </div>
                
                <div class="modal-body">
                	<form role="form" class="form-validation" method="post" id="update-profile-pic-form" name="update-profile-pic-form" enctype="multipart/form-data">
                    {{csrf_field()}}
                    	<input type="hidden" name="profile_employee_id" id="profile_employee_id">
                        <div class="row">
                            <div class="form-group col-12 col-sm-12 col-md-12 col-lg-12 text-center">
                                <div class="avatar">
                                    <img ng-show="edit.image!=NULL" style="object-fit: cover;" src="{{url('storage')}}/@{{edit.image}}" class="rounded-circle avatar profile-pic" alt="">
                                    <img ng-show="edit.image==NULL" src="{{asset('assets/admin_panel/images/user-avatar.png')}}" class="rounded-circle avatar profile-pic" alt="">
                                    
                                    <input id="fileToUpload" type="file" name="profile_pic" accept="image/jpeg, image/png" class="file-upload none"> 
                                    <button type="button" class="fab"  id="btn-edit-basic" 
                                            onclick="document.getElementById('fileToUpload').click()">
                                        <i class="fas fa-upload"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="row text-center">
                            <div class="form-group col-md-12">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-upload"></i> Update</button>
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

<script src="{{asset('assets/admin_panel/dist/bootsrap-fileinput/js/fileinput.min.js')}}"></script>
<script src="{{asset('/assets/dist/angular/angular/angular.min.js')}}"></script>
<script src="{{asset('/assets/dist/ng-multiselect/dualmultiselect.js')}}"></script>
<script src="{{asset('/assets/admin_panel/dist/select2/select2.min.js')}}"></script>
<script src="{{asset('/assets/js/dialog.js')}}"></script>

<script type="text/javascript">

	$(document).ready(function()
	{
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

        $("#profile_pic").fileinput({
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
	});

	//initialize angular app
	var app = angular.module("ngApp",['dualmultiselect']);

	//controller
	app.controller("EmployeeController", function($scope,$http)
	{

		$scope.edit = {};
		$scope.departments = [];
		$scope.supervisors = [];
		$scope.designations = [];

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
	 		$('#reset_username').val(emp_detail.user.username);
	 		$('#largeModalPasswordReset').modal('show');
	 	});

		$('#btn-add').on('click',function()
		{
	 		$('#largeModalAdd').modal('show');

	        $scope.addRoles.items = [];
	        $scope.addRoles.selectedItems = [];


	        $.ajax({
		        url: '{{url('admin/employee/getroles')}}',
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
		        url: '{{url('admin/employee/send-account-details')}}',
		        type: 'get',
		        data: {id:id},
		        success: function(reponse)
		        {
		            $('.dialog-loader').hide();

		            swal({
		            	title: "Send!",
		            	text: "Mail sent successfuly to employee.",
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
		        url: '{{url('admin/employee/getDepartments')}}',
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
		        url: '{{url('admin/employee/getSupervisors')}}',
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

	 		$.ajax({
		        url: '{{url('admin/employee/getemployee')}}',
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
	            url: "{{url('admin/employee/create')}}",
	            type: 'POST',
	            dataType : 'json',
	            data: formData,
	            success: function (data) {
	            	$('.dialog-loader').hide();

	            	swal({
	            		title: "Success!",
	            		text: "New Employee addedd successfuly.",
	            	});
	            	location.reload();
	            },
	            error:function(data) {
	            	$('.dialog-loader').hide();
	            	swal({
	            		title: "Error!",
	            		text: "Error adding new employee.",
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
	            url: "{{url('admin/employee/update')}}",
	            type: 'POST',
	            dataType : 'json',
	            data: formData,
	            success: function (data){
	            	$('.dialog-loader').hide();
	            	swal({
	            		title: "Success!",
	            		text: "Employee updated successfuly.",
	            	});
	            	location.reload();
	            },
	            error:function(data) {
	            	$('.dialog-loader').hide();
	            	swal({
	            		title: "Error!",
	            		text: "Error occured while updating employee.",
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
				        url: '{{url('admin/employee/delete')}}',
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
										        url: '{{url('admin/employee/deleteWithRelations')}}',
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
	            url: "{{url('admin/employee/resetPassword')}}",
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

	    $('.btn-profile').on('click',function()
	 	{
			var id = $(this).data('id');
			$('#profile_employee_id').val(id);

			$scope.edit_profile = {};
			
			$.ajax({
		        url: '{{url('admin/employee/getemployee')}}',
		        type: 'get',
		        data:{'id':id},
		        success: function(reponse){
		            $scope.edit  = reponse.employee;
		            $scope.$apply();
		            
		            $('.dialog-loader').hide();
		        },
		        error: function(Response){               
		        }
		    });

		    $('#largeModalChangeProfilePic').modal('show');
		});

		$("form#update-profile-pic-form").submit(function(e)
	    {
	        e.preventDefault();

	        var formData = new FormData(this);
	        $('.dialog-loader').show();
	        
	        $.ajax({
	            url: "{{url('admin/employee/updateProfilePicture')}}",
	            type: 'POST',
	            data: formData,
	            success: function (data) {
	             	$('.dialog-loader').hide();
	             	if(data.status==1){
		             	swal({
		             		title: "Success!",
		             		text: "Profile picture updated.",
		             	});
		             	location.reload();
		            }else{
		            	swal({
		             		title: "Faild!",
		             		text: "Profile picture update faild. Try Again.",
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
