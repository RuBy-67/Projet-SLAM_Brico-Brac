<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require '../templates/header.php';
require './dbadmin.php';
?>
<!-- Slogan -->
<section class="bg-top-banner h-[678px] flex items-center mb-8">
    <h2 class="container w-1/2 text-white text-center">Connexion</h2>
</section>

<?php
// Récupérer tous les articles de la table "Articles"
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

            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '">';
                echo '<td><input type="text" name="nom" value="' . $row['nom'] . '"></td>';
                echo '<td><input type="text" name="references" value="' . $row['references'] . '" readonly></td>';
                echo '<td><input type="text" name="prixHT" value="' . $row['prixHT'] . '"></td>';
                echo '<td><input type="text" name="TVA" value="' . $row['TVA'] . '"></td>';
                echo '<td><input type="text" name="pourcentagePromotion" value="' . $row['pourcentagePromotion'] . '"></td>';
                echo '<td>';
                echo '<select name="nouveaute">';
                echo '<option value="1" ' . ($row['nouveaute'] == 1 ? 'selected' : '') . '>Oui</option>';
                echo '<option value="0" ' . ($row['nouveaute'] == 0 ? 'selected' : '') . '>Non</option>';
                echo '</select>';
                echo '</td>';
                echo '<td>';
                echo '<input type="text" name="article_id" value="' . $row['articlesId'] . '">'; /// Pour update
                echo '<button type="submit" name="update">Update</button>';
                echo '<input type="hidden" name="article_id_to_delete" value="' . $row['articlesId'] . '">'; //pour suppression
                echo '<button type="submit" name="delete">Delete</button>';
                echo '</td>';
                echo '</form>';
                echo '</tr>';
            }
            ?>
        </table>
        <div>
            <h3>Ajouter un nouvel article</h3>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div>
                    <input type="text" name="nom" placeholder="Nom">
                    <input type="text" name="references" placeholder="Références">
                    <input type="text" name="prixHT" placeholder="Prix HT">
                    <input type="text" name="TVA" value="20">
                    <input type="text" name="pourcentagePromotion" placeholder="Pourcentage de promotion">
                    <select name="nouveaute">
                        <option value="1">Oui</option>
                        <option value="0">Non</option>
                    </select>
                    <button type="submit" name="add">Ajouter</button>
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

foreach ($_POST as $key => $value) {

    if (strpos($key, 'update') === 0) {
        $article_id = $_POST['article_id'];
        $nom = $_POST['nom'];
        $references = $_POST['references'];
        $prixHT = $_POST['prixHT'];
        $TVA = $_POST['TVA'];
        $pourcentagePromotion = $_POST['pourcentagePromotion'];
        $nouveaute = $_POST['nouveaute'];

        $sql = "UPDATE articles SET nom=?, `references`=?, prixHT=?, TVA=?, pourcentagePromotion=?, nouveaute=? WHERE articlesId=?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("siiiiii", $nom, $references, $prixHT, $TVA, $pourcentagePromotion, $nouveaute, $article_id);

        if ($stmt->execute()) {
            echo "Mise à jour effectuée avec succès !";
        } else {
            echo "Erreur lors de la mise à jour : " . $stmt->error;
        }
    }


    if (strpos($key, 'delete') === 0) {
        $article_id_to_delete = $_POST['article_id_to_delete'];

        $sql = "DELETE FROM articles WHERE articlesId = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("i", $article_id_to_delete);

        if ($stmt->execute()) {
            echo "Ligne supprimée avec succès.";
        } else {
            echo "Échec lors de la suppression : " . $stmt->error;
        }
    }


    if (strpos($key, 'update_') === 0) {
        $articleId = $_POST['article_id'];
        $nom = $_POST['nom'];
        $references = $_POST['references'];
        $prixHT = $_POST['prixHT'];
        $TVA = $_POST['TVA'];
        $pourcentagePromotion = $_POST['pourcentagePromotion'];
        $nouveaute = $_POST['nouveaute'];

        $updateArticleSql = "UPDATE articles 
                            SET nom = ?, `references` = ?, prixHT = ?, TVA = ?, pourcentagePromotion = ?, nouveaute = ?
                            WHERE articlesId = ?";
        $stmt = $mysqli->prepare($updateArticleSql);
        $stmt->bind_param("siiiiii", $nom, $references, $prixHT, $TVA, $pourcentagePromotion, $nouveaute, $articleId);
        if ($stmt->execute()) {
            echo '<p>Mise à jours réussis</p>';
        } else {
            echo '<p>Erreur lors de la mise à jour</p>';
        }
    }
}

// Gérer l'ajout d'un article
if (isset($_POST['add'])) {
    $nom = $_POST['nom'];
    $references = $_POST['references'];
    $prixHT = $_POST['prixHT'];
    $TVA = $_POST['TVA'];
    $pourcentagePromotion = $_POST['pourcentagePromotion'];
    $nouveaute = $_POST['nouveaute'];

    $insertArticleSql = "INSERT INTO articles (nom, `references`, prixHT, TVA, pourcentagePromotion, nouveaute) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $mysqli->prepare($insertArticleSql);
    $stmt->bind_param("siiiii", $nom, $references, $prixHT, $TVA, $pourcentagePromotion, $nouveaute);

    if ($stmt->execute()) {
        echo '<p>Article ajouté</p>';
    } else {
        echo '<p>Erreur lors de l\'ajout de l\'article</p>';
    }
}

require '../templates/footer.php';
?>