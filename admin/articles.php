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
    <h2 class="container w-1/2 text-white text-center">Gestion des articles</h2>
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

    $updateArticleSql = "UPDATE articles 
                        SET nom = ?, `references` = ?, prixHT = ?, TVA = ?, pourcentagePromotion = ?, nouveaute = ?
                        WHERE articlesId = ?";
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

    $deleteArticleSql = "DELETE FROM articles WHERE articlesId = ?";
    $stmt = $mysqli->prepare($deleteArticleSql);
    $stmt->bind_param("i", $articleIdToDelete);
    if ($stmt->execute()) {
        // Suppression réussie, vous pouvez rediriger ou afficher un message de succès ici
    } else {
        // Erreur lors de la suppression
    }
}

// Ajout articles
$nom = $_POST['nom'];
$references = $_POST['references'];
$prixHT = $_POST['prixHT'];
$TVA = $_POST['TVA'];
$pourcentagePromotion = $_POST['pourcentagePromotion'];
$nouveaute = $_POST['nouveaute'];

// Préparation de la requête SQL
$insertArticleSql = "INSERT INTO articles (nom, `references`, prixHT, TVA, pourcentagePromotion, nouveaute) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $mysqli->prepare($insertArticleSql);
$stmt->bind_param("sssiii", $nom, $references, $prixHT, $TVA, $pourcentagePromotion, $nouveaute);

// Exécution de la requête
if ($stmt->execute()) {
    // Article inséré avec succès
} else {
    // Une erreur s'est produite lors de l'insertion de l'article
    // Gérez l'erreur ou un message d'erreur
}

// Récupérez tous les articles de la table "Articles"
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
        ?>
        <section>
            <form method="post" action="ajouter_article.php">
                <input type="text" name="nom" placeholder="Nom">
                <input type="text" name="references" placeholder="Références">
                <input type="number" name="prixHT" placeholder="Prix HT">
                <input type="number" name="TVA" value="20">
                <input type="number" name="pourcentagePromotion" placeholder="Pourcentage de promotion">
                <select name="nouveaute">
                    <option value="oui">Oui</option>
                    <option value="non">Non</option>
                </select>
                <input type="submit" value="Ajouter l'article">
            </form>
        </section>
        <?php
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
            echo '<input type="hidden" name="article_id" value="' . $row['articlesId'] . '">';
            echo '<button type="submit" name="update">Update</button>';
            echo '<button type="submit" name="delete">Delete</button>';
            echo '<input type="hidden" name="article_id_to_delete" value="' . $row['articlesId'] . '">'; // Pour la suppression
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