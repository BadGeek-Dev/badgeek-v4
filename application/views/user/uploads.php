<div class="file-loading">
    <input id="input-ke-2" name="input-ke-2[]" type="file" multiple>
</div>
<script>
$("#input-ke-2").fileinput({
    theme: "explorer",
    allowedFileExtensions : ['mp3'],
    allowedPreviewTypes : ['audio'],
    uploadUrl: "<?=base_url('index.php/uploads/upload')?>",
    minFileCount: 2,
    maxFileCount: 5,
    maxFileSize: 10000,
    removeFromPreviewOnError: true,
    overwriteInitial: false,
    previewFileIcon: '<i class="fas fa-file"></i>',
    initialPreview: [
      <?php foreach($liste_files as $file) {
          echo "'".$file['url']."',";
      }?>
    ],
    initialPreviewAsData: true, // defaults markup  
    initialPreviewConfig: [
        <?php 
            foreach($liste_files as $key => $file) {
                echo '{type : "audio" , caption: "'.$file["caption"].'" , size: '.$file["size"].' , downloadUrl: "'.$file["url"].'", key: ' . $file["key"].'}';
            }
        ?>
    ],
   
    preferIconicPreview: true, // this will force thumbnails to display icons for following file extensions
         previewFileIconSettings: { // configure your icon file extensions
        'mp3': '<i class="fas fa-file-audio text-warning"></i>',
    },
    previewFileExtSettings: { // configure the logic for determining icon file extensions
       
        'mp3': function(ext) {
            return ext.match(/(mp3|wav)$/i);
        }
    }
});
</script>