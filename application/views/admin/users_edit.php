<?
$avatar = getAvatar($user->id);
if($avatar):
?>
<img src="<?= base_url($avatar) ?>" />
<br />
<br />
<?endif;?>
Username : <?= $user->username ?><br />
Email : <?= $user->email ?><br />
Last Login : <?= date('Y-m-d H:m', $user->last_login) ?><br />

<br />

Podcasteur : <?= strpos($user->groups_id, '3') !== false ? 'oui' : 'non' ?><br />
Poditeur : <?= strpos($user->groups_id, '2') !== false ? 'oui' : 'non' ?><br />
Admin : <?= strpos($user->groups_id, '1') !== false ? 'oui' : 'non' ?><br />

<br />

<?php if ($user->active == Users_Model::NON_VALIDE) : ?>
    <div class="alert alert-success fade show" role="alert" id="desactiver_compte_alert">
    Ce bouton permet de valider à la place de l'utilisateur son compte : 
        <a href="<?= base_url("admin/users/activate/" . $user->id); ?>" class="btn btn-success">
            Forcer la validation du compte
        </a>
    </div>
<?php else : ?>
    <?php if ($user->active == Users_Model::ACTIVE) : ?>
        <div class="alert alert-warning fade show" role="alert" id="desactiver_compte_alert">
        <strong>En cas de doute sur qui a accès au compte</strong>, ce bouton invalidera le compte et demandera à l'utilisateur de revalider via un lien envoyé par mail son compte : <a href="<?= base_url("admin/users/unvalidate/" . $user->id); ?>" class="btn btn-warning">
            Redemander la validation du compte
        </a>
        </div>

        <div class="alert alert-danger fade show" role="alert" id="desactiver_compte_alert">
            <strong>Attention : </strong> Désactiver un compte a pour conséquence d'<strong>archiver l'intégralité de sa production soit 
            <?php
            $nb_podcasts = count($liste_podcasts);
            echo $nb_podcasts . " podcast" . ($nb_podcasts > 1 ? "s" : "");
            ?>
            </strong>
            <br />
            <ul>
                <?php
                foreach ($liste_podcasts as $podcast) {
                    echo "<li>" . $podcast->titre . "</li>";
                }
                ?>
            </ul>
            Si vous êtes sûr, cliquez sur ce bouton :
            <a href="<?= base_url("admin/users/deactivate/" . $user->id); ?>" class="btn btn-danger">
                Désactiver le compte
            </a>
        </div>
        
    <?php else : ?>
        <a href="<?= base_url("admin/users/activate/" . $user->id); ?>" class="btn btn-info">
            Activer le compte
        </a>
    <?php endif; ?>
<?php endif; ?>