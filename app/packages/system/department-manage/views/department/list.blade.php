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
	     box-shadow: none; 
	    border: 1px solid #dedede;
	    padding: 3px;
	}
</style>
@stop


@section('content')

<div ng-app="ngApp" ng-controller="DepartmentController"> 
	
	<div class="block-header">
	    <div class="row">
	        <div class="col-lg-6 col-md-8 col-sm-12">
	            <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth">
	                <i class="fa fa-arrow-left"></i></a> Department Management</h2>
	            
	        </div>            
	        <div class="col-lg-6 col-md-4 col-sm-12">
	            <div class="row float-right mr-0">
	                <ul class="breadcrumb pull-right">
	                    <li class="breadcrumb-item"><a href="index.html"><i class="icon-home"></i></a></li>                           
	                    <li class="breadcrumb-item">Department Management</li>
	                    <li class="breadcrumb-item active">Department List</li>
	                </ul>
	            </div>
	        </div>
	    </div>
	</div>

	<div class="row clearfix">

	    <div class="col-lg-12 col-md-12">
	        <div class="card planned_task">
	            <div class="header">
	                <h2>Department List</h2>
	                <ul class="header-dropdown">

	                	<!-- CHECK PERM -->
	                	<li><a class="tab_btn table-btn" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="" data-original-title="Create New Department" id="btn-add"><i class="fas fa-plus "></i></a></li>
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
		                            <th width="6%">
		                                <label class="fancy-checkbox">
		                                    <input class="select-all" type="checkbox" name="checkbox">
		                                    <span></span>
		                                </label>
		                            </th>
		                            <th>Department Name</th> 
		                            <th>Under</th>  
		                            <th>Description</th>
		                            <th>Created By</th>
		                            <th>Created at</th>
		                            <th>Action</th>
		                        </tr>
		                    </thead>
		                        <tbody>
		                        @foreach($departments as $department)	
		                        <tr>
                                    <td>
                                    <label class="fancy-checkbox">
                                            <input class="checkbox-tick" type="checkbox" name="checkbox">
                                            <span></span>
                                        </label>
                                    </td>
                                    <td>
                                        <h6 class="mb-0"><a href="">{{$department->name}}</a></h6>
                                        <span>#{{$department->code}}</span>
                                    </td>
                                    <td>
                                    	@if(count($department->ancestors)>0)
	                                    	@foreach($department->ancestors as $ancestor)
	                                    		<span class="badge badge-success">{{$ancestor->name}}</span>
	                                    	@endforeach
                                    	@else
                                    		<span class="badge badge-success">MAIN DEPARTMENT</span>
                                    	@endif
                                    </td>
                                    <td>
                                    	{{$department->description}}
                                    </td>
                                	<td>{{$department->createdby->name}}</td>
                                    <td>{{$department->created_at->format('Y-m-d')}}</td>
                                    <td>
                                        <button type="button" class="btn btn-info btn-edit" title="Edit"
                                        data-id="{{$department->id}}"><i class="fa fa-edit"></i></button>
		                                <button type="button" data-type="confirm" 
		                                class="btn btn-danger js-sweetalert btn-delete" 
		                                 data-id="{{$department->id}}"
		                                title="Delete"><i class="fa fa-trash"></i></button>
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
	                <h4 class="title" id="largeModalLabel">Add New Department</h4>
	            </div>
	            <form action="" method="POST" role="form" id="role-form-add">
	            	{{csrf_field()}}
		            <div class="modal-body"> 

	            		<div class="row">
	            			<div class="form-group col-md-6">
		            			<label for="" class="required">Department Name</label>
		            			<input type="text" class="form-control" name="name" placeholder="Department Name">
		            		</div>
		            		<div class="form-group col-md-6">
		            			<label for="" class="required">Main Department</label>
		            			<select name="main_department" id="inputDepartment" class="form-control show-tick ms select2">
		            				<option value="0">- Main -</option>
		            				<option ng-value="department.id"
											ng-repeat="department in departments">@{{department.name}}</option>
		            			</select>
		            		</div>
	            		</div>

	            		<div class="row">
		            		<div class="form-group col-md-12">
		            			<label for="">Description</label>
		            			<input type="text" class="form-control" name="desc" placeholder="Description">
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
	                <h4 class="title" id="largeModalLabel">Update Department</h4>
	            </div>
	            <form action="" method="POST" role="form" id="role-form-edit">
	            	{{csrf_field()}}
		            <div class="modal-body"> 

		            	<input type="hidden" name="department_id" id="inputDepartment_id" class="form-control" value="@{{edit.id}}">

	            		<div class="row">
	            			<div class="form-group col-md-6">
		            			<label for="" class="required">Department Name</label>
		            			<input type="text" class="form-control" name="name" placeholder="Department Name"
		            			ng-model="edit.name">
		            		</div>
		            		<div class="form-group col-md-6">
		            			<label for="" class="required">Main Department</label>
		            			<select name="main_department" id="inputDepartment" class="form-control show-tick ms select2">
		            				<option value="0">- Main -</option>
									<option ng-value="department.id"
											ng-repeat="department in departments"
											ng-selected="department.id==edit.parent_id">@{{department.name}}</option>
		            			</select>
		            		</div>
	            		</div>

	            		<div class="row">
		            		<div class="form-group col-md-12">
		            			<label for="">Description</label>
		            			<input type="text" class="form-control" name="desc" placeholder="Description"
		            			ng-model="edit.description">
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
<script src="{{asset('/assets/admin_panel/dist/select2/select2.min.js')}}"></script>
<script src="{{asset('/assets/js/dialog.js')}}"></script>
<script type="text/javascript">

 $(document).ready(function(){

 		$(".select2").select2();
 });

 //initialize angular app
var app = angular.module("ngApp",[]);

//controller
app.controller("DepartmentController", function($scope,$http){

	$scope.edit = {};
	$scope.departments = [];

	$('#btn-add').on('click',function() {
 		$('#largeModalAdd').modal('show');
 		$.ajax({
	        url: '{{url('admin/department/getDepartments')}}',
	        type: 'get',
	        success: function(reponse){
	            $scope.departments  = reponse;
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
        $('.dialog-loader').show();


        $.ajax({
            url: "{{url('admin/department/create')}}",
            type: 'POST',
            dataType : 'json',
            data: formData,
            success: function (data) {
              $('.dialog-loader').hide();
              swal({
		        title: "Success!",
		        text: "New Department addedd successfuly.",
		      });
		      location.reload();

            },
            error:function(data) {
              $('.dialog-loader').hide();
              swal({
		        title: "Error!",
		        text: "Error adding new department.",
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
 		$('.dialog-loader').show();
 		$.ajax({
	        url: '{{url('admin/department/getDepartments')}}',
	        type: 'get',
	        success: function(reponse){
	            $scope.departments  = reponse;
	            $scope.$apply();

			    $.ajax({
			        url: '{{url('admin/department/getDepartment')}}',
			        type: 'get',
			        data:{'id':id},
			        success: function(reponse){
			            $scope.edit  = reponse;
			            $scope.$apply();
			            $('.select2').trigger('change');
			  			$('.dialog-loader').hide();
			        },
			        error: function(Response){               
			        }
			    });
	        },
	        error: function(Response){               
	        }
	    });

 	});

 	$('.btn-delete').on('click',function() {
 		 var id = $(this).data('id');

 		showConfirmMessage('Delete','Would you like to delete this?','yes delete','error',function(isConfirm) {
 			if(isConfirm){
				$.ajax({
			        url: '{{url('admin/department/delete')}}',
			        type: 'POST',
			        data:{'department_id':id,'releated':false},
			        success: function(response){
			            if(response.success){
							swal("Deleted","All records deleted ", "success");
							location.reload();
			            }else{
			            	if(response.error.code=="5000"){
			            		swal("Releated Data", response.error.message, "error");
				            }
			            }
			        },
			        error: function(reponse){
					    
					}
			    });
 			}
 		});
 	});


 	$("form#role-form-edit").submit(function(e) {
        e.preventDefault();    
        var formData = new FormData(this);
        $('.dialog-loader').show();
        $.ajax({
            url: "{{url('admin/department/update')}}",
            type: 'POST',
            dataType : 'json',
            data: formData,
            success: function (data) {
              $('.dialog-loader').hide();
              swal({
		        title: "Success!",
		        text: "New Department update successfuly.",
		      });
		      location.reload();

            },
            error:function(data) {
              $('.dialog-loader').hide();
              swal({
		        title: "Error!",
		        text: "Error updating department.",
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
