<div class="container">
<a href=<?= base_url("/lives/requestlive"); ?> class="btn btn-success">
    <i class="fas fa-edit"></i>&nbsp;Créer une nouvelle demande
</a>
<br> <br>
<table class="table table-striped  text-center table_admin">
    <thead class="bg-danger text-light">
    <tr>
        <th scope="col">Date Demande</th>
        <th scope="col">Titre</th>
        <th scope="col">Date Live</th>
        <th scope="col">Statut</th>
        <th scope="col">Actions</th>
    </tr>
    </thead>
    <tbody>
<?php foreach ($result as $live) {?>
    <tr>
        <td><?php echo $live->created_at;?></td>
        <td><?php echo $live->title;?></td>
        <td><?php echo $live->start_at;?></td>
        <?php  switch($live->status){
                case 0 :
                    echo "<td class='font-weight-bold text-danger'>LIVE REFUSE</td>";
                    break;
                case 1 :
                    echo "<td class ='font-weight-bold text-warning'>LIVE DEMANDE</td>";
                    break;
                case 2 :
                    echo "<td class='font-weight-bold text-success'>LIVE AUTORISE</td>";
                    break;
            default :
                echo "<td>Pas de demande en cours</td>";
            }?>
        <td><a href=<?= base_url("/lives/editlive/" . $live->id); ?> class="btn btn-success">
            <i class="fas fa-edit"></i></a></td>
    </tr>
    <?php } ?>
    </tbody>
</table>
</div>