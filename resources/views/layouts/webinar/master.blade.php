<!DOCTYPE html> 
<html lang="en">
    <head> 

        <title>GTW Hero</title> 

        <meta charset="utf-8">
        <meta name="viewport" content="initial-scale=1.0,user-scalable=no,maximum-scale=1" media="(device-height: 568px)">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="HandheldFriendly" content="True">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">

        <!-- Style Sheets --> 
        <link rel="stylesheet" type="text/css" media="all" href="{{ asset('assets/members/css/reset.css') }}" />
        <link rel="stylesheet" type="text/css" media="all" href="{{ asset('assets/members/css/trunk.css') }}" />
        <link rel="stylesheet" type="text/css" media="all" href="{{ asset('assets/members/css/font.css') }}" />
        <link rel="stylesheet" type="text/css" media="all" href="{{ asset('assets/members/css/blank.css') }}" />

        <link rel="stylesheet" type="text/css" media="all" href="{{ asset('assets/members/css/custom.css') }}" />

        <!-- Scripts --> 
        <script type="text/javascript">
        
        var baseUrl = '<?php echo url().'/';?>';
        
        if (typeof jQuery == 'undefined')
                document.write(unescape("%3Cscript src='{{ asset('assets/members/js/jquery-1.9.js') }}'" +
                        "type='text/javascript'%3E%3C/script%3E"))
        </script>
        <script type="text/javascript" language="javascript" src="{{ asset('assets/members/js/trunk.js') }}"></script>
        <!-- MediaElement Plugin For RTMP Streaming  -->
        <script src="{{ asset('mediaelement/jquery.js') }}"></script>
        <script src="{{ asset('mediaelement/mediaelement-and-player.min.js') }}"></script>
        <link rel="stylesheet" href="{{ asset('mediaelement/mediaelementplayer.min.css') }}" />
        <!--[if lt IE 9]>
        <script src="{{ asset('assets/members/js/html5shiv.js') }}"></script>
        <![endif]-->
        

    </head>
    <body>
        <div class="container">
            <header class="slide">     <!--	Add "slideRight" class to items that move right when viewing Nav Drawer  -->
                <ul id="navToggle" class="burger slide">    <!--	Add "slideRight" class to items that move right when viewing Nav Drawer  -->
                    <li></li><li></li><li></li>
                </ul>
                <h1>GTW Hero Webinar</h1>
            </header>

            <nav class="slide">
                <ul>
                    <li><a href="../trunk.html" class="active">HOME</a></li>
                    <li><a href="#">LINK TWO</a></li>
                    <li><a href="#">LINK THREE</a></li>
                    <li><a href="#">LINK FOUR</a></li>
                </ul>
            </nav>
            
            @yield('contents')
            
        </div>
        <!-- Javascript -->
        @yield('scripts')
    </body>
</html>