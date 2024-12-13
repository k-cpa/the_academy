<?php 
include('database.php');

// Vérifie si l'ID de l'élément est passé dans l'URL via la méthode GET
if (isset($_GET['id']) && isset($_GET['source'])) {
    $element_id = htmlspecialchars($_GET['id']); // L'ID de l'élément à supprimer
    $source = htmlspecialchars($_GET['source']); // La source (soit "bestiary" ou "codex")

    // Détermine le nom de la table et du dossier d'image en fonction de la source
    if ($source === 'bestiary') {
        $table = 'monsters';
        $folder = 'creatures';
        $id_column = 'monster_id';
    } elseif ($source === 'codex') {
        $table = 'spells';
        $folder = 'sorts';
        $id_column = 'spell_id';
    } else {
        header('location: index.php'); // Si la source est incorrecte
        exit();
    }

    // Prépare la requête pour récupérer l'élément de la base de données
    $imgRequest = $bdd->prepare('
        SELECT * 
        FROM '.$table.' 
        WHERE '.$id_column.' = :element_id
    ');
    $imgRequest->execute([
        'element_id' => $element_id
    ]);
    $data = $imgRequest->fetch();

    // Vérification de l'utilisateur avant de procéder à la suppression
    if ($_SESSION['id'] === $data['user_id']) {
        // Suppression du fichier image en local
        if (!empty($data['image']) && file_exists('assets/' . $folder . '/' . $data['image'])) {
            unlink('assets/' . $folder . '/' . $data['image']);
        }

        // Exécution de la requête DELETE pour supprimer l'élément de la base de données
        $request = $bdd->prepare('
            DELETE FROM '.$table.'
            WHERE '.$id_column.' = :element_id
        ');
        $request->execute([
            'element_id' => $element_id
        ]);

        // Rediriger l'utilisateur vers la page appropriée
        if ($source === 'bestiary') {
            header('location: bestiary.php');
        } elseif ($source === 'codex') {
            header('location: codex.php');
        }
        exit();
    } else {
        // Si l'utilisateur ne correspond pas, redirige vers la page de la source
        if ($source === 'bestiary') {
            header('location: bestiary.php');
        } elseif ($source === 'codex') {
            header('location: codex.php');
        }
    }

} else {
    // Si les paramètres id ou source sont manquants, redirige vers bestiary par défaut
    header('location: bestiary.php');
}
?>

