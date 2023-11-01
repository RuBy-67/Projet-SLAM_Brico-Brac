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
  <h2 class="container w-1/2 text-white text-center">Gestion des Utilisateurs</h2>
</section>

<?php
// Récupérer tous les users de la table "users"
if (isset($_POST['add'])) {
  $nom = $_POST['nom'];
  $prenom = $_POST['prenom'];
  $group = $_POST['group'];
  $mail = $_POST['mail'];
  $pays = $_POST['pays'];
  $numeros = $_POST['numeros'];
  $rue = $_POST['rue'];
  $ville = $_POST['ville'];
  $telephone = $_POST['telephone'];
  $date = date("Y-m-d H:i:s");

  // Appel de la fonction d'ajout
  if (addUsers($mysqli, $nom, $prenom, $group, $mail, $pays, $numeros, $rue, $ville, $telephone)) {
    echo '<p>Utilisateurs ajouté(e)</p>';
  } else {
    echo '<p>Erreur lors de l\'ajout de l\'Utilisateurs</p>';
  }
}

if (isset($_POST['update'])) {
  $userId = $_POST['UsersId'];
  $nom = $_POST['nom'];
  $prenom = $_POST['prenom'];
  $group = $_POST['group'];
  $mail = $_POST['mail'];
  $pays = $_POST['pays'];
  $numeros = $_POST['numeros'];
  $rue = $_POST['rue'];
  $ville = $_POST['ville'];
  $telephone = $_POST['telephone'];

  // Appel de la fonction de mise à jour
  if (updateUsers($mysqli, $userId, $nom, $prenom, $group, $mail, $pays, $numeros, $rue, $ville, $telephone)) {
    echo "Mise à jour effectuée avec succès !";
  } else {
    echo "Erreur lors de la mise à jour : " . $stmt->error;
  }
}

if (isset($_POST['delete'])) {
  $userIdToDelete = $_POST['userIdToDelete'];

  // Appel de la fonction de suppression
  if (deleteUsers($mysqli, $userIdToDelete)) {
    echo "Ligne supprimée avec succès.";
  } else {
    echo "Échec lors de la suppression : " . $stmt->error;
  }
}

if (isset($_POST['mdp'])) {
  // Récupérez l'ID de l'utilisateur à partir du champ caché
  $userId = $_POST['mdpToReset'];

  // Appelez la fonction de réinitialisation du mot de passe
  $newPassword = resetMdp($mysqli, $userId);

  if ($newPassword !== false) {
    echo "Réinitialisation réussie. Nouveau mot de passe : $newPassword";
  } else {
    echo "Échec de la réinitialisation du mot de passe : " . $stmt->error;
  }
}



$selectUsersSql = "SELECT * FROM users INNER JOIN usersInfos ON users.usersId = usersInfos.usersInfosId;";
$result = $mysqli->query($selectUsersSql);

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
        ?>
        <tr>
          <form method="post" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <td><input type="text" name="nom" value="<?= $row['name']; ?>"></td>
            <td><input type="text" name="prenom" value="<?= $row['surname']; ?>"></td>
            <td>
              <select name="group">
                <option value="0" <?= ($row['group'] == 0 ? 'selected' : ''); ?>>Users</option>
                <option value="1" <?= ($row['group'] == 1 ? 'selected' : ''); ?>>Vendeurs</option>
                <option value="2" <?= ($row['group'] == 2 ? 'selected' : ''); ?>>Admin</option>
              </select>
            </td>
            <td><input type="text" name="mail" value="<?= $row['mail']; ?>"></td>
            <td><input type="text" name="pays" value="<?= $row['states']; ?>"></td>
            <td><input type="text" name="numeros" value="<?= $row['number']; ?>"></td>
            <td><input type="text" name="rue" value="<?= $row['street']; ?>"></td>
            <td><input type="text" name="ville" value="<?= $row['city']; ?>"></td>
            <td><input type="text" name="telephone" value="<?= $row['phone']; ?>"></td>
            <td><input type="text" name="accountCreation" value="<?= $row['accountCreation']; ?>" readonly></td>

            <td>
              <input type="hidden" type="text" name="UsersId" value="<?= $row['usersId']; ?>"> <!-- Pour update -->
              <button type="submit" name="update">🪄</button>
              <input type="hidden" name="userIdToDelete" value="<?= $row['usersId']; ?>"> <!-- Pour suppression -->
              <button type="submit" name="delete">🗑️</button>
              <input type="hidden" name="mdpToReset" value="<?= $row['usersId']; ?>"> <!-- Pour reset -->
              <button type="submit" name="mdp">Réinitialiser le mot de passe</button>
            </td>
          </form>
        </tr>
        <?php
      }
      ?>

    </table>
    <div>
      <h3>Ajouter un nouvel Users</h3>
      <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div>
          <input type="text" name="nom" placeholder="Nom" required>
          <input type="text" name="prenom" placeholder="Prenoms" required>
          <td>
            <select name="group">
              <option value="1">Users</option>
              <option value="1">Vendeurs</option>
              <option value="2">Admin</option>
            </select>
          </td>
          <input type="text" name="mail" placeholder="mail" required>
          <input type="text" name="numeros" placeholder="nombre" required>
          <input type="text" name="rue" placeholder="rue" required>
          <input type="text" name="ville" placeholder="ville" required>
          <input type="text" name="pays" placeholder="Pays" required>
          <input type="text" name="telephone" placeholder="Telephone" required>
          <input type="password" name="mdp" placeholder="Mots de passe" required>
          <button type="submit" name="add">➕</button>
        </div>
      </form>
    </div>
    <?php
  } else {
    echo "Aucun utilisateurs n'a été trouvé.";
  }
} else {
  echo "Une erreur s'est produite lors de la récupération des Utilisateurs.";
}

require '../templates/footer.php';
?>