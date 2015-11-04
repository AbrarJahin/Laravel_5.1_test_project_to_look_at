<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>HTML5 MediaElement</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <script src="mediaelement/jquery.js"></script>
        <script src="mediaelement/mediaelement-and-player.min.js"></script>
        <link rel="stylesheet" href="mediaelement/mediaelementplayer.min.css" />
    </head>
    <body>

        <h2>RTMP stream</h2>
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <video controls style="max-width:100%;height:100%;">
                        <source
                            src="test"
                            type="video/rtmp" />
                    </video>
                </div>
            </div>
        </div>
        <script>
            var url = 'rtmp://streaming.webinarhero.net/live';
            $('video').mediaelementplayer(
                {
                    flashStreamer: url,
                    enableAutosize: true,
                    // the order of controls you want on the control bar (and other plugins below)
                    features: ['playpause', 'progress', 'current', 'duration', 'tracks', 'volume', 'fullscreen'],
                    // Hide controls when playing and mouse is not over the video
                    alwaysShowControls: false
                }
            );
        </script>
    </body>
</html>