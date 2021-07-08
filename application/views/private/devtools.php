<a href="<?php echo site_url("devtools/dump")?>" class="btn btn-info margin-right-10">Créer un dump</a> 
&nbsp;
<a href="<?php echo site_url("devtools/raz")?>" class="btn btn-info margin-right-10">Sauvegarder et restaurer la BDD initiale</a>
<br/>
<br/>
Dumps : 
<div class="alert alert-info" role="alert">
    <ul>
    <?php foreach($dumps as $dump): ?>
        <li>
            <? echo $dump; ?> 
            <a href="<?php echo site_url("devtools/forcedownload/$dump")?>" class="btn btn-secondary margin-right-10 margin-bottom-10">Télécharger</a>
            <a href="<?php echo site_url("devtools/importdump/$dump")?>" class="btn btn-info margin-right-10 margin-bottom-10">Restaurer</a>
            <a href="<?php echo site_url("devtools/deletedump/$dump")?>" class="btn btn-danger margin-right-10 margin-bottom-10">Supprimer</a>
        </li>
    <?php endforeach; ?>
    </ul>
    
</div>
