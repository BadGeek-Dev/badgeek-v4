<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Email_manager {
    private $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->library(['email']);
        $this->CI->config->load('ion_auth', TRUE);
        $this->CI->config->load('config', TRUE);
    }

    private function send($to, $subject, $message,$from = null)
    {
        if(is_array($to))
        {
            foreach($to as $destinataire)
            {
                $this->send($destinataire, $subject, $message);
            }
        }
        else
        {
            $this->CI->email->clear();
            if($from == null) {
				$this->CI->email->from($this->CI->config->item('admin_email', 'ion_auth'), $this->CI->config->item('site_title', 'ion_auth'));
			}else{
            	$this->CI->email->from($from);
			}
            $this->CI->email->to($to);
            $this->CI->email->subject($this->CI->config->item('site_title', 'ion_auth') . ' - ' . $subject);
            $this->CI->email->message($message);
            $this->CI->email->send();
        }
    }

    public function sendValidationPodcastEmail($podcast, $creator)
    {
        $this->send(
            [$this->CI->config->item('admin_email', 'config')],
            'Nouveau podcast en attente de validation',
            "Nouveau podcast en attente de validation : {$podcast->titre}<br/>
            Description : {$podcast->description} <br/>
            RSS : {$podcast->rss} <br/>
            Créateur : {$creator->username} {$creator->email}
            "
        );
        $this->send(
            [$creator->email],
            "Podcast en attente de validation",
            "Bonjour, <br/>
            Votre podcast {$podcast->titre} est actuellement en cours de validation par notre équipe.
            <br/>
            Cordialement,<br/>
            L'équipe Badgeek"
        );
    }

    public function sendPodcastValidatedEmail($podcast, $creator)
    {
        $this->send(
            [$creator->email],
            'Podcast validé',
            "Bonjour, <br/>
            Félicitations ! Votre podcast {$podcast->titre}, a été validé par l'équipe Badgeek.
            <br/>
            Cordialement,<br/>
            L'équipe Badgeek"
        );
    }

    public function sendPodcastRefusedEmail($podcast, $creator, $reason)
    {
        $this->send(
            [$creator->email],
            'Podcast refusé',
            "Bonjour, <br/>
            Votre podcast {$podcast->titre}, a été refusé par l'équipe Badgeek.
            <br/> Motif du refus : $reason
            <br/>
            Cordialement,<br/>
            L'équipe Badgeek
            "
        );
    }

    public function sendUserActiveState($user, $state, $motif = "")
    {
        if($state == Users_Model::NON_VALIDE)
        {
            //Mise en attente, envoi du mail de validation
            $auth = new Ion_auth();
            $auth->forgotten_password($user->email);
        }
        else
        {
            //Mail d'activation / désactivation
            $state = $state == Users_Model::ACTIVE ? "activé" : "désactivé";
            $this->send(
                [$user->email],
                "Compte {$state}" ,
                "Bonjour, <br/><br/>
                Votre compte a été {$state} par l'équipe Badgeek.
                <br/><br/>
                ". ($motif ? "Motif : $motif <br/><br/>" : "")."
                Cordialement,<br/>
                L'équipe Badgeek
                "
            );
        }
    }
        
    /**
     * sendErrorMailToAdmins
     *
     * @param  mixed $subject
     * @param  mixed $message
     * @return void
     */
    public function sendMessageToAdmins($subject = "", $message = "")
    {
        $this->CI->load->model("Users_model");
        $admins = $this->CI->Users_model->getAdmins("email");
        array_walk($admins, function (&$element) { $element = $element->email;});
        $this->send($admins,$subject ?: "Alerte destinée aux administrateurs", $message ?: print_r(debug_backtrace(),true));
    }


	/**
	 * sendSignalMailToAdmins
	 *
	 * @param  mixed $subject
	 * @param  mixed $message
	 * @param  mixed $email
	 * @return void
	 */
	public function sendSignalToAdmins($subject = "", $message = "",$email="")
	{

		$this->CI->load->model("Users_model");
		$admins = $this->CI->Users_model->getAdmins("email");
		array_walk($admins, function (&$element) { $element = $element->email;});
		$this->send($admins,$subject, $message);



	}
}
