@extends('master.master')

@section('css')

<link rel="stylesheet" href="{{asset('assets/admin_panel/dist/c3/c3.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/admin_panel/dist/bootsrap-fileinput/css/fileinput.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/admin_panel/dist/bootsrap-fileinput/themes/explorer-fa/theme.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/admin_panel/dist/select2/select2.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/admin_panel/dist/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')}}">
<style type="text/css">
	.file-drop-zone-title {
	    color: #aaa;
	    font-size: 1.6em;
	    padding: 50px 10px;
	    cursor: default;
	}

	.krajee-default .file-other-icon {
	    font-size: 2em;
	}
	.krajee-default.file-preview-frame .kv-file-content {
	    width: 150px;
	    height: 50px;
	}

	.krajee-default.file-preview-frame {
	    margin: 8px;
	    border: 1px solid rgba(0,0,0,.2);
	    box-shadow: none; 
	    padding: 6px;
	    float: left;
	    text-align: center;
	}

	.file-preview {
	    border-radius: 5px;
	    border: 0 !important;
	    padding:0; 
	    width: 100%;
	    margin-bottom: 5px;
	}

	.file-preview .fileinput-remove {
	    top: 8px;
	    right: 8px;
	    line-height: 10px;
	}

	.file-drop-zone {
	    border: 3px dashed #aaa;
	    border-radius: 4px;
	    height: 100%;
	    text-align: center;
	    vertical-align: middle;
	    margin: 0; 
	    padding: 0; 
	}

	.select2-container{
		height: 36px;
	}
</style>
@stop

@section('content')
<div ng-app="ngApp" ng-controller="JobManageController">

	<div class="block-header">
        <div class="row">
            <div class="col-lg-8 col-md-6 col-sm-12 col-12">
                <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth">
                    <i class="fa fa-arrow-left"></i></a> Job Management</h2>
            </div>            
            <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                <div class="row">
                    <div class="col-md-12">
                        <ul class="breadcrumb float-right">
                            <li style="display: inline;" class="breadcrumb-item"><a href="index.html"><i class="icon-home"></i></a></li>                           
                            <li style="display: inline;" class="breadcrumb-item">Job Management</li>
                            <li style="display: inline;" class="breadcrumb-item active">Create Job</li>
                        </ul>                       
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row clearfix">
		<div class="col-lg-12 col-md-12">
	        <div class="card">
	        	<div class="header">
	                <h2>Create Job</h2>
	                <ul class="header-dropdown">

	                	<li><a class="tab_btn table-btn" href="{{url('admin/job/index')}}" data-toggle="tooltip" data-placement="top" title="" data-original-title="Job List"><i class="fas fa-bars "></i></a></li>
	                </ul>
	            </div>

	            <div class="body">
                    <form action="" method="POST" role="form" id="job-create-form">
                        {{csrf_field()}}
                        <div class="row" style="padding: 10px">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label>Job Category</label>
                                            <select name="job_category" id="job_category" class="select2-container form-control show-tick ms select2">
                                                <option value="">- Select Job Category -</option>
                                                <option ng-repeat="category in job_categories" value="@{{category.id}}">@{{category.name}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label>Job Type</label>
                                            <select name="job_type" id="job_type" class="select2-container form-control show-tick ms select2">
                                                <option value="1">- One Time Job -</option>
                                                <option value="2">- Regular Job -</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="form-group">
                                            <label>Client</label>
                                            <select name="client" id="client" class="select2-container form-control show-tick ms select2">
                                                <option value="">- Select Client -</option>
                                                <option ng-repeat="client in clients" value="@{{client.id}}">@{{client.first_name}} @{{client.last_name}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="form-group">
                                            <label>Title</label>
                                            <input class="form-control" id="job_title" name="job_title" placeholder="Enter job title...">
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label>Start Date</label>
                                            <input class="form-control" id="start_date" name="start_date" placeholder="Select Date...">
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label>End Date</label>
                                            <input class="form-control" id="end_date" name="end_date" placeholder="Select Date...">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="form-group">
                                            <label>Job Note</label>
                                            <textarea style="height: 220px" class="form-control" name="job_note" id="job_note" placeholder="Enter note..."></textarea>
                                        </div>
                                    </div>       
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-xs-8 col-sm-8 col-md-10 col-lg-10">
                                        <div class="form-group">
                                            <label>Location Address</label>
                                            <input type="text" class="form-control" name="address" id="address" placeholder="Enter apt no.. street name"/>
                                        </div>
                                    </div>
                                    <div class="col-xs-4 col-sm-4 col-md-2 col-lg-2">
                                        <div class="form-group">
                                            <button style="margin-top: 40%" type="button" id="submit-btn" class="btn btn-primary float-right">Geocode</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">

                                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                        <div class="form-group">
                                            <label>City</label>
                                            <input type="text" class="form-control" name="city" id="city" placeholder="Enter city...">
                                        </div>
                                    </div>
                                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                        <div class="form-group">
                                            <label>State</label>
                                            <input type="text" class="form-control" name="state" id="state" placeholder="Enter state...">
                                        </div>
                                    </div>
                                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                        <div class="form-group">
                                            <label>Postal Code</label>
                                            <input type="text" class="form-control" name="postalcode" id="postalcode" placeholder="Enter postalcode...">
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="form-group">
                                            <label>Pick Location</label>
                                            <div style="height: 200px;" id="map"></div>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label>Longitude</label>
                                            <input type="text" class="form-control" name="lng" id="lng" placeholder="Enter longitiude...">
                                        </div>
                                    </div>

                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label>Latitude</label>
                                            <input type="text" class="form-control" name="lat" id="lat" placeholder="Enter latitude...">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <button type="submit" class="btn btn-primary float-right">Save</button>
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
<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
<script type="text/javascript" src="{{asset('assets/admin_panel/dist/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA0V9bbuS5WWoszmd6pPbKADQSaPGQqHpM&callback=initMap&libraries=&v=weekly" async></script>
<script type="text/javascript">

    $(document).ready(function()
    {
        $(".select2").select2();

        $('#start_date').datepicker({
            format: 'yyyy-mm-dd',
            todayHighlight: true
        });

        $('#end_date').datepicker({
            format: 'yyyy-mm-dd',
            todayHighlight: true
        });

    });

    function initMap() {

        const myLatlng = { lat: -25.363, lng: 131.044 };
        const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 4,
            center: myLatlng,
        });

        // 2. Initialize the GeoCoder API
        const geocoder = new google.maps.Geocoder();

        // 3. So when the user clicks on the submit BTN, geocode the given address if possible
        document.getElementById("submit-btn").addEventListener("click", () => {
            geocodeAddress(geocoder, map);
        });
    }

    // Handle conversion of text address to coordinates
    function geocodeAddress(geocoder, resultsMap) {
        const address = document.getElementById("address").value;

        // Search for the address with the API
        geocoder.geocode({ address: address }, (results, status) => {
            if (status === "OK") {
                // Display response in the console
                console.log(results);
                $('#lat').val(results[0].geometry.location.lat());
                $('#lng').val(results[0].geometry.location.lng());

                $('#city').val(results[0].address_components[1].long_name);
                $('#state').val(results[0].address_components[2].long_name);
                $('#postalcode').val(results[0].address_components[4].long_name);

                // Set the location of the map obtained by the API
                resultsMap.setCenter(results[0].geometry.location);

                // Add the marker with the obtained location
                new google.maps.Marker({
                    map: resultsMap,
                    position: results[0].geometry.location,
                });
            } else {
                alert("Geocode error: " + status);
            }
        });
    }

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
    app.controller("JobManageController", function($scope,$http)
    {
    	$scope.job_categories  = [];
    	$scope.clients  = [];

        $.ajax({
            url: "{{url('admin/job/categoryList')}}",
            type: 'GET',
            success: function (data) {
                $scope.job_categories = data;
                $scope.$apply();
            },
            error:function(data) {
              $('.dialog-loader').hide();
            }
        });

        $.ajax({
            url: "{{url('admin/job/clientList')}}",
            type: 'GET',
            success: function (data) {
                $scope.clients = data;
                $scope.$apply();
            },
            error:function(data) {
              $('.dialog-loader').hide();
            }
        });

        $("form#job-create-form").submit(function(e)
        {
            e.preventDefault();    
            var formData = new FormData(this);
            $('.dialog-loader').show();

            $.ajax({
                url: "{{url('admin/job/create')}}",
                type: 'POST',
                data: formData,
                success: function (data)
                {
                    if(data.status_code == 200)
                    {
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
