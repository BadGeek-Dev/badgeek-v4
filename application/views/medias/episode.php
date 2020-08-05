<h2><?php echo $episode->titre ?></h2>

<p><?php echo $episode->description ?></p>

<!-- PLAYER --> 
<script src="<?php echo base_url('assets/node_modules/mediaelement/build/mediaelement-and-player.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url("assets/node_modules/mediaelement/build/mediaelementplayer.css") ?>" />
<audio controls style="max-width:100%;" class="mejs__player">
    <source src="<?= $episode->lien_mp3 ?>" type="audio/mp3">
</audio>