<?php
session_start();
require './dbadmin.php';
require '../templates/header.php';
require '../php/functionSql.php';

///$user = $_SESSION['username'];
///$usergroup = $_SESSION['group'];
/// if ($usergroup != "2") {
/// header('Location: ../error/error.php');
////exit();
///}
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
  <title>Brico'brac - Gestion des utilisateurs</title>
</head>

<body>
  <!-- Slogan -->
  <section class="bg-top-banner  h-[400px] flex items-center mb-8">
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
    $password = generateRandomPassword();
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $date = date("Y-m-d H:i:s");

    // Appel de la fonction d'ajout
    if (addUsers($mysqli, $nom, $prenom, $group, $mail, $pays, $numeros, $rue, $ville, $telephone, $hashedPassword, $date)) {
      echo '<p>Utilisateurs ajouté(e) le mots de passe est :' . $password . '</p>';
    } else {
      echo '<p>L\'adresse e-mail ou le numéro de téléphone est déjà utilisé.</p>';
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

    $excludeUserId = $userId; // Exclure l'utilisateur actuel de la vérification
  
    if (checkEmailPhoneExists($mysqli, $mail, $telephone, $excludeUserId)) {
      echo "Les informations de l'utilisateur existent déjà, impossible d'effectuer cette mise à jour.";
    } else {
      if (updateUsers($mysqli, $userId, $nom, $prenom, $group, $mail, $pays, $numeros, $rue, $ville, $telephone)) {
        echo "Mise à jour effectuée avec succès !";
      } else {
        echo "Erreur lors de la mise à jour : " . $stmt->error;
      }
    }
  }

  if (isset($_POST['delete'])) {
    $userIdToDelete = $_POST['userIdToDelete'];

    // Appel de la fonction de suppression en spécifiant la table "users" et le champ "usersId"
    if (deleteRecord($mysqli, 'users', 'usersId', $userIdToDelete)) {
      echo "Utilisateur supprimé avec succès.";
    } else {
      echo "Échec lors de la suppression de l'utilisateur : " . $stmt->error;
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
      <section class="container w-1/2 flex flex-col items-center my-20">
        <h4 class="text-lg font-bold mb-4">Ajouter un nouvel Utilisateur</h4>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
          class="flex flex-col items-center mb-0">
          <div>
            <input type="text" name="nom" placeholder="Nom" required class="mb-8 border-primary">
            <input type="text" name="prenom" placeholder="Prénoms" required class="mb-8 border-primary">
            <input type="email" name="mail" placeholder="E-mail" required class="mb-8 border-primary">
            <input type="number" name="numeros" placeholder="Numéro" required class="mb-8 border-primary">
            <input type="text" name="rue" placeholder="Rue" required class="mb-8 border-primary">
            <input type="text" name="ville" placeholder="Ville" required class="mb-8 border-primary">
            <input type="text" name="pays" placeholder="Pays" required class="mb-8 border-primary">
            <input type="tel" name="telephone" placeholder="Téléphone" maxlength="10" requiredclass="mb-8 border-primary">
            <div class="relative">
              <select name="group" class="mb-8 border-primary">
                <option value="0">Utilisateurs</option>
                <option value="1">Vendeurs</option>
                <option value="2">Admin</option>
              </select>
            </div>
          </div>
          <button type="submit" name="add"
            class="block bg-primary text-white px-8 py-4 flex align-center justify-center rounded">Ajouter ➕</button>
        </form>
      </section>
      <h4 class="text-lg font-bold mb-4">Liste des utilisateurs</h4>
<table class="border-collapse w-full">
  <thead>
    <tr class="bg-gray-200">
      <th class="p-2">Noms</th>
      <th class="p-2">Prénoms</th>
      <th class="p-2">Groupe</th>
      <th class="p-2">Mails</th>
      <th class="p-2">Pays</th>
      <th class="p-2">Numéros</th>
      <th class="p-2">Rue</th>
      <th class="p-2">Ville</th>
      <th class="p-2">Téléphone</th>
      <th class="p-2">Membre depuis</th>
      <th class="p-2">Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php
    while ($row = $result->fetch_assoc()) {
    ?>
      <tr class="border-b border-gray-300">
        <form method="post" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
          <td class="p-2">
            <input type="text" name="nom" value="<?= $row['name']; ?>" class="w-full">
          </td>
          <td class="p-2">
            <input type="text" name="prenom" value="<?= $row['surname']; ?>" class="w-full">
          </td>
          <td class="p-2">
            <select name="group" class="w-full">
              <option value="0" <?= ($row['group'] == 0 ? 'selected' : ''); ?>>Users</option>
              <option value="1" <?= ($row['group'] == 1 ? 'selected' : ''); ?>>Vendeurs</option>
              <option value="2" <?= ($row['group'] == 2 ? 'selected' : ''); ?>>Admin</option>
            </select>
          </td>
          <td class="p-2">
            <input type="text" name="mail" value="<?= $row['mail']; ?>" class="w-full">
          </td>
          <td class="p-2">
            <input type="text" name="pays" value="<?= $row['states']; ?>" class="w-full">
          </td>
          <td class="p-2">
            <input type="text" name="numeros" value="<?= $row['number']; ?>" class="w-full">
          </td>
          <td class="p-2">
            <input type="text" name="rue" value="<?= $row['street']; ?>" class="w-full">
          </td>
          <td class="p-2">
            <input type="text" name="ville" value="<?= $row['city']; ?>" class="w-full">
          </td>
          <td class="p-2">
            <input type="text" name="telephone" value="<?= $row['phone']; ?>" maxlength="10" class="w-full">
          </td>
          <td class="p-2">
            <input type="text" name="accountCreation" value="<?= $row['accountCreation']; ?>" readonly class="w-full">
          </td>
          <td class="p-2">
            <input type="hidden" type="text" name="UsersId" value="<?= $row['usersId']; ?>">
            <button type="submit" name="update" class="text-blue-500 hover:underline mr-2">Modifier</button>
            <input type="hidden" name="userIdToDelete" value="<?= $row['usersId']; ?>">
            <button type="submit" name="delete" class="text-red-500 hover:underline mr-2">Supprimer</button>
            <input type="hidden" name="mdpToReset" value="<?= $row['usersId']; ?>">
            <button type="submit" name="mdp" class="text-purple-500 hover:underline">Réinitialiser le mot de passe</button>
          </td>
        </form>
      </tr>
    <?php
    }
    ?>
  </tbody>
</table>

      <?php
    } else {
      echo "Aucun utilisateurs n'a été trouvé.";
    }
  } else {
    echo "Une erreur s'est produite lors de la récupération des Utilisateurs.";
  }

  require '../templates/footer.php';
  ?>