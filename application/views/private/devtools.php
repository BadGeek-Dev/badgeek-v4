<a href="<?php echo site_url("devtools/dump")?>" class="btn btn-info margin-right-10">Créer un dump</a> 
&nbsp;
<a href="<?php echo site_url("devtools/raz")?>" class="btn btn-info margin-right-10">Sauvegarder et restaurer la BDD initiale</a>
&nbsp;
<a href="<?php echo site_url("devtools/greatreset")?>" class="btn btn-danger margin-right-10">Sauvegarder et restaurer la BDD initiale + Passer les migrations</a>

<br/>
<br/>
<div> Dumps : </div>
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
<div> Migration : <?php echo $migration_courante;?></div>
<div class="alert alert-info" role="alert">
    <table class='table'>
        <thead>
        <th scope="col">Version</th>
        <th scope="col">Nom</th>
        <th scope="col">Actions</th>
        </thead>
        <tbody>
        <?php 
            foreach($migrations as $version => $migration_path){
                $migration_file = explode("/",$migration_path);
                $migration_filename = end($migration_file);
                echo "
                <tr class='".($version <= $migration_courante ? "bg-success" : "bg-danger")."'>
                    <td scope='row'>".$version."</td>
                    <td>".substr($migration_filename, strlen($version) + 1,-4)."</td>
                    <td>
                        <a href='".site_url("devtools/migration/up/$version")."' class='btn btn-info margin-right-10 margin-bottom-10'>Passer la migration</a>
                        &nbsp;<a href='".site_url("devtools/migration/down/$version")."' class='btn btn-danger margin-right-10 margin-bottom-10'>Annuler la migration</a>
                    </td>
                </tr>";
            }
        ?>
        </tbody>
    </table>
</div>
