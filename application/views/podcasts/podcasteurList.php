<table class="table table-striped  text-center table_podcasteur">
		<thead>
		<tr class="text-center">
			<th scope="col">Titre</th>
			<th scope="col">Description</th>
			<th scope="col">Nombre Episodes</th>
			<th scope="col">Tags</th>
			<th scope="col">Statut</th>
			<th scope="col">Actions</th>
			<th scope="col" class="noorder"></th>
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
			<td> <?= $podcast->tags; ?></td>
			<td><?php
			switch ($podcast->valid) {
				case 0 :
					echo 'En Attente';
					break;
				case 1 :
					echo 'Validé';
					break;
				case 2 :
					echo 'Refusé';
					break;
			} ?></td>
			<td> <a href="<?=site_url("podcasts/edit/" . $podcast->id);?>" class="btn btn-primary margin-right-10">Editer le Podcast</a>
                      <a href="<?=site_url("episodes/create/" . $podcast->id);?>" class="btn btn-success margin-right-10">Ajouter un épisode</a>
                <a href="<?=site_url("podcasts/delete/" . $podcast->id); ?>" onclick="return confirm(<?='Supprimer' . $podcast->titre . ' ? cette action est définitive.';?>)" class="btn btn-danger margin-right-10">SUPPRIMER</a>
			</td>
		<tr/>
		<?php endforeach; ?>
		</tbody>
</table>

<br/>
<?php if (isPodcasteur()) : ?>
	<a href="<?= site_url("podcasts/create") ?>" class="btn btn-danger margin-right-10">Ajouter un podcast</a>
<?php endif; ?>
<script>
	$(".table_podcasteur table").DataTable({
		"language": {
			url: '/assets/node_modules/datatables.net/languages/fr_fr.json'
		},
		"columnDefs": [
			{
				"targets": 'nosort',
				"orderable": false
			}
		]
	})
</script>
