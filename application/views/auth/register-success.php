<?php echo validation_errors(); ?>

<?php echo form_open('form', array("class" => "form-horizontal")); ?>

<div class="form-group">
  <label for="email">Email : </label>
  <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelpId" placeholder="Votre email">
  <small id="emailHelpId" class="form-text text-muted">Il s'agira également de votre identificant sur le site</small>
</div>
<div class="form-group">
  <label for="password">Mot de passe :</label>
  <input type="password" class="form-control" name="password" id="password" placeholder="Votre mot de passe">
</div>
<div class="form-group">
  <label for="password_confirmation">Confirmation du mot de passe :</label>
  <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Votre mot de passe">
</div>
<button type="submit" class="btn btn-primary">Je m'inscris.</button>