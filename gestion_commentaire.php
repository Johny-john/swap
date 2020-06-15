<?php

require_once __DIR__ . '/../assets/config/bootstrap_admin.php';




// Affichage

$page_title = "Gestion membres";

include __DIR__ . '/../assets/includes/header_admin.php';

if (isset($_POST['del'])) {
    unset($_POST['del']);
    ajouterFlash('danger', 'Le commentaire est bien supprimée !');
  }
?>


<div class="border col-md-12">

<h1 style="text-align:center;">Gestion commentaires</h1>

<?php include __DIR__ .'/../assets/includes/flash.php';?>

<div style="overflow:scroll;">
        
   
        <?php
     

    
       $result = $pdo->query('SELECT * FROM commentaire');
       
       echo '<table class ="table table-bordered text-center"><tr>';
       for ($i=0; $i<$result->columnCount();$i++)
       {
         
        $colonne =$result->getColumnMeta($i);
        
        echo "<th>$colonne[name]</th>";
       }
       while ($ligne = $result->fetch(PDO::FETCH_ASSOC))
       {
        echo '<tr>'; 
        foreach ($ligne as $cellule) {
          
         echo '<td>'.$cellule.'</td>';
       
         
       //  print_r($ligne);
         
        }
       
        
       
        echo '<td>'.'<form method="post">'.'<button type="submit" name="del">'.'<input type="hidden" name="idsup" value="'.$ligne['id_commentaire'].'">Supprimer'.'<span class="glyphicon glyphicon-trash"></span>'.'</button>'.'</form>'.'</td>';
       }
       if (isset($_POST['idsup'])){
         $del = $pdo->prepare('DELETE FROM commentaire WHERE id_commentaire = ?');
         // $del->bind_param('i', $_POST['id_categorie']);
         $del->execute(array($_POST['idsup']));

       }
       echo '</tr>';
       
       echo '</table>';
       

        ?>
     </div>
    </div>


<?php
include __DIR__ . '/../assets/includes/footer.php';
