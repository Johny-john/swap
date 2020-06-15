<?php

require_once __DIR__ . '/../assets/config/bootstrap_admin.php';




// Affichage

$page_title = "Gestion membres";

include __DIR__ . '/../assets/includes/header_admin.php';
?>


<div class="border col-md-12">

<h1 style="text-align:center;">Gestion des notes</h1>

<?php include __DIR__ .'/../assets/includes/flash.php';?>

<div style="overflow:scroll;">
        
   
<?php
    

       
        $result = $pdo->query("SELECT * FROM note");
        

        echo '<table class="table table-bordered text-center";><tr>';
     
        for($i = 0; $i < $result->columnCount(); $i++)
        {
            $colonne = $result->getColumnMeta($i);
            echo "<th>$colonne[name]</th>";
        }

        echo '</tr>';
        while($ligne = $result->fetch(PDO::FETCH_ASSOC))
        {
            echo '<tr>';
            foreach($ligne as $cellule)
            {
                echo "<td>$cellule</td>";

            }    
            

            echo '<td>'.'<form method="post">'.'<button type="submit" name="del">'.'<input type="hidden" name="idsup" value="'.$ligne['id_note'].'">Supprimer'.'<span class="glyphicon glyphicon-trash"></span>'.'</button>'.'</form>'.'</td>';
        }

            if (isset($_POST['idsup'])){
              $del = $bdd->prepare('DELETE FROM note WHERE note = id_note = ?');
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
