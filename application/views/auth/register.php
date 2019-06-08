<div class='text-center'>
    <h3> Vous voulez nous rejoindre ? Quelle bonne idée !  </h3>

    <?php echo validation_errors(); ?>

    <div class="container margin-top-30">
        <div class="row">
            <div class="col-md-6">
                <button type="button" class="btn btn-primary btn-lg btn-block"><i class='icon-headphones-1'></i>&nbsp;&nbsp;Je suis une poditrice ou un poditeur</button>
            </div>
            <div class="col-md-6">
                <button type="button" class="btn btn-primary btn-lg btn-block"><i class='icon-mic'></i>&nbsp;&nbsp;Je suis une podcastrice ou un podcasteur.</button>
            </div>
        </div>
    </div>

    <div class='container margin-top-10 padding-10' style='border:1px red solid;' hidden>
        <?php echo form_open('form'); ?>
        <div class="form-group row">
            <label for="email" class="col-md-3 col-form-label text-right">Email : </label>
            <div class="col-md-9">
                <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelpId" placeholder="Votre email">
                <small>Il s'agira également de votre identifiant sur le site</small>
            </div>
        </div>
        <div class="form-group row">
            <label for="password" class="col-md-3 col-form-label text-right">Mot de passe :</label>
            <div class="col-md-9">
                <input type="password" class="form-control" name="password" id="password" placeholder="Votre mot de passe">
            </div>
        </div>
        <div class="form-group row">
            <label for="password_confirmation" class="col-md-3 col-form-label text-right">Confirmation du mot de passe :</label>
            <div class="col-md-9">
                <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Votre mot de passe">
            </div>
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-primary">Je m'inscris</button>
        </div>
    </div>
</div>