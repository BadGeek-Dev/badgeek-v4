<?php if (!$podcast->rss) :?>
    <a href="<?= site_url("episodes/create/".$podcast->id) ?>" class="btn btn-danger margin-right-10">Ajouter un épisode</a>
<?php endif ?>
<a href="<?= site_url("podcasts/sync/".$podcast->id) ?>" class="btn btn-danger margin-right-10">Synchroniser avec le flux RSS</a>
<a 
    href="<?= site_url("podcasts/delete/".$podcast->id) ?>" 
    class="btn btn-danger margin-right-10" 
    onclick="return confirm('Supprimer <?php echo $podcast->titre ?> ? cette action est définitive.')"
    >
    Supprimer le podcast
</a>

<h3>Episodes</h3>

<?php
    foreach ($episodes as $episode) {
        echo '<a href="'.site_url("episodes/edit/".$episode->id).'">'.$episode->titre.'</a>';
        echo "<br/>";
    }
?>
