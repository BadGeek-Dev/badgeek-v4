<table class="table table-striped  text-center table_podcasteur" id="table_podcasteur">
		<thead>
			<tr class="text-center">
				<th scope="col">Titre</th>
				<th scope="col">Description</th>
				<th scope="col">Nombre Episodes</th>
				<th scope="col">Tags</th>
				<th scope="col">Statut</th>
				<th scope="col" class="noorder">Actions</th>
			</tr>
		</thead>
		<tbody>
		<?php
		foreach ($podcasts as $podcast) : ?>
			<tr>
			<td> <?=$podcast->titre; ?></td>
			<td><?php echo substr($podcast->description, 0, 40);
			if (strlen($podcast->description) > 40) echo '...'; ?></td>
			<td><?= $podcast->nombreEpisodes; ?></td>
			<td> <input class='tags' readonly value="<?php echo $podcast->tags_value; ?>"/></td>
			<td> <?php echo $podcast->badge_statut; ?></td>
			<td> <a href="<?=site_url("podcasts/edit/" . $podcast->id);?>" class="btn btn-primary margin-right-10">Editer le Podcast</a>
                      <a href="<?=site_url("episodes/create/" . $podcast->id);?>" class="btn btn-success margin-right-10">Ajouter un épisode</a>
                <a href="<?=site_url("podcasts/delete/" . $podcast->id); ?>" onclick="return confirm(<?='Supprimer' . $podcast->titre . ' ? cette action est définitive.';?>)" class="btn btn-danger margin-right-10">SUPPRIMER</a>
			</td>
		</tr>
		<?php endforeach; ?>
		</tbody>
</table>

<br/>
<?php if (isPodcasteur()) : ?>
	<a href="<?= site_url("podcasts/create") ?>" class="btn btn-danger margin-right-10">Ajouter un podcast</a>
<?php endif; ?>
<script>
$(document).ready(function () {
	
	$("#table_podcasteur").DataTable({
		"language": {
			url: '/assets/node_modules/datatables.net/languages/fr_fr.json'
		}
		
	});
	$('.tags').tagify();
	$(".tags").css("border", "0px");
	$("tag").css("background-color", "white");

	
});
</script>
