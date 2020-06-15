<?php

require_once __DIR__ .'/assets/config/bootstrap.php';

$recherche = $_GET['recherche'] ?? '';
$req = $pdo->prepare(
    'SELECT *,
    MATCH (titre, description_courte) AGAINST (:recherche) AS score
    FROM annonce 
    HAVING score > 0
    ORDER BY score DESC
    ');
    $req->bindParam(':recherche', $recherche);
    $req->execute();

    $resultat = $req->fetchAll(PDO::FETCH_ASSOC);


    $page_title = 'Recherche: ' .$recherche;
    require __DIR__ .'/assets/includes/header.php';
?>
  <div class="container fluid border mt-4 p-4">
        <h4 class="mb-4" style="color:orange">Résultat de la recherche : <?= htmlspecialchars($recherche); ?></h4>
       
        <?php foreach($resultat as $post) :?>
        <a href="fiche_annonce.php?id=<?= $post['id_annonce']; ?>">
            <div class="card mt-4 ">
                <div class="row no-gutters">
                    <div class="col-md-6">
                        <img src="assets/img/<?= $post['photo'] ;?>" class="card-img">
                    </div>
                    <div class="col-md-6">
                        <div class="card-body">
                            <h4 class="card-title"><?= htmlspecialchars($post['titre']); ?></h4>
                            <h5 class="card-text">
                                <?= htmlspecialchars($post['prix']); ?> €
                            </h5>
                            <p class="card-text">
                            <?php if(strlen($post['description_courte']) > 50 ) :?>
                                <?= substr(htmlspecialchars($post['description_courte']), 0,50 ); ?>
                            <?php else : ?>
                                <?= htmlspecialchars($post['description_courte']); ?>
                            <?php endif; ?>
                            </p>
                            <h6 class="card-subtitle mb2 text-muted">
                                Enregistré le <?= (new DateTime($post['date_enregistrement']))->format('d/m/Y \à H:i'); ?>
                            </h6>
                            <br><br>
                            <p class="card-text">   
                                <small class="text-muted">
                                    Correspondance avec la recherche:
                                    <?= number_format(($post['score'] * 100), 2, '.',' '); ?> %
                                </small>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            
        </a>
        <?php endforeach ; ?>
     
    </div>

<?php
require __DIR__ .'/assets/includes/footer.php';



