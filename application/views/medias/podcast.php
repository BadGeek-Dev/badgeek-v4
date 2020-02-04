<h2><?php echo $podcast->titre ?></h2>

<h3>Episodes</h3>

<?php
    foreach ($episodes as $episode) {
        echo '<a href="'.site_url("medias/episode/".$episode->id).'">'.$episode->titre.'</a>';
        echo "<br/>";
    }
?>
