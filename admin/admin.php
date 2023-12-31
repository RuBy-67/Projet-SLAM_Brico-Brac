<?php
if (!session_id()) {
    session_start();
}
if (isset($_SESSION['group'])) {
    $usergroup = $_SESSION['group'];
}

if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
}
if (isset($_SESSION['surname'])) {
    $surname =  $_SESSION['surname'];
}
if ($usergroup !== 1 && $usergroup !== 2) {
    header('Location: ../error/error.php');
    exit();
}
require_once $_SERVER['DOCUMENT_ROOT'] . '/Projet-SLAM_Brico-Brac/admin/dbadmin.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/Projet-SLAM_Brico-Brac/templates/header.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/Projet-SLAM_Brico-Brac/php/functionSql.php';
?>
<!DOCTYPE html>
<html lang="fr">

<head>
<meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="/Projet-SLAM_Brico-Brac/dev/dist/output.css" rel="stylesheet">
    <link 
    href="<?= $_SERVER['DOCUMENT_ROOT'] ?>/Projet-SLAM_Brico-Brac/dev/css/splide.css" 
    rel="stylesheet"
    />
    <link rel="icon" type="image/png" href="/Projet-SLAM_Brico-Brac/dev/assets/favicon.png" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <title>Brico'brac - Administration</title>
</head>

<body class="min-h-screen flex flex-col"> 
    <!-- Slogan -->
    <section class="bg-top-banner  h-[400px] flex items-center mb-8">
        <h2 class="container w-1/2 text-white text-center">Gestion36</h2>
    </section>
    <section class="container my-16 grow">
        <div class="flex flex-wrap">
            <div class="w-full md:w-1/2 lg:w-1/3 p-2">
                <a href="./articles.php" class="bg-white shadow-md rounded-md block p-4">
                    <h3 class="text-xl font-bold mb-2">Gestion des articles</h3>
                    <p class="text-gray-600">Ajouter, modifier ou supprimer des articles.</p>
                </a>
            </div>
            <div class="w-full md:w-1/2 lg:w-1/3 p-2 ">
                <a href="./users.php" class="bg-white shadow-md rounded-md block p-4">
                    <h3 class="text-xl font-bold mb-2">Gestion des utilisateurs</h3>
                    <p class="text-gray-600">Ajouter, modifier ou supprimer des utilisateurs.</p>
                </a>
            </div>
            <!-- <div class="w-full md:w-1/2 lg:w-1/3 p-2">
                <a href="./commands.php" class="bg-white shadow-md rounded-md block p-4">
                    <h3 class="text-xl font-bold mb-2">Gestion des commandes</h3>
                    <p class="text-gray-600">Ajouter, modifier ou supprimer des commandes.</p>
                </a>
            </div> -->
        </div>
    </section>
    

    <?php require '../templates/footer.php'; ?>
</body>


</html>