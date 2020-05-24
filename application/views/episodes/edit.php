<h2><?php echo $episode->titre ?></h2>
<a href="<?= site_url("episodes/delete/".$episode->id) ?>" class="btn btn-danger margin-right-10">Supprimer l'épisode</a>

<p><?php echo $episode->description ?></p>