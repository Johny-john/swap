<?php

require_once __DIR__ . '/../assets/config/bootstrap_admin.php';
// Suppression d'annonces
if (isset($_POST['del'])) {
    unset($_POST['del']);
    ajouterFlash('danger', 'Le membre est bien supprimé !');
  }
  

if(isset($_POST['register'])) {

    if(getMembreBy($pdo, 'pseudo', $_POST['pseudo']) !== null) {
        ajouterFlash('danger', 'Ce pseudo est déjà pris.');

       
     } elseif(strlen($_POST['pseudo']) < 3 || strlen($_POST['pseudo']) > 25) {
         ajouterFlash('danger', 'Le pseudo doit contenir entre 3 et 25 caractères.'); 

    } elseif(strlen($_POST['nom']) < 3 || strlen($_POST['nom']) > 25) {
        ajouterFlash('danger', 'Le nom doit contenir entre 3 et 25 caractères.'); 

       
     } elseif(strlen($_POST['nom']) < 3 || strlen($_POST['nom']) > 25) {
         ajouterFlash('danger', 'Le nom doit contenir entre 3 et 25 caractères.'); 

    } elseif(!preg_match('~^[a-zA-Z0-9_-]+$~', $_POST['pseudo'])) {
        ajouterFlash('danger', 'Le pseudo contient des caractères non-autorisés.');

       
    } elseif(getMembreBy($pdo, 'email', $_POST['email']) !== null) {
        ajouterFlash('danger', 'Cette adresse email est déjà utilisée.');

        
    } elseif(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        ajouterFlash('danger', 'Veuillez indiquer une adresse email valide.');

   
    } elseif(!preg_match('~^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$~', $_POST['password'])) {
        ajouterFlash('danger', 'Le mot de passe doit contenir au minimum : 8caractères, 1 majuscule, 1 minuscule, 1 chiffre, 1 caractère spécial.');

    } elseif(!filter_var($_POST['telephone'], FILTER_SANITIZE_NUMBER_INT) && strlen($_POST['telephone'])==10) {
        ajouterFlash('danger', 'Veuillez indiquer un numéro de téléphone valide à dix chiffres.');

    } else {
     
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
            'statut' => $_POST['statut'],
        ]);

        ajouterFlash('success', 'Vous avez bien été inscrit !');
        ajouterFlash('info', 'Vous pouvez vous connecter.');
        
    }
}

// Affichage

$page_title = "Gestion membres";

include __DIR__ . '/../assets/includes/header_admin.php';
?>


<div class="border col-md-12">

<h1 style="text-align:center;">Gestion Membres</h1>

<?php include __DIR__ .'/../assets/includes/flash.php';?>

<div style="overflow:scroll;">
        
   
        <?php


       
        $result = $pdo->query("SELECT * FROM membre");
        

        echo '<table class="table-bordered text-center";><tr>';
     
        for($i = 0; $i < $result->columnCount(); $i++)
        {
            $colonne = $result->getColumnMeta($i);
            echo "<th>$colonne[name]</th>";
        }

        echo '</tr>';
        while($ligne = $result->fetch(PDO::FETCH_ASSOC))
        {
            echo '<tr>';
            foreach($ligne as $cellule)
            {
                echo "<td>$cellule</td>";

            }    
            

            echo '<td>'.'<form method="post">'.'<button type="submit" name="del">'.'<input type="hidden" name="idsup" value="'.$ligne['id_membre'].'">Supprimer'.'<span class="glyphicon glyphicon-trash"></span>'.'</button>'.'</form>'.'</td>';
        }

            if (isset($_POST['idsup'])){
              $del = $pdo->prepare('DELETE FROM membre WHERE id_membre = ?');
              // $del->bind_param('i', $_POST['id_categorie']);
              $del->execute(array($_POST['idsup']));

            }


            echo '</tr>';
        echo '</table>';
      
        ?>
     </div>
    </div>
<br>
    <h3 class="text-center tm-4">Vous pouvez ajouter un membre, si vous le souhaitez !</h3>


<div class="row p-5">
    <div class="container border pt-4 pb-4 col-md-6">
<form action="gestion_membre.php" method="post" enctype="multipart/form-data">
    <div class="form-groupe">
        <label>Pseudo</label>
        <input type="text" name="pseudo" class="form-control" value="<?= $_POST['pseudo'] ?? ''?>">
    </div>
    <div class="form-group">
                <label>Mot de passe</label>
                <input type="password" name="password" class="form-control">
            </div>
            <div class="form-group">
                <label>Nom</label>
                <input type="text" name="nom" class="form-control" value="<?= $_POST['nom'] ?? ''; ?>">
            </div>
            <div class="form-group">
                <label>Prénom</label>
                <input type="text" name="prenom" class="form-control" value="<?= $_POST['prenom'] ?? ''; ?>">
            </div>
    </div>
 
    <div class="container border pt-4 pb-4 col-md-6">
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="<?= $_POST['email'] ?? ''; ?>">
            </div>
            <div class="form-group">
                <label>Téléphone</label>
                <input type="number" name="telephone" class="form-control" value="<?= $_POST['telephone'] ?? ''; ?>">
            </div>
            <div class="form-group">
                  <label for="sel1">Civilité </label>
                    <select class="form-control"  type="enum" name="civilite" value="<?= $_POST['civilite'] ?? ''; ?>">
                                <option value="m">Homme</option>
                                    <option value="f">Femme</option> 
                                </select>
                            </div>
                        <div class="form-group">
            <label for="sel1">Statut</label>
            <select class="form-control" type="enum" name="statut" value="<?= $_POST['statut'] ?? ''; ?>">
                        <option value="1">Admin</option>
                            <option value="0">User</option> 
                        </select>
                    <br>
            </div>
                    <div class="text-center">
            <input type="submit" name="register" value="Enregistrer" class="btn btn-warning">
        </div>
    </form>
</div>
</div>
<hr>
    </div>

<?php
include __DIR__ . '/../assets/includes/footer.php';
