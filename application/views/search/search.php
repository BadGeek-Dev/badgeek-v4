<h3>Résultat recherche</h3>

<?php
    foreach ($podcasts as $podcast) {
        echo '<a href="'.site_url("podcasts/display/".$podcast->id).'">'.$podcast->titre.'</a>';
        echo "<br/>";
    }
?>
