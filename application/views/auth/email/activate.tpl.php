<html>
<body>
	<p>Bonjour, </p>
	<p>Vous recevez ce mail parce que nous avons reçu une inscription pour votre adresse mail sur notre site BadGeek. </p>
	<p> Pour finir votre inscription, merci d'activer votre compte en cliquant sur ce lien  : 
		<?php echo anchor('auth/activate/'. $id .'/'. $activation, lang('email_activate_link'))?>
	</p>
	<p> Si vous n'avez pas effectué d'inscription sur badgeek.fr, merci d'ignorer ce mail.</p>
	<p> Cordialement, </p>
	<p> L'équipe de BadGeek.</p>
</body>
</html>