<h3>Résultat recherche <?php if($query) echo "\"".$query."\""; ?></h3>

<?php
    foreach ($podcasts as $podcast) {
        echo '<a href="'.site_url("podcasts/display/".$podcast->id).'">'.$podcast->titre.'</a>';
        echo "<br/>";
    }
?>
