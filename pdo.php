<?php

// Connexion a la base de données
/**
 * 
 * Un bloc try catch permet d'intercepter les erreurs de type exception
 * une Exception est un objet de la classe exception
 * 
 * On tente d'executer le code du bloc try
 * Si une Exception est lancée durant l'exécution, le bloc catch sera éxécuté
 * / */
try{
    $pdo = new PDO(
        sprintf('mysql:host=%s;dbname=%s;' , DB_HOST, DB_NAME),
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
        ]
    );
}catch(Exception $e){
    die('Erreur de connexion à MySQL:' . $e->getMessage());
}
