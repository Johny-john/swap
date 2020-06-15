<?php

//fichier de configuration pour le back-office


include __DIR__ . '/bootstrap.php';


if(role(ROLE_ADMIN) !== true){
    // ... on le redirige sur la page connexion
ajouterFlash('danger', 'Vous n\'avez pas les droit d\'accès admin.');
// session_write_close () Bloque l'acces a admin par un client lambda par url
session_write_close();
header('Location: ../login.php');
}
