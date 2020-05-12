<?php
    foreach ($podcasts as $podcast) {
        echo '<a href="'.site_url("podcasts/edit/".$podcast->id).'">'.$podcast->titre.'</a>';
        echo "<br/>";
    }
?>

<a href="<?= site_url("podcasts/create") ?>" class="btn btn-danger margin-right-10">Ajouter un podcast</a>