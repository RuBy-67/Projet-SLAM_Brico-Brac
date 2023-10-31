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
    $states = $_POST['states'];
    $city = $_POST['city'];
    $street = $_POST['street'];
    $number = $_POST['number'];
    $date = date("Y-m-d H:i:s");


    /// verification mdp
    if (!isStrongPassword($mdp)) {
        echo "Le mot de passe ne respecte pas les exigences.";
        exit();
    } elseif ($mdp !== $mdp_confirm) {
        echo "Les mots de passe ne correspondent pas.";
        exit();
    } else {
        //hachage de mot du passe
        $hashed_password = password_hash($mdp, PASSWORD_DEFAULT);

        // Vérification que l'adresse e-mail ou le numéro de téléphone ne sont pas déjà utilisés
        $checkEmailPhoneSql = "SELECT * FROM users WHERE mail = ? OR usersId IN (SELECT usersInfosId FROM usersInfos WHERE phone = ?)";
        $stmtCheckEmailPhone = $mysqli->prepare($checkEmailPhoneSql);
        $stmtCheckEmailPhone->bind_param("ss", $mail, $phone);
        $stmtCheckEmailPhone->execute();
        $resultCheckEmailPhone = $stmtCheckEmailPhone->get_result();
        if ($resultCheckEmailPhone->num_rows > 0) {
            echo "L'adresse e-mail ou le numéro de téléphone est déjà utilisé.";
            exit();
        }


        $insertUserSql = "INSERT INTO users (mail, password) VALUES (?, ?)";
        $stmt = $mysqli->prepare($insertUserSql);
        $stmt->bind_param("ss", $mail, $hashed_password);
        if ($stmt->execute()) {
            $userId = $stmt->insert_id;

            // Insertion des informations supplémentaires dans la table "userInfos"
            $insertUserInfoSql = "INSERT INTO usersInfos (usersInfosId, name, surname, states, city, street, number, phone, accountCreation) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt2 = $mysqli->prepare($insertUserInfoSql);
            $stmt2->bind_param("issssssss", $userId, $name, $surname, $states, $city, $street, $number, $phone, $date);
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
<section class="max-w-md mx-auto mt-10 p-4 bg-white shadow-md rounded-lg">
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <input type="text" name="nom" required placeholder="Nom" class="w-full py-2 px-3 mb-4 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-500" /><br><br>
        <input type="text" name="prenom" required placeholder="Prénom" class="w-full py-2 px-3 mb-4 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-500" /><br><br>
        <input type="email" name="mail" required placeholder="Adresse@e-mail" class="w-full py-2 px-3 mb-4 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-500" /><br><br>
        <input type="tel" name="tel" placeholder="Téléphone" maxlength="10" class="w-full py-2 px-3 mb-4 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-500" /><br><br>
        <input type="password" name="mdp" required placeholder="Mot de passe" class="w-full py-2 px-3 mb-4 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-500" /><br><br>
        <input type="password" name="mdp_confirm" required placeholder="Confirmez le mot de passe" class="w-full py-2 px-3 mb-4 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-500" /><br><br>
        <input type="text" name="states" required placeholder="Pays" class="w-full py-2 px-3 mb-4 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-500" /><br><br>
        <input type="text" name="city" required placeholder="Ville" class="w-full py-2 px-3 mb-4 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-500" /><br><br>
        <input type="text" name="street" required placeholder="Rue" class="w-full py-2 px-3 mb-4 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-500" /><br><br>
        <input type="text" name="number" required placeholder="Numéro de rue" class="w-full py-2 px-3 mb-4 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-500" /><br><br>
        <input type="submit" name="submit" value="S'inscrire" class="w-full bg-indigo-500 text-white py-2 px-4 rounded-md hover:bg-indigo-600 focus:outline-none focus:ring focus:ring-indigo-400" />
    </form>
</section>

<?php require '../templates/footer.php'; ?>