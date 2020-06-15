<?php

require_once __DIR__ . '/assets/config/bootstrap.php';

$page_title = 'Accueil';
include __DIR__ . '/assets/includes/header.php';
?>

<div class="text-center" style="font-size:2em;background-color:DarkOrange">SWAP un site d'annonces en ligne !</div> 

<?php
if( isset($_GET['action']) && $_GET['action'] == 'fiche_annonce'){
    header('location:fiche_annonce.php');
}

if (isset($_POST['filtre'])){
    $r = $pdo->query("SELECT m.*, a.*, c.* FROM membre m, annonce a, categorie c  WHERE a.membre_id  =  m.id_membre
        AND c.id_categorie = a.categorie_id
        AND m.id_membre = a.membre_id
        AND c.titre = '$_POST[categorie]'
        AND a.prix = '$_POST[prix]'
        AND m.pseudo = '$_POST[membre]'");
        
    $annonce = $r->fetch(PDO::FETCH_ASSOC);
}


if(isset($_POST['categorie']) && isset($_POST['prix']) && isset($_POST['membre'])){

    $where = '';  // on prépare la conditon de la requette sql 

    if(!empty($_POST['categorie'])) {
        $where .= " AND categorie_id = '$_POST[categorie]' ";
    }
    if(!empty($_POST['prix'])) {
        $where .= " AND id_annonce = '$_POST[prix]' ";
    }
    if(!empty($_POST['membre'])) {
        $where .= " AND membre_id = '$_POST[membre]' ";
    }
   
    // echo 'REQUETE<br>'. $where;
    $r1 = $pdo->query(" SELECT * FROM annonce WHERE true $where");
    $content = ' ';
    $content .= '<h3>Nous avons trouvé ' . $r1->rowCount() . ' annonce(s) correspondant à votre recherche</h3>';
   
    while($resultat_filtre = $r1->fetch(PDO::FETCH_ASSOC)) {
    // var_dump($resultat_filtre);
    $content .= '<hr>';
    
    $content .= '<div class="card col-8 offset-3" style="width:30rem;">';
        $content .= '<img class="card-img-top" src="assets/img/'.$resultat_filtre['photo'].'" width="100" alt="Card image cap" >';
        $content .= '<div class="card-body">';
        $content .= '<h5 class="card-title">'.$resultat_filtre['titre'].'</h5>';
        $content .= '<p class="card-text">'.$resultat_filtre['description_courte'].'</p>';
        $content .= '<p class="card-text">'.$resultat_filtre['prix'].' €</p>';
        $content .= '<a href="fiche_annonce.php?id='.$resultat_filtre['id_annonce'].'" class="btn btn-primary">Voir l\'annonce</a>';
        $content .= '<a href="commenter.php?id='.$resultat_filtre['id_annonce'].'" class="btn btn-success">Commenter l\'annonce</a>';

        $content .= '<div>'.'';
        
        $content .= '</div>';

    $content .= '</div>';
    $content .= '</div>';
    
    }    
}
//DELETE annonce
if(isset($_POST['delete'])){

    $req =$pdo->prepare(
    'DELETE FROM annonce
     WHERE :id= id_annonce'
 );
 
    $req->bindParam(':id',$_POST['idSupr'],PDO::PARAM_INT);
    $req->execute();

ajouterFlash('success','Annonce supprimée !');
}  

?>

<div class="mb-3">
    <form action="" method="post" id="filtre">
        <div class="form-row">

            <div class="col-4 mt-4 mb-3 border" style="background-color:lightgrey">
                <label for="categorie" class="text-center"><strong>Catégories</strong></label>
                <select class="form-control" name="categorie" id="categorie">
                <option value="">Choississez une catégorie...</option>
                <?php  $r = $pdo->query("SELECT * FROM categorie");
                while($categorie = $r->fetch(PDO::FETCH_ASSOC)): 
                ?>
                <option value="<?= $categorie['id_categorie'] ?>"><?= $categorie['titre'] ?></option>
                <?php endwhile; ?>
                </select>
            </div>
            <div class="col-4 mt-4 mb-3 border" style="background-color:lightgrey">
                <label for="membre" class="text-center"><strong>Membre</strong></label>
                    <select class="form-control" name="membre" id="membre">
                    <option value="">Choississez un membre...</option>
                    <?php  $r = $pdo->query("SELECT * FROM membre");
                    while($membre = $r->fetch(PDO::FETCH_ASSOC)): 
                    ?>
                    <option value="<?= $membre['id_membre'] ?>"><?= $membre['pseudo'] ?></option>
                    <?php endwhile; ?>
                    </select><br><br>
            </div>  
            <div class="col-4 mt-4 mb-3 border" style="background-color:lightgrey">
                <label for="prix"><strong>Prix</strong></label>
                <select class="form-control" name="prix" id="prix">
                    <option value="">Choississez un prix...</option>
                    <?php  $r = $pdo->query("SELECT DISTINCT * FROM annonce");
                    while($prix = $r->fetch(PDO::FETCH_ASSOC)): 
                    ?>
                    <option value="<?= $prix['id_annonce'] ?>"><?= $prix['prix'] ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="col-12">
                <button type="submit" name="filtre" class="btn btn-warning btn-block"><i class="fas fa-search"></i>Filter</button>
            </div>
        </div>   
    </form>
</div>


<?php if(isset($_POST['filtre'])){
echo $content; }?>


<!--Menu des annonces-->
<?php include __DIR__ . '/assets/includes/flash.php'; ?>

<div class="text-center mt-5" style="font-size:2em;background-color:Moccasin">Actualités</div>

<div class="container border mt-3">

    <?php foreach(listeAnnonces($pdo) as $annonce) : ?>
    <div class="row">
        <div class="col-md-4 mt-4">
            <img src="assets/img/<?= $annonce['photo']; ?>" class="card-img-top" style="width:70%" >
        </div>
        <div class="card-block px-3 mt-4">
                    <h4 class="card-title"><?= htmlspecialchars($annonce['titre']); ?></h4>
                    <p class="card-text"><?= htmlspecialchars($annonce['description_courte']); ?></p>
              
                    <a class="btn btn-info" href="fiche_annonce.php?id=<?= $annonce['id_annonce']; ?>">Voir</a>
                    
                    <?php if(getMembre() != null) : ?>
                 
                    <a class="btn btn-success" href="commenter.php?id=<?= $annonce['id_annonce']; ?>">Commentaire</a>
                    
                    <?php endif; ?>

                    <?php if(role(ROLE_ADMIN)) :?>
               
                    <form action="index.php?id=<?=$annonce['id_annonce'];?>" method="post">
                    <input type="hidden" name="idSupr" value="<?=$annonce['id_annonce'];?>">
                    <input type="submit" class="btn btn-danger" name="delete" value="Supprimer">
                    </form>     
                    <?php endif; ?>
        </div>
        <div class="col-md-4 px-3 ml-2 mt-4 text-right">
                    <p class="card-text">Membre : <?= getMembreBy($pdo, 'id_membre', $annonce['membre_id'])['pseudo']; ?></p>
                    <p class="card-text">Note : <?= getNoteBy($pdo, 'id_note', $annonce['membre_id'])['note']; ?> sur 5</p>
                    <p class="card-text">Prix : <?= htmlspecialchars($annonce['prix']); ?> €</p>
        </div>
    </div>
  
    <hr>
    <?php endforeach; ?>
</div>







<?php
include __DIR__ . '/assets/includes/footer.php';