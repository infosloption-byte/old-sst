@extends('master.master')

@section('css')
<style type="text/css">
	
</style>
@stop


@section('content')

<div class="block-header">
    <div class="row">
        <div class="col-lg-6 col-md-8 col-sm-12">
            <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth">
                <i class="fa fa-arrow-left"></i></a> Dashboard</h2>
            
        </div>            
        <div class="col-lg-6 col-md-4 col-sm-12">
            <div class="row">
                <ul class="breadcrumb pull-right">
                    <li class="breadcrumb-item"><a href="index.html"><i class="icon-home"></i></a></li>                            
                    <li class="breadcrumb-item active">Dashboard</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="row clearfix">

    <div class="col-lg-12 col-md-12">
        <div class="card planned_task">
            <div class="header">
                <h2>Stater Page</h2>
                <ul class="header-dropdown">
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"></a>
                        <ul class="dropdown-menu dropdown-menu-right animated bounceIn">
                            <li><a href="javascript:void(0);">Action</a></li>
                            <li><a href="javascript:void(0);">Another Action</a></li>
                            <li><a href="javascript:void(0);">Something else</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="body">
                <h4>Stater Page</h4>
            </div>
        </div>
    </div>

</div>
            

@stop
