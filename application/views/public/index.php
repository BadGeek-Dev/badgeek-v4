<?php if($user): ?>
    <h1> Bienvenue <?=$user->username?></h1><a href="<?=site_url("auth/logout")?>">Se déconnecter</a>
<?php else: ?>
    <a href="<?=site_url("auth/register")?>">Je veux m'inscrire sur BadGeek ! </a>
<?php endif; ?>