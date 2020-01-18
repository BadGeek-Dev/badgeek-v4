<?php 
    echo validation_errors();

    echo form_open_multipart('episodes/create/'.$podcast->id);

    foreach ($attributes as $attribute) {
        echo '<div class="form-group row">';
            echo form_label($attribute['label'], null, ['class' => 'col-md-4 col-form-label text-right']);
            echo '<div class="col-md-6">';
            echo form_input($attribute);
            echo '</div>';
        echo '</div>';
    }
    echo '<div class="row">';
        echo '<div class="col-md-12 text-center">';
            echo form_submit('submit', 'Créer', ['class' => 'btn btn-danger']);
        echo '</div>';
    echo '</div>';
?>
