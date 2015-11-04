
@extends('layouts.webinar.master')

@section('contents')
<div class="content slide">
    <!--	Add "slideRight" class to items that move right when viewing Nav Drawer  -->
    <ul class="responsive">

        <div class="top-header"> <h1>{{$webinar->title}}</h1> </div>

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

                    <?php if($subscriber!=NULL){ ?>

                    <li class="sub-info">
                        <ul>
                            @if(!$is_panelist)
                                    <li>
                                        <div class="col-md-3">
                                            <input type="text" id="subscriber_first_name" name="name"
                                                   value="{{$subscriber->first_name}}"
                                                   class="form-control" style="width: 60px"
                                                    placeholder="First Name"
                                            >
                                            <input type="text" id="subscriber_last_name" name="name"
                                                   value="{{$subscriber->last_name}}"
                                                   placeholder="Last Name"
                                                   class="form-control" style="width: 60px">
                                            <input id="subscriber_name_submit" class="btn btn-info"
                                                   type="button" name="submit" value="save">
                                        </div>

                                    </li>
                            <li><label>Vote</label></li>
                            <li>
                                <button id="button_yes" class="btn btn-medium">
                                    <img src="{{ asset('assets/members/images/up.png') }}">
                                </button>
                                <button id="button_no" class="btn btn-medium">
                                    <img src="{{ asset('assets/members/images/down.png') }}">
                                </button>
                            </li>
                            @endif
                            @if($is_panelist)
                            <li><label>Welcome {{Auth::user()->name}}</label></li>
                            @endif
                            <li>Shared Url:</li>
                            <li><textarea readonly rows="10" cols="30" id="sharedUrl">{{$webinar->share}}</textarea></li>
                        </ul>
                    </li>

                    <?php } ?>

                </ul>
            </div>
        </li>
        <li class="body-section">

            <div class="sub">

                <ul class="sub-container">
                    <li class="sub-info">
                        <ul class="device">

                            <section class="module" id="private_questions">
                                @if(!$is_panelist)
                                @include('layouts.webinar.subscriber_qa')
                                @else
                                @include('layouts.webinar.panelist_qa')
                                @endif
                            </section>


                        </ul>
                    </li>

                </ul>



                <ul class="sub-container">
                    <li class="sub-info">
                        <ul class="device">
                            <section class="module2" id="public_questions">
                                <header class="top-bar">
                                    <div class="left">
                                        <h1>Public</h1>
                                    </div>
                                </header>

                                <ul class="discussion">
                                    @foreach($publicQA as $qa)
                                    <li class="other">
                                        <div class="avatar">
                                            <img src="{{ asset('assets/members/images/avatar-1.jpg') }}" />
                                        </div>
                                        <div class="messages">
                                            <p>{{$qa->question}}</p>
                                            <time datetime='{{$qa->question_datetime}}'>@ {{$qa->first_name}} {{ $qa->last_name }} • {{$qa->question_ask_before}} s before</time>
                                        </div>
                                    </li>
                                    <li class="self">
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

                                <!-- <ol class="discussion">
                                    <div class="media">
                                        @foreach($webinar->public_qas as $key => $qa)
                                        @if($key != 0)
                                        <div class="media">
                                            @endif
                                            <div class="media-left">
                                                <a href="#">
                                                    <img class="media-object" data-src="holder.js/64x64" alt="64x64" style="width: 40px; height: 40px;" src="{{ asset('assets/members/images/avatar-1.jpg') }}" data-holder-rendered="true">
                                                </a>
                                            </div>
                                            <div class="media-body">
                                                <h4 class="media-heading">User @sandesh</h4>
                                                <p>{{$qa->question}}</p>
                                            </div>
                                            @if($key != 0)
                                        </div>
                                        @endif
                                        @endforeach
                                    </div>
                                </ol> -->

                               

                                {{--<input id="asked_question_add_in_public" class="quest-control" type="text" class="faq" name="questions" placeholder="Ask your Questions here ???">--}}
                                {{--<!-- <input class="send-btn" type="submit" name="submit" value="send"> -->--}}
                                {{--<button class="send-btn" id="question_add_in_public">Send</button>--}}
                            </section>
                        </ul>
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
<?php if($subscriber!=NULL){ ?>
<meta name="subscriber_id" content="{{$subscriber->id}}">
<?php } ?>
<meta name="qustion_before" content='<li class="other"><div class="avatar"><img src="{{ asset("assets/members/images/avatar-1.jpg") }}" /></div><div class="messages"><p>'>
<meta name="qustion_after_datetime_before" content='</p><time datetime="'>
<meta name="datetime_after_name_bfore" content='">@'>
<meta name="name_after_time_before" content=' • '>
<meta name="time_after" content='</time></div></li>'>
<meta name="csrf_token" content="{{ csrf_token() }}">
<script src="{{ asset('assets/members/js/custom/webniar.js') }}"></script>
<script src="{{ asset('assets/members/js/custom/tracking.js') }}"></script>

@endsection