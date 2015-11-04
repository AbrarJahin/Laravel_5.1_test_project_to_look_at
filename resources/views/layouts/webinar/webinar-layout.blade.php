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
<link rel="stylesheet" type="text/css" media="all" href="assets/members/css/reset.css" />
<link rel="stylesheet" type="text/css" media="all" href="assets/members/css/trunk.css" />
<link rel="stylesheet" type="text/css" media="all" href="assets/members/css/font.css" />
<link rel="stylesheet" type="text/css" media="all" href="assets/members/css/blank.css" />


<!-- Scripts --> 
<script type="text/javascript">
	if (typeof jQuery == 'undefined')
		document.write(unescape("%3Cscript src='assets/members/js/jquery-1.9.js'" + 
															"type='text/javascript'%3E%3C/script%3E"))
</script>
<script type="text/javascript" language="javascript" src="assets/members/js/trunk.js"></script>
<script src="{{ asset('flowplayer/js/flowplayer-3.2.13.min.js') }}"></script>
<!--[if lt IE 9]>
<script src="assets/members/js/html5shiv.js"></script>
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
	
	<div class="content slide">
   <!--	Add "slideRight" class to items that move right when viewing Nav Drawer  -->
		<ul class="responsive">

			<div class="top-header"> <h1>Best Lead Generation System</h1> </div>

			<li class="header-section">

				<div class="sub">
				
				<ul class="sub-container">
						<li class="sub-info">
							<ul class="device">
                                                            <!--<iframe src="https://www.youtube.com/embed/XGSy3_Czz8k" frameborder="0" allowfullscreen></iframe>-->
                                                            <div id="player"></div>
                                                            <script>
                                                            flowplayer("player", "{{ asset('flowplayer/swf/flowplayer-3.2.18.swf') }}", {
                                                                clip: {
                                                                    url: 'BigBuckBunny_115k.mov',
                                                                    live: true,
                                                                    provider: 'rtmp',
                                                                    autoPlay: true,
                                                                    bufferLength: 0
                                                                },
                                                                plugins: {
                                                                    rtmp: {
                                                                        url: "{{ asset('flowplayer/swf/flowplayer.rtmp-3.2.13.swf') }}",
                                                                        netConnectionUrl: 'rtmp://184.72.239.149/vod'
                                                                    }
                                                                    
                                                                }
                                                            });
                                                            </script>
							</ul>
						</li>
						<li class="sub-info">
						<ul>
						<li><input type="text" name="name" class="form-control"> <input class="btn btn-info" type="submit" name="submit" value="save"></li>
						<li><label>Vote</label></li>
						<li><button class="btn btn-medium"><img src="assets/members/images/up.png"></button> <button class="btn btn-medium"><img src="assets/members/images/down.png"></button></li>
						<li>Shared Url:</li>
						<li><textarea rows="10" cols="30"></textarea></li>
						</ul>
						</li>
		
					</ul>


				</div>
			</li>
			<li class="body-section">
				
						<div class="sub">
				
				<ul class="sub-container">
						<li class="sub-info">
							<ul class="device">

  <header class="top-bar">
    <div class="left">
      <h1>My Questions</h1>
    </div>
  </header>

<section class="module">

  <ol class="discussion">
    <li class="other">
      <div class="avatar">
        <img src="assets/members/images/avatar-1.jpg" />
      </div>
      <div class="messages">
        <p>Do we Get full support for the plugin</p>
        <time datetime="2009-11-13T20:00">@sandesh • 51 min</time>
      </div>
    </li>
    <li class="self">
      <div class="avatar">
        <img src="assets/members/images/avatar-2.jpg" />
      </div>
      <div class="messages">
        <p>Yes we provide full support</p>
        <p>Why don't you contact us on our email.</p>
        <time datetime="2009-11-13T20:14">@MR 37 • mins</time>
      </div>
    </li>
    <li class="other">
      <div class="avatar">
        <img src="assets/members/images/avatar-1.jpg" />
      </div>
      <div class="messages">
        <p>Ok sure, why not, i have lots of questions which needs to be answered.</p>
          <time datetime="2009-11-13T20:14">@Sandesh 2 • mins</time>
      </div>
    </li>
      <li class="self">
      <div class="avatar">
        <img src="assets/members/images/avatar-2.jpg" />
      </div>
      <div class="messages">
        <p>Yes we provide full support</p>
        <p>Why don't you contact us on our email.</p>
        <time datetime="2009-11-13T20:14">@MR 37 • mins</time>
      </div>
    </li>
      <li class="self">
      <div class="avatar">
        <img src="assets/members/images/avatar-2.jpg" />
      </div>
      <div class="messages">
        <p>Yes we provide full support</p>
        <p>Why don't you contact us on our email.</p>
        <time datetime="2009-11-13T20:14">@MR 37 • mins</time>
      </div>
    </li>
  </ol>
 
</section>

 <input type="text" class="quest-control " name="questions" placeholder="Ask your Questions here ???"><input class="send-btn" type="submit" name="submit" value="send">
							</ul>	
						</li>
				
					</ul>



				<ul class="sub-container">
						<li class="sub-info">
							<ul class="device">

    <header class="top-bar">
    <div class="left">
      <h1>Public Questions</h1>
    </div>
  </header>

	<section class="module2">
  <ol class="discussion">
   <div class="media">
      <div class="media-left">
        <a href="#">
          <img class="media-object" data-src="holder.js/64x64" alt="64x64" style="width: 40px; height: 40px;" src="assets/members/images/avatar-1.jpg" data-holder-rendered="true">
        </a>
      </div>
      <div class="media-body">
        <h4 class="media-heading">User @sandesh</h4>
        <p>Hello i am sandesh and i have certian questions for you guys</p>
        </div>
        <div class="media">
      <div class="media-left">
        <a href="#">
          <img class="media-object" data-src="holder.js/64x64" alt="64x64" style="width: 40px; height: 40px;" src="assets/members/images/avatar-2.jpg" data-holder-rendered="true">
        </a>
      </div>
      <div class="media-body">
        <h4 class="media-heading">User @sandesh</h4>
        <p>Hello i am sandesh and i have certian questions for you guys</p>
        </div>
    </div>
    <div class="media">
      <div class="media-left">
        <a href="#">
          <img class="media-object" data-src="holder.js/64x64" alt="64x64" style="width: 40px; height: 40px;" src="assets/members/images/avatar-1.jpg" data-holder-rendered="true">
        </a>
      </div>
      <div class="media-body">
        <h4 class="media-heading">User @sandesh</h4>
        <p>Hello i am sandesh and i have certian questions for you guys</p>
        </div>
    </div>
    <div class="media">
      <div class="media-left">
        <a href="#">
          <img class="media-object" data-src="holder.js/64x64" alt="64x64" style="width: 40px; height: 40px;" src="assets/members/images/avatar-2.jpg" data-holder-rendered="true">
        </a>
      </div>
      <div class="media-body">
        <h4 class="media-heading">User @sandesh</h4>
        <p>Hello i am sandesh and i have certian questions for you guys</p>
        </div>
    </div>
    <div class="media">
      <div class="media-left">
        <a href="#">
          <img class="media-object" data-src="holder.js/64x64" alt="64x64" style="width: 40px; height: 40px;" src="assets/members/images/avatar-1.jpg" data-holder-rendered="true">
        </a>
      </div>
      <div class="media-body">
        <h4 class="media-heading">User @sandesh</h4>
        <p>Hello i am sandesh and i have certian questions for you guys</p>
        </div>
    </div>

        <div class="media">
      <div class="media-left">
        <a href="#">
          <img class="media-object" data-src="holder.js/64x64" alt="64x64" style="width: 40px; height: 40px;" src="assets/members/images/avatar-1.jpg" data-holder-rendered="true">
        </a>
      </div>
      <div class="media-body">
        <h4 class="media-heading">User @sandesh</h4>
        <p>Hello i am sandesh and i have certian questions for you guys</p>
        </div>
    </div>

    </div>
  </ol>
  
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
</div>
	
</body> 
</html>







