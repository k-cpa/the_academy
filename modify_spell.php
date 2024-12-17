<?php 
    include ('database.php');
    
    if(isset($_GET['id'])) {
        $spell_id = htmlspecialchars($_GET['id']);

        $requestSpell = $bdd->prepare ('
            SELECT *
            FROM spells
            WHERE spell_id = :spell_id
        ');
        $requestSpell->execute([
            'spell_id' => $spell_id
        ]);

        $data = $requestSpell->fetch();

        // initialisation message vide pour donner un feedback en cas d'erreur
        $errorMessage = '';
        // Récupération de l'ID des éléments de l'utilisateur
        $elements_id = array_column($_SESSION['element'], 'element_id');

        // Peut modifier uniquement si l'élément du sort correspond aux éléments maîtrisés par l'utilisateur
        if (isset($_SESSION['element']) && in_array($data['element_id'], $elements_id)) {

            if (isset($_POST['spell_name']) && isset($_POST['description'])) {
                $spell_name = htmlspecialchars($_POST['spell_name']);
                $description = htmlspecialchars($_POST['description']);
                $spell_id = htmlspecialchars(trim($_POST['spell_id']));

                if($_FILES['image']['error'] === UPLOAD_ERR_NO_FILE) {
                    $request->prepare ('
                        UPDATE spells
                        SET spell_name = :spell_name, description = :description
                        WHERE spell_id = :spell_id
                    ');
                    $request->execute ([
                        'spell_name' => $spell_name,
                        'description' => $description,
                        'spell_id' => $spell_id
                    ]);
                    header ('location: codex.php');
                } else {
                    $fileName = $_FILES['image']['name']; // Nom original
                    $tmpName = $_FILES['image']['tmp_name']; // Nouveau nom 
                    $location = 'assets/sorts/'; // dossier de destination
                    $imageFileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION)); // Extension du fichier en minuscule

                    $autorizedExtension = ['png', 'jpeg', 'jpg', 'webp', 'bmp', 'svg'];

                    if (in_array($imageFileType, $autorizedExtension)) {
                        $uniqueFileName = uniqid('Image_', true) . '.' . $imageFileType;
                        move_uploaded_file($tmpName, $location.$uniqueFileName);
                        // Supprime l'image déjà existante
                        unlink('assets/sorts/' . $data['image']);
                    } else {
                        $successMessage = 'Something went wrong during the upload';
                        exit;
                    }

                    $request = $bdd->prepare ('
                        UPDATE spells
                        SET spell_name = :spell_name, description = :description, image = :image
                        WHERE spell_id = :spell_id
                    ');
                    $request->execute ([
                        'spell_name' => $spell_name,
                        'description' => $description,
                        'image' => $uniqueFileName,
                        'spell_id' => $spell_id                  
                    ]);
                    header('location: codex.php');
                }
            } else {
                header ('location: codex.php');
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
            <?php if (!empty($errorMessage)) : ?>
                <p class="succes_message"><?= $errorMessage ?></p>
            <?php endif; ?>
        </article>
    </section>
</body>
</html>
