<?php
    //Récupération du message en session
    $flashdata = $this->session->flashdata();
    if (is_array($flashdata) && key_exists("message", $flashdata)) 
    {
        $flashdata_message_title = key_exists("message-title", $flashdata) ? $flashdata["message-title"] : "Message de BadGeek" ;
        $flashdata_message = $flashdata["message"];
        $flashdata_position = "position:absolute;";
        $message_position = (key_exists("message-position", $flashdata) ? $flashdata["message-position"] : "top-center");
        if(FALSE !== strstr($message_position, "top")) $flashdata_position .= "top:55px;"; 
        if(FALSE !== strstr($message_position, "bottom")) $flashdata_position .= "bottom:55px;"; 
        if(FALSE !== strstr($message_position, "left")) $flashdata_position .= "left:20px;"; 
        if(FALSE !== strstr($message_position, "right")) $flashdata_position .= "right:20px;"; 
        if(FALSE !== strstr($message_position, "center")) $flashdata_position .= "left:40%;"; 
        $flashdata_timeout = key_exists("message-timeout", $flashdata) ? $flashdata["message-timeout"] : BADGEEK__TIMEOUT_TOAST;
    }
?>
<?php if (isset($flashdata_message)) : ?>
        <div class="toast" role="alert" aria-live="polite" aria-atomic="true" id="toast-message" data-autohide="true" data-delay="<?=$flashdata_timeout?>" style="<?=$flashdata_position?>">
                <div class="toast-header">
                        <i class="icon-info-circled"></i>
                        <strong class="mr-auto"><?= $flashdata_message_title?></strong>
                        <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="toast-body">
                        <?= $flashdata_message ?>
                </div>
        </div>
<?php endif; ?>