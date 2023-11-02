<?php
if (!session_id()) {
    session_start();
}

$user = $_SESSION['username'];
$usergroup = $_SESSION['group'];
 if ($usergroup != "2") {
  header('Location: ../error/error.php');
  exit();
}
require_once $_SERVER['DOCUMENT_ROOT'].'admin/dbadmin.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/templates/header.php';
$group=1;
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
    <title>Brico'brac - Gestion des commandes</title>
</head>
<body>
    <!-- Slogan -->
    <section class="bg-top-banner  h-[400px] flex items-center mb-8">
        <h2 class="container w-1/2 text-white text-center">Créer un Compte</h2>
    </section>

<?php require '../templates/footer.php'; ?>