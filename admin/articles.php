<?php
session_start();

///$user = $_SESSION['username'];
///$usergroup = $_SESSION['group'];
/// if ($usergroup != "2" ||$usergroup != "1") {
/// header('Location: ../error/error.php');
////exit();
///}
require './dbadmin.php';
require '../templates/header.php';
require '../php/functionSql.php';
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
        <h2 class="container w-1/2 text-white text-center">Créer un Compte</h2>
    </section>
    <?php
    if (isset($_POST['add']) || isset($_POST['update']) && isset($_FILES['image'])) {
        $cleanedFileName = preg_replace("/[^\w-_.]/", "", $nom);
        $newFileName = $cleanedFileName . '.jpg';
        echo $newFileName . '<br>';
        $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/dev/assets/product/';
        echo $uploadDir . '<br>';
        $newFilePath = $uploadDir . $newFileName;
        echo $newFilePath . '<br>';
        $uploadFile = $uploadDir . basename($_FILES['image']['name']);
        echo $uploadFile . '<br>';
        $references = $_POST['references'];
        $prixHT = $_POST['prixHT'];
        $TVA = $_POST['TVA'];
        $pourcentagePromotion = $_POST['pourcentagePromotion'];
        $nouveaute = $_POST['nouveaute'];

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
                $checkReferencesSql = "SELECT COUNT(*) FROM articles WHERE references = ?";
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
            } elseif (isset($_POST['update'])) {
                // Mettre à jour 
                $articleId = $_POST['articleId'];
                $mysqli->query("UPDATE articles SET imgRef = '$newFileName' WHERE articleId = $articleId");
            }
        } else {
            echo 'Erreur lors du téléchargement du fichier.';
        }
    }



    if (isset($_POST['update'])) {
        $article_id = $_POST['article_id'];
        $nom = $_POST['nom'];
        $references = $_POST['references'];
        $prixHT = $_POST['prixHT'];
        $TVA = $_POST['TVA'];
        $pourcentagePromotion = $_POST['pourcentagePromotion'];
        $nouveaute = $_POST['nouveaute'];

        // Appel de la fonction de mise à jour
        if (updateArticle($mysqli, $article_id, $nom, $references, $prixHT, $TVA, $pourcentagePromotion, $nouveaute)) {
            echo "Mise à jour effectuée avec succès !";
        } else {
            echo "Erreur lors de la mise à jour : " . $stmt->error;
        }
    }

    if (isset($_POST['delete'])) {
        $articleIdToDelete = $_POST['articleIdToDelete'];
        $file = $_POST['fichierToDelete'];

        // Supprimer le fichier associé à l'article
        $filePath = '../dev/assets/product/' . $file;
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
    <div>
        <h4>Ajouter un nouvel article</h4>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
            enctype="multipart/form-data">
            <div>
                <input type="text" name="nom" placeholder="Nom" require_one>
                <input type="text" name="references" placeholder="Références" require_one>
                <input type="text" name="prixHT" placeholder="Prix HT" require_one>
                <input type="text" name="TVA" value="20" require_one>
                <input type="text" name="pourcentagePromotion" placeholder="Pourcentage de promotion" require_one>
                <input type="file" name="image" placeholder="fichiers" require_one>
                <select name="nouveaute">
                    <option value="1">Oui</option>
                    <option value="0">Non</option>
                </select>
                <button type="submit" name="add">➕</button>
            </div>
        </form>
    </div>
    <h4>Liste des Articles </h4>
    <?php
    if ($result) {
        if ($result->num_rows > 0) {
            ?>
            <table>
                <tr>
                    <th>Nom</th>
                    <th>Références</th>
                    <th>Prix HT</th>
                    <th>TVA</th>
                    <th>Pourcentage Promotion</th>
                    <th>refIMG</th>
                    <th>Nouveauté</th>
                    <th>Actions</th>
                </tr>
                <?php
                while ($row = $result->fetch_assoc()):
                    ?>
                    <tr>
                        <form method="post" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
                            <td><input type="text" name="nom" value="<?= $row['nom']; ?>"></td>
                            <td><input type="text" name="references" value="<?= $row['references']; ?>" readonly></td>
                            <td><input type="text" name="prixHT" value="<?= $row['prixHT']; ?>"></td>
                            <td><input type="text" name="TVA" value="<?= $row['TVA']; ?>"></td>
                            <td><input type="text" name="pourcentagePromotion" value="<?= $row['pourcentagePromotion']; ?>"></td>
                            <td>
                                <p>"
                                    <?= $row['imgRef']; ?>"
                                </p>
                                <input type="file" name="img">
                            </td>
                            <td>
                                <select name="nouveaute">
                                    <option value="1" <?= ($row['nouveaute'] == 1 ? 'selected' : ''); ?>>Oui</option>
                                    <option value="0" <?= ($row['nouveaute'] == 0 ? 'selected' : ''); ?>>Non</option>
                                </select>
                            </td>
                            <td>
                                <input type="hidden" name="article_id" value="<?= $row['articlesId']; ?>"> <!-- Pour update -->
                                <button type="submit" name="update">🪄</button>
                                <input type="hidden" name="fichierToDelete" value="<?= $row['imgRef']; ?>">
                                <input type="hidden" name="articleIdToDelete" value="<?= $row['articlesId']; ?>">
                                <!-- Pour suppression -->
                                <button type="submit" name="delete">🗑️</button>
                            </td>
                        </form>
                    </tr>
                    <?php
                endwhile;
                ?>

            </table>
            <?php
        } else {
            echo "Aucun article n'a été trouvé.";
        }
    } else {
        echo "Une erreur s'est produite lors de la récupération des articles.";
    }

    require '../templates/footer.php';
    ?>