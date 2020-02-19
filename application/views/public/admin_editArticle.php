
            <div class="container">
                <div class="row">
                    <h2>Editer un Article</h2>
                </div>
                <div class="row">
                    <?= form_open('admin/editArticle/' . $article->id, ['class' => 'form-horizontal']); ?>
                    <div class="form-group">
                        <?= form_label("Titre&nbsp:", "title", ['class' => "col-md-2 control-label "]) ?>
                        <div class="col-md-10">
                            <?= form_input(['name' => "title", 'id' => "title", 'value' => $article->title, 'class' => 'form-control']) ?>
                            <span class="help-block"><?= form_error('title'); ?> </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <?= form_label("Contenu&nbsp:", "content", ['class' => "col-md-2 control-label "]) ?>
                        <div class="col-md-10">
                            <?= form_textarea(['name' => "content", 'id' => "content", 'value' => $article->content, 'class' => 'form-control']) ?>
                            <span class="help-block"><?= form_error('content'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <?= form_label("Visible&nbsp:", "status", ['class' => "col-md-2 control-label "]) ?>
                        <div class="col-md-10">
                            <?= form_checkbox("status", "status", $article->status) ?>
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
