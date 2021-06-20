<?php
echo form_open_multipart('dev/check_dev_password');
    echo '<div class="form-group row">';
        echo form_label("Password", null, ['class' => 'col-md-4 col-form-label text-right']);
        echo '<div class="col-md-6">';
            echo form_input("check_dev_password");
        echo '</div>';
    echo '</div>';
    echo '<div class="row">';
        echo '<div class="col-md-12 text-center">';
            echo form_submit('submit', 'Créer', ['class' => 'btn btn-danger']);
        echo '</div>';
    echo '</div>';