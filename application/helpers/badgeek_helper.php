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

if (! function_exists( 'checkIsGroup')) {
	function checkIsPodcasteur()
	{
		if(!isPodcasteur())
		{
			redirect('/', 'refresh');
		}
	}
}

if ( ! function_exists('getLibelleFromUser'))
{
	function getLibelleFromUser($user, $retour = "")
	{
		switch ($retour) {
			case 'user_only':
				return $user->username ?: "(pas de pseudo défini)";
				break;
			
			default:
				return ($user->username ?: "(pas de pseudo défini)"). " - ".$user->email;
				break;
		}
	}
}

if ( ! function_exists('getBadgeFromUser'))
{
	function getBadgeFromUser(Users_Model $user)
	{
		if($user->isAdmin())
		{
			return "<span class=\"badge badge-primary\">".Users_Model::LIBELLE_ADMIN."</span>";
		}
		if($user->isActive())
		{
			return "<span class=\"badge badge-success\">".Users_Model::LIBELLE_ACTIVE."</span>";
		}
		if($user->isDesactive())
		{
			return "<span class=\"badge badge-danger\">".Users_Model::LIBELLE_DESACTIVE."</span>";
		}
		if($user->isNonValide())
		{
			return "<span class=\"badge badge-warning\">".Users_Model::LIBELLE_NON_VALIDE."</span>";
		}
	}
}
if ( ! function_exists('getBadgeFromPodcast'))
{
	function getBadgeFromPodcast(Podcasts_model $podcast, $mode = "statut")
	{
		if($mode == "statut")
		{
			return getBadgeFromPodcastStatut($podcast);
		}
		else if($mode == "tags")
		{
			return getBadgeFromPodcastTags($podcast);
		}
	}

	function getBadgeFromPodcastStatut(Podcasts_model $podcast)
	{
		if($podcast->isValide())
		{
			return "<span class=\"badge badge-success\">".Podcasts_model::LIBELLE_VALIDE."</span>";
		}
		if($podcast->isRefuse())
		{
			return "<span class=\"badge badge-danger\">".Podcasts_model::LIBELLE_REFUSE."</span>";
		}
		if($podcast->isEnAttente())
		{
			return "<span class=\"badge badge-warning\">".Podcasts_model::LIBELLE_EN_ATTENTE."</span>";
		}
	}

	function getBadgeFromPodcastTags(Podcasts_model $podcast)
	{
		$retour = "";
		$tags = json_decode($podcast->tags, true);
		foreach($tags as $tag)
		{
			$retour .= "<span class=\"badge badge-secondary\">".$tag["value"]."</span>&nbsp;";
		}
		return $retour;
	}
}

if ( ! function_exists('getConfig'))
{
	function getConfig($element = "")
    {
		$CI =& get_instance();
        $config = $CI->session->userdata("config");
		if(1 || empty($config))
		{
			$CI->load->model("Config_model");
			$CI->Config_model->loadConfig();
			$config = $CI->session->userdata("config");
		}
        return $config && $element && key_exists($element, $config) ? $config[$element] : $config;
    }
	
}

if ( ! function_exists('getBaseUrlFromRealpath'))
{
	function getBaseUrlFromRealpath($real_path)
	{
		return base_url(substr($real_path, strlen("/badgeek/")));
	}

}
if ( ! function_exists('getPrivateDir'))
{
	function getPrivateDir($id_user = 0)
    {
        return realpath(__DIR__."/../../assets/private/".($id_user ?: ""));
    }

	function getPrivateUrl($id_user = 0)
    {
        return base_url("assets/private/".($id_user ?: ""));
    }

	function getPrivateListOfFileForUser($id_user)
    {
         //La liste des fichiers
		 $dir_user = getPrivateDir($id_user);
		 if($id_user && is_dir($dir_user))
		 {
			 return array_filter(scandir($dir_user), function($file) use($dir_user) {
				 return is_file($dir_user."/".$file);
				});
		}
		return false;
    }
  
}




