<?php

require_once __DIR__ . '/assets/config/bootstrap.php';

// Traitement

if(isset($_POST['register'])) {
    if(getMembreBy($pdo, 'pseudo', $_POST['pseudo']) !== null) {
        ajouterFlash('danger', 'Ce pseudo est déjà pris.');

        // Pseudo trop court ou trop long
    } elseif(strlen($_POST['pseudo']) < 3 || strlen($_POST['pseudo']) > 25) {
        ajouterFlash('danger', 'Le pseudo doit contenir entre 3 et 25 caractères.'); 

        // Nom trop court ou trop long
    } elseif(strlen($_POST['nom']) < 3 || strlen($_POST['nom']) > 25) {
        ajouterFlash('danger', 'Le nom doit contenir entre 3 et 25 caractères.'); 

        // Prénom trop court ou trop long
    } elseif(strlen($_POST['prenom']) < 3 || strlen($_POST['prenom']) > 25) {
        ajouterFlash('danger', 'Le prenom doit contenir entre 3 et 25 caractères.'); 

        // Caractères non-autorisés
    } elseif(!preg_match('~^[a-zA-Z0-9_-]+$~', $_POST['pseudo'])) {
        ajouterFlash('danger', 'Le pseudo contient des caractères non-autorisés.');

        // Email déjà existant
    } elseif(getMembreBy($pdo, 'email', $_POST['email']) !== null) {
        ajouterFlash('danger', 'Cette adresse email est déjà utilisée.');

        // Format de l'email
    } elseif(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        ajouterFlash('danger', 'Veuillez indiquer une adresse email valide.');

        // Mot de passe: min. 8caractères, 1 majuscule, 1 minuscule, 1 chiffre, 1 caractère spécial
    } elseif(!preg_match('~^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$~', $_POST['password'])) {
        ajouterFlash('danger', 'Le mot de passe doit contenir au minimum : 8caractères, 1 majuscule, 1 minuscule, 1 chiffre, 1 caractère spécial.');

    }elseif ($_POST['password'] !== $_POST['confirmation']){
        ajouterFlash('danger','Les 2 mots de passe ne correspondent pas.');

        // Format du numéro de téléphone
    } elseif(!filter_var($_POST['telephone'], FILTER_SANITIZE_NUMBER_INT) && strlen($_POST['telephone'])==10) {
        ajouterFlash('danger', 'Veuillez indiquer un numéro de téléphone valide à dix chiffres.');

    } else {
        // Enregistrement 
        $req = $pdo->prepare(
            'INSERT INTO membre (pseudo, mdp, nom, prenom, telephone, email, civilite, statut, date_enregistrement)
            VALUES (:pseudo, :mdp, :nom, :prenom, :telephone, :email, :civilite, :statut, NOW())'
        );

        $req->execute([
            'pseudo' => $_POST['pseudo'],
            'mdp' => password_hash($_POST['password'], PASSWORD_DEFAULT),
            'nom' => $_POST['nom'],
            'prenom' => $_POST['prenom'],
            'telephone' => $_POST['telephone'],
            'email' => $_POST['email'],
            'civilite' => $_POST['civilite'],
            'statut' => ROLE_USER,
        ]);

        ajouterFlash('success', 'Vous avez bien été inscrit !');
        ajouterFlash('info', 'Vous pouvez vous connecter.');
        session_write_close();
        header('Location: login.php');
    }
}

// Affichage

$page_title = "Inscription";

include __DIR__ . '/assets/includes/header.php';
?>

<div class="container border mt-4 p-4">

        <h1 class="text-center">S'inscrire !</h1>

        <?php include __DIR__ . '/assets/includes/flash.php'; ?>

        <form action="register.php" method="post">
            <div class="form-group">
                <label>Votre pseudo</label>
                <input type="text" name="pseudo" class="form-control" value="<?= $_POST['pseudo'] ?? ''; ?>">
            </div>

            <div class="form-group">
                <label>Mot de passe</label>
                <input type="password" name="password" class="form-control">
            </div>
            <div class="form-group">
                    <label>Confirmation du mot de passe</label>
                    <input type="password" name="confirmation" class="form-control">
            </div>

            <div class="form-group">
                <label>Votre nom</label>
                <input type="text" name="nom" class="form-control" value="<?= $_POST['nom'] ?? ''; ?>">
            </div>

            <div class="form-group">
                <label>Votre prénom</label>
                <input type="text" name="prenom" class="form-control" value="<?= $_POST['prenom'] ?? ''; ?>">
            </div>

            <div class="form-group">
                <label>Votre email</label>
                <input type="email" name="email" class="form-control" value="<?= $_POST['email'] ?? ''; ?>">
            </div>

            <div class="form-group">
                <label>Votre téléphone</label>
                <input type="number" name="telephone" class="form-control" value="<?= $_POST['telephone'] ?? ''; ?>">
            </div>

            <div class="form-group">
                  <label for="sel1">Votre civilité :</label>
                    <select class="form-control"  type="enum" name="civilite" value="<?= $_POST['civilite'] ?? ''; ?>">
                                <option value="m">Homme</option>
                                    <option value="f">Femme</option> 
                                </select>
            </div>
            <input type="submit" name="register" value="S'inscrire" class="btn btn-success">

        </form>
    </div>

<?php 
include __DIR__ . '/assets/includes/footer.php';

?>