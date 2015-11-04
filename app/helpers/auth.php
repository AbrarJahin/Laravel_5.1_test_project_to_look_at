<?php

function isAdmin($user = null) {
	$user = $user == null ? Auth::user() : $user;
	if($user == null) return false;
	return $user->hasRole('admin');
}

function isCustomer($user = null) {
	$user = $user == null ? Auth::user() : $user;
        if($user == null) return false;
	return $user->hasRole('customer');
}