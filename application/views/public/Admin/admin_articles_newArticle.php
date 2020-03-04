            <div class="container">
                    <h2>Créer un nouvel Article</h2>
                    <?= form_open_multipart('admin_articles/addArticle'); ?>
                    <div class="form-group">
                        <?= form_label("Titre&nbsp:", "title", ['class' => "control-label "]) ?>
                        <div >
                            <?= form_input(['name' => "title", 'id' => "title", 'class' => 'form-control']) ?>
                            <span class="help-block"><?= form_error('title'); ?> </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <?= form_label("Contenu&nbsp:", "content", ['class' => "control-label "]) ?>
                        <div >
                            <?= form_textarea(['name' => "content", 'id' => "content", 'class' => 'form-control']) ?>
                            <span class="help-block"><?= form_error('content'); ?>
                        </div>
                    </div>
                <div class="form-group">
                    <?= form_label("Illustration&nbsp:", "picture", ['class' => "control-label "]) ?>
                    <div>
                        <?= form_upload(['name' => "picture", 'id' => "picture", 'class' => 'form-control']) ?>
                        <span class="help-block"><?php if(isset($error)){echo $error;} ?> </span>
                    </div>
                </div>
                    <div class="form-group">
                        <?= form_label("Visible&nbsp:", "status", ['class' => "control-label "]) ?>
                            <?= form_checkbox("status", "status", FALSE) ?>
                    </div>
                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-10">
                            <?= form_submit("send", "Envoyer", ['class' => "btn btn-success"]); ?>
                        </div>
                    </div>
                    <?= form_close() ?>
            </div>
