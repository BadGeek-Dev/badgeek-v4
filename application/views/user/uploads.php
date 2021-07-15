<link rel="stylesheet" href="<?php echo base_url('assets/node_modules/bootstrap4c-dropzone/dist/css/component-dropzone.min.css'); ?>">
<script src="<?php echo base_url('assets/node_modules/dropzone/dist/dropzone.js'); ?>"></script>
<div class="container">
    <div class="dropzone margin-bottom-10 col-md-12" id="dropzone">
    </div>
    <div class="col-md-12" >
        <ul class="list-group">
            <li class="list-group-item active">Vos fichiers en attente</li>
            <?php foreach ($liste_files as $file) : ?>
                <li class="list-group-item text-dark"><i class="far fa-file-audio"></i>
                    &nbsp;<?php echo $file["caption"]; ?> - <?php echo $file["size"]; ?>
                    <audio controls>
                        <source src="<?php echo base_url($file["path"]); ?>" type="audio/mpeg">>
                    </audio>
                    <button type="button" class="btn btn-danger delete-file" data-path="<?php echo $file["path"]; ?>"> <i class="fas fa-trash"></i>&nbsp; Supprimer </button>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
<script>
    Dropzone.autoDiscover = false;
    $(document).ready(function() {
        $("#dropzone").dropzone({
            url: "/uploads/upload",
            paramName: "file", //name that will be used to transfer the file
            acceptedFiles: "audio/mpeg",
        });
        $(".delete-file").click(function (e) { 
            $.ajax({
                type: "POST",
                url: ajaxUrl + "/uploads/delete",
                data: {"path" :  $(this).data("path")},
                dataType: "JSON"
            });
        });
        
    });
</script>