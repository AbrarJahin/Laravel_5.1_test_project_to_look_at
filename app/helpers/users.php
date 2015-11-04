<?php
use \App\User;

function createUser($fields) {
	$user = User::create($fields);
	return $user;
}