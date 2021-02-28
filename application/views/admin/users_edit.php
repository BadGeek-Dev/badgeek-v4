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
<?php
$nb_podcasts = count($liste_podcasts);
$display_nb_podcasts =  $nb_podcasts . " podcast" . ($nb_podcasts > 1 ? "s" : "");
$display_liste_podcasts = "<ul>";
foreach ($liste_podcasts as $podcast) {
    $display_liste_podcasts .= "<li>" . $podcast->titre . "</li>";
}
$display_liste_podcasts .= "</ul>";
?>

<?php if ($user->active == Users_Model::NON_VALIDE) : ?>
    <div class="alert alert-success fade show" role="alert" id="desactiver_compte_alert">
        Le compte est actuellement en attente. <br/>Ce bouton permet de valider à la place de l'utilisateur son compte :
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
                echo $display_nb_podcasts . " : <br/>" . $display_liste_podcasts;
                ?>
            </strong>
            <?= form_open_multipart('admin/users/deactivate/' . $user->id); ?>
            Si vous êtes sûr, fournissez un motif : 
            <?= form_textarea(['name' => "motif", 'id' => "motif", 'value' => "", 'class' => 'form-control']) ?>
            ... et cliquez sur ce bouton :
            <?= form_submit("send", "Désactiver le compte", ['class' => "btn btn-danger margin-top-10"]); ?>
            <?= form_close() ?>
        </div>

    <?php else : ?>
        <div class="alert alert-success fade show" role="alert" id="desactiver_compte_alert">
            Le compte est actuéellement désactivé. Cela provoquera le désarchivage de ses
            <?php
            echo $display_nb_podcasts . " : <br/>" . $display_liste_podcasts;
            ?>
            <a href="<?= base_url("admin/users/activate/" . $user->id); ?>" class="btn btn-success">
                Ré-activer le compte
            </a>
        </div>
    <?php endif; ?>
<?php endif; ?>