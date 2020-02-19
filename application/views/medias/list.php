<h2>Les podcasts</h2>
<?php
    foreach ($podcasts as $podcast) {
        echo '<a href="'.site_url("medias/podcast/".$podcast->id).'">'.$podcast->titre.'</a>';
        echo "<br/>";
    }
?>