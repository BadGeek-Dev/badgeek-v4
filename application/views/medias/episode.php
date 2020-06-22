<h2><?php echo $episode->titre ?></h2>

<p><?php echo $episode->description ?></p>

<audio controls style="max-width:100%;">
    <source src="<?= $episode->lien_mp3 ?>" type="audio/mp3">
</audio>