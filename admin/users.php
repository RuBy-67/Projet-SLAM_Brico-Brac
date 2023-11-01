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
  <h2 class="container w-1/2 text-white text-center">Gestion des Articles</h2>
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

  // Appel de la fonction d'ajout
  if (addArticle($mysqli, $nom, $references, $prixHT, $TVA, $pourcentagePromotion, $nouveaute)) {
    echo '<p>Article ajouté</p>';
  } else {
    echo '<p>Erreur lors de l\'ajout de l\'article</p>';
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

  // Appel de la fonction de suppression
  if (deleteArticle($mysqli, $article_id_to_delete)) {
    echo "Ligne supprimée avec succès.";
  } else {
    echo "Échec lors de la suppression : " . $stmt->error;
  }
}
$selectArticlesSql = "SELECT * FROM users INNER JOIN usersInfos ON users.usersId = usersInfos.usersInfosId;";
$result = $mysqli->query($selectArticlesSql);

if ($result) {
  if ($result->num_rows > 0) {
    ?>
    <table>
      <tr>
        <th>Noms</th>
        <th>Prénoms</th>
        <th>groupe</th>
        <th>mails</th>
        <th>Pays</th>
        <th>Adresse</th>
        <th>Téléphone</th>
        <th>Membre depuis</th>
      </tr>
      <?php

      while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '">';
        echo '<td><input type="text" name="nom" value="' . $row['name'] . '"></td>';
        echo '<td><input type="text" name="prenom" value="' . $row['surname'] . '"></td>';
        echo '<td>';
        echo '<select name="group">';
        echo '<option value="0" ' . ($row['group'] == 0 ? 'Users' : '') . '>Users</option>';
        echo '<option value="1" ' . ($row['group'] == 1 ? 'vendeurs' : '') . '>Vendeurs</option>';
        echo '<option value="2" ' . ($row['group'] == 2 ? 'Admin' : '') . '>Admin</option>';
        echo '</select>';
        echo '</td>';
        echo '<td><input type="text" name="mail" value="' . $row['mail'] . '"></td>';
        echo '<td><input type="text" name="prenom" value="' . $row['surname'] . '"></td>';
        echo '<td><input type="text" name="pays" value="' . $row['states'] . '"></td>';
        echo '<td><input type="text" name="adresse" value="' . $row['number'] . ' ' . $row['street'] . ' ' . $row['city'] . '"></td>';
        echo '<td><input type="text" name="telephone" value="' . $row['phone'] . '"></td>';
        echo '<td><input type="text" name="accountCreation" value="' . $row['accountCreation'] . '" readonly ></td>';


        echo '<td>';
        echo '<input type="text" name="article_id" value="' . $row['usersId'] . '">'; /// Pour update
        echo '<button type="submit" name="update">🪄</button>';
        echo '<input type="hidden" name="article_id_to_delete" value="' . $row['usersId'] . '">'; //pour suppression
        echo '<button type="submit" name="delete">🗑️</button>';
        echo '<input type="hidden" name="mdp to reset" value="' . $row['usersId'] . '">'; //pour reset
        echo '<button type="submit" name="mdp">Reinitialiser le mdp</button>';
        echo '</td>';
        echo '</form>';
        echo '</tr>';
      }
      ?>
    </table> 
    <div>
      <h3>Ajouter un nouvel Users</h3>
      <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div>
          <input type="text" name="nom" placeholder="Nom">
          <input type="text" name="prenomd" placeholder="Prenoms">
          <td>
            <select name="group">
              <option value="1">Users</option>
              <option value="1">Vendeurs</option>
              <option value="2">Admin</option>
            </select>
          </td>
          <input type="text" name="mail" placeholder="mail">
          <input type="text" name="number" value="nombre">
          <input type="text" name="street" placeholder="rue">
          <input type="text" name="city" value="ville">
          <input type="text" name="pays" placeholder="Pays">
          <input type="text" name="telephone" placeholder="Telephone">
          <input type="date" name="date" placeholder="date">
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