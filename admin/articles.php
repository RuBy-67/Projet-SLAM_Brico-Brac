<?php
session_start();
require './dbadmin.php';
require '../templates/header.php';
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
    // Récupérer tous les articles de la table "Articles"
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
            if (addArticle($mysqli, $nom, $references, $prixHT, $TVA, $pourcentagePromotion, $nouveaute)) {
                echo '<p>Article ajouté</p>';
            } else {
                echo '<p>Erreur lors de l\'ajout de l\'article</p>';
            }
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
        $article_id_to_delete = $_POST['article_id_to_delete'];
    
        // Appel de la fonction de suppression en spécifiant la table "articles" et le champ "articlesId"
        if (deleteRecord($mysqli, 'articles', 'articlesId', $article_id_to_delete)) {
            echo "Article supprimé avec succès.";
        } else {
            echo "Échec lors de la suppression de l'article : " . $stmt->error;
        }
    }
    $selectArticlesSql = "SELECT * FROM articles";
    $result = $mysqli->query($selectArticlesSql);

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
                    <th>Nouveauté</th>
                    <th>Actions</th>
                </tr>
                <?php
                while ($row = $result->fetch_assoc()):
                    ?>
                    <tr>
                        <form method="post" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <td><input type="text" name="nom" value="<?= $row['nom']; ?>"></td>
                            <td><input type="text" name="references" value="<?= $row['references']; ?>" readonly></td>
                            <td><input type="text" name="prixHT" value="<?= $row['prixHT']; ?>"></td>
                            <td><input type="text" name="TVA" value="<?= $row['TVA']; ?>"></td>
                            <td><input type="text" name="pourcentagePromotion" value="<?= $row['pourcentagePromotion']; ?>"></td>
                            <td>
                                <select name="nouveaute">
                                    <option value="1" <?= ($row['nouveaute'] == 1 ? 'selected' : ''); ?>>Oui</option>
                                    <option value="0" <?= ($row['nouveaute'] == 0 ? 'selected' : ''); ?>>Non</option>
                                </select>
                            </td>
                            <td>
                                <input type="text" name="article_id" value="<?= $row['articlesId']; ?>"> <!-- Pour update -->
                                <button type="submit" name="update">🪄</button>
                                <input type="hidden" name="article_id_to_delete" value="<?= $row['articlesId']; ?>">
                                <!-- Pour suppression -->
                                <button type="submit" name="delete">🗑️</button>
                            </td>
                        </form>
                    </tr>
                    <?php
                endwhile;
                ?>

            </table>
            <div>
                <h3>Ajouter un nouvel article</h3>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <div>
                        <input type="text" name="nom" placeholder="Nom" required>
                        <input type="text" name="references" placeholder="Références" required>
                        <input type="text" name="prixHT" placeholder="Prix HT" required>
                        <input type="text" name="TVA" value="20" required>
                        <input type="text" name="pourcentagePromotion" placeholder="Pourcentage de promotion" required>
                        <select name="nouveaute">
                            <option value="1">Oui</option>
                            <option value="0">Non</option>
                        </select>
                        <button type="submit" name="add">➕</button>
                    </div>
                </form>
            </div>
            <?php
        } else {
            echo "Aucun article n'a été trouvé.";
        }
    } else {
        echo "Une erreur s'est produite lors de la récupération des articles.";
    }

    require '../templates/footer.php';
    ?>