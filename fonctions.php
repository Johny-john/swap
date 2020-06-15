<?php

/**
 * Fichier contenant toutes les fonctions de l'application
 */

/**
 * Ajouter un message flash
 * @param string $type      erreur, success, etc
 * @param string $message   le message à afficher
 * @param void
 */

function ajouterFlash(string $type, string $message) : void 
{
    // Enregistrement du message dans un tableau en session
    // $tableau[] =     insère en fin de tableau et créée le tableau s'il n'existe pas 
    $_SESSION['flash'][] = [
        'type' => $type,
        'message' => $message,
    ];
}

/**
 * Récupérer les messages flash
 * @return array
 */

 function recupererFlash() : array
 {

    // récupération des messages en session s'il y en a
    $messages = $_SESSION['flash'] ?? [];
    // Suppression des messages en session (pas d'erreur si déjà inexistant)
    unset($_SESSION['flash']);

    // Renvoi des messages
    return $messages;

    }


/**
 * Récupérer un membre par un critère
 * @param PDO $pdo
 * @param string $colonne       nom de la colonne sur laquelle rechercher
 * @param mixed $valeur         valeur de la $colonne
 *  */ 

function getMembreBy(PDO $pdo, string $colonne, $valeur) : ?array
{
    $req = $pdo->prepare(sprintf(
        'SELECT *
        FROM membre
        WHERE %s = :valeur',
        $colonne
    ));
    $req->bindParam(':valeur', $valeur);
    $req->execute();

    $membre = $req->fetch(PDO::FETCH_ASSOC);
    return $membre ?: null;
}


function getMembre() : ? array {
    return $_SESSION['utilisateur'] ?? null;
}


function getPseudoId(PDO $pdo) : array
{
    $req = $pdo->query(
        'SELECT *
        FROM annonce
        WHERE  membre_id = :membre_id '
    );

    $pseudo = $req->fetchAll(PDO::FETCH_ASSOC);
    return $pseudo;
}



/**
* Verifier que l'utilisateur courant a un certain role/statut
*@param int $role
*@return bool
*/
function role(int $role) : bool {
// en BDD le role est enregistré dans la colonne "statut"
// il y a peut-être pas d'utilisateur connecter
if(getMembre() === null){
    return false;
}
// pas de comparaison strict car la super-globale ne contiens que des string
return getMembre()['statut'] == $role;

// l'utilisateur et sous forme de tableau associatif ! retourner par 
// getUtilisateur()
}


// TEST

function getCategorie(PDO $pdo, $id) : ?array
{
    // Vérification de la valeur de $id
    if (!ctype_digit($id)) {
        return null;
    }

    $req = $pdo->prepare(
        'SELECT *
        FROM categorie
        WHERE id = :id'
    );
    $req->bindParam(':id', $id, PDO::PARAM_INT);
    $req->execute();

    $categorie = $req->fetch(PDO::FETCH_ASSOC);
    // Récupérer la première valeur truthy: $val1 ?: $val2 ?: $val3
    // return $post ? $post : null;
    return $categorie ?: null;
}


function getPhoto(PDO $pdo, $photo_id) : ?array
{
    // Vérification de la valeur de $id
    if (!ctype_digit($photo_id)) {
        return null;
    }

    $req = $pdo->prepare(
        'SELECT *
        FROM photo
        WHERE id_photo = :id'
    );
    $req->bindParam(':id', $photo_id, PDO::PARAM_INT);
    $req->execute();

    $photo = $req->fetch(PDO::FETCH_ASSOC);
    // Récupérer la première valeur truthy: $val1 ?: $val2 ?: $val3
    // return $post ? $post : null;
    return $photo ?: null;
}


// /**
//  * Récupérer l'id d'une catégorie
//  * @param PDO $pdo
//  * @param string $categorie
//  * @return int|false
//  */

// function getCategorieId(PDO $pdo, string $categorie) : ?int
// {
//     $req = $pdo->prepare(
//         'SELECT id_categorie
//         FROM categorie
//         WHERE titre = :categorie'
//     );
//     $req->bindParam(':categorie', $categorie);
//     $req->execute();
//     $categories = $req->fetch(PDO::FETCH_ASSOC);
//     if($categories['id_categorie'] == null){
//         return false;
//     }
//     return $categories['id_categorie'];
// }

function listCategorie(PDO $pdo) : array{

    $req = $pdo->query(
        'SELECT *
        FROM categorie
    '
    );
    $posts = $req->fetchAll(PDO::FETCH_ASSOC);
    return $posts;
}

/**
 * Obtenir la liste des posts des plus récents aux plus anciens
 * @param PDO $pdo
 * @return array
 */
function listeAnnonces(PDO $pdo) : array
{
    $req = $pdo->query(
        'SELECT *
        FROM annonce
        ORDER BY date_enregistrement DESC'
    );

    $annonces = $req->fetchAll(PDO::FETCH_ASSOC);
    return $annonces;
}


function listeAnnoncesId(PDO $pdo) : array
{
    $req = $pdo->query(
        'SELECT *
        FROM annonce
        WHERE id_annonce = membre_id'
    );

    $annoncesId = $req->fetchAll(PDO::FETCH_ASSOC);
    return $annoncesId;
}


/**
 * Récupérer 1 annonce
 * @param PDO $pdo
 * @param mixed $id_annonce
 * @return array|null
 */
function getAnnonce(PDO $pdo, $id_annonce) : ?array
{
    // Vérification de la valeur de $id
    if (!ctype_digit($id_annonce)) {
        return null;
    }

    $req = $pdo->prepare(
        'SELECT *
        FROM annonce
        WHERE id_annonce = :id'
    );
    $req->bindParam(':id', $id_annonce, PDO::PARAM_INT);
    $req->execute();

    $annonce = $req->fetch(PDO::FETCH_ASSOC);
    // Récupérer la première valeur truthy: $val1 ?: $val2 ?: $val3
    // return $post ? $post : null;
    return $annonce ?: null;
}
function getAnnonceBy(PDO $pdo, $membre_id) : ?array
{
    // Vérification de la valeur de $id
    if (!ctype_digit($membre_id)) {
        return null;
    }

    $req = $pdo->prepare(
        'SELECT *
        FROM annonce
        WHERE membre_id = :id'
    );
    $req->bindParam(':id', $membre_id, PDO::PARAM_INT);
    $req->execute();

    $annonceBy = $req->fetch(PDO::FETCH_ASSOC);
    // Récupérer la première valeur truthy: $val1 ?: $val2 ?: $val3
    // return $post ? $post : null;
    return $annonceBy ?: null;
}





function listeCommentaire(PDO $pdo) : array
{
    $req = $pdo->query(
        'SELECT *
        FROM commentaire
        ORDER BY date_enregistrement DESC'
    );

    $commentaire = $req->fetchAll(PDO::FETCH_ASSOC);
    return $commentaire;
}



function getCommentaires(PDO $pdo, $id_commentaire) : ?array
{
    // Vérification de la valeur de $id
    if (!ctype_digit($id_commentaire)) {
        return null;
    }

    $req = $pdo->prepare(
        'SELECT *
        FROM commentaire
        WHERE id_commentaire = :id'
    );
    $req->bindParam(':id', $id_commentaire, PDO::PARAM_INT);
    $req->execute();

    $commentaires = $req->fetch(PDO::FETCH_ASSOC);
    // Récupérer la première valeur truthy: $val1 ?: $val2 ?: $val3
    // return $post ? $post : null;
    return $commentaires ?: null;
}

function getCommentairesByPost(PDO $pdo, int $post_id) : array{

    $req = $pdo->prepare(
       'SELECT *
       FROM commentaire 
       WHERE annonce_id = :annonce_id
       ORDER BY date_enregistrement DESC'
    );
    $req->bindParam(':annonce_id', $post_id, PDO::PARAM_INT);
    $req->execute();
 
    return $req->fetchall(PDO::FETCH_ASSOC);
      
  }


  function getPost(PDO $pdo, $id) : ?array{

    //Vérification de la valeur du $id
    if(!ctype_digit($id)){
 return null;
 
    }
 
       $req =$pdo->prepare(
          'SELECT *
          FROM annonce
          WHERE id_annonce = :id_annonce'
       );
       $req->bindParam(':id_annonce', $id, PDO::PARAM_INT);
       $req->execute();
 
       $post = $req->fetch(PDO::FETCH_ASSOC);
   //Récuperer la première valeur truthy: $val1 ?: $val2 ?: $val3
       // return $post ? $post : null;
       return $post ?: null; 
 }

//  function execute_requete($req){
// 	global $pdo;
// 	$r = $pdo->query($req);
//     return $r;
//  }

 function getReponseByCommentaire(PDO $pdo, int $commentaire) : array{

    $req = $pdo->prepare(
       'SELECT *
       FROM commentaire
       WHERE commentaire = :commentaire
       ORDER BY date_publication ASC'
       
    );
    $req->bindParam(':commentaire', $commentaire, PDO::PARAM_INT);
    $req->execute();
 
    return $req->fetchAll(PDO::FETCH_ASSOC);
 }


 function getCommentaire(PDO $pdo, $id_commentaire) : ?array{

    //Si $id n'est pas un entier (en chaine de caractères)
 if(!ctype_digit($id_commentaire)){
    return null;
    }
 $req = $pdo->prepare(
    'SELECT *
    FROM commentaire
    WHERE id_commentaire = :id_commentaire'
    );
    $req->bindParam(':id_commentaire', $id_commentaire, PDO::PARAM_INT);
    $req->execute();

    return $req->fetch(PDO::FETCH_ASSOC) ?: null;
} 


 

function getNoteBy(PDO $pdo, string $colonne, $valeur) : ?array
{
    $req = $pdo->prepare(sprintf(
        'SELECT *
        FROM note
        WHERE %s = :valeur',
        $colonne
    ));
    $req->bindParam(':valeur', $valeur);
    $req->execute();

    $note = $req->fetch(PDO::FETCH_ASSOC);
    return $note ?: null;
}

?>
