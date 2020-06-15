<?php
/**
 * Ce fichier est le fichier de configuration principal
 * (Cela na rien a voir avec bootstrap CSS)
 * 
 * Il sera le 1er fichier charger sur chacune des pages
 * Il doit contenir toute la configuration néccesaire avant de traité la requete
 * / */

 // Parametres de lapplication
 require_once __DIR__ . '/parametres.php';

 // Connexion a la base de donées BD
 require_once __DIR__ . '/pdo.php';

 // fichier des fonctions
require_once __DIR__ .'/fonctions.php';

// Demarrage de la sessions
session_start();

