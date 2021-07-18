<link rel="stylesheet" href="<?php echo base_url('assets/node_modules/bootstrap4c-dropzone/dist/css/component-dropzone.min.css'); ?>">
<script src="<?php echo base_url('assets/node_modules/dropzone/dist/dropzone.js'); ?>"></script>

<?php echo form_open_multipart('episodes/create/' . $podcast->id); ?>
<div class="container">
    <?php
    $errors .= validation_errors();
    if ($errors) :
    ?>
        <div class="row">
            <div class="alert alert-danger full-width" role="alert">
                <?php echo $errors;?>
            </div>
        </div>
    <?php endif; ?>
    <div class="row">

        <div class="col-md-8">
            <div class="alert alert-primary" role="alert">
                Les infos du podcast
            </div>
            <?
            foreach ($attributes as $attribute) {
                echo '<div class="form-group row">';
                echo form_label($attribute['label'], null, ['class' => 'col-md-4 col-form-label text-right']);
                echo '<div class="col-md-6">';
                echo form_input($attribute);
                echo '</div>';
                echo '</div>';
            }
            ?>
            <audio controls style="width:100%;" id="mp3player">
                <source src="" type="audio/mpeg" id="mp3source" data-path="<?php echo getPrivateUrl($this->session->userdata('user_id')); ?>">
            </audio>
        </div>
        <div class="col-md-4">

            <div class="alert alert-primary" role="alert">
                Le mp3
            </div>
            <div class="form-group">
                <label for="selectMp3">Vos fichiers</label>
                &nbsp;&nbsp;
                <span class="badge badge-light" id="nbmp3"><?php echo count($list_files); ?></span>

                <select class="form-control" id="selectMp3">
                    <option value=''>-- MP3 disponibles --</option>
                    <?php foreach ($list_files as $file) : ?>
                        <option value='<?php echo $file; ?>'><?php echo $file; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="dropzone">Uploader un fichier :</label>
                <div class="dropzone margin-bottom-10 col-md-12" id="dropzone">
                </div>
                <button type="button" id="valid-upload" class="btn btn-success margin-bottom-10"><i class="fas fa-handshake"></i>&nbsp; Envoyer </button>
            </div>
            <input type="hidden" name="lien_mp3" id="lien_mp3" value="" />
        </div>
    </div>

    <?php
    echo '<div class="row">';
    echo '<div class="col-md-12 text-center">';
    echo form_submit('submit', 'Créer', ['class' => 'btn btn-danger', 'style' => 'width:100%']);
    echo '</div>';
    echo '</div>';
    ?>
</div>
<script>
    Dropzone.autoDiscover = false;
    $(document).ready(function() {
        $('[name=tags]').tagify();
        $("#mp3player").hide();
        $("#selectMp3").change(function(e) {
            $("#lien_mp3").val($(this).val());
            if ($(this).val()) {
                console.log($("#mp3source").data("path") + "/" + $(this).val());
                $("#mp3player").attr("src", $("#mp3source").data("path") + "/" + $(this).val()).show();
            } else {
                $("#mp3player").hide();
            }
        });
        var myDropzone = new Dropzone("div#dropzone", {
            url: "/myuploads/file_upload_no_flashdata",
            paramName: "file", //name that will be used to transfer the file
            acceptedFiles: "audio/mpeg",
            maxFilesize: 512,
            addRemoveLinks: true,
            maxFiles: 1,
            autoProcessQueue: false,
            dictRemoveFile: "Supprimer",
            parallelUploads: 1,
            dictDefaultMessage: "Sélectionner votre fichier mp3 (512 Mo max)",
            dictInvalidFileType: "Fichier MP3 seulement",
            dictFileTooBig: "512 Mo maximum",
            init: function() {
                var startUpload = document.getElementById("valid-upload");
                myDropzone = this;
                startUpload.addEventListener("click", function() {
                    myDropzone.processQueue();
                });
                this.on("processing", function(file) {
                    $(".dz-remove").html("");
                });
                this.on("success", function(file) {
                    myDropzone.removeFile(file);
                    $("#selectMp3").append($('<option>').val(file.name).text(file.name)).trigger("change");
                    $("#nbmp3").html(parseInt($("#nbmp3").html()) + 1);
                });
            }
        });
        $(".valid-upload").click(function(e) {
            myDropzone.processQueue();
        });

    });
</script>