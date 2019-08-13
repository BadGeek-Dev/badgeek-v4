<script src="<?php echo base_url("assets/js/register.js") ?>"></script>
<div class='text-center'>
    <h3> Vous voulez nous rejoindre ? Quelle bonne idée ! </h3>

   <!--  
    <div class="container margin-top-30">
        <div class="row">
            <div class="col-md-6">
                <button type="button" class="btn btn-primary btn-lg btn-block" id='inscription-poditeur-start'><i class='icon-headphones-1'></i>&nbsp;&nbsp;Je suis une poditrice ou un poditeur</button>
            </div>
            <div class="col-md-6">
                <button type="button" class="btn btn-primary btn-lg btn-block" id='inscription-podcasteur-start'><i class='icon-mic'></i>&nbsp;&nbsp;Je suis une podcastrice ou un podcasteur.</button>
            </div>
        </div>
    </div> 
    <div class='container margin-top-10 padding-10 collapse white-border' id='inscription-poditeur-form'>
        <div id='carousel-poditeur' class='carousel slide' data-ride="carousel" data-interval="false">
            <div class="carousel-inner">
                <div class="carrousel-item">
                </div>
                <div class="carousel-item">
                    TUTUT
                    <button type="button" class="btn btn-primary" data-target="#carousel-poditeur" data-slide-to="0"><< Revenir</button>
                </div>
            </div>
            <div>
                <ul class="carousel-indicators">
                    <li id='inscription-poditeur-e0' class="active"></li>
                    <li id='inscription-poditeur-e1'></li>
                </ul>
            </div>
        </div>
    </div>
-->

    <?php echo validation_errors(); ?>
    <?php echo form_open('auth/register_validation'); ?>
    <input type='hidden' name='groupe' value='poditeur' />
    <div class="form-group row">
        <div class="col-md-12 text-center lead"> <u>Vos informations de connexion </u></div>
    </div>
    <div class="form-group row">
        <label for="email" class="col-md-4 col-form-label text-right"><i class='icon-mail' data-toggle="tooltip"></i>&nbsp;Email * : </label>
        <div class="col-md-4">
            <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelpId" placeholder="Votre email" value="<?=$email?>">
        </div>
    </div>
    <div class="form-group row">
        <label for="password" class="col-md-4 col-form-label text-right"><i class='icon-key' data-toggle="tooltip"></i>&nbsp;Mot de passe * :</label>
        <div class="col-md-4">
            <input type="password" class="form-control" name="password" id="password" placeholder="Votre mot de passe">
        </div>
    </div>
    <div class="form-group row">
        <label for="password_confirmation" class="col-md-4 col-form-label text-right"><i class='icon-key' data-toggle="tooltip"></i>&nbsp;Confirmation du mot de passe * :</label>
        <div class="col-md-4">
            <input type="password" class="form-control" name="password_confirm" id="password_confirmation" placeholder="Votre mot de passe">
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-4"></div>
        <div class="col-md-4 text-left">
            <input type="submit" class="btn btn-primary" value="Créer le profil et passer à l'étape suivante >>"/>
        </div>
    </div>
    <?php echo form_close();?>

    