    <!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link
            rel="stylesheet"
            href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
            integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
            crossorigin="anonymous">

        <title><?= $page_title ?>
            | SWAP</title>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-light bg-dark">
            <ul class="navbar-nav mr-auto">
            <li class="nav-item">
        <a class="nav-link text-light" style="color:red" href="../">Retour</a>
        </li>
        <li class="nav-item">
                <a class="nav-link"  style="color:orange" href="../admin/gestion_categorie.php">Gestion des catégories</a>
            </li>
            <li class="nav-item">
                <a class="nav-link"  style="color:orange" href="../admin/gestion_membre.php">Gestion des membres</a>
            </li>  
            <li class="nav-item">
                <a class="nav-link"  style="color:orange" href="../admin/gestion_annonce.php">Gestion des Annonces</a>
            </li>
            <li class="nav-item">
                <a class="nav-link"  style="color:orange" href="../admin/gestion_commentaire.php">Gestion des commentaires</a>
            </li>
            <li class="nav-item">
                <a class="nav-link"  style="color:orange" href="../admin/gestion_note.php">Gestion des notes</a>
            </li>
    
    
            <li class="nav-item">
                <a class="nav-link" href="../login.php?logout" style="color:red;">Déconnexion</a>
            </li>
            
          
        


        </nav>

        

    </body>
</html>