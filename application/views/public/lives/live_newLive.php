<div class="container">
    <h2>Demander un nouveau Live</h2>
    <?= form_open('lives/requestlive'); ?>

    <div class="form-group">
        <?= form_label("Titre&nbsp:", "title", ['class' => "control-label "]) ?>
        <div >
            <?= form_input(['name' => "title", 'id' => "title", 'class' => 'form-control']) ?>
            <span class="help-block"><?= form_error('title'); ?> </span>
        </div>
    </div>

    <div class="form-group">
        <?= form_label("Motif&nbsp:", "content", ['class' => "control-label "]) ?>
        <div >
            <?= form_textarea(['name' => "content", 'id' => "content", 'class' => 'form-control']) ?>
            <span class="help-block"><?= form_error('content'); ?>
        </div>
    </div>

    <div class="form-group">
        <?= form_label("Date de Début&nbsp:", "start_at", ['class' => "control-label "]) ?>
        <div>
            <?= form_input(['name' => "start_at", 'id' => "start_at", 'class' => 'form-control','type'=>'date']) ?>
            <span class="help-block"><?= form_error('start_at'); ?> </span>
        </div>
    </div>

    <div class="form-group">
        <?= form_label("Heure de Début&nbsp:", "start_at_hour", ['class' => "control-label "]) ?>
        <div>
            <?= form_input(['name' => "start_at_hour",'id' => "start_at_hour", 'class' => 'form-control', 'type'=>'time']
                ) ?>
<!--            <span class="help-block">--><?//= form_error('start_at'); ?><!-- </span>-->
        </div>
    </div>


    <div class="form-group">
        <div class="col-md-offset-2 col-md-10">
            <?= form_submit("send", "Envoyer", ['class' => "btn btn-success"]); ?>
        </div>
    </div>
    <?= form_close() ?>
</div>