<?php
//Configuration

require_once __DIR__ . '/assets/config/bootstrap.php';

//Traitement (partie logique)

$content ='';
if(isset($_POST['login'])){
    // ajouterFlash('success','Ca marche !');
    // ajouterFlash('danger','Une erreur est survenue.... ');

    // 1er) recuperer l'utilisateur
    $req = $pdo->prepare(
        'SELECT *
        FROM membre
        WHERE
          pseudo = :pseudo
          OR email = :email'
    );
    $req->bindParam(':pseudo' , $_POST['identifiant']);
    $req->bindParam(':email' , $_POST['identifiant']);
    $req->execute();
    $utilisateur = $req->fetch(PDO::FETCH_ASSOC);

    if(!$utilisateur) {
        ajouterFlash('danger','Utilisateur inconnu chez nous.');

        //Si le mot passe et incorrect ....
    }elseif(!password_verify($_POST['mdp'], $utilisateur['mdp'])){
        ajouterFlash('danger','Mot de passe erroné');
        //Sinon, connexion   
    }else{
        // On ne garde pas le hash du mot de passe en session
        unset($utilisateur['mdp']);
        $_SESSION['utilisateur'] = $utilisateur;
        //On redirige
        header('Location: index.php');
    }

}

//Deconnexion
if(isset($_GET['logout'])){
unset($_SESSION['utilisateur']);
ajouterFlash('success','Vous avez bien été deconnecté.');
}

//Afichage
$page_title = 'Connexion';
include __DIR__ . '/assets/includes/header.php';
?>

    <div class="container border mt-4 p-4 text-center ">

        <h1 style="text-align:center">Espace membre</h1>

    <?php include __DIR__ . '/assets/includes/flash.php'; ?>

        <form action="login.php" method="post">
            <div class="form-group">
                <label>Pseudo / Email</label>
                <input type="text" name="identifiant" class="form-control" value="<?= $_POST['identifiant'] ?? '' ?>">
            </div>
            <div class="class form-group">
                <label>Mot de passe</label>
                <input type="password" name="mdp" class="form-control">
            </div>
            <input type="submit" name="login" class="btn btn-success" value="On y va !">
        </form>
    </div>

    <?php include __DIR__ .'/assets/includes/footer.php'; ?>