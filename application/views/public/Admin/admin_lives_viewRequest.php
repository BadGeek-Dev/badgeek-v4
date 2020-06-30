<div class="container">
    <p> Demande de : <?php echo $result->username;?></p>

    <p> Titre du Live : <?php echo $result->title;?></p>

    <p> Date de début de Live : <?php echo $result->start_at;?></p>

    <p> Decriptif : <?php echo $result->content;?></p>

    <a href="<?= base_url("admin/lives/accept/" . $result->id)?>" class="btn btn-success"> <i class="fas fa-check"></i> Autoriser</a>
    <a href="<?= base_url("admin/lives/refuse/" . $result->id)?>" class ="btn btn-danger"> <i class="fas fa-times"></i> Refuser</a>

</div>
