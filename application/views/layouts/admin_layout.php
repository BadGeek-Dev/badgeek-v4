<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            <div class="card rounded-lg admin_card">
                <div class="card-header rounded-bottom admin_card_header">
                    <a href="<?= base_url("admin"); ?>">Menu d'Administration</a>
                </div>
                <ul class="list-group admin_listgroup">
                    <li class="list-group-item admin_listitem"><a href="<?= base_url("admin/users"); ?>">Gestion des utilisateurs</a></li>
                    <li class="list-group-item admin_listitem">
                        <a href="<?= base_url("admin/podcasts"); ?>">Gestion des podcasts <? if($waiting_podcasts) echo "($waiting_podcasts en attente)"?></a>
                    </li>
                    <li class="list-group-item admin_listitem">
                        <a href="<?= base_url("admin/articles"); ?>">Gestion des Articles</a>
                      <li class="list-group-item admin_listitem"><a href="<?= base_url("admin/lives"); ?>">Modération des Lives</a></li>
                    </li>
                </ul>

            </div>
        </div>
        <div class="col-md-8">
            <?php echo $contents_admin ?>
        </div>
    </div>
</div>
