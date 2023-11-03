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
    <title>Brico'brac - Panier</title>
</head>
<body class="min-h-screen flex flex-col">
    <?php require '../templates/header.php'; ?>
        <!-- Slogan -->
        <section class="bg-top-banner  h-[400px] flex items-center mb-16">
            <h1 class="container sm:w-1/2 text-white text-center sm:mt-20 mt-52">Votre panier</h1>
        </section>
        
        <section class="container flex flex-col items-center my-20 grow">
           <p>Votre commande a été enregistrée </p>
           <a class=" block m-2  bg-primary text-white px-8 py-4 flex items-center justify-center rounded" 
                href="/index.php"
            >
                Retour <span class="material-symbols-outlined ml-4">home</span>
            </a>
        </section>
       
    <?php require '../templates/footer.php'; ?>
</body>
</html>