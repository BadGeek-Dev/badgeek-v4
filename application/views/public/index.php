Bienvenue <?=$this->ion_auth->logged_in() ? $this->user->username : ""?>

<?php
if(isset($result) AND sizeof($result)>0) { ?>

<div class="container-fluid">
    <div class="card text-white bg-dark">
        <div class="card-header bg-danger">
            <h2> News</h2>
        </div>
        <div class="card-body ">
            <?php foreach ($result as $item) { ?>
                <h3> <?= $item->title ?></h3>
                <p class="font-italic text-secondary"> par <?= $item->username ?>
                    le <?= $item->created_at ?></p>
                <p><?= $item->content ?></p>
                <hr class="hr_news">
            <?php }
            }?>
        </div>
    </div>
</div>