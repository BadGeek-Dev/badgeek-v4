<h2><?php echo $episode->titre ?></h2>
<a href="<?= site_url("episodes/delete/".$episode->id) ?>" class="btn btn-danger margin-right-10">Supprimer l'épisode</a>
<?php
    echo validation_errors();

    echo form_open('episodes/edit/'.$episode->id);

    if ($errors) {
        echo $errors;
    }

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
                echo form_submit('submit', 'Modifier', ['class' => 'btn btn-danger']);
            echo '</div>';
        echo '</div>';
?>

<script>
    $('[name=tags]').tagify();
</script>
