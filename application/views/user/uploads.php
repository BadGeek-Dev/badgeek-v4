<link rel="stylesheet" href="<?php echo base_url('assets/node_modules/bootstrap4c-dropzone/dist/css/component-dropzone.min.css'); ?>">
<script src="<?php echo base_url('assets/node_modules/dropzone/dist/dropzone.js'); ?>"></script>
<div class="container">
    <div class="dropzone margin-bottom-10 col-md-12" id="dropzone">
    </div>
    <button type="button" id="valid-upload" class="btn btn-success margin-bottom-10"><i class="fas fa-handshake"></i>&nbsp; Envoyer </button>
    <div class="col-md-12">
        <ul class="list-group">
            <li class="list-group-item active">Vos fichiers en attente</li>
            <?php
            if (empty($liste_files)) {
            ?>
                <li class="list-group-item text-dark">Rien. Que dalle ! Nada.</li>
                <?php
            } else {
                foreach ($liste_files as $file) : ?>
                    <li class="list-group-item text-dark">
                        <div class='container'>
                            <div class="row">
                                <div class="col-sm-4">
                                    <i class="far fa-file-audio" style="font-size:25px"></i>&nbsp;
                                    <?php echo $file["caption"]; ?> - <?php echo $file["size"]; ?>
                                </div>
                                <div class="col-sm-6">
                                    <audio controls style="width:100%">
                                        <source src="<?php echo base_url($file["path"]); ?>" type="audio/mpeg">>
                                    </audio>
                                </div>
                                <div class="col-sm-2">
                                    <button type="button" class="btn btn-danger delete-file" data-path="<?php echo $file["path"]; ?>"> <i class="fas fa-trash"></i>&nbsp; Supprimer </button>
                                </div>
                            </div>
                        </div>
                    </li>
            <?php
                endforeach;
            } ?>
        </ul>
    </div>
</div>
<script>
    Dropzone.autoDiscover = false;
    $(document).ready(function() {
        var myDropzone = new Dropzone("div#dropzone", {
            url: "/myuploads/file_upload",
            paramName: "file", //name that will be used to transfer the file
            acceptedFiles: "audio/mpeg",
            maxFilesize: 512,
            addRemoveLinks: true,
            multiple: true,
            autoProcessQueue: false,
            dictRemoveFile: "<div><i class='fas fa-trash'></i>&nbsp;Supprimer</div>",
            parallelUploads: 1,
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
                    if (myDropzone.getQueuedFiles().length == 0) {
                        location.reload();
                    } else {
                        myDropzone.options.autoProcessQueue = true;
                    }
                });
            }
        });
        $(".delete-file").click(function(e) {
            if (confirm("Êtes vous sûr de vouloir supprimer ce fichier ?")) {

                $.ajax({
                    type: "POST",
                    url: ajaxUrl + "/myuploads/delete",
                    data: {
                        "path": $(this).data("path")
                    },
                    dataType: "JSON",
                    success: function(data) {
                        location.reload();
                    },
                });
            }
        });
        $(".valid-upload").click(function(e) {
            myDropzone.processQueue();
        });

    });
</script>