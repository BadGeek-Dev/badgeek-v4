<h2>Les podcasts</h2>
<h5>Résultats pour : <?=$query?></h5>
<?php
    foreach ($podcasts as $podcast) {
        echo '<a href="'.site_url("medias/podcast/".$podcast->id).'">'.$podcast->titre.'</a>';
        echo "<br/>";
    }
?>