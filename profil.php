
<?php

require_once __DIR__ . '/assets/config/bootstrap.php';


$page_title = 'Accueil';
include __DIR__ . '/assets/includes/header.php';
?>  

    <!------ Include the above in your HEAD tag ---------->

    <div class="container text-center">
 
<div class="panel panel-default">
    <div class="panel-heading">
        <h4 >Bonjour <?= getMembre()['pseudo']?> !</h4>
    </div>
    <div class="panel-body">
            <div class="col-md-8 col-xs-12 col-sm-6 col-lg-8" style="margin-left: 114px">
                <div class=" text-center">
                    <h2>Mon Profil</h2>
                    <p>Pseudo
        <b>
            <?= getMembre()['pseudo']?></b>
    </p>

            </div>
            <hr>
                <ul class="container details">
                    <li>
                        <p>
                            <span class="glyphicon glyphicon-user one" style="width:50px;"></span><?= getMembre()['nom'] ?>
                            <?= getMembre()['prenom'] ?></p>
                    </li>
                    <li>
                        <p>
                            <span class="glyphicon glyphicon-envelope one" style="width:50px;"></span><?= getMembre()['email'] ?></p>
                    </li>
                </ul>
                <hr>
                    <div class="col-sm-5 col-xs-6 tital">
    <?php 
                        $date=date('d-m-Y');
                        $heure=date('H:i');
                        echo"Nous sommes le $date et il est $heure";                          
                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
    <?php
$annonce = getAnnonce($pdo, $_GET['id'] ?? null);
$photo = getPhoto($pdo, $annonce['photo_id'] ?? null);
$membre = getMembre($pdo, $annoncesId['membre_id'] ?? null);
?>
    <?php foreach(listeAnnoncesId($pdo) as $annonceId) : ?>
    <div class="row">
        <div class="col-md-4 mt-4">
            <img src="assets/img/<?= $membre['photo']; ?>" class="card-img-top" style="width:70%" >
        </div>
        <div class="card-block px-3 mt-4">
                    <h4 class="card-title"><?= htmlspecialchars($membre['titre']); ?></h4>
                    <p class="card-text"><?= htmlspecialchars($membre['description_courte']); ?></p>
                    <?php if(role(ROLE_ADMIN)) :?>
                    <form action="index.php?id=<?=$annonce['id_annonce'];?>" method="post">
                    <input type="hidden" name="idSupr" value="<?=$annonce['id_annonce'];?>">
                    <input type="submit" class="btn btn-danger" name="delete" value="Supprimer">
                    </form>     
                    <?php endif; ?>
        </div>
        <div class="col-md-4 px-3 ml-2 mt-4 text-right">
                    <p class="card-text">Membre : <?= getMembreBy($pdo, 'id_membre', $annonce['membre_id'])['pseudo']; ?></p>
                    <p class="card-text">Note :</p>
                    <p class="card-text">Prix : <?= htmlspecialchars($annonce['prix']); ?> €</p>
        </div>
    </div>
  
    <hr>
    <?php endforeach; ?>
                    </div>
   
                </html>

                <?php
include __DIR__ . '/assets/includes/footer.php';