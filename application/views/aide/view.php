<div class="accordion" id="accordionExample">
	<div class="card">
	<?php foreach ($result as $item) { ?>
		<div class="card-header" id="heading<?=$item->id?>">
			<h2 class="mb-0">
				<button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse<?=$item->id?>" aria-expanded="true" aria-controls="collapse<?=$item->id?>">
					<?=$item->title?>
				</button>
			</h2>
		</div>
		<div id="collapse<?=$item->id?>" class="collapse" aria-labelledby="heading<?=$item->id?>" data-parent="#accordionExample">
			<div class="card-body bg-dark">
				<?=$item->content?>
			</div>
		</div>
<?php
	}
?>

	</div>

</div>






