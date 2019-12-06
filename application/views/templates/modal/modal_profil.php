<div class="modal fade modal-black" id="profilModal" tabindex="-1" role="dialog" aria-labelledby="profilModal" aria-hidden="true">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Votre profil sur Badgeek</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger" role="alert" id="profil-ko-message" style="display:none">
                </div>
                <div class="alert alert-success d-none" role="alert" id="profil-ok-message">
                </div>
                <div class="row">
                    <div class="col-sm-4 text-center">
                        <div class="margin-auto kv-div">
                            <div class="kv-avatar">
                                <div class="file-loading">
                                    <input id="profilAvatarInput" type="file">
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id='profil-submit-button'><i class='icon-edit'></i>Mettre à jour mon profil</button>
            </div>
        </div>
    </div>
</div>
<!-- some CSS styling changes and overrides -->
<style>

.kv-avatar .krajee-default.file-preview-frame,.kv-avatar .krajee-default.file-preview-frame:hover {
    margin: 0;
    padding: 0;
    border: none;
    box-shadow: none;
    text-align: center;
}
.kv-avatar {
    display: inline-block;
    margin: auto;
}
.kv-avatar .file-input {
    display: table-cell;
}
.kv-reqd {
    color: red;
    font-family: monospace;
    font-weight: normal;
}
.file-preview 
{
    height:auto;
    width:220px;
}
.file-drop-zone
{
    margin : 0 !important;
    border : 0px;
}
.krajee-default.file-preview-frame .kv-file-content
{
    height: 180px;
    width: 180px;
}
.file-drop-zone .file-preview-thumbnails
{
    height:230px;
}
.krajee-default .file-footer-caption
{
    background-color: lightgray;
    margin-bottom: 0px;
}

</style>
<script>
    $(document).ready(function () {
        $("#profilAvatarInput").fileinput({
            overwriteInitial: true,
            uploadUrl: '<?=base_url('index.php/Auth/uploadAvatar')?>',
            maxFileCount:1,
            maxFileSize: 500,
            language:'fr',
            theme:'fas',
            autoReplace: true,
            allowedFileExtensions: ["jpg", "png"],
            browseOnZoneClick: true,
            showClose: false,
            showCaption: false,
            showBrowse: false,
            elErrorContainer: '#profil-ko-message',
            msgErrorClass: 'alert alert-block alert-danger',
            defaultPreviewContent: '<h3> Avatar</h3><img src="<?=base_url('assets/pictures/avatar.png')?>" alt="Your Avatar"><div class="kv-avatar-hint">\
                                <small>Taille maximum : 500 KB</small><br/>\
                                <small>Seuls les fichiers jpg et les png sont acceptés.</small>\
                            </div>',
            layoutTemplates: {
                actions: '', 
                preview: '<div class="file-preview {class} clickable">\n' +
        '    <div class="{dropClass}">\n' +
        '    <div class="file-preview-thumbnails ">\n' +
        '    </div>\n' +
        '</div></div>',
            }

        });
    });
</script>