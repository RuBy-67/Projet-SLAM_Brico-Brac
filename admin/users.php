<?php
session_start();
///$user = $_SESSION['username'];
///$usergroup = $_SESSION['group'];
/// if ($usergroup != "admin") {
 /// header('Location: ../error/error.php');
  ////exit();
///}
require '../php/dbadmin.php';
require '../templates/header.php';
?>
<!-- Slogan -->
<section class="bg-top-banner h-[678px] flex items-center mb-8">
    <h2 class="container w-1/2 text-white text-center">Connexion</h2>
</section>

<?php require '../templates/footer.php'; ?>