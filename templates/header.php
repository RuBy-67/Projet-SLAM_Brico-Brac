<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="../dev/dist/output.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="../dev/assets/favicon.png" />
    <title>Brico'brac</title>
</head>
    <body>
        <script type="text/javascript" src="../dev/js/theme.js"></script>
        <?php require './php/function.php'; ?>
        <header class="z-10 absolute w-full rounded-md">
            <div class="container flex flex-row items-center justify-between py-4 border-b border-opacity-60">
                    <img src="../dev/assets/logo.png" alt="Brico'brac"/>
                    <div>
                        <?php require './templates/menu-nav.php'; ?>
                        <a class="btn">Se connnecter</a>
                    </div>
                
            </div>
        </header>