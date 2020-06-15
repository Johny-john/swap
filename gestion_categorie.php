<?php

require_once __DIR__ . '/../assets/config/bootstrap_admin.php';

//Formulaire: supprimer 1 catégorie
if(isset($_POST['supprimer'])){
    // recuperation d'une catégorie a supprimer
    $commentaire = getAnnonce($pdo, $_POST['commentaire']);
    
    //Si l'utilisateur courant n'a pas les droit requis
    if(!role(ROLE_ADMIN) && (getMembre()() === null || getMembre()['id'] !== $annonce['titre'])){
        ajouterFlash('danger','Vous ne pouvez pas supprimer ce commentaire.');
    
    } else {
            //Suppression
            $req =$pdo->prepare(
                'DELETE FROM annonce
                WHERE id = :id'
            );
            $req->bindParam(':id', $annonce['id'], PDO::PARAM_INT);
            $req->execute();
       
            ajouterFlash('success','Le commentaire a bien été supprimé.');
        }
    }




if (isset($_POST['rajouter'])){
    if(empty($_POST['titre']) || strlen($_POST['titre']) > 255 ){
        ajouterFlash('danger' ,'Le titre doit contenir entre 1 et 255 caractères.');
       

    }elseif (empty($_POST['contenu']) || strlen($_POST['contenu']) > 20 ){
        ajouterFlash('danger' ,'La description courte doit contenir entre 1 et 20 caractères.');

    }else{


$req =$pdo->prepare(
    'INSERT INTO categorie(titre, motscles)
    VALUE (:titre, :motscles)'
);

$req->bindParam(':titre', $_POST['titre']);
$req->bindParam(':motscles', $_POST['contenu']);
$req->execute();


unset($_POST);
ajouterFlash('success','Votre catégorie est bien ajoutée !');
    }
}
// Suppression de catégories
if (isset($_POST['del'])) {
    unset($_POST['del']);
    ajouterFlash('danger', 'Votre catégorie est bien supprimée !');
}


// Affichage

$page_title = "Gestion catégorie";

include __DIR__ . '/../assets/includes/header_admin.php';
?>

<div class="container border mt-4 pb-4 col-md-12">
<h1 style="text-align:center;color:">Gestion catégorie</h1>

<?php include __DIR__ .'/../assets/includes/flash.php';?>


<?php
require_once('../assets/config/init.php');
$result = $pdo->query('SELECT * FROM categorie');

echo '<table class ="table table-bordered text-center"><tr>';
for ($i=0; $i<$result->columnCount();$i++)
{
 $colonne =$result->getColumnMeta($i);
 echo "<th>$colonne[name]</th>";
}
while ($ligne = $result->fetch(PDO::FETCH_ASSOC))
{
 echo '<tr>'; 
 foreach ($ligne as $cellule)  {

  echo '<td>'.$cellule.'</td>';
//   var_dump($cellule);
 }

 echo '<td>'.'<form method="post">'.'<button type="submit" name="del">'.'<input type="hidden" name="idsup" value="'.$ligne['id_categorie'].'">Supprimer'.'<span class="glyphicon glyphicon-trash"></span>'.'</button>'.'</form>'.'</td>';
}
if (isset($_POST['idsup'])){
    $del = $pdo->prepare('DELETE FROM categorie WHERE id_categorie = ?');
    // $del->bind_param('i', $_POST['id_categorie']);
    $del->execute(array($_POST['idsup']));
 }
echo '</tr>';

echo '</table>';

?>
<i class="fa fa-trash" aria-hidden="true"></i>


<h3 class="text-center tm-4">Vous pouvez ajouter une catégorie, si vous le souhaitez !</h3>
        
        <form action="gestion_categorie.php" method="post" enctype="multipart/form-data">
    <div class="form-groupe">
        <label>Nouveau titre</label>
        <input type="text" name="titre" class="form-control" value="<?= $_POST['titre'] ?? ''?>">
    </div>
    <div class="form-group">
        <label>Petite description</label>
        <textarea name="contenu" class="form-control"><?= $_POST['contenu'] ?? ''; ?></textarea>
    </div>
    <div class="text-center">
    <input type="submit" name="rajouter" value="Enregistrer" class="btn btn-warning">
    </div>
        </form>
</div>

<?php
include __DIR__ . '/../assets/includes/footer.php';
