<div class="sidebar-menu toggle-others fixed">

    <div class="sidebar-menu-inner">

        <header class="logo-env">

            <!-- logo -->
            <div class="logo">
                <a href="#" class="logo-expanded">
                    <img src="{{asset('assets/members/images/generic-logo-sample.png')}}" width="200" alt="" />
                </a>

                <a href="#" class="logo-collapsed">
                    <img src="{{asset('assets/members/images/generic-logo-sample.png')}}" width="100" alt="" />
                </a>
            </div>

            <!-- This will toggle the mobile menu and will be visible only on mobile devices -->
            <div class="mobile-menu-toggle visible-xs">
                <a href="#" data-toggle="user-info-menu">
                    <i class="fa-bell-o"></i>
                    <span class="badge badge-success">7</span>
                </a>

                <a href="#" data-toggle="mobile-menu">
                    <i class="fa-bars"></i>
                </a>
            </div>

        </header>

        <ul id="main-menu" class="main-menu">
            <!-- add class "multiple-expanded" to allow multiple submenus to open -->
            <!-- class "auto-inherit-active-class" will automatically add "active" class for parent elements who are marked already with class "active" -->

            <li class="active">
                <a href="{!! url('/members/dashboard') !!}">
                    <i class="fa fa-cogs "></i>
                    <span class="title">Dashboard</span>
                </a>
            <li>
                <a href="{{route('users.subscribers-lists.index',$user->id)}}">
                    <i class="fa fa-envelope"></i>
                    <span class="title">Subscribers</span>
                </a>
            </li>
            <li>
                <a href="{{route('users.webinars.index',$user->id)}}">
                    <i class="fa fa-star "></i>
                    <span class="title">Webinars</span>
                </a>
                @if(isset($menu_upcoming_webinars) && $user->webinars->count())
                    <ul>
                        @foreach($menu_upcoming_webinars as $webinar)
                        <li>
                            <a href="{{route('users.webinars.edit',	[$user->id,$webinar->uuid])}}"
                               title="{{$webinar->title}}">
                                <span class="title">
                                    {{(strlen($webinar->title)<13)?$webinar->title:substr($webinar->title,0,12).'...'}}
                                </span>
                                <span class="badge badge-roundless badge-info pull-right">
                                    {{gmdate("j \d H:i", $webinar->timeLeft())}}
                                </span>

                            </a>
                        </li>
                        @endforeach
                        <li>
                            <a href="{{route('users.webinars.index',$user->id)}}">
                                <span class="title">All Webinars</span>
                            </a>
                        </li>
                    </ul>
                @endif
            </li>
            <li>
                <a href="{{route('users.panelists.index',$user->id)}}">
                    <i class="fa fa-star "></i>
                    <span class="title">Panelists</span>
                </a>
            </li>

            <li>
                <a href="{{URL::to('members/settings')}}">
                    <i class="fa fa-wrench "></i>
                    <span class="title">Settings</span>
                </a>
                <ul>
                    <li>
                        <a href="{{URL::to('members/settings')}}">
                            <i class="fa fa-cog "></i>
                            <span class="title">General</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('users.notification-templates.index',$user->id)}}">
                            <i class="fa fa-info-circle "></i>
                            <span class="title">Notifications</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('users.smtp.index',$user->id)}}">
                            <i class="fa fa-star "></i>
                            <span class="title">SMTP Server</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</div>
