<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            <div class="card rounded-lg admin_card">
                <div class="card-header rounded-bottom admin_card_header">
                    <a href="<?= base_url("admin"); ?>">Menu d'Administration</a>
                </div>
                <ul class="list-group admin_listgroup">
                    <li class="list-group-item admin_listitem"><a href="<?= base_url("admin_articles/index"); ?>">Gestion des Articles</a></li>
                </ul>
            </div>
        </div>
        <div class="col-md-8">
            <?php echo $contents_admin ?>
        </div>
    </div>
</div>
