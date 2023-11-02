<?php
if (!session_id()) {
    session_start();
}
$user = $_SESSION['user'];
$usergroup = $_SESSION['group'];
require($_SERVER['DOCUMENT_ROOT'] . '/php/db.php');
require($_SERVER['DOCUMENT_ROOT'] . '/templates/header.php');
require_once $_SERVER['DOCUMENT_ROOT'] . '/php/functionSql.php';
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
    <title>Brico'brac - se connecter</title>
</head>

<body>
    <!-- Slogan -->
    <section class="bg-top-banner h-[400px] flex items-center mb-8">
        <h2 class="container sm:w-1/2 text-white text-center sm:mt-20 mt-52">Connexion</h2>
    </section>
    <?php
    // Traitement du formulaire de connexion
    if (isset($_POST['connexion'])) {

        $mail = $_POST["mail"];
        $password = $_POST["mdp"];

        $sql = "SELECT users.*, usersInfos.name
        FROM users
        JOIN usersInfos ON users.usersId = usersInfos.usersInfosId
        WHERE users.mail = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("s", $mail);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 0) {
            echo '<p>Identifiants incorrects</p>.';
        } else {
            $row = $result->fetch_assoc();
            $stored_password = $row["password"];

            // Vérification du mot de passe
            if (password_verify($password, $stored_password)) {
                // Mise en session de l'utilisateur
                $_SESSION['group'] = $row["group"];
                $_SESSION['id'] = $row["usersId"];
                $_SESSION['user'] = $row["name"];


                echo '<p>Vous êtes maintenant connecté.</p>';
                // Redirection vers la page d'accueil
                header("Location: ../index.php");
                exit();
            } else {
                echo '<p>Mot de passe incorrect.</p>';
            }
        }
    }

    if (isset($_POST['mdp'])) {
        // Récupérez l'ID de l'utilisateur via une requête SQL
        $mail = $_POST["mail"];
        $sql = "SELECT usersId FROM users WHERE mail = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("s", $mail);
        $stmt->execute();
        $stmt->bind_result($userId);
        $stmt->fetch();
        $stmt->close();
    
        if ($userId) {
            // Appelez la fonction de reset de mdp
            $newPassword = resetMdp($mysqli, $userId);
    
            if ($newPassword !== false) {
                echo "Réinitialisation réussie. Nouveau mot de passe : $newPassword";
            } else {
                echo "Échec de la réinitialisation du mot de passe.";
            }
        } else {
            echo "Aucun utilisateur avec l'adresse e-mail $mail n'a été trouvé.";
        }
    }

    ?>

    <section class="container w-1/2 flex flex-col items-center my-20">
        <form class="flex flex-col items-center mb-0" method="post"
            action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <input class="mb-8 border-primary" type="text" name="mail" required placeholder="adresse-mail@email.com">
            <input class="mb-8 border-primary" type="password" name="mdp"  placeholder="Mot de passe">
            <button type="submit" name="connexion"
                class="bg-primary text-white px-8 py-4 flex align-center justify-center rounded">Se connecter</button>
            <button type="submit" name="mdp"
                class="bg-primary text-white rounded hover:bg-primary-dark m-2 p-2">❗Réinitialiser le mot de
                passe</button>
        </form>
    </section>
    <?php require '../templates/footer.php'; ?>
</body>

</html>