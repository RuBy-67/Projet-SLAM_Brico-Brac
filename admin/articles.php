<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require '../templates/header.php';
require './dbadmin.php';
///$user = $_SESSION['username'];
///$usergroup = $_SESSION['group'];
/// if ($usergroup != "admin") {
 /// header('Location: ../error/error.php');
  ////exit();
///}
?>
<!-- Slogan -->
<section class="bg-top-banner h-[678px] flex items-center mb-8">
    <h2 class="container w-1/2 text-white text-center">Connexion</h2>
</section>
<?php
// Gérer la mise à jour d'un article
if (isset($_POST['update'])) {
    $articleId = $_POST['article_id'];
    $nom = $_POST['nom'];
    $references = $_POST['references'];
    $prixHT = $_POST['prixHT'];
    $TVA = $_POST['TVA'];
    $pourcentagePromotion = $_POST['pourcentagePromotion'];
    $nouveaute = $_POST['nouveaute'];

    $updateArticleSql = "UPDATE Articles 
                        SET nom = ?, references = ?, prixHT = ?, TVA = ?, pourcentagePromotion = ?, nouveaute = ?
                        WHERE articleId = ?";
    $stmt = $mysqli->prepare($updateArticleSql);
    $stmt->bind_param("ssdddsi", $nom, $references, $prixHT, $TVA, $pourcentagePromotion, $nouveaute, $articleId);
    if ($stmt->execute()) {
        // Mise à jour réussie, vous pouvez rediriger ou afficher un message de succès ici
    } else {
        // Erreur lors de la mise à jour
    }
}

// Gérer la suppression d'un article
if (isset($_POST['delete'])) {
    $articleIdToDelete = $_POST['article_id_to_delete'];

    $deleteArticleSql = "DELETE FROM Articles WHERE articleId = ?";
    $stmt = $mysqli->prepare($deleteArticleSql);
    $stmt->bind_param("i", $articleIdToDelete);
    if ($stmt->execute()) {
        // Suppression réussie, vous pouvez rediriger ou afficher un message de succès ici
    } else {
        // Erreur lors de la suppression
    }
}

// Récupérez tous les articles de la table "Articles"
$selectArticlesSql = "SELECT * FROM Articles";
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
            echo '<td><input type="text" name="nom" value="' . $row['nom'] . '"></td>';
            echo '<td><input type="text" name="references" value="' . $row['references'] . '"></td>';
            echo '<td><input type="text" name="prixHT" value="' . $row['prixHT'] . '"></td>';
            echo '<td><input type="text" name="TVA" value="' . $row['TVA'] . '"></td>';
            echo '<td><input type="text" name="pourcentagePromotion" value="' . $row['pourcentagePromotion'] . '"></td>';
            echo '<td>';
            echo '<select name="nouveaute">';
            echo '<option value="1"' . ($row['nouveaute'] == 1 ? ' selected' : '') . '>Oui</option>';
            echo '<option value="0"' . ($row['nouveaute'] == 0 ? ' selected' : '') . '>Non</option>';
            echo '</select>';
            echo '</td>';
            echo '<td>';
            echo '<input type="hidden" name="article_id" value="' . $row['articleId'] . '">';
            echo '<button type="submit" name="update">Update</button>';
            echo '<button type="submit" name="delete">Delete</button>';
            echo '<input type="hidden" name="article_id_to_delete" value="' . $row['articleId'] . '">'; // Pour la suppression
            echo '</td>';
            echo '</tr>';
        }

        echo '</table>';
        echo '</form>';
    } else {
        echo "Aucun article n'a été trouvé.";
    }
} else {
    echo "Une erreur s'est produite lors de la récupération des articles.";
}

?>

<?php require '../templates/footer.php';