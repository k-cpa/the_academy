<?php  
    include ('database.php');

        // vérifier si l'utilisateur est connecté pour afficher la page
        if (!isset($_SESSION['id'])) {
            header ('location: index.php');
            exit;
        } 
        // Initialisation d'un message vide pour prévenir l'utilisateur que l'élément a été ajouté
        $successMessage = '';
    
        $type = $bdd->prepare ('
            SELECT element_id, element_name
            FROM elements
        ');
    
        $type->execute([]);
    
        if (isset($_FILES['image'])) {
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
        }
    
        // Vérifie si champs du form sont bien ont été envoyés
        if (isset($_POST['spell_name']) && isset($_POST['description']) && isset($_POST['element_name'])) {
            // Récupère et sécurise les valeurs soumises par l'utilisateur
            $spell_name = htmlspecialchars($_POST['spell_name']);
            $description = htmlspecialchars($_POST['description']);
            $element_name = ($_POST['element_name']);
            $user_id = $_SESSION['id'];
    
            // Préparation requette SQL pour insérer les données dans database
            $request = $bdd-> prepare ('
                INSERT INTO spells (spell_name, description, image, user_id, element_id)
                VALUES (:spell_name, :description, :image, :user_id, :element_id)
            ');
    
            // Exécute la requete 
            $request->execute([
                'spell_name' => $spell_name,
                'description' => $description,
                'image' => $uniqueFileName, // Nom unique de l'image qu'on récupère à stocker 
                'user_id' => $user_id,
                'element_id' => $element_name
            ]);
    
            // Si réussite = message pour l'utilisateur et possibilité d'ajouter un nouveau monstre
            $successMessage = "The spell is successfully added, congratulations wizard !";
        } 
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Add spells</title>
</head>
<body>
    <?php include ('header.php')?>
    <section id="add">
        <div class="add_title">
            <h3>Add a new Spell</h3>
        </div>
        <article class="container add_container">
            <form action="add_spell.php#add" method="post" enctype="multipart/form-data">
                <input type="text" id="spell_name" name="spell_name" placeholder="Spell name" required>
                <textarea id="description" name="description" placeholder="Description of the spell" required></textarea>
                <select id="element_name" name="element_name">
                    <option value="" disabled selected>Select an element</option>
                    <!-- Affiche chaque type de monstre dans le select -->
                    <?php
                        while($row = $type->fetch()) {
                            $element_id = $row['element_id'];
                            $element_name = $row['element_name'];

                            echo '<option value="' . $element_id . '">' . $element_name . '</option>';
                        }
                    ?>
                </select>
                <input type="file" id="image" name="image">
                <button type="submit">Add Spell</button>
            </form>
            <?php if (!empty($successMessage)) : ?>
                <p class="succes_message"><?= $successMessage ?></p>
            <?php endif; ?>
        </article>
    </section>
</body>
</html>