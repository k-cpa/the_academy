<?php 
    include ('database.php');
    
    // Vérifie si l'ID de l'élément est passé dans l'URL + source de la page
    if (isset($_GET['id'])) {
        $spell_id = htmlspecialchars($_GET['id']);

        // Initisalisation d'un message vide pour prévenir l'utilisateur que l'élément a été ajouté
        $successMessage = '';

        // Préparation de la requête pour récupérer l'élément de la database
        $request = $bdd->prepare ('
            SELECT * 
            FROM spells
            WHERE spell_id = :spell_id 
        ');

        $request->execute([
            'spell_id' => $spell_id
        ]);
        $data = $request->fetch();

        if(isset($_POST["spell_name"]) && isset($_POST["description"])){
            $spell_id = htmlspecialchars($_POST["spell_id"]);
            $spell_name = htmlspecialchars(trim(strtolower($_POST["spell_name"])));
            $description = htmlspecialchars(trim($_POST["description"]));

            if($_FILES["image"]['error'] === UPLOAD_ERR_NO_FILE){
                $updateRequest = $bdd->prepare("  UPDATE spells
                                            SET spell_name=:spell_name, description=:description
                                            WHERE spell_id=:spell_id AND user_id = :user_id
                ");
                $updateRequest->execute([
                    "spell_name"    => $spell_name,
                    "description"   => $description,
                    "spell_id"      => $spell_id
                ]);
                header("Location:codex.php");
            }else{
                $fileName = $_FILES['image']['name']; // nom original du fichier
                $tmpName = $_FILES['image']['tmp_name']; // nouveau nom du fichier
                $location = 'assets/sorts/'; // dossier de destination des img
                $imageFileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION)); // Extension du fichier en minuscule
        
                $autorizedExtension = ['png', 'jpeg', 'jpg', 'webp', 'bmp', 'svg'];
        
                // Vérifie si extension img est dans la liste des extensions autorisées
                if (in_array($imageFileType, $autorizedExtension)) {
                    // Génère un nom de ficier unique pour éviter le conflit
                    $uniqueFileName = uniqid('Image_', true) . '.' . $imageFileType;
                    // Déplace l'image dans le dossier 
                    move_uploaded_file($tmpName, $location.$uniqueFileName);
                } else {
                    echo "Please choose an image in PNG, JPEG, WEBP, BMP, or SVG format.";
                    exit;
                }
                $updateRequest = $bdd->prepare('
                UPDATE spells
                                        SET spell_name = :spell_name, description = :description, image = :image
                                        WHERE spell_id = :spell_id
                ');
                $updateRequest->execute([
                    "spell_name"    => $spell_name,
                    "description"   => $description,
                    "image"         => $uniqueFileName,
                    "spell_id"      => $spell_id
                ]);
                header("Location:codex.php");
                exit;
            }
        }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Edit</title>
</head>
<body>
<section id="add">
        <div class="add_title">
            <h3>Modify the spell</h3>
        </div>
        <article class="container add_container">
            <form action="modify_spell.php" method="post" enctype="multipart/form-data">
                <input type="text" id="spell_name" name="spell_name" value="<?= $data['spell_name'] ?>" required>
                <textarea id="description" name="description" required><?= $data['description'] ?></textarea>
                <input type="file" id="image" name="image">
                <input type="hidden" name="spell_id" value="<?php echo $data['spell_id'];?>">
                <button type="submit">Modify the spell</button>
            </form>
            <?php if (!empty($successMessage)) : ?>
                <p class="succes_message"><?= $successMessage ?></p>
            <?php endif; ?>
        </article>
    </section>
</body>
</html>
