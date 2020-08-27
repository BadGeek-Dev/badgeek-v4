<h2><?= $podcast->titre ?></h2>
Podcast : <br/>
Description : <?= $podcast->description ?> <br/>
Status : <?php switch ($podcast->valid) {
    case 0:
        echo "En attente de validation";
        break;

    case 1:
        echo "Validé";
        break;

    case 2:
        echo "Refusé";
        break;
    }?><br/>
RSS : <?= $podcast->rss ?><br/>
Lien : <?= $podcast->lien ?><br/>
Image : <?= $podcast->image ?><br/>
<br/>

Créateur : <br/>
Login : <?= $creator->username ?><br/>
Email : <?= $creator->email ?><br/>
<br/>

Actions : <br/>
<?php if ($podcast->valid != 0) :?>
    <a 
        href="<?= base_url("admin/podcasts/waiting/" . $podcast->id); ?>" 
        class="btn btn-info"
    >
        En attente de validation
    </a>
    <br/>
    <br/>
<?php endif ;?>

<?php if ($podcast->valid != 1) :?>
    <a 
        href="<?= base_url("admin/podcasts/validate/" . $podcast->id); ?>" 
        class="btn btn-info"
    >
        Valider
    </a>
    <br/>
    <br/>
<?php endif ;?>

<?php if ($podcast->valid != 2) :?>
    <form method="POST" action="<?= base_url("admin/podcasts/refuse/" . $podcast->id); ?>">
        <label for="reason">Raison du refus :</label>
        <textarea id="reason" name="reason" required></textarea>
        <br/>
        <input type="submit" class="btn btn-info" value="Refuser">
    </form>
    <br/>
    <br/>
<?php endif ;?>