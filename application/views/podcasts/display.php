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
    $total = [];

    foreach ($episodes as $episode) {
        echo '<a href="'.site_url("episodes/view/".$episode->id).'">'.$episode->titre.'</a>';
        if ($this->user && $podcast->id_createur == $this->user->id) {
            $stats = json_decode($episode->stats, true);
            echo ' (page vu '.($stats['view'] ?? "0").', lecture '.($stats['listen'] ?? "0").')';

            $total = [
                'view' => ($total['view'] ?? 0) + ($stats['view'] ?? 0),
                'listen' => ($total['listen'] ?? 0) + ($stats['listen'] ?? 0)
            ];
        }
        echo "<br/>";
    }
?>

<?php if ($this->user && $podcast->id_createur == $this->user->id): ?>
    <h3>Statistiques global</h3>
    <p>Total page vu <?= $total['view'] ?? 0 ?></p>
    <p>Total lecture <?= $total['listen'] ?? 0 ?></p>
<?php endif; ?>
