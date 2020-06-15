<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="ajax_annonce.js"></script>

<?php

require_once __DIR__ . '/../assets/config/bootstrap_admin.php';

// Suppression d'annonces
if (isset($_POST['del'])) {
  unset($_POST['del']);
  ajouterFlash('danger', 'L\'annonce est bien supprimée !');
}

// Affichage

$page_title = "Gestion annonces";

include __DIR__ . '/../assets/includes/header_admin.php';

?>
<?php include __DIR__ .'/../assets/includes/flash.php';?>

<div class="container border mt-4 pb-4 col-md-12 scroll">
    
<h1 style="text-align:center;">Gestion Annonces</h1>



<?php include __DIR__ .'/../assets/includes/flash.php';?>

<form method="post" class="col-md-4 offset-md-4 text-center">
  
<select name="categorie" id="categorie" method="post" class="form-control">
<?php
  
    $result = $pdo->query('SELECT DISTINCT id_categorie, titre FROM categorie');
    while($categories = $result->fetch(PDO::FETCH_ASSOC)):
      echo'<pre>'; print_r($categorie);echo'</pre>';
         //print_r($categories);
        ?>  
        <option value="<?= $categories['id_categorie']?>"> <?= $categories['titre']?>
        
        </option>
        <?php endwhile; ?> 
        </select>

  <button type="submit" id="submit" class="mt-2 col-md-12 btn btn-warning ">Trier par catégorie</button>
</form>



<div id="resultat">

<?php
require_once('../assets/config/init.php');

echo '<div style="overflow:scroll">';

$result = $pdo->query('SELECT * FROM annonce');

echo '<table class ="table-fluid table-bordered text-center"><tr>';
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

echo '<td>'.'<form method="post">'.'<button type="submit" name="del">'.'<input type="hidden" name="idsup" value="'.$ligne['id_annonce'].'">Supprimer'.'<span class="glyphicon glyphicon-trash"></span>'.'</button>'.'</form>'.'<form method="post">'.'<button type="submit" name="vue">'.'<input type="hidden" name="idvu" value="'.$ligne['id_annonce'].'">Voir'.'</button>'.'</form>'.
 '</td>';


}
if (isset($_POST['idsup'])){
  $del = $pdo->prepare('DELETE FROM annonce WHERE id_annonce = ?');
  // $del->bind_param('i', $_POST['id_categorie']);
  $del->execute(array($_POST['idsup']));
}


echo '</tr>';

echo '</table>';

?>

  </div>
</div>

</div>
<?php
include __DIR__ . '/../assets/includes/footer.php';
