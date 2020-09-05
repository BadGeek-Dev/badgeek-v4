Bienvenue 
    <?=$this->ion_auth->logged_in() ? isset($this->user->prefs_decoded['navi']) && $this->user->prefs_decoded['navi'] ? 'Hey You! Listen!' : $this->user->username : ""?>

<div class="container-fluid">
    <div class="card text-white bg-dark">
        <div class="card-header bg-danger">
            <h2> News</h2>
        </div>
        <div class="card-body ">
            <?php foreach ($result as $item) : ?>
                <h3> <?= $item->title ?></h3>
                <p class="font-italic text-secondary"> par <?= $item->username ?>
                    le <?= $item->created_at ?></p>
                <div class="row">
                    <?php if($item->picture != null) : ?>
                    <img class="mr-4"src="<?php echo base_url('assets/pictures/news/'.$item->picture);?>"></img>
                    <?php endif ?>
                    <p><?= $item->content ?></p>
                </div>
                <hr class="hr_news">
            <?php endforeach ?>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="card text-white bg-dark">
        <div class="card-header bg-danger">
            <h2> Derniers podcasts validés</h2>
        </div>
        <div class="card-body ">
            <?php 
                foreach ($podcasts as $podcast) {
                    echo '<a href="'.site_url("podcasts/display/".$podcast->id).'">'.$podcast->titre.'</a>';
                    echo "<br/>";
                } 
            ?>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="card text-white bg-dark">
        <div class="card-header bg-danger">
            <h2> Derniers épisodes validés</h2>
        </div>
        <div class="card-body ">
            <?php 
                foreach ($episodes as $episode) {
                    echo '<a href="'.site_url("episodes/view/".$episode->id).'">'.$episode->titre.'</a>';
                    echo "<br/>";
                } 
            ?>
        </div>
    </div>
</div>