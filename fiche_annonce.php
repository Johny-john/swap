<link href="style.css" rel="stylesheet">
<?php

require_once __DIR__ . '/assets/config/bootstrap.php';
$page_title = 'Fiche annonce';
include __DIR__ . '/assets/includes/header.php'; 


$annonce = getAnnonce($pdo, $_GET['id'] ?? null);
$photo = getPhoto($pdo, $annonce['photo_id'] ?? null);
// $membre = getPseudoId($pdo, $pseudo['membre_id']);
if ($annonce === null) {
    ajouterFlash('danger', 'Annonce inconnue.');
    session_write_close();
    header('Location: index.php');
 }
?>


    <body>
        <div class="container">
            <div class="row">
                <div class="col md-12">
                <h1 class="text-center"><?= htmlspecialchars($annonce['titre']); ?></h1>
                <a href="assets/img/<?= $photo['photo1']; ?>"><img src="assets/img/<?= $annonce['photo']; ?>" class="rounded mx-auto d-block" style="width: 70%;">
                    <br><br> 
                <div class="row">
                <a href="assets/img/<?= $photo['photo2']; ?>"><img src="assets/img/<?= $photo['photo2']; ?>" class="rounded mx-auto d-block" style=" height: 60px;margin: 0 10px !important;;"></a>
                <a href="assets/img/<?= $photo['photo3']; ?>"><img src="assets/img/<?= $photo['photo3']; ?>" class="rounded mx-auto d-block" style=" height: 60px;margin: 0 10px !important;"></a>
                <a href="assets/img/<?= $photo['photo4']; ?>"><img src="assets/img/<?= $photo['photo4']; ?>" class="rounded mx-auto d-block" style=" height: 60px;margin: 0 10px !important;"></a>
                <a href="assets/img/<?= $photo['photo5']; ?>"><img src="assets/img/<?= $photo['photo5']; ?>" class="rounded mx-auto d-block" style=" height: 60px;margin: 0 10px !important;"></a>
                </div>
                    </div> 
                    <div class="col">
                    <?php if(getMembre() != null) : ?>
                    <button class="btn btn-outline-warning"  data-toggle="modal" data-target="#exampleModal" style="float: right;margin-top: 8px;">contactez
                    <?= getMembreBy($pdo, 'id_membre', $annonce['membre_id'])['pseudo']; ?></button>
                        <br>
                        <br>
                        <?php endif; ?>
                    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Coordonnées de l'annonceur</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
                    <ul class="container details modalId">
                        <li>
                            <p> Nom de la personne :
                                <?= getMembreBy($pdo, 'id_membre', $annonce['membre_id'])['pseudo']; ?></p>
                        </li>
                        <li>
                            <p>Numéro de téléphone : 
                               <?= getMembreBy($pdo, 'id_membre', $annonce['membre_id'])['telephone']; ?></p>
                        </li>
                        <li>
                            <p>Membre depuis le :
                               <?= getMembreBy($pdo, 'id_membre', $annonce['membre_id'])['date_enregistrement']; ?></p>
                        </li>
                        <li>
                        <a href="notes.php?id_membre=<?= getMembreBy($pdo, 'id_membre', $annonce['membre_id'])['id_membre'];  ?>">Noter ce membre</a>

                        </li>
                    </ul>
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>
                <!--suite de la page -->
            <h3><?= nl2br(htmlspecialchars($annonce['description_courte'])); ?></h3>

            <p><?= nl2br(htmlspecialchars($annonce['description_longue'])); ?></p>

            <br>
            <h5>Prix : <?= htmlspecialchars($annonce['prix']); ?> Euros
    </h5>                 
</div>
            </div>
            <h3 class="mb-4 mt-5 text-center" style="background-color:orange">Liste des Commentaires</h3>

<?php foreach(getCommentairesByPost($pdo, $annonce['id_annonce']) as $commentaire) : ?>
<div class="card mt-3">
    <div class="card-body">
    <h5 class="card-title"><?= getMembreBy($pdo, 'id_membre', $commentaire['membre_id'])['pseudo']; ?></h5>
    <h6 class="card-subtitle mb-2 text-muted">
        <?= (new DateTime($commentaire['date_enregistrement']))->format('d/m/Y H:i'); ?></h6>
        <p class="card-text">
            <?= nl2br(htmlspecialchars($commentaire['commentaire'])); ?>
        </p>
        <?php endforeach ;?>
    </div>
</div>

<?php if(getMembre() !== null) : ?>
        <div class="col ml-3">
            <a class="btn btn-success mt-3" href="commenter.php?id=<?= $annonce['id_annonce']; ?>">Faire un commentaire</a>
        </div>
            <?php endif; ?>
                <?php if(getMembre() === null) : ?>
                <div class="col ml-6">
            <a class="btn btn-dark mt-3" href="login.php">Veuillez vous connecter pour poster un commentaire</a>
        </div>
    <?php endif; ?>
            <br><br>
            <span style="float: right;margin-top: 8px;">37 Rue St Sebastien, 75011 Paris</span>
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2624.8163356337227!2d2.368692415183933!3d48.86171257928777!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e66dfc3751dc55%3A0xb5ee5babe14b6d30!2s37%20Rue%20Saint-S%C3%A9bastien%2C%2075011%20Paris!5e0!3m2!1sfr!2sfr!4v1568026411200!5m2!1sfr!2sfr"
                width="100%"
                height="300"
                frameborder="0"
                style="border:0;"
                allowfullscreen=""></iframe>
            <a href="index.php" style="float: right;margin-top: 8px;">Retour vers les annonces</a>
            <br><br>
        </body>
        <footer>
            
        </footer>
    </html>
    <script src="config.js"></script>

    <?php
include __DIR__ . '/assets/includes/footer.php';