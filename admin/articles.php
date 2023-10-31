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
    $stmt->bind_param("siiiiii", $nom, $references, $prixHT, $TVA, $pourcentagePromotion, $nouveaute, $articleId);
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
if (isset($_POST['add'])) {
    // Récupération des données du formulaire
    $nom = $_POST['nom'];
    $references = $_POST['references'];
    $prixHT = $_POST['prixHT'];
    $TVA = $_POST['TVA'];
    $pourcentagePromotion = $_POST['pourcentagePromotion'];
    $nouveaute = $_POST['nouveaute'];

    // Préparation de la requête SQL
    $insertArticleSql = "INSERT INTO articles (nom, `references`, prixHT, TVA, pourcentagePromotion, nouveaute) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $mysqli->prepare($insertArticleSql);
    $stmt->bind_param("siiiii", $nom, $references, $prixHT, $TVA, $pourcentagePromotion, $nouveaute);

    // Exécution de la requête
    if ($stmt->execute()) {
        echo "L'article a été ajouté avec succès.";
    } else {
        echo "Une erreur s'est produite lors de l'ajout de l'article.";
    }
}

// Récupérez tous les articles de la table "Articles"
$selectArticlesSql = "SELECT * FROM articles";
$result = $mysqli->query($selectArticlesSql);
?>
<section>
    <form method="post" action="ajouter_article.php" class="mb-4">
        <input type="text" name="nom" placeholder="Nom" class="border p-2 rounded-md mr-2">
        <input type="text" name="references" placeholder="Références" class="border p-2 rounded-md mr-2">
        <input type="number" name="prixHT" placeholder="Prix HT" class="border p-2 rounded-md mr-2">
        <input type="number" name="TVA" value="20" class="border p-2 rounded-md mr-2">
        <input type="number" name="pourcentagePromotion" placeholder="Pourcentage de promotion" class="border p-2 rounded-md mr-2">
        <select name="nouveaute" class="border p-2 rounded-md mr-2">
            <option value="oui">Oui</option>
            <option value="non">Non</option>
        </select>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Ajouter l'article</button>
    </form>
    <?php
    if ($result) {
        if ($result->num_rows > 0) {
            echo '<form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '">';
            echo '<table class="table-auto w-full">';
            echo '<thead>';
            echo '<tr>';
            echo '<th class="px-4 py-2">Nom</th>';
            echo '<th class="px-4 py-2">Références</th>';
            echo '<th class="px-4 py-2">Prix HT</th>';
            echo '<th class="px-4 py-2">TVA</th>';
            echo '<th class="px-4 py-2">Pourcentage Promotion</th>';
            echo '<th class="px-4 py-2">Nouveauté</th>';
            echo '<th class="px-4 py-2">Actions</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td class="px-4 py-2"><input type="text" name="nom" value="' . $row['nom'] . '"></td>';
                echo '<td class="px-4 py-2"><input type="text" name="references" value="' . $row['references'] . '"></td>';
                echo '<td class="px-4 py-2"><input type="text" name="prixHT" value="' . $row['prixHT'] . '"></td>';
                echo '<td class="px-4 py-2"><input type="text" name="TVA" value="' . $row['TVA'] . '"></td>';
                echo '<td class="px-4 py-2"><input type="text" name="pourcentagePromotion" value="' . $row['pourcentagePromotion'] . '"></td>';
                echo '<td class="px-4 py-2">';
                echo '<select name="nouveaute">';
                echo '<option value="1"' . ($row['nouveaute'] == 1 ? ' selected' : '') . '>Oui</option>';
                echo '<option value="0"' . ($row['nouveaute'] == 0 ? ' selected' : '') . '>Non</option>';
                echo '</select>';
                echo '</td>';
                echo '<td class="px-4 py-2">';
                echo '<input type="hidden" name="article_id" value="' . $row['articlesId'] . '">';
                echo '<button type="submit" name="update" class="bg-blue-500 text-white px-2 py-1 rounded-md mr-2">Update</button>';
                echo '<button type="submit" name="delete" class="bg-red-500 text-white px-2 py-1 rounded-md">Delete</button>';
                echo '<input type="hidden" name="article_id_to_delete" value="' . $row['articlesId'] . '">';
                echo '</td>';
                echo '</tr>';
            }
            echo '</tbody>';
            echo '</table>';
            echo '</form>';
        }
    }
    ?>
</section>


<?php require '../templates/footer.php';