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
    </head>

    <body>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3><p class="text-center">Best Lead Generation system</p></h3>
            </div>
            <div class="panel-body">
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
                    <button class="btn btn-info pull-right">Reset</button>
                    <!-- Graph Will Come Here -->
                    <div class="attenders_vote"></div>
                    
                    <h5>Share URL to Attenders</h5>
                    <div class="form-group">
                        <textarea class="form-control" rows="5"></textarea>
                    </div>
                    <h5>Webinar Invite URL:</h5>
                    <p>http://domain.com/webinar</p>
                </div>
                <div class="col-md-8">
                    <h3><p class="text-center">All Questions</p></h3>
                    <ul class="list-group">
                        <li class="list-group-item">Que: How are you?</li>
                        <li class="list-group-item list-group-item-info">Ans: I am fine and you?</li>
                        <li class="list-group-item">Que: Me too good?</li>
                        <li class="list-group-item list-group-item-info">Ans: Nice to hear that :)</li>
                    </ul>

                    <h3><p class="text-center">Webinar Stats</p></h3>
                    <label>Attenders(Email Stats)</label>
                    <ul class="list-group">
                        <li class="list-group-item"><span class="badge">3000</span> Total Active in Lists</li>
                        <li class="list-group-item"><span class="badge">500</span> Openers</li>
                        <li class="list-group-item"><span class="badge">300</span> Clickers</li>
                    </ul>
                    <label>Questions</label>
                    <ul class="list-group">
                        <li class="list-group-item"><span class="badge">30</span> Total </li>
                        <li class="list-group-item"><span class="badge">15</span> Unanswered</li>
                        <li class="list-group-item"><span class="badge">3</span> Public</li>
                    </ul>
                    <label>Panelists</label>
                    <ul class="list-group">
                        <li class="list-group-item"><span class="badge">0</span> Rizvaan</li>
                        <li class="list-group-item"><span class="badge">15</span> Hannah</li>
                        <li class="list-group-item"><span class="badge">3</span> MR</li>
                    </ul>
                </div>

            </div>
            <div class="panel-footer">
                <p class="text-center">Copyright</p>
            </div>
        </div>
    </body>
</html>