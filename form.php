<?php

if($_SERVER['REQUEST_METHOD'] === "POST") {
    // Je récupère l'extension du fichier
    $extension = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
    // Les extensions autorisées
    $authorizedExtensions = ['jpg','jpeg','png'];
    // Le poids max géré par PHP par défaut est de 2M 
    $maxFileSize = 100000;

    /****** Si l'extension est autorisée *************/
    if( in_array($extension, $authorizedExtensions) ) {
            // chemin vers un dossier sur le serveur qui va recevoir les fichiers uploadés
            $uploadDir = 'public/uploads/';
            // le nom de fichier unique
            $uploadFile = $uploadDir . uniqid() . '.' . $extension;
            /****** Si la taille est autorisée *************/
            if( $_FILES['avatar']['size'] > $maxFileSize) {
                $errors[] = "Votre fichier doit faire moins de 1M !";
                echo "Votre fichier doit faire moins de 1M !";
            }
            /****** Si je n'ai pas d'erreur alors j'upload *************/
            if (empty($errors)) {
                if(move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadFile)){
                    // Le fichier a bien été uploadé, on peut afficher l'image
                    ?>
                    <img src="<?php echo $uploadFile; ?>" alt="">
                    <?php
                } else {
                    // Il y a eu une erreur lors de l'upload du fichier
                    $errors[] = 'Une erreur est survenue lors de l\'upload du fichier.';
                }
            }
        
    } else {
        // L'extension du fichier n'est pas autorisée
        $errors[] = "L'extension du fichier n'est pas autorisée.";
    }

    // Si des erreurs ont été détectées, on les affiche
    if(!empty($errors)){
        foreach($errors as $error){
            echo "<p>".$error."</p>";
        }
    }
}  

?>
<form method="post" enctype="multipart/form-data">
    <label for="imageUpload">Upload an profile image</label>    
    <input type="file" name="avatar" id="imageUpload" />
    <button name="send">Send</button>
</form>
