<?php
if (!session_id()) {
    session_start();
}
if (isset($_SESSION['group'])) {
    $usergroup = $_SESSION['group'];
}

if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
}
if (isset($_SESSION['surname'])) {
    $surname = $_SESSION['surname'];
}
if ($usergroup !== 2 && $usergroup !== 1) {
    header('Location: ../admin/admin.php');
    exit();
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/dbadmin.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/templates/header.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/php/functionSql.php';
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="../dev/dist/output.css" rel="stylesheet">
    <link href="<?= $_SERVER['DOCUMENT_ROOT'] ?>/dev/css/splide.css" rel="stylesheet" />
    <link rel="icon" type="image/png" href="../dev/assets/favicon.png" />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <title>Brico'brac - Gestion des articles</title>
</head>

<body>
    <!-- Slogan -->
    <section class="bg-top-banner  h-[400px] flex items-center mb-8">
        <h2 class="container w-1/2 text-white text-center">Gestion des Articles</h2>
    </section>
    <?php
    if (isset($_POST['add'])) {
        $nom = $_POST['nom'];
        $cleanedFileName = str_replace(' ', '_', $nom);
        $newFileName = $cleanedFileName . '.jpg';
        $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/dev/assets/products/';
        $newFilePath = $uploadDir . $newFileName;
        $uploadFile = $uploadDir . basename($_FILES['image']['name']);
        $references = $_POST['references'];
        $prixHT = $_POST['prixHT'];
        $TVA = $_POST['TVA'];
        $pourcentagePromotion = $_POST['pourcentagePromotion'];
        $nouveaute = $_POST['nouveaute'];

        if (file_exists($_FILES['image']['tmp_name'])) {

            if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {

                echo 'Fichier téléchargé avec succès.';
                $newFilePath = $uploadDir . $newFileName;
                rename($uploadFile, $newFilePath);

                if (isset($_POST['add'])) {

                    $nom = $_POST['nom'];
                    $references = $_POST['references'];
                    $prixHT = $_POST['prixHT'];
                    $TVA = $_POST['TVA'];
                    $pourcentagePromotion = $_POST['pourcentagePromotion'];
                    $nouveaute = $_POST['nouveaute'];

                    // Vérifier si la référence existe déjà dans la base de données
                    $checkReferencesSql = "SELECT COUNT(*) FROM articles WHERE `references` = ?";
                    $stmt = $mysqli->prepare($checkReferencesSql);
                    $stmt->bind_param("i", $references);
                    $stmt->execute();
                    $stmt->bind_result($count);
                    $stmt->fetch();
                    $stmt->close();

                    if ($count > 0) {
                        echo '<p>La référence existe déjà. Veuillez en choisir une autre.</p>';
                    } else {
                        // Appel de la fonction d'ajout
                        if (addArticle($mysqli, $nom, $references, $prixHT, $TVA, $pourcentagePromotion, $nouveaute, $newFileName)) {
                            echo '<p>Article ajouté</p>';
                        } else {
                            echo '<p>Erreur lors de l\'ajout de l\'article</p>';
                        }
                    }
                }
            } else {
                echo 'Erreur lors du téléchargement du fichier.';
            }
        } else {
            echo 'Le fichier temporaire n\'existe pas.';
        }
    }



    if (isset($_POST['update'])) {
        $article_id = $_POST['article_id'];
        $nom = $_POST['nom'];
        $references = $_POST['references'];
        $prixHT = $_POST['prixHT'];
        $fileToUpdate = $_POST['fichierToUpdate'];
        $TVA = $_POST['TVA'];
        $pourcentagePromotion = $_POST['pourcentagePromotion'];
        $nouveaute = $_POST['nouveaute'];

        // Vérifiez si un nouveau fichier a été téléchargé
        if (isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
            $newFileName = $fileToUpdate; // Le nom du fichier reste le même
    
            $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/dev/assets/products/';
            $uploadFile = $uploadDir . $newFileName;

            // Assurez-vous que le fichier a été téléchargé avec succès
            if (move_uploaded_file($_FILES['img']['tmp_name'], $uploadFile)) {
                echo 'Nouveau fichier téléchargé avec succès.';
            } else {
                echo 'Erreur lors du téléchargement du nouveau fichier.';
            }
        }

        // Effectuez la mise à jour des autres champs de l'article
        if (updateArticle($mysqli, $article_id, $nom, $references, $prixHT, $TVA, $pourcentagePromotion, $nouveaute)) {
            echo "Mise à jour de l'article effectuée avec succès !";
        } else {
            echo "Erreur lors de la mise à jour de l'article : " . $stmt->error;
        }
    }


    if (isset($_POST['delete'])) {
        $articleIdToDelete = $_POST['articleIdToDelete'];
        $file = $_POST['fichierToDelete'];

        // Supprimer le fichier associé à l'article
        $filePath = '../dev/assets/products/' . $file;
        if (file_exists($filePath)) {
            if (unlink($filePath)) {
                echo "Fichier supprimé avec succès.";
                // Appel de la fonction de suppression de l'article en spécifiant la table "articles" et le champ "articlesId"
                if (deleteRecord($mysqli, 'articles', 'articlesId', $articleIdToDelete)) {
                    echo "Article supprimé avec succès.";
                } else {
                    echo "Échec lors de la suppression de l'article : " . $stmt->error;
                }
            } else {
                echo "Erreur lors de la suppression du fichier.";
            }
        } else {
            echo "Le fichier n'existe pas.";
            // Appel de la fonction de suppression de l'article en spécifiant la table "articles" et le champ "articlesId"
            if (deleteRecord($mysqli, 'articles', 'articlesId', $articleIdToDelete)) {
                echo "Article supprimé avec succès.";
            } else {
                echo "Échec lors de la suppression de l'article : " . $stmt->error;
            }
        }
    }

    $selectArticlesSql = "SELECT * FROM articles";
    $result = $mysqli->query($selectArticlesSql);
    ?>
    <div class="container w-1/2 flex flex-col items-center my-20">
        <h4 class="text-lg font-bold mb-4">Ajouter un nouvel article</h4>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data"
            class="flex flex-col items-center mb-0">
            <div>
                <input type="text" name="nom" placeholder="Nom" required class="mb-8 border-primary">
                <input type="text" name="references" placeholder="Références" required class="mb-8 border-primary">
                <input type="text" name="prixHT" placeholder="Prix HT" required class="mb-8 border-primary">
                <input type="text" name="TVA" placeholder="TVA" value="20" required class="mb-8 border-primary">
                <input type="text" name="pourcentagePromotion" placeholder="Pourcentage de promotion" required
                    class="mb-8 border-primary">
                <input type="text" name="description" placeholder="Descriptions" required class="mb-8 border-primary">
                <input type="file" name="image" placeholder="Fichier" required class="mb-8 border-primary">
                <select name="nouveaute" class="mb-8 border-primary">
                    <option value="1">Oui</option>
                    <option value="0">Non</option>
                </select>
                <button type="submit" name="add"
                    class="bg-primary text-white px-8 py-4 flex align-center justify-center rounded">➕ Ajouter</button>
            </div>
        </form>
    </div>

    <h4>Liste des Articles </h4>
    <?php
    if ($result) {
        if ($result->num_rows > 0) {
            ?>
            <table class="border-collapse w-full">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="p-2">Nom</th>
                        <th class="p-2">Références</th>
                        <th class="p-2">Prix HT</th>
                        <th class="p-2">TVA</th>
                        <th class="p-2">Pourcentage Promotion</th>
                        <th class="p-2">Description</th>
                        <th class="p-2">Réf. IMG</th>
                        <th class="p-2">Nouveauté</th>
                        <th class="p-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = $result->fetch_assoc()):
                        ?>
                        <tr class="border-b border-gray-300">
                            <form method="post" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
                                enctype="multipart/form-data">
                                <td class="p-2">
                                    <input type="text" name="nom" value="<?= $row['nom']; ?>" class="w-full">
                                </td>
                                <td class="p-2">
                                    <input type="text" name="references" value="<?= $row['references']; ?>" readonly class="w-full">
                                </td>
                                <td class="p-2">
                                    <input type="text" name="prixHT" value="<?= $row['prixHT']; ?>" class="w-full">
                                </td>
                                <td class="p-2">
                                    <input type="text" name="TVA" value="<?= $row['TVA']; ?>" class="w-full">
                                </td>
                                <td class="p-2">
                                    <input type="text" name="pourcentagePromotion" value="<?= $row['pourcentagePromotion']; ?>"
                                        class="w-full">
                                </td>
                                <tdclass="p-2"> <input type="text" name="description" value="<?= $row['descriptions']; ?>"
                                class="w-full"></td>
                                <td class="p-2">
                                    <p>
                                        <?= $row['imgRef']; ?>
                                    </p>
                                    <input type="file" name="img" class="w-full">
                                </td>
                                <td class="p-2">
                                    <select name="nouveaute" class="w-full">
                                        <option value="1" <?= ($row['nouveaute'] == 1 ? 'selected' : ''); ?>>Oui</option>
                                        <option value="0" <?= ($row['nouveaute'] == 0 ? 'selected' : ''); ?>>Non</option>
                                    </select>
                                </td>
                                <td class="p-2">
                                    <input type="hidden" name="fichierToUpdate" value="<?= $row['imgRef']; ?>">
                                    <input type="hidden" name="article_id" value="<?= $row['articlesId']; ?>">
                                    <button type="submit" name="update"
                                        class="bg-primary text-white px-4 py-2 rounded hover:bg-primary-dark m-2">🪄
                                        Modifier</button>
                                    <input type="hidden" name="fichierToDelete" value="<?= $row['imgRef']; ?>">
                                    <input type="hidden" name="articleIdToDelete" value="<?= $row['articlesId']; ?>">
                                    <button type="submit" name="delete"
                                        class="bg-primary text-white px-4 py-2 rounded hover:bg-primary-dark m-2">🗑️
                                        Suprimmer</button>
                                </td>
                            </form>
                        </tr>
                        <?php
                    endwhile;
                    ?>
                </tbody>
            </table>

            <?php
        } else {
            echo "Aucun article n'a été trouvé.";
        }
    } else {
        echo "Une erreur s'est produite lors de la récupération des articles.";
    }
    ?>
    <?php require '../templates/footer.php'; ?>
</body>


</html>