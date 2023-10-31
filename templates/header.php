<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="../dev/dist/output.css" rel="stylesheet">
    <script 
    src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"
    >
    </script>
    <link 
    href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css" 
    rel="stylesheet"
    />
    <link rel="icon" type="image/png" href="../dev/assets/favicon.png" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <title>Brico'brac</title>
</head>
    <body>
        <?php $current_page = basename($_SERVER['PHP_SELF']);

        if ($current_page === 'index.php') {?>
            <!-- ?check if you are on hp or not -->
            <?php require './php/function.php'; ?>
            <header class="z-10 absolute w-full rounded-md">
                <div class="container flex lg:flex-row flex-col items-center justify-between py-4 border-b border-opacity-60">
                    <a href="./index.php"><img src="./dev/assets/logo.png" alt="Brico'brac"/></a>
                    <div class="flex items-center">
                        <?php require './templates/menu-nav.php'; ?>
                        <a class="btn">Se connnecter</a>
                    </div>
                </div>
            </header>
        <?php } else { ?>
            <?php require '../php/function.php'; ?>
            <header class="z-10 absolute w-full rounded-md">
                <div class="container flex lg:flex-row flex-col items-center justify-between py-4 border-b border-opacity-60">
                    <a href="../index.php"><img src="../dev/assets/logo.png" alt="Brico'brac"/></a>
                    <div class="flex items-center">
                        <?php require '../templates/menu-nav.php'; ?>
                        <a class="btn">Se connnecter</a>
                    </div>
                </div>
            </header>
       <?php } ?>
       