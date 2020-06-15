<link href="style.css">

<?php

require_once __DIR__ . '/assets/config/bootstrap.php';


$page_title = 'Commentaire';
include __DIR__ . '/assets/includes/header.php';


//Récuperation du post
$annonce = getPost($pdo, $_GET['id'] ?? null);

 if ($annonce === null) {
    ajouterFlash('danger', 'Commentaire inconnu.');
    session_write_close();
    header('Location: index.php');
 }

 // Formulaire: poster un commentaire
if (isset($_POST['commenter']) && getMembre() != null) {
    // Taille du commentaire
    if (empty($_POST['commentaire']) || strlen($_POST['commentaire']) > 800) {
        ajouterFlash('danger', 'Votre commentaire doit contenir entre 1 & 800 caractères.');

    } else {
        $req = $pdo->prepare(
            'INSERT INTO commentaire(membre_id, annonce_id,commentaire, date_enregistrement)
            VALUES (:membre_id, :annonce_id, :commentaire, NOW())'
        );
        $req->execute([
            ':membre_id' => getMembre()['id_membre'],
            ':annonce_id' => $annonce['id_annonce'],
            ':commentaire' => $_POST['commentaire'],
        ]);

        ajouterFlash('success', 'Votre commentaire a bien été envoyé.');
    }
}

//Formulaire: supprimer 1 commentaires
if(isset($_POST['supprimer'])){
    // recuperation du commentaire a supprimer
    $commentaire = getCommentaire($pdo, $_POST['commentaire']);
    
    //Si l'utilisateur courant n'a pas les droit requis
    if(!role(ROLE_ADMIN)){

    } else {
            //Suppresion
            $req =$pdo->prepare(
                'DELETE FROM commentaire
                WHERE id_commentaire = :id_commentaire'
            );
            $req->bindParam(':id_commentaire', $commentaire['id_commentaire'], PDO::PARAM_INT);
            $req->execute();
    
            ajouterFlash('success','Le commentaire a bien été supprimé.');
        }
    
    }

$annonce = getAnnonce($pdo, $_GET['id'] ?? null);
$photo = getPhoto($pdo, $annonce['photo_id'] ?? null);

?>

<body>
<?php include __DIR__ . '/assets/includes/flash.php'; ?>
        <div class="container mt-2 p-2 ">
            <div class="row">
                <div class="col md-12 carousel slide" data-ride="carousel" id="carouselExampleIndicators">
                <ol class="carousel-indicators">
                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="4"></li>
                </ol>
                <h1 class="text-center"><?= htmlspecialchars($annonce['titre']); ?></h1>
                <div class="carousel-inner">
                <div class="carousel-item active">
                <a href="assets/img/<?= $photo['photo']; ?>"><img src="assets/img/<?= $annonce['photo']; ?>" class="rounded mx-auto d-block" style="width: 70%; height: 350px;"></a>
                </div>
                <div class="carousel-item">
                <a href="assets/img/<?= $photo['photo2']; ?>"><img src="assets/img/<?= $photo['photo2']; ?>" class="rounded mx-auto d-block" style="width: 70%;height: 350px;"></a>
                </div>        
                <div class="carousel-item">
                <a href="assets/img/<?= $photo['photo3']; ?>"><img src="assets/img/<?= $photo['photo3']; ?>" class="rounded mx-auto d-block" style="width: 70%;height: 350px;"></a>
                </div>
                
                <div class="carousel-item">
                <a href="assets/img/<?= $photo['photo4']; ?>"><img src="assets/img/<?= $photo['photo4']; ?>" class="rounded mx-auto d-block" style="width: 70%;height: 350px;"></a>
                </div>
                <div class="carousel-item">
                <a href="assets/img/<?= $photo['photo5']; ?>"><img src="assets/img/<?= $photo['photo5']; ?>" class="rounded mx-auto d-block" style="width: 70%;height: 350px;"></a>
                </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>
            </div>
            <p class="text-center ">Description courte :<?= nl2br(htmlspecialchars($annonce['description_courte'])); ?></p>
    <p class="text-center"><?= nl2br(htmlspecialchars($annonce['description_longue'])); ?></p>
</div>
    <!--Liste des commentaires-->
    <h2 class="mb-4" style="text-align:center; background-color:orange">Commentaires</h2>
      
            <div class="container p-4 mt-2 mb-4">

   <!--Formulaire pour répondre-->

    <?php if(getMembre() !== null) : ?>
    
    <form action="commenter.php?id=<?= $annonce['id_annonce']; ?>" method="post">
    <div class="form-group">
        <label>Votre commentaire</label>
        <textarea name="commentaire" class="form-control"></textarea>
    </div>
    <input type="submit" name="commenter" value="Valider" class="btn btn-success">
    </form>
            <?php endif; ?>
        
       
     <!--Liste des commentaires-->
     <h3 class="mb-4 mt-5 text-center" style="background-color:orange">Liste des Commentaires</h3>

<?php foreach(getCommentairesByPost($pdo, $annonce['id_annonce']) as $commentaire) : ?>
<?php include __DIR__ .'/assets/includes/flash.php'; ?>
<div class="card mt-3">
    <div class="card-body">
    <h5 class="card-title"><?= getMembreBy($pdo, 'id_membre', $commentaire['membre_id'])['pseudo']; ?></h5>
    <h6 class="card-subtitle mb-2 text-muted">
        <?= (new DateTime($commentaire['date_enregistrement']))->format('d/m/Y H:i'); ?></h6>
        <p class="card-text">
            <?= nl2br(htmlspecialchars($commentaire['commentaire'])); ?>
        </p>
        
          <!--Bouton de suppression-->
          <?php if(role(ROLE_ADMIN)) :?>
        <form action="commenter.php?id=<?= $annonce['id_annonce'] ?>" method="post">
        <input type="hidden" name="commentaire" value="<?= $commentaire['id_commentaire']; ?>">
        <input type="submit" name="supprimer" value="Supprimer" class="btn btn-danger">
        </form>
            <?php endif; ?>

        </div>
<?php endforeach ;?>
</body>   
    
<?php
include __DIR__ . '/assets/includes/footer.php';

