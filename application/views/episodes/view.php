<h2>
    <?php echo $episode->titre ?>
    <?php if($this->user && $podcast->id_createur == $this->user->id): ?>
        (<a href="<?= site_url("episodes/edit/".$episode->id) ?>">modifier</a>)
    <?php endif; ?>
</h2>

<p><?php echo $episode->description ?></p>

<!-- PLAYER --> 
<script src="<?php echo base_url('assets/node_modules/mediaelement/build/mediaelement-and-player.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url("assets/node_modules/mediaelement/build/mediaelementplayer.css") ?>" />
<audio controls style="max-width:100%;" class="mejs__player">
    <source src="<?= $episode->lien_mp3 ?>" type="audio/mp3">
</audio>

<script>
    let update_stats = function() {
        $.ajax({
            type: "POST",
            url: "<?= site_url("episodes/stats/listen/".$episode->id) ?>",
        });
    };
    $('.mejs__player')[0].addEventListener("play", update_stats);
</script>