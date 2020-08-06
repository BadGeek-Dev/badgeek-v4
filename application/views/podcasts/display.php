<h2>
    <?php echo $podcast->titre ?> 
    <?php if($this->user && $podcast->id_createur == $this->user->id): ?>
        (<a href="<?= site_url("podcasts/edit/".$podcast->id) ?>">modifier</a>)
    <?php endif; ?>
</h2>
<?php if($this->user && $podcast->id_createur == $this->user->id): ?>
    <?php if ($podcast->hosted) :?>
        <a href="<?= site_url("episodes/create/".$podcast->id) ?>" class="btn btn-danger margin-right-10">Ajouter un épisode</a>
    <?php else :?>
        <a href="<?= site_url("podcasts/sync/".$podcast->id) ?>" class="btn btn-danger margin-right-10">Synchroniser avec le flux RSS</a>
    <?php endif ?>

    <a 
        href="<?= site_url("podcasts/delete/".$podcast->id) ?>" 
        class="btn btn-danger margin-right-10" 
        onclick="return confirm('Supprimer <?php echo $podcast->titre ?> ? cette action est définitive.')"
        >
        Supprimer le podcast
    </a>
<?php endif; ?>

<h3>Episodes</h3>

<?php
    foreach ($episodes as $episode) {
        echo '<a href="'.site_url("episodes/view/".$episode->id).'">'.$episode->titre.'</a>';
        echo "<br/>";
    }
?>
