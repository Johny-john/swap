<?php

// 1) Configuration
require_once __DIR__ . '/assets/config/bootstrap.php';



// 3) Traitement
if (isset($_POST['ajouter'])){

    if(empty($_POST['titre']) || strlen($_POST['titre']) > 100 ){
        ajouterFlash('danger' ,'Le titre doit contenir entre 1 et 100 caractères.');
       

    }elseif (empty($_POST['contenu']) || strlen($_POST['contenu']) > 50 ){
            ajouterFlash('danger' ,'La description courte doit contenir entre 1 et 50 caractères.');

    }elseif (empty($_POST['contenu_sup']) || strlen($_POST['contenu_sup']) > 250 ){
            ajouterFlash('danger' ,'La description longue doit contenir entre 1 et 250 caractères.');

    }elseif (empty($_POST['prix'])){
        ajouterFlash('danger','Prix manquant.');


    }elseif (empty($_POST['categorie'] )){
        ajouterFlash('danger','Vous n\'avez pas sélectionné de catégorie.');
    
                //verification de l'envoi du fichier
    }elseif($_FILES['photo1']['error'] !== UPLOAD_ERR_OK){
        ajouterFlash('warning','Probleme lors de l\'envoi de la photo1.');          

    }elseif ($_FILES['photo1']['size'] < 12 || exif_imagetype($_FILES['photo1']['tmp_name']) === false ){
        ajouterFlash('danger','Le fichier envoyé n\'est pas une photo');

    }elseif($_FILES['photo2']['error'] !== UPLOAD_ERR_OK){
        ajouterFlash('warning','Probleme lors de l\'envoi de la photo2.');          

    }elseif ($_FILES['photo2']['size'] < 12 || exif_imagetype($_FILES['photo2']['tmp_name']) === false ){
        ajouterFlash('danger','Le fichier envoyé n\'est pas une photo');

    }elseif($_FILES['photo3']['error'] !== UPLOAD_ERR_OK){
        ajouterFlash('warning','Probleme lors de l\'envoi de la photo3.');          

    }elseif ($_FILES['photo3']['size'] < 12 || exif_imagetype($_FILES['photo3']['tmp_name']) === false ){
        ajouterFlash('danger','Le fichier envoyé n\'est pas une photo');

    }elseif($_FILES['photo4']['error'] !== UPLOAD_ERR_OK){
        ajouterFlash('warning','Probleme lors de l\'envoi de la photo4.');          

    }elseif ($_FILES['photo4']['size'] < 12 || exif_imagetype($_FILES['photo4']['tmp_name']) === false ){
        ajouterFlash('danger','Le fichier envoyé n\'est pas une photo');


    }elseif($_FILES['photo5']['error'] !== UPLOAD_ERR_OK){
    ajouterFlash('warning','Probleme lors de l\'envoi de la photo5.');          

    }elseif ($_FILES['photo5']['size'] < 12 || exif_imagetype($_FILES['photo5']['tmp_name']) === false ){
        ajouterFlash('danger','Le fichier envoyé n\'est pas une photo');



    // }elseif (empty($_POST['pays']) || ($_POST['pays'])){
    //     ajouterFlash('danger' ,'Veuillez indiquez un pays.');

    }elseif (empty($_POST['ville']) || ($_POST['ville']) > 20 ){
        ajouterFlash('danger' ,'Veuillez indiquez une ville.');


    }elseif (empty($_POST['adresse']) || ($_POST['adresse']) > 255 ){
        ajouterFlash('danger' ,'Veuillez indiquez une adresse valide.');

    }elseif (empty($_POST['cp']) || ($_POST['cp']) == 5 ){
        ajouterFlash('danger' ,'Veuillez indiquez un Code postal a 5 chiffres.');

}else{
            // Récuperation de l'extention du fichier d'origine
            $extension1 = pathinfo($_FILES['photo1']['name'],PATHINFO_EXTENSION);
            $extension2 = pathinfo($_FILES['photo2']['name'],PATHINFO_EXTENSION);
            $extension3 = pathinfo($_FILES['photo3']['name'],PATHINFO_EXTENSION);
            $extension4 = pathinfo($_FILES['photo4']['name'],PATHINFO_EXTENSION);
            $extension5 = pathinfo($_FILES['photo5']['name'],PATHINFO_EXTENSION);

            $path = __DIR__ . '/assets/img';

    do{
        $filename1 = bin2hex(random_bytes(16));
    
        $complete_path1 = $path . '/' .$filename1 . '.' . $extension1;

    
    }while (file_exists($complete_path1));

    do{
        $filename2 = bin2hex(random_bytes(16));
    
        $complete_path2 = $path . '/' .$filename2 . '.' . $extension2;

    
    }while (file_exists($complete_path2));

    do{
        $filename3 = bin2hex(random_bytes(16));
    
        $complete_path3 = $path . '/' .$filename3 . '.' . $extension3;

    
    }while (file_exists($complete_path3));

    do{
        $filename4 = bin2hex(random_bytes(16));
    
        $complete_path4 = $path . '/' .$filename4 . '.' . $extension4;

    
    }while (file_exists($complete_path4));

    do{
        $filename5 = bin2hex(random_bytes(16));
    
        $complete_path5 = $path . '/' .$filename5 . '.' . $extension5;

    
    }while (file_exists($complete_path5));


    if (!move_uploaded_file($_FILES['photo1']['tmp_name'], $complete_path1)) {

        ajouterFlash('danger', 'l\'image n\'a pas pu etre enrengistré');
    }
    if (!move_uploaded_file($_FILES['photo2']['tmp_name'], $complete_path2)) {
        ajouterFlash('danger', 'l\'image n\'a pas pu etre enrengistré');
    }
    if (!move_uploaded_file($_FILES['photo3']['tmp_name'], $complete_path3)) {
        ajouterFlash('danger', 'l\'image n\'a pas pu etre enrengistré');
    }
    if (!move_uploaded_file($_FILES['photo4']['tmp_name'], $complete_path4)) {
        ajouterFlash('danger', 'l\'image n\'a pas pu etre enrengistré');
    }
    if (!move_uploaded_file($_FILES['photo5']['tmp_name'], $complete_path5)) {
        ajouterFlash('danger', 'l\'image n\'a pas pu etre enrengistré');
    
    }else{

         //Enregistrement BDD
             $req1 =$pdo->prepare(
                'INSERT INTO photo(photo1, photo2, photo3, photo4, photo5)
                VALUE (:photo1, :photo2, :photo3, :photo4, :photo5)'
            );
            $req1->bindValue(':photo1', $filename1 . '.' . $extension1);
            $req1->bindValue(':photo2', $filename2 . '.' . $extension2);
            $req1->bindValue(':photo3', $filename3 . '.' . $extension3);
            $req1->bindValue(':photo4', $filename4 . '.' . $extension4);
            $req1->bindValue(':photo5', $filename5 . '.' . $extension5);

            $req1->execute();
            $photos = $pdo->lastInsertId();



            // $req2 = $pdo->prepare(
            //     'INSERT INTO categorie(titre, motsclefs)
            //     VALUE(:titre, :motscles)'
            // );
            // $req2->bindParam(':categorie', $_POST['categorie']);
            // $req2->bindParam(':motsclefs', $_POST['motscles']);




            $req3 =$pdo->prepare(
                'INSERT INTO annonce(titre, description_courte, description_longue, photo, prix, pays, ville, adresse, cp, membre_id, photo_id, categorie_id, date_enregistrement )
                VALUE (:titre, :description_courte, :description_longue, :photo1, :prix, "France", :ville, :adresse, :cp, :membre_id, :photo_id, :categorie_id, NOW())'
            );
            // $req3->bindParam(':pseudo',getMembre()['pseudo'], PDO::PARAM_INT);
            $req3->bindParam(':titre', $_POST['titre']);
            $req3->bindParam(':description_courte', $_POST['contenu']);
            $req3->bindParam(':description_longue', $_POST['contenu_sup']);
            $req3->bindValue(':photo1', $filename1 . '.' . $extension1);
            $req3->bindParam(':prix', $_POST['prix']);
            // $req->bindParam(':pays', $_POST['pays']);
            $req3->bindParam(':ville', $_POST['ville']);
            $req3->bindParam(':adresse', $_POST['adresse']);
            $req3->bindParam(':cp', $_POST['cp']);
            $req3->bindParam(':membre_id',getMembre()['id_membre'], PDO::PARAM_INT);
            $req3->bindParam(':photo_id', $photos);
            $req3->bindParam(':categorie_id', $_POST['categorie'], PDO::PARAM_INT);
            // $req->bindValue(':date', (new DateTime())->format('Y-m-d H:i:s'));
            $req3->execute();


            // Pour vider le formulaire
            unset($_POST);
            ajouterFlash('success','Votre annonce est enregistrée !');
            header('Location: index.php');
            session_write_close();
        

        }  

    } 
}


// 2) Affichage
$page_title = "Deposer une annonce";
include __DIR__ .'/assets/includes/header.php';
?>
    <div class="row p-5">
    <div class="container border mt-4 pb-4 col-md-6">
        <h1>Déposer une annonce</h1>

        <?php include __DIR__ . '/assets/includes/flash.php'; ?>
    <!-- Pour pouvoir envoyer des fichiers, il faut preciser
    enctype='multipart/form-data' -->
        <form action="post_ajouter.php" method="post" enctype="multipart/form-data">
    <div class="form-groupe">
        <label>Titre</label>
        <input type="text" name="titre" class="form-control" value="<?= $_POST['titre'] ?? ''?>">
    </div>
    <div class="form-group">
        <label>Description Courte</label>
        <textarea name="contenu" class="form-control"><?= $_POST['contenu'] ?? ''; ?></textarea>
    </div>
    <div class="form-group">
        <label>Description Longue</label>
        <textarea name="contenu_sup" class="form-control"><?= $_POST['contenu_sup'] ?? ''; ?></textarea>
    </div>
    <label>Prix en €</label>
    <input type="number" name="prix" class="form-control" value="<?= $_POST['prix'] ?? ''; ?>">
    <br>
<label>Catégorie</label>
    <select name="categorie" method="post" class="form-control">
<?php

    $result = $pdo->query('SELECT DISTINCT id_categorie, titre FROM categorie ');
    while($categories = $result->fetch(PDO::FETCH_ASSOC)):
         //print_r($categories);
        ?>  
        <option value="<?= $categories['id_categorie']?>"><?= $categories['titre']?>
        </option>
        <?php endwhile; ?> 
        </select>
    </div>
    


    <hr>
        <div class="container border mt-4 pb-4 col-md-6 ">
        <div class="custom-file">
            <input type="file" name="photo1" class="custom-file-input" id="customFile1">
            <label for="customFile1" class="custom-file-label" id="etiquette_image1">Photo1</label>
      
        <div class="custom-file">
            <input type="file" name="photo2" class="custom-file-input" id="customFile2">
            <label for="customFile2" class="custom-file-label" id="etiquette_image2">Photo2</label>
            </div>
            <div class="custom-file">
            <input type="file" name="photo3" class="custom-file-input" id="customFile3">
            <label for="customFile3" class="custom-file-label" id="etiquette_image3">Photo3</label>
            </div>
            <div class="custom-file">
            <input type="file" name="photo4" class="custom-file-input" id="customFile4">
            <label for="customFile4" class="custom-file-label" id="etiquette_image4">Photo4</label>
            </div>
            <div class="custom-file">
            <input type="file" name="photo5" class="custom-file-input" id="customFile5">
            <label for="customFile5" class="custom-file-label" id="etiquette_image5">Photo5</label>
            </div>
            </div>
            <!-- -------------------------- Affichage ----------------------- -->
        
    <?php for($i =0; $i <5; $i++) : ?>
        <div class="container">
        <div class="row">
            <div class="mt-2" id="preview<?= ($i+1)?>"></div>
            </div>
            </div>
    <?php endfor; ?>
    
            <label>Ville</label>
            <input type="text" name="ville" class="form-control"value="<?= $_POST['ville'] ?? ''; ?>">
            <br>
            <div class="form-group">
                <label>Adresse</label>
                <textarea name="adresse" class="form-control" value="<?= $_POST['adresse'] ?? ''; ?>"></textarea>
            </div>
            <br>
            <div class="form-group">
                <label>Code Postal</label>
                <input type="number" name="cp" class="form-control" value="<?= $_POST['cp'] ?? ''; ?>">
            </div>     
        </div>
    </div>
</div>
        <br>
    <div class="text-center">
    <input type="submit" name="ajouter" value="Enregistrer" class="btn btn-success">
    </div>
        </form>

    
    <hr>
        

    <?php include __DIR__ .'/assets/includes/footer.php';?>
    <!-- -------------------- Code Js -----------------------------------------  -->
<script>
    function handleFiles(file, preview) {
        preview.innerHTML = "";
        let imageType = /^image\//;

        if (!imageType.test(file.type)) {
            return null;
        }

        let img = document.createElement("img");
        img.classList.add("image_preview");
        img.file = file;
        preview.appendChild(img);
        img.style.width = '100px';
        let reader = new FileReader();
        console.log(img);
        reader.onload = (function (aImg) {
            return function (e) {
                aImg.src = e.target.result;
            };
        })(img);
        reader.readAsDataURL(file);
    }
    for (let i = 0; i < 5; i++) {

        let inputFileElt = document.getElementById('customFile' + (i + 1));
        let etiquetteImageElt = document.getElementById('etiquette_image' + (i + 1));
        let previewElt = document.getElementById('preview' + (i + 1));
        // console.log(inputFileElt);
        // console.log(etiquetteImageElt);


        inputFileElt.addEventListener('change', function () {
            handleFiles(inputFileElt.files[0], previewElt);
            let nom_image = (inputFileElt.files[0]['name'].length < 25) ? inputFileElt.files[0]['name'] :
                '...' + inputFileElt.files[0]['name'].substr(inputFileElt.files[0]['name'].length - 25, 25);
            etiquetteImageElt.textContent = nom_image;
        });

    }   

    
</script>