Bienvenue <?= $this->ion_auth->logged_in() ? $this->user->username : "" ?>


<?php if (!empty($news)) :?>
    <div class="container-fluid">
        <div class="card text-white bg-dark">
            <div class="card-header bg-danger">
                <h2>L'actu</h2>
            </div>
        <? foreach($news as $item):?>
            <div class="card-body"id="ajax-results">
                <h3><?= $item->title ?></h3>
                <p class="font-italic text-secondary">
                    par <?= $item->username ?> le <?= $item->created_at ?>
                </p>
                <div class="row">
                    <?php if($item->picture) : ?>
                        <img class="mr-4" src="<?php echo base_url('assets/pictures/news/'.$item->picture);?>"></img>
                    <?php endif ?>
                    <p><?= $item->content ?></p>
                </div>
            </div>
            <script>
                let currentID = <?= $item->id ?>; //initialisation pour index.js
            </script>
        <? endforeach;?>
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <li class="btn page-item previous_news_item <?php if(!$btnStatus['previous']){ echo "disabled";}?> p-0"><button class="page-link previous_news"><< Article précédent </button></li>
                    <li class="btn page-item next_news_item <?php if(!$btnStatus['next']){ echo "disabled";}?> p-0"><button class="page-link next_news">Article suivant >> </button></li>
                </ul>
            </nav>
        </div>
    </div>
    
<?php endif;?>


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


<script src="<?php echo base_url('assets/js/index.js') ?>"></script>