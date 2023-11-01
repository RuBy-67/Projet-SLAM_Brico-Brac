<?php
session_start();
require '../php/db.php';
require '../templates/header.php';
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
    <title>Brico'brac - s'inscrire</title>
</head>

<body>
    <!-- Slogan -->
    <section class="bg-top-banner  h-[400px] flex items-center mb-8">
        <h2 class="container w-1/2 text-white text-center">Créer un Compte</h2>
    </section>
    <?php
    if (isset($_POST['submit'])) {
        // Récupération des données du formulaire
        $name = $_POST['nom'];
        $surname = $_POST['prenom'];
        $group = 0;
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
        } elseif ($mdp !== $mdp_confirm) {
            echo "Les mots de passe ne correspondent pas.";
        } else {
            //hachage de mot du passe
            $hashedPassword = password_hash($mdp, PASSWORD_DEFAULT);
            // Appel de la fonction d'ajout
            if (addUsers($mysqli, $name, $surname, $group, $mail, $states, $number, $street, $city, $phone, $hashedPassword, $date)) {
                header("Location: sign_in.php");
            } else {
                echo '<p>L\'adresse e-mail ou le numéro de téléphone est déjà utilisé.</p>';
            }
        }
    }


    ?>
    <section class="container w-1/2 flex flex-col items-center my-20">
        <form class="flex flex-col items-center mb-0" method="post"
            action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="grid grid-cols-2 gap-8 mb-8">
                <input type="text" name="nom" require_one placeholder="Nom">
                <input type="text" name="prenom" require_one placeholder="Prénom">
                <input type="email" name="mail" require_one placeholder="Adresse@e-mail">
                <input type="tel" name="tel" placeholder="Téléphone" maxlength="10">
                <input type="password" name="mdp" require_one placeholder="Mot de passe">
                <input type="password" name="mdp_confirm" require_one placeholder="Confirmez le mot de passe">
                <input type="text" name="states" require_one placeholder="Pays">
                <input type="text" name="city" require_one placeholder="Ville">
                <input type="text" name="street" require_one placeholder="Rue">
                <input type="text" name="number" require_one placeholder="Numéro de rue">
            </div>

            <input class="block bg-primary text-white px-8 py-4 flex align-center justify-center rounded" type="submit"
                name="submit" value="S'inscrire">
        </form>
    </section>
    <?php require '../templates/footer.php'; ?>
</body>

</html>