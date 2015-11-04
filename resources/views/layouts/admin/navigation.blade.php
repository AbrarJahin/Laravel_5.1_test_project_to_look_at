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
                <a href="{!! url('/users') !!}">
                    <i class="linecons-user "></i>
                    <span class="title">Users</span>
                </a>
                <ul>
                    <li>
                        {{--<a href="#">--}}
                            {{--<i class="entypo-flow-line"></i>--}}
                            {{--<span class="title">Menu Level 1.1</span>--}}
                        {{--</a>--}}
                        {{--<ul>--}}
                            {{--<li>--}}
                                {{--<a href="#">--}}
                                    {{--<i class="entypo-flow-parallel"></i>--}}
                                    {{--<span class="title">Menu Level 2.1</span>--}}
                                {{--</a>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                                {{--<a href="#">--}}
                                    {{--<i class="entypo-flow-parallel"></i>--}}
                                    {{--<span class="title">Menu Level 2.2</span>--}}
                                {{--</a>--}}
                                {{--<ul>--}}
                                    {{--<li>--}}
                                        {{--<a href="#">--}}
                                            {{--<i class="entypo-flow-cascade"></i>--}}
                                            {{--<span class="title">Menu Level 3.1</span>--}}
                                        {{--</a>--}}
                                    {{--</li>--}}
                                    {{--<li>--}}
                                        {{--<a href="#">--}}
                                            {{--<i class="entypo-flow-cascade"></i>--}}
                                            {{--<span class="title">Menu Level 3.2</span>--}}
                                        {{--</a>--}}
                                        {{--<ul>--}}
                                            {{--<li>--}}
                                                {{--<a href="#">--}}
                                                    {{--<i class="entypo-flow-branch"></i>--}}
                                                    {{--<span class="title">Menu Level 4.1</span>--}}
                                                {{--</a>--}}
                                            {{--</li>--}}
                                        {{--</ul>--}}
                                    {{--</li>--}}
                                {{--</ul>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                                {{--<a href="#">--}}
                                    {{--<i class="entypo-flow-parallel"></i>--}}
                                    {{--<span class="title">Menu Level 2.3</span>--}}
                                {{--</a>--}}
                            {{--</li>--}}
                        {{--</ul>--}}
                    {{--</li>--}}
                    <li>
                        <a href="{!! url('/users') !!}">
                            <i class="entypo-flow-line"></i>
                            <span class="title">List</span>
                        </a>
                    </li>
                    <li>
                        <a href="{!! url('/users/create') !!}">
                            <i class="entypo-flow-line"></i>
                            <span class="title">Create User</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#">
                    <i class="fa fa-video-camera "></i>
                    <span class="title">Streaming Settings</span>
                </a>
                <ul>
                    <li>
                        <a href="#">
                            <span class="title">Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('streaming-servers')}}">
                            <span class="title">Servers</span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <span class="title">Stats</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#settings">
                    <i class="fa-wrench"></i>
                    Settings
                </a>
            </li>

        </ul>

    </div>

</div>

{{--<ul class="nav nav-tabs pull-right">--}}
  {{--<li role="presentation" class="active"><a href="{!! url('/users') !!}">Users</a></li>--}}
  {{--<li role="presentation" class="active"><a href="{!! url('/users/create') !!}">Create User</a></li>--}}
{{--</ul>--}}