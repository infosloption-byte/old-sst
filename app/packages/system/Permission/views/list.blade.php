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
	                <i class="fa fa-arrow-left"></i></a> Permission Management</h2>
	            
	        </div>            
	        <div class="col-lg-6 col-md-4 col-sm-12">
	            <ul class="breadcrumb float-right">
	                <li class="breadcrumb-item"><a href="index.html"><i class="icon-home"></i></a></li>                           
	                <li class="breadcrumb-item">Permission Management</li>
	                <li class="breadcrumb-item active">Permission List</li>
	            </ul>
	        </div>
	    </div>
	</div>

	<div class="row clearfix">

	    <div class="col-lg-12 col-md-12">
	        <div class="card planned_task">
	            <div class="header">
	                <h2>Permission List</h2>
	                <ul class="header-dropdown">

	                	<!-- CHECK PERM -->
	                	<li><a class="tab_btn table-btn" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="" data-original-title="Create New Role" id="btn-add"><i class="fas fa-plus "></i></a></li>
						
	                </ul>
	            </div>
	            <div class="body">
	                <div class="table-responsive">
		                <table class="table table-hover m-b-0 c_list">
		                    <thead>
		                        <tr>
		                            <th>Name</th>                                    
		                            <th>Display Name</th>                                    
		                            <th>Created By</th>
		                            <th>Created at</th>
		                            <th>Action</th>
		                        </tr>
		                    </thead>
		                        <tbody>
		                        @foreach($perms as $perm)
		                        <tr>
		                            <td>
		                                <span class="social_icon linkedin">{{(strtoupper(substr($perm->name,0,1)))}}</span>
		                                <p class="c_name">{{$perm->name}}</p>
		                            </td>
		                            <td>
		                                <p class="c_name">{{$perm->display_name}}</p>
		                            </td>                                   
		                            <td>
		                               {{$perm->createdby->name}}
		                            </td>
		                            <td>
		                                {{$perm->created_at->format('Y-m-d')}} <br><small>{{$perm->created_at->format('H:i')}} </small>
		                            </td>
		                            <td>                                            
		                                <button type="button" class="btn btn-info btn-edit" title="Edit"
		                                data-id="{{$perm->id}}"><i class="fa fa-edit"></i></button>
		                                <button type="button" data-type="confirm" class="btn btn-danger js-sweetalert btn-delete" title="Delete"
		                                data-id="{{$perm->id}}"><i class="fa fa-trash"></i></button>
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
	                <h4 class="title" id="largeModalLabel">Add New Permission</h4>
	            </div>
	            <form action="" method="POST" role="form" id="role-form-add">
	            	{{ csrf_field() }}
		            <div class="modal-body"> 
	            		<div class="row">
	            			<div class="form-group col-md-4">
		            			<label for="">Name</label>
		            			<input type="text" class="form-control" name="name" placeholder="Perm Name">
		            		</div>
		            		<div class="form-group col-md-8">
		            			<label for="">Display Name</label>
		            			<input type="text" class="form-control" name="displayName" placeholder="Display Name">
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
	                <h4 class="title" id="largeModalLabel">Edit Permission</h4>
	            </div>
	            <form action="" method="POST" role="form" id="role-form-edit">
	            	{{ csrf_field() }}
		            <div class="modal-body"> 
		            	<input type="hidden" name="id" id="inputRole_id" class="form-control" value="@{{edit.id}}">
	            		<div class="row">
	            			<div class="form-group col-md-4">
		            			<label for="">Name</label>
		            			<input type="text" class="form-control" name="name" placeholder="Perm Name"
		            			ng-model="edit.name">
		            		</div>
		            		<div class="form-group col-md-8">
		            			<label for="">Display Name</label>
		            			<input type="text" class="form-control" name="displayName" placeholder="Display Name"
		            			ng-model="edit.display_name">
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


//controller
app.controller("RoleController", function($scope,$http){

	$scope.edit = {};

	$('#btn-add').on('click',function() {
 		$('#largeModalAdd').modal('show');
 	});

 	$("form#role-form-add").submit(function(e) {
        e.preventDefault();    
        var formData = new FormData(this);  
        $('.dialog-loader').show();
        $.ajax({
            url: "{{url('/admin/permisson/create')}}",
            type: 'POST',
            dataType : 'json',
            data: formData,
            success: function (data) {
              $('.dialog-loader').hide();
              swal({
		        title: "Success!",
		        text: "New Perm addedd successfuly.",
		      });
		      location.reload();

            },
            error:function(data) {
              $('.dialog-loader').hide();
              swal({
		        title: "Error!",
		        text: "Error adding new Perm.",
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
	        url: '{{url('admin/permisson/getPerm')}}',
	        type: 'get',
	        data:{'id':id},
	        success: function(reponse){
	            $scope.edit  = reponse.perm;
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
        $('.dialog-loader').show();
        $.ajax({
            url: "{{url('/admin/permisson/update')}}",
            type: 'POST',
            dataType : 'json',
            data: formData,
            success: function (data) {
              $('.dialog-loader').hide();
              swal({
		        title: "Success!",
		        text: "updated successfuly.",
		      });
		      location.reload();

            },
            error:function(data) {
              $('.dialog-loader').hide();
              swal({
		        title: "Error!",
		        text: "Error while updating.",
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
		        url: '{{url('admin/permisson/delete')}}',
		        type: 'POST',
		        data:{'id':id},
		        success: function(response){
		            if(response.status==1){
						swal("Deleted","Record deleted", "success");
						location.reload();
		            }else{
		            	swal({
					        title: "Error!",
					        text: "Error while deleting.",
					    });
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
