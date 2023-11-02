<?php if (!session_id()) {
    session_start();
}
$usergroup = $_SESSION['group'];
$user = $_SESSION['user'];
require($_SERVER['DOCUMENT_ROOT'] . '/php/db.php');
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="../dev/dist/output.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js">
    </script>
    <link href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css" rel="stylesheet" />
    <link href="/dev/css/splide.css" rel="stylesheet" />
    <link rel="icon" type="image/png" href="../dev/assets/favicon.png" />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <title>Brico'brac - Compte</title>
</head>

<body>
    <?php require($_SERVER['DOCUMENT_ROOT'] . '/templates/header.php') ?>
    <!-- Slogan -->
    <section class="bg-top-banner  h-[678px] flex items-center mb-8">
        <h1 class="container lg:w-1/2 text-white text-center xl:mt-0 md:mt-18 mt-52">
            Bonjour
            <?= $user ?> <br /> - <br /> Votre compte
        </h1>
</body>
<?php
if (isset($_POST['logout'])) {
    // Déconnexion de l'utilisateur en supprimant la session
    session_destroy();
    header('Location: ../index.php');
    exit();
}
?>
<!-- Contenu de la page -->


<form method="post">
    <input type="submit" name="logout" value="Se déconnecter">
</form>
<?php require '../templates/footer.php'; ?>
</body>

</html>