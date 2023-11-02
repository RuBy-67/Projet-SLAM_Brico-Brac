<?php
if (!session_id()) {
    session_start();
}
$user = $_SESSION['user'];
$usergroup = $_SESSION['group'];
require ($_SERVER['DOCUMENT_ROOT'].'/php/db.php');
require ($_SERVER['DOCUMENT_ROOT'].'/templates/header.php');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="../dev/dist/output.css" rel="stylesheet">
    <link 
    href="<?= $_SERVER['DOCUMENT_ROOT'] ?>/dev/css/splide.css" 
    rel="stylesheet"
    />
    <link rel="icon" type="image/png" href="../dev/assets/favicon.png" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <title>Brico'brac - se connecter</title>
</head>
<body>
    <!-- Slogan -->
    <section class="bg-top-banner h-[400px] flex items-center mb-8">
        <h2 class="container sm:w-1/2 text-white text-center sm:mt-20 mt-52">Connexion</h2>
    </section>
    <?php
    // Traitement du formulaire de connexion
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

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
    ?>

    <section class="container w-1/2 flex flex-col items-center my-20">
        <form  
        class="flex flex-col items-center mb-0" 
        method="post" 
        action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
        >
            <input class="mb-8 border-primary" type="text" name="mail" required placeholder="adresse-mail@email.com">
            <input  class="mb-8 border-primary" type="password" name="mdp" required placeholder="Mot de passe">
            <input 
                type="submit" 
                class="bg-primary text-white px-8 py-4 flex align-center justify-center rounded" 
                value="Se connecter"
            >
        </form>
    </section>
    <?php require '../templates/footer.php'; ?>
</body>
</html>