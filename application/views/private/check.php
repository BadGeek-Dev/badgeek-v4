<?php
echo form_open_multipart('devtools/check');
    echo '<div class="form-group row">';
        echo '<div class="col-md-4 text-right">';
            echo form_label("Password", null, ['class' => 'col-md-4 col-form-label text-right']);
        echo '</div>';
        echo '<div class="col-md-4">';
            echo form_input("check_dev_password",'', 'style="width:100%"');
        echo '</div>';
        echo '<div class="col-md-4 text-left">';
            echo form_submit('submit', 'Créer', ['class' => 'btn btn-danger']);
        echo '</div>';
    echo '</div>';