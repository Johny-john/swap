<?php

require_once __DIR__ . '/assets/config/bootstrap.php';


$page_title = 'Notes';
include __DIR__ . '/assets/includes/header.php';

$annonce = getAnnonce($pdo, $_GET['id_membre'] ?? null);
$photo = getPhoto($pdo, $annonce['photo_id'] ?? null);
$membre = getAnnonce($pdo, $_GET['id_membre'] ?? null);



 // Formulaire: poster un avis
 if (isset($_POST['envoyeravis']) && getMembre() != null) {
    // Taille du commentaire
    if (empty($_POST['avis']) || strlen($_POST['avis']) > 800) {
        ajouterFlash('danger', 'Votre avis doit contenir entre 1 & 800 caractères.');

    } else {
        $req = $pdo->prepare(
            'INSERT INTO note(membre_id1, membre_id2, note, avis, date_enregistrement)
            VALUES (:membre_id1, :membre_id2, :note, :avis, NOW())'
        );
        $req->execute([
            ':membre_id1' => getMembre()['id_membre'],
            ':membre_id2' => getMembreBy($pdo,'id_membre', $_GET['id_membre'])['id_membre'],
            ':note' => $_POST['note'],
            ':avis' => $_POST['avis'],
        ]);

        ajouterFlash('success', 'Votre note a bien été envoyée.');
    }
}
// var_dump(getMembreBy($pdo,'id_membre', $_GET['id_membre']));

// var_dump(getMembreBy($pdo,'id_membre', $_GET['id_membre'])["id_membre"]);
?>

<body>
<?php include __DIR__ . '/assets/includes/flash.php'; ?>


<div class="panel-heading text-center">
        <h4>Bonjour <?= getMembre()['pseudo']?> !</h4>
</div>

<div class="panel-heading text-center">
        <h4>Vous allez noter le membre <?= getMembreBy($pdo,'id_membre', $_GET['id_membre'])['pseudo'];
 ?> !</h4>
</div>

   <!--Formulaire pour donner une note-->

   <?php if(getMembre() !== null) : ?>
    
    <form action="notes.php?id_membre=<?= getMembreBy($pdo,'id_membre', $_GET['id_membre'])["id_membre"];  ?>" method="post">
    <div class="form-group">
        <label>Votre avis sur le membre</label>
        <textarea name="avis" class="form-control" placeholder="Exprimez vous librement mais de manière bienveillante"></textarea>
    </div>
    <select name="note">
		<option>Sélectionner une note sur 5</option>
		<option value="1">1 sur 5</option>
		<option value="2">2 sur 5</option>
		<option value="3">3 sur 5</option>
		<option value="4">4 sur 5</option>
		<option value="5">5 sur 5</option>
	</select>
    <input type="submit" name="envoyeravis" value="Valider" class="btn btn-success">
    </form>
            <?php endif; ?>

    
    </body>

<?php
include __DIR__ . '/assets/includes/footer.php';