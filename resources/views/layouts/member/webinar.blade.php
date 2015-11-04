
<!DOCTYPE html>
<html>
    <head>
        <title>GTW Hero</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <!-- MediaElement Plugin For RTMP Streaming  -->
        <script src="{{ asset('mediaelement/jquery.js') }}"></script>
        <script src="{{ asset('mediaelement/mediaelement-and-player.min.js') }}"></script>
        <link rel="stylesheet" href="{{ asset('mediaelement/mediaelementplayer.min.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/members/css/custom.css') }}" />
    </head>

    <body>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3><p class="text-center">Best Lead Generation system</p></h3>
            </div>
            <div class="panel-body container">

                <div class="row">

                    <div class="col-md-4">
                        @if($webinar->streaming_server_id != 'custom' && !empty($streamingServer))
                        <video width="320" height="240" class="embed-responsive-item" autoplay="true" controls="controls" preload="none">
                            <source src="{{ $webinar->uuid }}" type="video/rtmp" />
                        </video>
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
                        @endif
                        <br/>
                        <h5>Streaming Details:</h5>
                        <span class="label label-default">Audio BitRate : 20kbps</span>
                        <span class="label label-default">Video BitRate : 20kbps</span>
                        <h4><p class="text-center">Attenders Vote</p></h4>
                            <div class="attenders_vote">
                                <div id="piechart_voting" style="width: 100%; height: 100%;">
                                    <!-- Chart goes here -->
                                </div>
                            </div>
                            <button id="reset_current_question_data" class="btn btn-info pull-right">Reset</button>
                            <button id="refresh_current_question_data" class="btn btn-info pull-left">Refresh</button>

                            <div class="row col-md-12">
                                <h5>Share URL to Attenders</h5>
                                <div class="form-group">
                                    <textarea id="shareContainer" class="form-control" rows="5">{{$webinar->share}}</textarea>
                                </div>
                                <button id="updateShare" class="btn btn-info pull-right">Update</button>

                                <div class="row col-md-12">
                                    <h5>Webinar Invite URL:</h5>
                                    <p>{{route('site.webinar.lp', [$webinar->uuid])}}</p>
                                </div>
                            </div>
                    </div>

                    <div class="col-md-4">
                        <h3><p class="text-center">All Questions</p></h3>
                        <ul class="list-group pre-scrollable" id="qa-container">

                        </ul>
                    </div>

                    <div class="col-md-4">
                        <h3><p class="text-center">Webinar Stats</p></h3>
                        <div id="stats-table">
                            <label>Attenders(Email Stats)</label>
                            <ul class="list-group" id="attenders-stats">
                            </ul>
                            <label>Questions</label>
                            <ul class="list-group" id="questions-stats">
                            </ul>
                            <label>Panelists</label>
                            <ul class="list-group" id="panelists-stats">
                            </ul>
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div id="line_chart" style="width: 100%; height: 100%; margin: 0 auto">
                            <!-- Line Chart Goes Here -->
                        </div>
                        <div class="form-group" style="width:10%;min-width:300px;margin: 0 auto;">
                            <label class="sr-only" for="exampleInputAmount">Amount (in dollars)</label>
                            <div class="input-group">
                                <div class="input-group-addon">Show</div>
                                <input value="10"  min="5" max="100" type="number" class="form-control" id="no_of_points_to_show" placeholder="No of Points to Show">
                                <div class="input-group-addon">points in the Curve</div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="panel-footer">
                <p class="text-center">Copyright</p>
            </div>
        </div>

    </body>

    <script src="{{ asset('assets/members/js/host-page.js') }}"></script>
    <meta name="base_url" content="{{URL::to('/')}}">
    <meta name="webinar_id" content="{{$webinar['uuid']}}">
    <meta name="webinar_id_int" content="{{$webinar['id']}}">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script src="http://code.highcharts.com/highcharts.js"></script>
    <script src="{{asset('assets/members/js/custom/chart.js')}}"></script>
</html>