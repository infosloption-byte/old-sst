@extends('master.master')

@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/dist/ng-multiselect/dualmultiselect.css')}}">
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
</style>
@stop


@section('content')

<div ng-app="ngApp" ng-controller="RoleController"> 
	
	<div class="block-header">
	    <div class="row">
	        <div class="col-lg-6 col-md-8 col-sm-12">
	            <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth">
	                <i class="fa fa-arrow-left"></i></a> Role Management</h2>
	            
	        </div>            
	        <div class="col-lg-6 col-md-4 col-sm-12">
	            <div class="row">
	                <ul class="breadcrumb pull-right">
	                    <li class="breadcrumb-item"><a href="index.html"><i class="icon-home"></i></a></li>                           
	                    <li class="breadcrumb-item">Role Management</li>
	                    <li class="breadcrumb-item active">Role List</li>
	                </ul>
	            </div>
	        </div>
	    </div>
	</div>

	<div class="row clearfix">

	    <div class="col-lg-12 col-md-12">
	        <div class="card planned_task">
	            <div class="header">
	                <h2>Role List</h2>
	                <ul class="header-dropdown">

	                	<!-- CHECK PERM -->
	                	<li><a class="tab_btn table-btn" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="" data-original-title="Create New Role" id="btn-add"><i class="fas fa-plus "></i></a></li>
						<!-- CHECK PERM -->

	                    <li class="dropdown">
	                        <a href="javascript:void(0);" class="tab_btn table-btn dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" style="color:white"></a>
	                        <ul class="dropdown-menu dropdown-menu-right animated bounceIn">
	                            <li><a href="javascript:void(0);">Action</a></li>
	                            <li><a href="javascript:void(0);">Another Action</a></li>
	                            <li><a href="javascript:void(0);">Something else</a></li>
	                        </ul>
	                    </li>
	                    <li><a class="tab_btn table-btn" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="" data-original-title="Filter Roles"><i class="fas fa-filter "></i></a></li>
	                </ul>
	            </div>
	            <div class="body">
	                <div class="table-responsive">
		                <table class="table table-hover m-b-0 c_list">
		                    <thead>
		                        <tr>
		                            <th>
		                                <label class="fancy-checkbox">
		                                    <input class="select-all" type="checkbox" name="checkbox">
		                                    <span></span>
		                                </label>
		                            </th>
		                            <th>Name</th>                                    
		                            <th>Display Name</th>                                    
		                            <th>Created By</th>
		                            <th>Created at</th>
		                            <th>Action</th>
		                        </tr>
		                    </thead>
		                        <tbody>
		                        @foreach($roles as $role)
		                        <tr>
		                            <td style="width: 50px;">
		                                <label class="fancy-checkbox">
		                                    <input class="checkbox-tick" type="checkbox" name="checkbox">
		                                    <span></span>
		                                </label>
		                            </td>
		                            <td>
		                                <span class="social_icon linkedin">{{(strtoupper(substr($role->name,0,1)))}}</span>
		                                <p class="c_name">{{$role->name}}</p>
		                            </td>
		                            <td>
		                                <p class="c_name">{{$role->display_name}}</p>
		                            </td>                                   
		                            <td>
		                               {{$role->createdby->name}}
		                            </td>
		                            <td>
		                                {{$role->created_at->format('Y-m-d')}} <br><small>{{$role->created_at->format('H:i')}} </small>
		                            </td>
		                            <td>                                            
		                                <button type="button" class="btn btn-info btn-edit" title="Edit"
		                                data-id="{{$role->id}}"><i class="fa fa-edit"></i></button>
		                                <button type="button" data-type="confirm" class="btn btn-danger js-sweetalert btn-delete" title="Delete"
		                                data-id="{{$role->id}}"><i class="fa fa-trash"></i></button>
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
	                <h4 class="title" id="largeModalLabel">Add New Role</h4>
	            </div>
	            <form action="" method="POST" role="form" id="role-form-add">
	            	{{ csrf_field() }}
		            <div class="modal-body"> 
	            		<div class="row">
	            			<div class="form-group col-md-4">
		            			<label for="">Role Name</label>
		            			<input type="text" class="form-control" name="roleName" placeholder="Role Name">
		            		</div>
		            		<div class="form-group col-md-8">
		            			<label for="">Display Name</label>
		            			<input type="text" class="form-control" name="displayName" placeholder="Display Name">
		            		</div>
	            		</div>
	            		<div class="row">
	            			<div class="form-group col-md-12">
		            			<dualmultiselect options="addOptions"> </dualmultiselect>	
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
	                <h4 class="title" id="largeModalLabel">Edit Role</h4>
	            </div>
	            <form action="" method="POST" role="form" id="role-form-edit">
	            	{{ csrf_field() }}
		            <div class="modal-body"> 
		            	<input type="hidden" name="role_id" id="inputRole_id" class="form-control" value="@{{edit.id}}">
	            		<div class="row">
	            			<div class="form-group col-md-4">
		            			<label for="">Role Name</label>
		            			<input type="text" class="form-control" name="roleName" placeholder="Role Name"
		            			ng-model="edit.name">
		            		</div>
		            		<div class="form-group col-md-8">
		            			<label for="">Display Name</label>
		            			<input type="text" class="form-control" name="displayName" placeholder="Display Name"
		            			ng-model="edit.display_name">
		            		</div>
	            		</div>
	            		<div class="row">
	            			<div class="form-group col-md-12">
		            			<dualmultiselect options="editOptions"> </dualmultiselect>	
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


</div>

@stop


@section('js')

<script src="{{asset('/assets/dist/angular/angular/angular.min.js')}}"></script>
<script src="{{asset('/assets/dist/ng-multiselect/dualmultiselect.js')}}"></script>
<script src="{{asset('/assets/js/dialog.js')}}"></script>
<script type="text/javascript">

 $(document).ready(function(){

 	




 });

 //initialize angular app
var app = angular.module("ngApp",['dualmultiselect']);

	app.filter('cut', function () {
    return function (value, wordwise, max, tail) {
        if (!value) return '';

        max = parseInt(max, 10);
        if (!max) return value;
        if (value.length <= max) return value;

        value = value.substr(0, max);
        if (wordwise) {
            var lastspace = value.lastIndexOf(' ');
            if (lastspace !== -1) {
              //Also remove . and , so its gives a cleaner result.
              if (value.charAt(lastspace-1) === '.' || value.charAt(lastspace-1) === ',') {
                lastspace = lastspace - 1;
              }
              value = value.substr(0, lastspace);
            }
        }

        return value + (tail || ' …');
    };
});

//controller
app.controller("RoleController", function($scope,$http){

	$scope.edit = {};

	$scope.addOptions = {
		labelAll: 'All Items',
		labelSelected: 'Selected Items',
		helpMessage: 'Select permmsion to assign , search permmsion from below',
		/* angular will use this to filter your lists */
		orderProperty: 'name',
		/* this contains the initial list of all items (i.e. the left side) */
		items: [],
		/* this list should be initialized as empty or with any pre-selected items */
		selectedItems: [] 
	};	
	
	$scope.editOptions = {
		labelAll: 'All Items',
		labelSelected: 'Selected Items',
		helpMessage: 'Select permmsion to assign , search permmsion from below',
		/* angular will use this to filter your lists */
		orderProperty: 'name',
		/* this contains the initial list of all items (i.e. the left side) */
		items: [],
		/* this list should be initialized as empty or with any pre-selected items */
		selectedItems: [] 
	};	


	$('#btn-add').on('click',function() {
 		$('#largeModalAdd').modal('show');
		$scope.addOptions.items = [];
		$scope.addOptions.selectedItems = [];
 		$('.dialog-loader').show();
	    $.ajax({
	        url: '{{url('admin/user/role/getpermissions')}}',
	        type: 'get',
	        success: function(reponse){
	            $scope.addOptions.items  = reponse;
	            $scope.$apply();


	  			$('.dialog-loader').hide();
	        },
	        error: function(Response){               
	        }
	    });	
 	});

 	$("form#role-form-add").submit(function(e) {
        e.preventDefault();    
        var formData = new FormData(this); 
        formData.append('permission',angular.toJson($scope.addOptions.selectedItems));  
        $('.dialog-loader').show();
        $.ajax({
            url: "{{url('admin/user/role/create')}}",
            type: 'POST',
            dataType : 'json',
            data: formData,
            success: function (data) {
              $('.dialog-loader').hide();
              swal({
		        title: "Success!",
		        text: "New Role addedd successfuly.",
		      });
		      location.reload();

            },
            error:function(data) {
              $('.dialog-loader').hide();
              swal({
		        title: "Error!",
		        text: "Error adding new role.",
		      });
            },
            cache: false,
            contentType: false,
            processData: false
        });
        return false;
    });



 	$('.btn-edit').on('click',function() {
 		$('#largeModalEdit').modal('show');
 		var id = $(this).data('id');
		$scope.editOptions.items = [];
		$scope.editOptions.selectedItems = [];
 		$('.dialog-loader').show();
	    $.ajax({
	        url: '{{url('admin/user/role/getRole')}}',
	        type: 'get',
	        data:{'id':id},
	        success: function(reponse){
	            $scope.edit  = reponse.role;
	            $scope.editOptions.items  = reponse.permissions;
	            $scope.editOptions.selectedItems  = reponse.role.permissions;

	            $scope.$apply();

	  			$('.dialog-loader').hide();
	        },
	        error: function(Response){               
	        }
	    });	
 	});


    $("form#role-form-edit").submit(function(e) {
        e.preventDefault();    
        var formData = new FormData(this); 
        formData.append('permission',angular.toJson($scope.editOptions.selectedItems));  
        $('.dialog-loader').show();
        $.ajax({
            url: "{{url('/admin/user/role/update')}}",
            type: 'POST',
            dataType : 'json',
            data: formData,
            success: function (data) {
              $('.dialog-loader').hide();
              swal({
		        title: "Success!",
		        text: "Role updated successfuly.",
		      });
		      location.reload();

            },
            error:function(data) {
              $('.dialog-loader').hide();
              swal({
		        title: "Error!",
		        text: "Error while updating role.",
		      });
            },
            cache: false,
            contentType: false,
            processData: false
        });
        return false;
    });

	$('.btn-delete').on('click',function() {
 		var id = $(this).data('id');

 		showConfirmMessage('Delete','Would you like to delete this?','yes delete','error',function() {
 			$.ajax({
		        url: '{{url('admin/user/role/delete')}}',
		        type: 'POST',
		        data:{'id':id},
		        success: function(response){
		            if(response.success){
						swal("Deleted","Record deleted", "success");
						location.reload();
		            }else{
		            	if(response.error.code=="5000"){
		            		showCancelMessage("Releated Data", response.error.message, "error",function(isConfirm) {
		            			if (isConfirm) {
						            $.ajax({
								        url: '{{url('admin/user/role/deleteWithRelations')}}',
								        type: 'POST',
								        data:{'id':id,'releated':false},
								        success: function(response){
								            if(response.success){
												showWithTitleMessage("Deleted", "Record has been deleted with relations");
												location.reload();
								            }else{
								            	showWithTitleMessage("Cancelled", "If you need to delete this record you have to unlink all related data");
								            }
								        },
								        error: function(reponse){
										    
										}
								    });
						        } else {
						            showWithTitleMessage("Cancelled", "If you need to delete this record you have to unlink all related data");
						        }
		            		});
			            }
		            }
		        },
		        error: function(reponse){
				    
				}
		    });
 		});
			
 	});
   
  	
});//end controller




</script>
@stop
