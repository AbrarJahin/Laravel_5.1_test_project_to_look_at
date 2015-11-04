
@extends('layouts.webinar.master')

@section('contents')
<div class="content slide">
    <!--	Add "slideRight" class to items that move right when viewing Nav Drawer  -->
    <ul class="responsive">

        <div class="top-header"> <h1>{{$webinar->title}}</h1> </div>
<!-- 
        <li class="header-section">

            <div class="sub">

                <ul class="sub-container">
                    <li class="sub-info">
                        <ul class="device">
                            @if($webinar->streaming_server_id != 'custom' && !empty($streamingServer))
                            <div class="embed-responsive embed-responsive-16by9">
                                <video class="embed-responsive-item" autoplay="true" controls="controls" preload="none">
                                    <source src="{{ $webinar->uuid }}" type="video/rtmp" />
                                </video>
                            </div>
                            <script>
                            var url = '<?php echo $streamingServer->streaming_url?>';
                            $('video').mediaelementplayer({
                                flashStreamer: url,
                                enableAutosize: true,
                                // the order of controls you want on the control bar (and other plugins below)
                                features: ['playpause', 'progress', 'current', 'duration', 'tracks', 'volume', 'fullscreen'],
                                // Hide controls when playing and mouse is not over the video
                                alwaysShowControls: false    
                            });
                            </script>
                            <li><button class="btn btn-medium">USA Server</button> <button class="btn btn-medium">EU Server</button> <button class="btn btn-medium">Asia Server</button></li>
                            @endif
                        </ul>
                    </li>

                </ul>
            </div>
        </li>
 -->
        <li class="body-section">

            <div class="sub">

                <ul class="sub-container">
                    <li class="sub-info">
                        <ul class="device">

                            <section class="module" id="private_questions">
                                @include('layouts.webinar.panelist_qa')
                            </section>


                        </ul>
                    </li>

                </ul>



                <ul class="sub-container">
                    <li class="sub-info">
                            <header class="top-bar">
                                <div class="left">
                                    <h1>Public</h1>
                                </div>
                            </header>
                        <section class="module2">
                            <ul class="discussion" id="public_questions">
                                @foreach($publicQA as $qa)
                                <li class="question" id="{{$qa->id}}_question">
                                    <div class="avatar">
                                        <img src="{{ asset('assets/members/images/avatar-1.jpg') }}" />
                                    </div>
                                    <div class="messages">
                                        <p>{{$qa->question}}</p>
                                        <time datetime="{{$qa->question_datetime}}">@ {{$qa->question_name}} • {{$qa->question_ask_before}} s before</time>
                                    </div>
                                </li>
                                <li class="self" id="{{$qa->id}}_answer">
                                    <div class="avatar">
                                        <img src="{{ asset('assets/members/images/avatar-2.jpg') }}" />
                                    </div>
                                    <div class="messages">
                                        <p>{{ $qa->answer }}</p>
                                        <time datetime="2009-11-13T20:14">@MR 37 • mins</time>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                            <meta name="after_start_berore_question_id"             content='<li class="question" id="'>
                            <meta name="after_question_id_berore_question"          content='_question"><div class="avatar"><img src="{{ asset('assets/members/images/avatar-1.jpg') }}"></div><div class="messages"><p>'>
                            <meta name="after_question_before_questioneer_name"     content='</p><time datetime="2015-10-12 10:00:23"> @ '>
                            <meta name="after_questioneer_name_before_ask_before"   content=' • '>
                            <meta name="after_ask_before_before_answer_id"          content=' before</time></div></li><li class="self" id="'>
                            <meta name="after_answer_id_before_answer"              content='_answer"><div class="avatar"><img src="{{ asset('assets/members/images/avatar-2.jpg') }}"></div><div class="messages"><p>'>
                            <meta name="after_answer_before_panelist_name"          content=' </p><time datetime="2009-11-13T20:14"> @ '>
                            <meta name="after_panelist_name_before_answer_time"     content=' • '>
                            <meta name="after_panelist_name_before_end"             content=' before</time></div></li>'>
                        </section>
                    </li>
                </ul>
            </div>
        </li>
        <li class="footer-section">
            <p class="placefiller">FOOTER</p>
        </li>
    </ul>
</div>

<meta name="base_url" content="{{URL::to('/')}}">
<meta name="webniar_ID" content="{{$webinar['uuid']}}">
<meta name="webniar_ID_int" content="{{$webinar['id']}}">
<meta name="webinar_id" content="{{$webinar->id}}">
<meta name="qustion_before" content='<li class="other"><div class="avatar"><img src="{{ asset("assets/members/images/avatar-1.jpg") }}" /></div><div class="messages"><p>'>
<meta name="qustion_after_datetime_before" content='</p><time datetime="'>
<meta name="datetime_after_name_bfore" content='">@'>
<meta name="name_after_time_before" content=' • '>
<meta name="time_after" content='</time></div></li>'>
<meta name="csrf_token" content="{{ csrf_token() }}">
<script src="{{ asset('assets/members/js/custom/webniar.js') }}"></script>
<script src="{{ asset('assets/members/js/custom/panelist_qa.js') }}"></script>

@endsection