<h1>PODCASTEUR LISTE</h1>
<table class="table_admin">
    <thead>
    <tr class="text-center">
        <th>Titre</th>
        <th>Description</th>
        <th >Nombre Episode</th>
        <th>Tags</th>
		<th>Statut</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php

    foreach ($podcasts as $podcast) {
        echo "<tr>";
        echo '<td> '.$podcast->titre.'</td>';
        echo '<td> '.substr($podcast->description,0,40);
        if(strlen($podcast->description)>40) echo '...';
        echo '</td>';
        echo '<td>Nombre EP</td>';
        echo '<td> '.$podcast->tags.' </td>';
        echo '<td>';
        switch ($podcast->valid){
            case 0 :
                echo 'En Attente';
                break;
            case 1 :
                echo 'Validé';
                break;
            case 2 :
                echo 'Refusé';
                break;
        }
        echo '</td>';
        echo '<td>    <a href="'.site_url("podcasts/edit/".$podcast->id).'" class="btn btn-primary margin-right-10">Editer le Podcast</a> 
                      <a href="'.site_url("episodes/create/".$podcast->id).'" class="btn btn-success margin-right-10">Ajouter un épisode</a>
                <a href="'.site_url("podcasts/delete/".$podcast->id).'" onclick="return confirm(\'Supprimer'.$podcast->titre.' ? cette action est définitive.\')" class="btn btn-danger margin-right-10">SUPPRIMER</a>';
        echo "<tr/>";
    }
    ?>
    </tbody>
</table>
<br/>
<?php if (isPodcasteur()) : ?>
    <a href="<?= site_url("podcasts/create") ?>" class="btn btn-danger margin-right-10">Ajouter un podcast</a>
<?php endif; ?>
