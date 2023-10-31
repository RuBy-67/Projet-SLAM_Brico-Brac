<?php
session_start();
require '../php/db.php';
require '../templates/header.php';
require '../templates/footer.php'; 
?>

<!-- Slogan -->
<section class="bg-top-banner h-[678px] flex items-center mb-8">
    <h2 class="container w-1/2 text-white text-center">Connexion</h2>
</section>
<?php
// Traitement du formulaire de connexion
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $mail = $_POST["mail"];
    $password = $_POST["mdp"];

    $sql = "SELECT * FROM users WHERE mail=?";
    $stmt = $conn->prepare($sql);
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

<section>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <input type="text" name="mail" required placeholder="adresse-mail@email.com"><br><br>
        <input type="password" name="mdp" required placeholder="Mot de passe"><br><br>
        <input type="submit" value="Se connecter">
    </form>
</section>
