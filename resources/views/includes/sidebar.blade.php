<!-- SIDEBAR --> 
<div id="left-sidebar" class="sidebar">
    <div class="sidebar-scroll">
        <div class="user-account">
            <a href="{{url('admin/profile/index')}}">
            @if(!Auth::user()->image)
                <img src="{{url('assets/admin_panel/images/user-avatar.png')}}" class="rounded-circle user-photo" alt="User Profile Picture">
            @else
                <img src="{{url('storage')}}/{{Auth::user()->image}}" class="rounded-circle user-photo" alt="{{Auth::user()->full_name}}">
            @endif
            </a>
            <div class="dropdown" style="margin-top: 2px">
                <a href="{{url('admin/profile/index')}}" class="user-name">
                    @if(Auth::user())
                        <strong>Hello! {{Auth::user()->full_name}}</strong>
                    @else
                        -
                    @endif
                </a>
            </div>
            <hr>
        </div>

        <ul class="nav nav-tabs" style="margin: 0px 20px 0px 20px;">
            @if(\Entrust::ability('admin','dashboard,inquiry.accept,inquiry.reject,inquiry.payment,inquiry.send.mail,profile,induction,job,task,repair,client,report'))
            <li class="nav-item">
                <a class="nav-link @show('admin.dashboard.*') @show('profile.*') @show('admin.inquiry.*') @show('induction.*') @show('job.*') @show('repair.*') @show('task.*') @show('task.*') @show('inspection.*') @show('client.*') @show('report.*')" data-toggle="tab" href="#hr_menu">Main</a>
            </li>
            @endif
        </ul>

        <div class="tab-content p-l-0 p-r-0" style="margin: 0px 20px 0px 20px;">
            <div class="tab-pane animated fadeIn @show('admin.dashboard.*') @show('profile.manage.*') @show('induction.*') @show('admin.inquiry.*') @show('admin.job.*') @show('admin.repair.*') @show('admin.task.*') @show('admin.section.*') @show('admin.client.*') @show('admin.inspection.*') @show('admin.report.*')" id="hr_menu">
                <nav class="sidebar-nav">
                    <ul class="main-menu metismenu">

                        @if(\Entrust::can('dashboard'))
                        <li class="@active('admin.dashboard.*')"><a href="{{url('/admin')}}"><i class="fa fa-chart-bar"></i><span>Dashboard</span></a></li>
                        @endif

                        @if(\Entrust::can('inquiry.list','inquiry.accept','inquiry.reject','inquiry.payment','inquiry.send.mail'))
                        <li class="@active('admin.inquiry.list')">
                            <a href="#Clients" class="has-arrow"><i class="fa fa-sticky-note"></i><span>Appointments</span></a>
                            <ul>
                                <li><a href="{{url('admin/inquiries')}}">List</a></li>
                            </ul>
                        </li>
                        <li class="@active('admin.inquiry.list')">
                            <a href="#Clients" class="has-arrow"><i class="fa fa-sticky-note"></i><span>Ratings</span></a>
                            <ul>
                                <li><a href="{{url('admin/inquiries')}}">List</a></li>
                            </ul>
                        </li>
                        @endif
                    </ul>
                </nav>
            </div>      
        </div>          
    </div>
</div>
<!-- SIDEBAR