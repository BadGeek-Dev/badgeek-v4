<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            <div class="card rounded-lg admin_card">
                <div class="card-header rounded-bottom admin_card_header">
                    Menu d'Administation
                </div>
                <ul class="list-group admin_listgroup">
                    <li class="list-group-item admin_listitem"><a href="<?= base_url("admin"); ?>">Articles</a></li>
                    <li class="list-group-item admin_listitem"><a href="<?= base_url("admin/addArticle"); ?>">Ajouter un
                            article</a></li>
                </ul>
            </div>

        </div>
        <div class="col-md-8">
            <div class="container">
                <div class="row">
                    <h2>Créer un nouvel Article</h2>
                </div>
                <div class="row">
                    <?= form_open('admin/addArticle', ['class' => 'form-horizontal']); ?>
                    <div class="form-group">
                        <?= form_label("Titre&nbsp:", "title", ['class' => "col-md-2 control-label "]) ?>
                        <div class="col-md-10">
                            <?= form_input(['name' => "title", 'id' => "title", 'class' => 'form-control']) ?>
                            <span class="help-block"><?= form_error('title'); ?> </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <?= form_label("Contenu&nbsp:", "content", ['class' => "col-md-2 control-label "]) ?>
                        <div class="col-md-10">
                            <?= form_textarea(['name' => "content", 'id' => "content", 'class' => 'form-control']) ?>
                            <span class="help-block"><?= form_error('content'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <?= form_label("Visible&nbsp:", "status", ['class' => "col-md-2 control-label "]) ?>
                        <div class="col-md-10">
                            <?= form_checkbox("status", "status", FALSE) ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-10">
                            <?= form_submit("send", "Envoyer", ['class' => "btn btn-success"]); ?>
                        </div>
                    </div>
                    <?= form_close() ?>
                </div>
            </div>
        </div>
    </div>
</div>
