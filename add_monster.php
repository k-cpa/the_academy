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
        SELECT type_id, type_name
        FROM type
    ');

    $type->execute([]);

    if (isset($_FILES['image'])) {
        $fileName = $_FILES['image']['name']; // nom original du fichier
        $tmpName = $_FILES['image']['tmp_name']; // nouveau nom du fichier
        $location = 'assets/creatures/'; // dossier de destination des img
        $imageFileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION)); // Extension du fichier en minuscule

        $autorizedExtension = ['png', 'jpeg', 'jpg', 'webp', 'bmp', 'svg'];

        // Vérifie si extension img est dans la liste des extensions autorisées
        if (in_array($imageFileType, $autorizedExtension)) {
            // Génère un nom de ficier unique pour éviter le conflit
            $uniqueFileName = uniqid('Image_', true) . '.' . $imageFileType;
            // Déplace l'image dans le dossier 
            move_uploaded_file($tmpName, $location.$uniqueFileName);
        } else {
            echo "Veuillez choisir une image au format PNG, JPEG, WEBP, BMP ou SVG";
            exit;
        }
    }

    // Vérifie si champs du form sont bien ont été envoyés
    if (isset($_POST['monster_name']) && isset($_POST['description']) && isset($_POST['monster_type'])) {
        // Récupère et sécurise les valeurs soumises par l'utilisateur
        $monster_name = htmlspecialchars($_POST['monster_name']);
        $description = htmlspecialchars($_POST['description']);
        $monster_type = ($_POST['monster_type']);
        $user_id = $_SESSION['id'];

        // Préparation requette SQL pour insérer les données dans database
        $request = $bdd-> prepare ('
            INSERT INTO monsters (monster_name, description, image, user_id, type_id)
            VALUES (:monster_name, :description, :image, :user_id, :type_id)
        ');

        // Exécute la requette 
        $request->execute([
            'monster_name' => $monster_name,
            'description' => $description,
            'image' => $uniqueFileName, // Nom unique de l'image qu'on récupère à stocker 
            'user_id' => $user_id,
            'type_id' => $monster_type
        ]);

        // Si réussite = message pour l'utilisateur et possibilité d'ajouter un nouveau monstre
        $successMessage = "The beast is successfully added, congratulations wizard !";
    } 
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Add beasts</title>
</head>
<body>
    <?php include ('header.php')?>
    <section id="add">
        <div class="add_title">
            <h3>Add a new Beast</h3>
        </div>
        <article class="container add_container">
            <form action="add_monster.php#add" method="post" enctype="multipart/form-data">
                <input type="text" id="monster_name" name="monster_name" placeholder="Monster name" required>
                <textarea id="description" name="description" placeholder="Brief story of the monster" required></textarea>
                <select id="monster_type" name="monster_type">
                    <option value="" disabled selected>Select a beast type</option>
                    <!-- Affiche chaque type de monstre dans le select -->
                    <?php
                        while($row = $type->fetch()) {
                            $type_id = $row['type_id'];
                            $type_name = $row['type_name'];

                            echo '<option value="' . $type_id . '">' . $type_name . '</option>';
                        }
                    ?>
                </select>
                <input type="file" id="image" name="image">
                <button type="submit">Add Monster</button>
            </form>
            <?php if (!empty($successMessage)) : ?>
                <p class="succes_message"><?= $successMessage ?></p>
            <?php endif; ?>
        </article>
    </section>
</body>
</html>