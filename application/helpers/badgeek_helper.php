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
