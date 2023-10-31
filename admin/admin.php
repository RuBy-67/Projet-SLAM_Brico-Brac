<?php
///session_start();

///$user = $_SESSION['username'];
///$usergroup = $_SESSION['group'];
/// if ($usergroup != "admin") {
 /// header('Location: ../error/error.php');
  ////exit();
///}
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
?>
<?php require '../templates/header.php'; ?>
    <!-- Slogan -->
    <section class="bg-top-banner  h-[678px] flex items-center mb-8">
        <h2 class="container w-1/2 text-white text-center">
            Bienvenue sur Brico’brac ! <br />
            La référence du magasin de bricolage près de chez vous !
        </h2>
    </section>
        <div class="container">
            <h2 class="text-3xl font-bold mb-4">Administration</h2>
            <div class="flex flex-wrap">
                <div class="w-full md:w-1/2 lg:w-1/3 p-2">
                    <a href="./admin/admin.php" class="bg-white shadow-md rounded-md block p-4">
                        <h3 class="text-xl font-bold mb-2">Gestion des articles</h3>
                        <p class="text-gray-600">Ajouter, modifier ou supprimer des articles.</p>
                    </a>
                </div>
                <div class="w-full md:w-1/2 lg:w-1/3 p-2">
                    <a href="./admin/admin.php" class="bg-white shadow-md rounded-md block p-4">
                        <h3 class="text-xl font-bold mb-2">Gestion des utilisateurs</h3>
                        <p class="text-gray-600">Ajouter, modifier ou supprimer des utilisateurs.</p>
                    </a>
                </div>
                <div class="w-full md:w-1/2 lg:w-1/3 p-2">
                    <a href="./admin/admin.php" class="bg-white shadow-md rounded-md block p-4">
                        <h3 class="text-xl font-bold mb-2">Gestion des commandes</h3>
                        <p class="text-gray-600">Ajouter, modifier ou supprimer des commandes.</p>
                    </a>
                </div>
            </div>
        </div>
    </section>




<?php require '../templates/footer.php'; ?>