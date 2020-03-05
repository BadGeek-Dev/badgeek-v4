Bienvenue <?= $this->ion_auth->logged_in() ? $this->user->username : "" ?>

<?php
if (isset($result) AND sizeof($result) > 0) {
    ?>

<div class="container-fluid">
    <div class="card text-white bg-dark">
        <div class="card-header bg-danger">
            <h2> News</h2>
        </div>
    </div>
    <div class="card-body"id="ajax-results">
        <h3> <?= $result->title ?></h3>
        <p class="font-italic text-secondary"> par <?= $result->username ?>
            le <?= $result->created_at ?></p>
        <p><?= $result->content ?></p>
    </div>
    <nav aria-label="Page navigation example">
        <ul class="pagination">
            <li class="btn page-item previous_news_item disabled p-0"><button class="page-link previous_news">Previous</button></li>
            <li class="btn page-item next_news_item <?php if(!$nextID>0){ echo "disabled";}?> p-0"><button class="page-link next_news">Next</button></li>
        </ul>
    </nav>
</div>
<?php } ?>

<script>
    let nextNews = <?= $nextID ?>; //initialisation pour index.js
</script>
<script src="<?php echo base_url('assets/js/index.js') ?>"></script>