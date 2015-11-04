<?php
use \App\Subscriber;

function hashSubscriber($subscriber) {
	$hashids = new Hashids\Hashids(config('gtw.hashid.salts.subscribers'), 20, config('gtw.hashid.hash_chars'));
	
	if(!is_int($subscriber))
		$subscriber = $subscriber->id;
	
	return $hashids->encode($subscriber);	
}

function decodeSubscriber($subscriberHash) {
	$hashids = new Hashids\Hashids(config('gtw.hashid.salts.subscribers'), 20, config('gtw.hashid.hash_chars'));
	$ids = null;
	
	try {
		$ids = $hashids->decode($subscriberHash);
	} catch( \Exception $e) {

	}

	if(count($ids) ==0 )
		return null;	
	return Subscriber::findOrFail($ids[0]);
}