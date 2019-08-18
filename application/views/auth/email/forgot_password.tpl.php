<html>

<body>
	<p>Bonjour, </p>
	<p>Vous recevez ce mail parce que nous avons reçu une demande de réinitialisaiton de mot de passe pour votre adresse mail sur notre site BadGeek. </p>
	<p> Pour finir votre changement de mot de passe, merci de cliquer sur ce lien :
		<?php echo anchor('auth/reset_password/' . $forgotten_password_code, lang('email_forgot_password_link')) ?>
	</p>
	<p> Si vous n'avez pas effectué de demande sur badgeek.fr, merci d'ignorer ce mail.</p>
	<p> Cordialement, </p>
	<p> L'équipe de BadGeek.</p>
</body>

</html>