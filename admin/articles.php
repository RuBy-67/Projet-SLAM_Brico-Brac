<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require '../templates/header.php';
require './dbadmin.php';
// Activer le débogage des requêtes SQL
///$user = $_SESSION['username'];
///$usergroup = $_SESSION['group'];
/// if ($usergroup != "admin") {
/// header('Location: ../error/error.php');
////exit();
///}
?>
<!-- Slogan -->
<section class="bg-top-banner h-[678px] flex items-center mb-8">
    <h2 class="container w-1/2 text-white text-center">Gestion des articles</h2>
</section>
<?php
// Gérer la mise à jour d'un article
if (isset($_POST['update'])) {
    $articleId = $_POST['article_id'];
    $nom = $_POST['nom'][$articleId];
    $references = $_POST['references'][$articleId];
    $prixHT = $_POST['prixHT'][$articleId];
    $TVA = $_POST['TVA'][$articleId];
    $pourcentagePromotion = $_POST['pourcentagePromotion'][$articleId];
    $nouveaute = $_POST['nouveaute'][$articleId];

    $updateArticleSql = "UPDATE articles 
                        SET nom = ?, references = ?, prixHT = ?, TVA = ?, pourcentagePromotion = ?, nouveaute = ?
                        WHERE articlesId = ?";
    $stmt = $mysqli->prepare($updateArticleSql);
    $stmt->bind_param("siiiiii", $nom, $references, $prixHT, $TVA, $pourcentagePromotion, $nouveaute, $articleId);
    if ($stmt->execute()) {
        echo '<p>Mise à jours réussis</p>';
    } else {
        echo '<p>Erreur lors de la mise à jour</p>';
    }
}

// Gérer la suppression d'un article
if (isset($_POST['delete'])) {
    $articleIdToDelete = $_POST['article_id_to_delete'];

    $deleteArticleSql = "DELETE FROM articles WHERE articlesId = ?";
    $stmt = $mysqli->prepare($deleteArticleSql);
    $stmt->bind_param("i", $articleIdToDelete);
    if ($stmt->execute()) {
        echo '<p>Supression réussis</p>';
    } else {
        echo '<p>Echec Supression</p>';
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

    $insertArticleSql = "INSERT INTO articles (nom, references, prixHT, TVA, pourcentagePromotion, nouveaute) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $mysqli->prepare($insertArticleSql);
    $stmt->bind_param("siiiii", $nom, $references, $prixHT, $TVA, $pourcentagePromotion, $nouveaute);

    if ($stmt->execute()) {
        echo '<p>article ajouté</p>';
    } else {
        echo '<p>Erreurs lors de l\'ajout</p>';
    }
}

// Récupérer tous les articles de la table "Articles"
$selectArticlesSql = "SELECT * FROM articles";
$result = $mysqli->query($selectArticlesSql);

if ($result) {
    if ($result->num_rows > 0) {
        echo '<form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '">';
        echo '<table>';
        echo '<tr>';
        echo '<th>Nom</th>';
        echo '<th>Références</th>';
        echo '<th>Prix HT</th>';
        echo '<th>TVA</th>';
        echo '<th>Pourcentage Promotion</th>';
        echo '<th>Nouveauté</th>';
        echo '<th>Actions</th>';
        echo '</tr>';

        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td><input type="text" name="nom[' . $row['articlesId'] . ']" value="' . $row['nom'] . '"></td>';
            echo '<td><input type="text" name="references[' . $row['articlesId'] . ']" value="' . $row['references'] . '"></td>';
            echo '<td><input type="text" name="prixHT[' . $row['articlesId'] . ']" value="' . $row['prixHT'] . '"></td>';
            echo '<td><input type="text" name="TVA[' . $row['articlesId'] . ']" value="' . $row['TVA'] . '"></td>';
            echo '<td><input type="text" name="pourcentagePromotion[' . $row['articlesId'] . ']" value="' . $row['pourcentagePromotion'] . '"></td>';
            echo '<td>';
            echo '<select name="nouveaute[' . $row['articlesId'] . ']">';
            echo '<option value="1" ' . ($row['nouveaute'] == 1 ? 'selected' : '') . '>Oui</option>';
            echo '<option value="0" ' . ($row['nouveaute'] == 0 ? 'selected' : '') . '>Non</option>';
            echo '</select>';
            echo '</td>';
            echo '<td>';
            echo '<input type="hidden" name="article_id" value="' . $row['articlesId'] . '">';
            echo '<button type="submit" name="update">Update</button>';
            echo '<button type="submit" name="delete">Delete</button>';
            echo '<input type="hidden" name="article_id_to_delete" value="' . $row['articlesId'] . '">'; // Pour la suppression
            echo '</td>';
            echo '</tr>';
        }

        echo '</table>';
        echo '</form>';
        echo '<form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '">';
        echo '<tr>';
        echo '<td><input type="text" name="nom" placeholder="Nom"></td>';
        echo '<td><input type="text" name="references" placeholder="Références"></td>';
        echo '<td><input type="text" name="prixHT" placeholder="Prix HT"></td>';
        echo '<td><input type="text" name="TVA" value="20"></td>';
        echo '<td><input type="text" name="pourcentagePromotion" placeholder="Pourcentage de promotion"></td>';
        echo '<td>';
        echo '<select name="nouveaute">';
        echo '<option value="oui">Oui</option>';
        echo '<option value="non">Non</option>';
        echo '</select>';
        echo '</td>';
        echo '<td>';
        echo '<input type="hidden" name="add" value="true">'; // Indicateur pour l'ajout
        echo '<button type="submit">Ajouter</button>';
        echo '</td>';
        echo '</tr>';
        echo '</form>';

    } else {
        echo "Aucun article n'a été trouvé.";
    }
} else {
    echo "Une erreur s'est produite lors de la récupération des articles.";
}

require '../templates/footer.php';
?>