<div class="container">
                    <h2>Editer un Article</h2>
                    <?= form_open_multipart('admin/articles/edit/' . $article->id); ?>
                    <div class="form-group">
                        <?= form_label("Titre&nbsp:", "title", ['class' => "control-label "]) ?>
                        <div>
                            <?= form_input(['name' => "title", 'id' => "title", 'value' => $article->title, 'class' => 'form-control']) ?>
                            <span class="help-block"><?= form_error('title'); ?> </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <?= form_label("Contenu&nbsp:", "content", ['class' => "control-label "]) ?>
                        <div>
                            <?= form_textarea(['name' => "content", 'id' => "content", 'value' => $article->content, 'class' => 'form-control']) ?>
                            <span class="help-block"><?= form_error('content'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <?= form_label("Illustration&nbsp:", "picture", ['class' => "control-label "]) ?>
                        <?php if($article->picture != null){ ?>
                            <img class="ml-4 mb-4"src="<?php echo base_url('assets/pictures/news/'.$article->picture);?>"></img>
                        <?php } ?>
                        <div>
                         <?= form_upload(['name' => "picture", 'id' => "picture", 'class' => 'form-control']) ?>
                        <span class="help-block"><?= isset($error_upload) ? $error_upload : "" ?> </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <?= form_label("Visible&nbsp:", "status", ['class' => "control-label "]) ?>
                            <?= form_checkbox("status", "status", $article->status) ?>
                    </div>
                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-10">
                            <?= form_submit("send", "Envoyer", ['class' => "btn btn-success"]); ?>
                        </div>
                    </div>
                    <?= form_close() ?>
                </div>
