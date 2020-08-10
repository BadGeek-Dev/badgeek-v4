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
	function setFlashdataMessage(&$session, $message, $position = "top-center", $title = false, $timeout = BADGEEK__TIMEOUT_TOAST)
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

if ( ! function_exists('isInGroupe'))
{
	function isAdmin()
	{
		return isInGroupe(Badgeek_constantes::AUTH_GROUP_ADMIN);
	}
	function isPoditeur()
	{
		return isInGroupe(Badgeek_constantes::AUTH_GROUP_PODITEUR);
	}
	function isPodcasteur()
	{
		return isInGroupe(Badgeek_constantes::AUTH_GROUP_PODCASTEUR);
	}
	function isInGroupe($group_id)
	{
		if(!key_exists("user", $_SESSION)) return false; // False si l'utilisateur n'est pas connecté
		$user = $_SESSION['user'];
		return in_array($group_id,  $user->groups_id);
	}
}


