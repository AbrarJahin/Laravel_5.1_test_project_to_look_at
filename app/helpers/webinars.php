<?php
use App\StreamingServer;
use \App\Webinar;

/*
| Just a simple utility function used in views 
*/
function hasSubscriberList($subscribersLists,$subsciberList) {

	foreach ($subscribersLists as $list) {
		if($subsciberList->id == $list->id) {
			return true;
		}
	}
	return false;
}

function hashWebinar($webinarId) {
	$hashids = new Hashids\Hashids(config('gtw.hashid.salts.webinars'), 20, config('gtw.hashid.hash_chars'));
	return $hashids->encode($webinarId);
}

function decodeWebinar($webinarHash) {
	$hashids = new Hashids\Hashids(config('gtw.hashid.salts.webinars'), 20, config('gtw.hashid.hash_chars'));
	$ids = null;
	
	try {
		$ids = $hashids->decode($webinarHash);
	}catch(\Exception $e) {

	}

	if(count($ids) ==0 )
		return null;
	return Webinar::findOrFail($ids[0]);
}

function get_server_embed_code($server_id, Webinar $webinar)
{

	$server = StreamingServer::find($server_id);

	$html = '
	<div id="wowza" style="width:644px;height:276px;margin:0 auto;text-align:center">
    <img src="/media/img/player/splash_black.jpg"
         height="276" width="548" style="cursor:pointer" />
	</div>
	<script>
	$f("wowza", "http://releases.flowplayer.org/swf/flowplayer-3.2.18.swf", {
 
    clip: {
        url: "mp4:vod/demo.flowplayer/buffalo_soldiers.mp4",
        scaling: "fit",
        // configure clip to use hddn as our provider, referring to our rtmp plugin
        provider: "hddn"
    },
 
    // streaming plugins are configured under the plugins node
    plugins: {
 
        // here is our rtmp plugin configuration
        hddn: {
            url: "flowplayer.rtmp-3.2.13.swf",
 
            // netConnectionUrl defines where the streams are found
            netConnectionUrl: "rtmp://'.$server->streaming_url.'/live/'.$webinar->uuid.'"
			}
	},
	canvas: {
		backgroundGradient: "none"
		}
	});
	</script>';

	return $html;

}

function hashCampaignEmail($campaignEmailId) {
    $hashids = new Hashids\Hashids(config('gtw.hashid.salts.cmapaign_emails'), 20, config('gtw.hashid.hash_chars'));
    return $hashids->encode($campaignEmailId);
}
