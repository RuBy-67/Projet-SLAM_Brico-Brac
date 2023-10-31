<?php
session_start();
require '../php/db.php';
require '../templates/header.php';
?>

<!-- Slogan -->
<section class="bg-top-banner  h-[678px] flex items-center mb-8">
    <h2 class="container w-1/2 text-white text-center">Créer un Compte</h2>
</section>
<?php
if (isset($_POST['submit'])) {
    // Récupération des données du formulaire
    $name = $_POST['nom'];
    $surname = $_POST['prenom'];
    $mail = $_POST['mail'];
    $phone = $_POST['tel'];
    $mdp = $_POST['mdp'];
    $mdp_confirm = $_POST['mdp_confirm'];
    $birthdate = $_POST['birthdate'];
    $states = $_POST['states'];
    $city = $_POST['city'];
    $street = $_POST['street'];
    $number = $_POST['number'];
    $date = date("Y-m-d H:i:s");


    /// verification mdp
    if (!isStrongPassword($mdp)) {
        echo "Le mot de passe ne respecte pas les exigences.";
    } elseif ($mdp !== $mdp_confirm) {
        echo "Les mots de passe ne correspondent pas.";
    } else {
        //hachage de mot du passe
        $hashed_password = password_hash($mdp, PASSWORD_DEFAULT);

        $insertUserSql = "INSERT INTO users (mail, password) VALUES (?, ?)";
        $stmt = $mysqli->prepare($insertUserSql);
        $stmt->bind_param("ss", $mail, $hashed_password);
        if ($stmt->execute()) {
            $userId = $stmt->insert_id;

            // Insertion des informations supplémentaires dans la table "userInfos"
            $insertUserInfoSql = "INSERT INTO userInfos (usersInfosId, name, surname, states, city, street, number, phone, accountCreation, birthdate) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt2 = $mysqli->prepare($insertUserInfoSql);
            $stmt2->bind_param("isssssssss", $userId, $name, $surname, $states, $city, $street, $number, $phone, $date, $birthdate);
            if ($stmt2->execute()) {
                // Redirection vers une autre page après l'inscription réussie
                header("Location: sign_in.php");
            } else {
                echo "Une erreur s'est produite lors de l'inscription.";
            }
        } else {
            echo "Une erreur s'est produite lors de l'inscription.";
        }
    }
}

?>
<section>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <input type="text" name="nom" required placeholder="Nom"><br><br>
        <input type="text" name="prenom" required placeholder="Prénom"><br><br>
        <input type="email" name="mail" required placeholder="Adresse@e-mail"><br><br>
        <input type="tel" name="tel" placeholder="Téléphone"><br><br>
        <input type="password" name="mdp" required placeholder="Mot de passe"><br><br>
        <input type="password" name="mdp_confirm" required placeholder="Confirmez le mot de passe"><br><br>
        <input type="date" name="birthdate"><br><br>
        <input type="text" name="states" required placeholder="Pays"><br><br>
        <input type="text" name="city" required placeholder="Ville"><br><br>
        <input type="text" name="street" required placeholder="Rue"><br><br>
        <input type="text" name="number" required placeholder="Numéro de rue"><br><br>
        <input type="submit" name="submit" value="S'inscrire">
    </form>
</section>
<?php require '../templates/footer.php'; ?>