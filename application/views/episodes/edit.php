<p><a href="<?php echo site_url("podcasts") ?>">
    Podcasts
    </a>/
    <a href="<?php echo site_url("podcasts/edit/".$podcast->id) ?>">
    <?php echo $podcast->titre ?>
    </a>/
    <?php echo $episode->titre ?>
</p>

<h2><?php echo $episode->titre ?></h2>
<a href="<?= site_url("episodes/delete/".$episode->id) ?>" class="btn btn-danger margin-right-10">Supprimer l'épisode</a>

<p><?php echo $episode->description ?></p>