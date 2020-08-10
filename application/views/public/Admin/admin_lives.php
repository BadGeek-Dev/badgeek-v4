<div class="container">
    <table class="table table-striped  text-center table_admin">
        <thead class="bg-danger text-light">
        <tr>
            <th scope="col">Date Demande</th>
            <th scope="col">Titre</th>
            <th scope="col">Date </th>
            <th scope="col">Statut</th>
            <th scope="col">Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($result as $live) { ?>
                <td><?php echo substr($live->created_at,0,10);?></td>
                <td><?php echo $live->title; ?></td>
                <td><?php echo substr($live->start_at,0,10); ?></td>
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
                <td><a href="<?= base_url("admin/lives/view/" . $live->id)?>" class="btn btn-info"><i class="fas fa-eye"></i></a>

                 <?php switch($live->status) {

                     case 0:
                         ?> <a href="<?= base_url("admin/lives/accept/" .$live->id)?>" class="btn btn-success"><i class="fas fa-check"></i></a> <?php
                         break;
                     case 1:
                         ?> <a href="<?= base_url("admin/lives/accept/" . $live->id)?>" class="btn btn-success"><i class="fas fa-check"></i></a>
                    <a href="<?= base_url("admin/lives/refuse/" . $live->id)?>" class="btn btn-danger"><i class="fas fa-times"></i></a><?php
                         break;
                     case 2:
                         ?><a href="<?= base_url("admin/lives/refuse/" . $live->id)?>" class="btn btn-danger"><i class="fas fa-times"></i></a><?php
                         break;
                     default :
                         break;
                 }
                 ?>
                   </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>