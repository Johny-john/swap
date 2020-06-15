<?php
require_once __DIR__ . '/assets/config/bootstrap.php';
require_once('assets/config/init.php');?>

<?php 

// var_dump($_SESSION);

extract($_POST);

$erreur = '';

$content = '';



$page_title = 'Accueil';
include __DIR__ . '/assets/includes/header.php';


if(isset($_POST['login'])){
    $r = execute_requete("SELECT * FROM membre WHERE pseudo ='$_POST[pseudo]'");
  
	if( $r->rowCount() >=1 ){
        $membre = $r->fetch(PDO::FETCH_ASSOC);
       
		
        if( password_verify($_POST['mdp'] , $membre['mdp'])){
            
			$_SESSION['membre']['id_membre'] = $membre['id_membre'];
			$_SESSION['membre']['pseudo'] = $membre['pseudo'];
            $_SESSION['membre']['mdp'] = $membre['mdp'];
			$_SESSION['membre']['nom'] = $membre['nom'];
            $_SESSION['membre']['prenom'] = $membre['prenom'];
            $_SESSION['membre']['telephone'] = $membre['telephone'];
			$_SESSION['membre']['email'] = $membre['email'];
			$_SESSION['membre']['civilite'] = $membre['civilite'];
			$_SESSION['membre']['statut'] = $membre['statut'];
			$_SESSION['membre']['date_enregistrement'] = $membre['date_enregistrement'];	
            
            if( $_SESSION['membre']['statut'] == 0 ){   
                header('location:index.php');
            }
            else {
                header('location:admin/index.php');
            }
            $content .= '<div class="alert alert-success" role="alert">Connexion ok</div>';
        }
		else{
            $content .= '<div class="alert alert-danger text-center" role="alert">Erreur de mot de passe</div>';
        }
    }   
	else{
        $content .= '<div class="alert alert-danger" role="alert">Pseudo inexistant</div>';
    }
}
//======
if( isset($_GET['action']) && $_GET['action'] == 'deconnexion' ){
	session_destroy();
    header('location:connexion.php');
} 


// echo '<pre>'; print_r($_POST); echo '</pre>';

// $bdd= new PDO('mysql:host=127.0.0.1; dbname=swap','root','root');


// if(isset($_POST['forminscription']))
// {
//     $pseudo=htmlspecialchars($_POST['pseudo']);
//     $mail=htmlspecialchars($_POST['email']);
//     $mail2=htmlspecialchars($_POST['email2']);
//     $mpd=sha1($_POST['mdp']);
//     $mpd2=sha1($_POST['mdp2']);
//     if(!empty($_POST['pseudo'])AND !empty($_POST['email']) AND !empty($_POST['email2']) AND 
//     !empty($_POST['mdp']) AND !empty($_POST['mdp2']))
//     {    
//         $pseudolenght=strlen($pseudo);
//         if($pseudolenght <=255)
//         {
//             if($email==$email2)
//             {
//                 if(filter_var($email, FILTER_VALIDATE_EMAIL))
//                 {
//                     if(filter_var($email, FILTER_VALIDATE_EMAIL))
//                     $reqmail=$bdd->prepare("SELECT * FROM membre WHERE email=?");
//                     $reqmail->execute(array($email));
//                     $emailexiste=$reqmail->rowCount();
//                     if ($emailexiste==0)
//                 {
//                     if($mdp == $mdp2)
//                     {
//                         $insertmbr= $bdd-> prepare("INSERT INTO membre(pseudo,email,motdepasse)VALUE(?,?,?)");
//                         $insertmbr->execute(array($pseudo, $email, $mpd));
//                         $erreur= "Vos informations ont bien étés modifiées !";
//                     }
//                     else
//                     {
//                         $erreur .= "vos mots de passe ne correspondent pas !";   
//                     }
//                 }
//                 else
//                 {
//                     $erreur.= "Adresse mail déja utiliser";
//                 }
//             }
//                 else
//                 {
//                     $erreur .="Votre adresses mail n'est pas valide !"; 
//                 }
//             }
            
//             else
//             {
//                 $erreur .="Vos adresses mail ne correspondent pas !";   
//             }
//         }
//         else
//         {
//             $erreur .="Votre pseudo ne doit pas depasser 255 caracteres !";
//         }
    
//     }
//     else
//     { 
//         $erreur .="Tous les champs doivent être complètés !";
//     }
// }

if(isset($_POST['forminscription'])){
	//debug($_POST);
    execute_requete(" UPDATE membre SET pseudo = '$_POST[pseudo]', nom = '$_POST[nom]', prenom = '$_POST[prenom]', telephone = '$_POST[telephone]', email = '$_POST[email]', civilite = '$_POST[civilite]', statut = '$_POST[statut]' WHERE id_membre= '$_GET[id_membre]'");
}

?>


<html lang="fr">
    <head>
        <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <meta http-equiv="X-UA-Compatible" content="ie=edge">
                    <title>Profil</title>
                </head>
                <body >

                    <link
                        href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css"
                        rel="stylesheet"
                        id="bootstrap-css">
                        <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>

<div class="container">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 >Modifier Mon Profile</h4>
            </div>
            <div class="panel-body">
            <div class="col-md-4 col-xs-12 col-sm-6 col-lg-4">
                <img
                    alt="User Pic"
                    src="https://x1.xingassets.com/assets/frontend_minified/img/users/nobody_m.original.jpg"
                    id="profile-image1"
                    class="img-circle img-responsive">
            </div>
                    <div class="col-md-8 col-xs-12 col-sm-6 col-lg-8">
                        <div class="container">
                            <h2>Modifier</h2>
                            <p>Pseudo:
                                <b>
                                </span><?= getMembre()['pseudo'] ?></b>
                            </p>
                        </div>
                        <form method="POST"  action="">
                        
<table>
        <tr>
            <td align="right"><label for="pseudo">Pseudo:</label></td>   
            <td><input type="text" placeholder="Votre Pseudo" id="pseudo" name="pseudo" value="<?php if(isset($pseudo)){echo $pseudo;}?>"></td>  
        </tr>

        <tr>
                <td align="right"><label for="email">Email:</label></td>   
                <td><input type="email" placeholder="Votre email" id="email" name="email" value="<?php if(isset($email)){echo $email;}?>" ></td>  
        </tr>

        <tr>
                <td align="right"><label for="email2">Email:</label></td>   
                <td><input type="email" placeholder="Confirmez votre mail" id="email2" name="email2" value="<?php if(isset($email2)){echo $email2;}?>"></td>  
        </tr>

        <tr>
                <td align="right"><label for="mdp">Mot de passe:</label></td>   
                <td><input type="password" placeholder="Mot de passe" id="mdp" name="mdp"></td> 
                
                <tr>
                <td align="right"><label for="mdp2">mot de passe:</label></td>   
                <td><input type="password" placeholder="Confirmez votre MDP" id="mdp2" name="mdp2"></td>  
        </tr>
        </tr>  
        
        <tr>
            <td></td>
            <br>
            <td align="center"><input type="submit" name="forminscription" value="Modifier"></td>
        </tr>
<?php 
    if(isset($erreur))
    {
    echo '<font color="red">' .$erreur.'</font>'; 
    }
?>        
</table>
</div>
<?php 
    $date=date('d-m-Y');
    $heure=date('H:i');
    echo"Nous sommes le $date et il est $heure";                          
?>
            </div>            
        </div>
    </div>
</div>


</form>
<br> <br>
            </div>
        </div>
    </div>
</div>

</body>
</html>                                <?php
include __DIR__ . '/assets/includes/footer.php';