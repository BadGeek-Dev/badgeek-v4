<?php

defined('BASEPATH') OR exit('No direct script access allowed');

if ( ! function_exists('refreshSid'))
{
	
	function refreshSid()
	{
		$_SESSION["sid"] = rand(0, time());
		return $_SESSION["sid"];
	}
}

if ( ! function_exists('setFlashdataMessage'))
{
	function setFlashdataMessage(&$session, $message, $title = false, $position = "top-right", $timeout = BADGEEK__TIMEOUT_TOAST)
	{
		if($message)  $session->set_flashdata('message', $message);
		if($title)    $session->set_flashdata('message-title', $title);
		if($position) $session->set_flashdata('message-position', $position);
		if($timeout)  $session->set_flashdata('message-timeout', $timeout);
	}
}

if ( ! function_exists('getAvatar'))
{
	function getAvatar($id_user)
	{
		$avatar_directory = realpath(__DIR__."/../../assets/pictures/avatars/");
		if(file_exists($avatar_directory."/".$id_user.".jpg")) return "assets/pictures/avatars/".$id_user.".jpg";
		if(file_exists($avatar_directory."/".$id_user.".png")) return "assets/pictures/avatars/".$id_user.".png";
		return FALSE;
	}
}