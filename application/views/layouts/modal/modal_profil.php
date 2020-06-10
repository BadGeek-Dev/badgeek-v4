<div class="modal fade modal-black" id="profilModal" tabindex="-1" role="dialog" aria-labelledby="profilModal" aria-hidden="true">
    <!-- some CSS styling changes and overrides -->
    <style>
    .fileinput-upload-button
    {
        position:relative;
        top:-30px;
        width:90%;
    } 

    .centered {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    }

    .filter-brightness-50
    {
        filter: brightness(50%);
    }

    #default_preview_avatar, .file-preview-image
    {
        width:190px !important;
        height:190px !important;
    }
    .kv-file-content
    {
        height:auto !important;
        padding-top: 10px;
    }
    .file-preview-frame
    {
        margin: 0px!important;
        padding: 0px !important;
        width:96%;
        left:2%;
    }
    .file-preview
    {
        box-shadow : 0 0 0 0 !important;
    }
    .file-thumbnail-footer
    {
        min-height:80px !important;
    }
    .file-drop-zone
    {
        border:2px dashed #999;
        margin: 0px !important;
        padding: 3px !important;
        box-shadow : 0 0 0px 0 rgba(0,0,0,.2) !important;
    }

    .file-drop-zone img
    {
        cursor:pointer;
    }
    .kv-avatar-hint
    {
        height:50px;
    }
    .file-footer-caption
    {
        margin-bottom:10px !important;
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
                allowedFileExtensions: ["jpg", "png", "jpeg"],
                browseOnZoneClick: true,
                showClose: false,
                showCaption: false,
                showBrowse: false,
                showRemove:false,
                showUpload:false,
                defaultPreviewContent: '<div>\
                                            <img id="default_preview_avatar" src="'+ $("#avatar").attr("src") +"?lastmod="+Date.now() + '" alt="Your Avatar" class="margin-top-10">\
                                            <div class="centered cache text-white" id="avatar_edit_hover_text" style="display: none;">Choisir un fichier</div>\
                                        </div>\
                                        <div class="kv-avatar-hint text-center margin-top-10">\
                                            <small>Taille maximum : 500 KB</small><br/>\
                                            <small>Extensions : jpg et png </small>\
                                        </div>',
                layoutTemplates: {
                    actions : '<button class="kv-file-upload btn btn-primary btn-sm">Envoyer</button>', 
                    preview: '    <div class="file-preview-thumbnails clearfix {dropClass}">\n' +
                        '</div>', 
            },
            
            
            });

            $('#profilAvatarInput').on('fileimageloaded', function(event, data, message) {
                console.log($(".file-preview-image"));
                $(".file-preview-image").click(function(){
                    $($("input[type='file']")).data('zoneClicked', true).trigger("click");
                });
            });
            $('#profilAvatarInput').on('fileuploaderror', function(event, data, message) {
                $(this).fileinput("reset");
                $("#default_preview_avatar").attr("src", $("#avatar").attr("src")+"?lastmod="+Date.now());
                $("#profil-ko-message").html(message + "&nbsp;&nbsp;<button type='button' class='close' onclick='hideId(\"profil-ko-message\", 200)' aria-label='Close'>\
                    <span aria-hidden='true'>×</span>\
                    </button>").show();
                throw new Error("Avatar non conforme");
            });

            $('#profilAvatarInput').on('change', function(event) {
                $("#profil-ko-message").html("").hide();
            });

            $('#profilAvatarInput').on('fileuploaded', function(event, data, previewId, index) {
                
                $("#avatar").attr("src", data.response.message+"?lastmod="+Date.now());
                $(this).fileinput("reset");
                $("#default_preview_avatar").attr("src", data.response.message+"?lastmod="+Date.now());
                showAvatar();
            });

            
            
            if($("#avatar").attr("src") == "")
            {
                showInputAvatar(0,0);
            }
            else
            {
                showAvatar(0,0);
                $("#avatar_edit_go_back").show();
            }

            $(".avatar_container").click(function(){
                showInputAvatar(500,500);
            });
            
            $("#avatar_edit_go_back").click(function(){
                resetModalProfil(500,0);
            });

            $(".avatar_container").hover( 
                function()
                {
                    $("#avatar").addClass("filter-brightness-50");
                    $("#avatar_hover_text").show();
                },
                function()
                {
                    $("#avatar").removeClass("filter-brightness-50");
                    $("#avatar_hover_text").hide();
                }
            );
            $(".kv-avatar").hover( 
                function()
                {
                    $("#default_preview_avatar").addClass("filter-brightness-50");
                    $("#avatar_edit_hover_text").show();
                },
                function()
                {
                    $("#default_preview_avatar").removeClass("filter-brightness-50");
                    $("#avatar_edit_hover_text").hide();
                }
            );
            
        });

        function showAvatar(hide, show) { 
            $("#avatar_edit").hide(hide);
            $("#avatar_show").show(show);
        }

        function showInputAvatar(hide, show) { 
            $("#avatar_show").hide(hide);
            $("#avatar_edit").show(show);
            $("#default_preview_avatar").attr("src", $("#avatar").attr("src")+"?lastmod="+Date.now());
        }

        function hideId(id, hide)
        {
            $("#" + id).hide(hide);
        }

        function resetAvatarEdit()
        {
            $("#profilAvatarInput").fileinput("reset");
        }

        function resetMessageErreur(transition_time)
        {
            $("#profil-ko-message").html("").hide(transition_time);
        }

        function resetModalProfil(transition_time)
        {
            resetAvatarEdit();
            showAvatar(transition_time, transition_time);
            resetMessageErreur(transition_time);
            
        }

        
    </script>


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
                    <div class="col-sm-4 text-center border-right">
                        <div class="cache avatar_container" id="avatar_show">
                            <div class="font-weight-bold margin-bottom-10"> Avatar</div>
                            <img id="avatar" class="avatar" src="<?=base_url($this->user->avatar ?:'assets/pictures/avatars/avatar.png')?>"/>
                            <div class="centered cache text-white" id="avatar_hover_text">Cliquer pour modifier l'avatar</div>
                        </div>
                        <div class="margin-auto kv-div cache" id="avatar_edit">
                            
                        <div class="margin-bottom-10"> Changer mon avatar</div>
                            <div class="kv-avatar">
                                <div class="file-loading">
                                    <input id="profilAvatarInput" type="file">
                                </div>
                                <button class="btn btn-dark cache margin-top-10" id="avatar_edit_go_back"><i class='icon-undo'></i>Annuler </button> 
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-8 text-center">
                        <div class="font-weight-bold margin-bottom-10"> Informations de profil</div>
                        <form id="profil-form">
                            <input type="hidden" name="id" value="<?=$this->user->id?>">
                            <div class="form-group row ">
                                <label for="identity" class="col-md-4 col-form-label text-right"><i class='icon-mail' data-toggle="tooltip"></i>&nbsp;Email : </label>
                                <div class="col-md-6 text-left padding-5">
                                    <input type="hidden" class="form-control" name="email" id="profil-form-email" aria-describedby="emailHelpId" placeholder="Votre email" value="<?=$this->user->email?>">
                                    <?=$this->user->email?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="identity" class="col-md-4 col-form-label text-right"><i class='icon-user' data-toggle="tooltip"></i>&nbsp;Login : </label>
                                <div class="col-md-6">
                                    <input class="form-control" name="user" id="profil-form-user" aria-describedby="userHelId" placeholder="" value="<?= $this->user->username == $this->user->email ? "": $this->user->username?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="identity" class="col-md-4 col-form-label text-right"><i class='icon-edit' data-toggle="tooltip"></i>&nbsp;Status : </label>
                                <div class="col-md-6 text-left">
                                    <? foreach($this->groups as $group):?>
                                        <div class="form-check" >
                                            <input 
                                                class="form-check-input" 
                                                type="checkbox" value="<?=$group["id"]?>" 
                                                name="group_<?=$group["id"]?>" <?= in_array($group["id"], $this->user->groups_id) ? "checked=\"checked\"" : ""?>
                                                <?= ($group["id"] == 3 && count($this->user_podcasts)) ? "disabled=disabled" : "" ?>>
                                            <label class="form-check-label" for="group_<?=$group["id"]?>">
                                                <?=$group["description"]?>
                                            </label>
                                        </div>
                                    <? endforeach; ?>
                                </div>
                            </div>
                            <input type="hidden" name="sid" class='sid' id="profil-form-sid" value="<?= $sid ?>" />
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id='profil-submit-button'><i class='icon-edit'></i>Mettre à jour mon profil</button>
            </div>
        </div>
    </div>
</div>

