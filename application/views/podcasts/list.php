<?php
    foreach ($podcasts as $podcast) {
        echo '<a href="'.site_url("podcasts/display/".$podcast->id).'">'.$podcast->titre.'</a>';
        echo "<br/>";
    }
?>

<a href="<?= site_url("podcasts/create") ?>" class="btn btn-danger margin-right-10">Ajouter un podcast</a>

<br/>
<br/>
<?php 
    if(count($podcasts_waiting)) {
        echo '<h4>Mes podcasts en attente de validation :</h4>';
    }

    foreach ($podcasts_waiting as $podcast) {
        echo $podcast->titre . ' (<a href="'.site_url("podcasts/edit/".$podcast->id).'">modifier</a>)<br/>';
    }
?>