<link href="style.css" rel="stylesheet">
<?php

require_once __DIR__ . '/assets/config/bootstrap.php';
$page_title = 'Fiche annonce';
include __DIR__ . '/assets/includes/header.php'; 


$annonce = getAnnonce($pdo, $_GET['id'] ?? null);
$photo = getPhoto($pdo, $annonce['photo_id'] ?? null);
$annonceMembre = getAnnonceBy($pdo, $annonce['photo_id']);
?>


    <body>
        <div class="container">
            <div class="container mb-3">
            <div class="row">
                <div class="col md-12 carousel slide" data-ride="carousel" id="carouselExampleIndicators" >
               
                <h1 class="text-center"><?= htmlspecialchars($annonce['titre']); ?></h1>
                <div class="carousel-inner" style="height:60%">
                <div class="carousel-item active">
                <a href="assets/img/<?= $photo['photo']; ?>"><img src="assets/img/<?= $annonce['photo']; ?>" class="rounded mx-auto d-block" style="width: 70%;"></a>
                </div>
                <div class="carousel-item">
                <a href="assets/img/<?= $photo['photo2']; ?>"><img src="assets/img/<?= $photo['photo2']; ?>" class="rounded mx-auto d-block" style="width: 70%;"></a>
                </div>        
                <div class="carousel-item">
                <a href="assets/img/<?= $photo['photo3']; ?>"><img src="assets/img/<?= $photo['photo3']; ?>" class="rounded mx-auto d-block" style="width: 70%;"></a>
                </div>
                
                <div class="carousel-item">
                <a href="assets/img/<?= $photo['photo4']; ?>"><img src="assets/img/<?= $photo['photo4']; ?>" class="rounded mx-auto d-block" style="width: 70%;"></a>
                </div>
                <div class="carousel-item">
                <a href="assets/img/<?= $photo['photo5']; ?>"><img src="assets/img/<?= $photo['photo5']; ?>" class="rounded mx-auto d-block" style="width: 70%;"></a>
                </div>
        </div>
</div>
            </div>
            </div>

                <div class="container mt-5">
                    <div class="row">
                <a href="assets/img/<?= $photo['photo2']; ?>"><img src="assets/img/<?= $photo['photo2']; ?>" class="rounded mx-auto d-block" style=" height: 60px;margin: 0 10px !important;;"></a>
                <a href="assets/img/<?= $photo['photo3']; ?>"><img src="assets/img/<?= $photo['photo3']; ?>" class="rounded mx-auto d-block" style=" height: 60px;margin: 0 10px !important;"></a>
                <a href="assets/img/<?= $photo['photo4']; ?>"><img src="assets/img/<?= $photo['photo4']; ?>" class="rounded mx-auto d-block" style=" height: 60px;margin: 0 10px !important;"></a>
                <a href="assets/img/<?= $photo['photo5']; ?>"><img src="assets/img/<?= $photo['photo5']; ?>" class="rounded mx-auto d-block" style=" height: 60px;margin: 0 10px !important;"></a>
                </div>
                </div>
                    </div> 
                </div>
                </div>
                    <div class="col text-center">
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
                <p> Nom de la personne : <?= getMembreBy($pdo, 'id_membre', $annonce['membre_id'])['prenom']; ?></p>
            </li>
            <li>
                <p>Numéro de téléphone : <?= getMembreBy($pdo, 'id_membre', $annonce['membre_id'])['telephone']; ?></p>
            </li>
            <li>
                <p>Membre depuis le : <?= getMembreBy($pdo, 'id_membre', $annonce['membre_id'])['date_enregistrement']; ?></p>
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
    <div class="form-group" id="rating-ability-wrapper">
        <label class="control-label" for="rating">
            <span class="field-label-header"></span><br>
            <span class="field-label-info"></span>
            <input
                type="hidden"
                id="selected_rating"
                name="selected_rating"
                value=""
                required="required">
        </label>
        <h2 class="bold rating-header etoile" style="">
            <span class="selected-rating">0</span>
            <small>/ 5</small>
            <button
                class="btnrating btn btn-default btn-lg"
                data-attr="1"
                id="rating-star-1">
                <i class="fa fa-star" aria-hidden="true"></i>
            </button>
            <button
                class="btn-rating btn btn-default btn-lg"
                data-attr="2"
                id="rating-star-2">
                <i class="fa fa-star" aria-hidden="true"></i>
            </button>
            <button
                class="btnrating btn btn-default btn-lg"
                data-attr="3"
                id="rating-star-3">
                <i class="fa fa-star" aria-hidden="true"></i>
            </button>
            <button
                class="btnrating btn btn-default btn-lg"
                data-attr="4"
                id="rating-star-4">
                <i class="fa fa-star" aria-hidden="true"></i>
            </button>
            <button
                class="btnrating btn btn-default btn-lg"
                data-attr="5"
                id="rating-star-5">
                <i class="fa fa-star" aria-hidden="true"></i>
            </button>
        </h2>
    </div>                    
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
            <br><br>
            <span style="float: right;margin-top: 8px;">37 Rue St Sebastien, 75011 Paris</span>
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2624.8163356337227!2d2.368692415183933!3d48.86171257928777!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e66dfc3751dc55%3A0xb5ee5babe14b6d30!2s37%20Rue%20Saint-S%C3%A9bastien%2C%2075011%20Paris!5e0!3m2!1sfr!2sfr!4v1568026411200!5m2!1sfr!2sfr"
                width="100%"
                height="300"
                frameborder="0"
                style="border:0;"
                allowfullscreen=""></iframe>
            <hr>
            <hr>
            <a href="commenter.php?id=<?= $annonce['id_annonce']; ?>">Deposer un commentaire ou une note</a>
            <a href="index.php" style="float: right;margin-top: 8px;">Retour vers les annonces</a>
            <br><br>
        </body>

        <footer>
            <script src="config.js"></script>
        </footer>

    </html>

    <?php
include __DIR__ . '/assets/includes/footer.php';