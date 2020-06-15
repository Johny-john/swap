
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
        <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
        <link href="https://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
        <title><?= $page_title ?>
            | SWAP</title>
    </head>

    <body>
        <nav class="navbar navbar-expand-lg navbar-light bg-dark">
            <ul class="navbar-nav mr-auto">

            <li class="class item">
                <a class="nav-link" href="profil.php" style="color:white"><?= getMembre()['pseudo'] ?></a>
            </li>

                <li class="nav-item">
                    <a class="nav-link" href="index.php" style="color:red">Accueil</a>
                </li>
                <?php if(getMembre() === null) : ?>

                <li class="nav-item">
                    <a class="nav-link" href="#" style="color:orange">Qui Sommes Nous</a>
                </li>

                <li class="nav-item dropdown">
                    <a
                        class="nav-link dropdown-toggle"
                        href="#"
                        id="navbarDropdown"
                        role="button"
                        data-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false"
                        style="color:orange">
                        Espace membre
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="register.php">Inscription</a>
                        <a class="dropdown-item" href="login.php">Connexion</a>
                    </div>
                </li>
            </ul>
        <?php else:?>
            <li class="nav-item">
                <a class="nav-link" href="post_ajouter.php" style="color:orange">Déposer une annonce</a>
            </li>            

            <li class="nav-item dropdown">
                    <a
                        class="nav-link dropdown-toggle"
                        style="color:orange"
                        href="#"
                        id="navbarDropdown"
                        role="button"
                        data-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false"
                        style="color:yellow">
                        Espace membre
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item">
                        <a class="dropdown-item" href="modification_profil.php">Modifier</a>
                        <a class="dropdown-item" href="login.php?logout" style="color:red">Déconnexion</a>
                    </div>
                </li>

            <?php if(role(ROLE_ADMIN)) :?>
            <li class="nav-item">
                <a class="btn btn-outline-warning mt-1 mr-3" href="admin/gestion_categorie.php">Back-office</a>
            </li>
            <?php endif; ?>
            <?php endif; ?>

            <form action="search.php" method="get" class="form-inline mt-1">
      <input type="search" name="recherche" class="form-control mr-sm-2">
      <input type="submit" value="Rechercher" class="btn btn-outline-success my-2 my-sm-0">
    </form>

    

    
    </nav> 
