<?php

/**
 * Check if a password meets certain  criteria.
 *
 * @param string $password The password to check.
 * @param array $options (Optional) An array of options to configure the criteria.
 * @return bool Returns true if the password is strong, false otherwise.
 */
function isStrongPassword($password) {
    // Définissez les options par défaut
    $options = array(
        'minLength' => 8,
        'requireUpperCase' => true,
        'requireLowerCase' => true,
        'requireNumbers' => true,
        'requireSpecialChars' => true
    );
    if (strlen($password) < $options['minLength']) {
        return false;
    }

    if ($options['requireUpperCase'] && !preg_match('/[A-Z]/', $password)) {
        return false;
    }

    if ($options['requireLowerCase'] && !preg_match('/[a-z]/', $password)) {
        return false;
    }

    if ($options['requireNumbers'] && !preg_match('/[0-9]/', $password)) {
        return false;
    }

    if ($options['requireSpecialChars'] && !preg_match('/[^A-Za-z0-9]/', $password)) {
        return false;
    }

    return true;
}


///----------------------- SQL ARTICLES ---------------------------------///
/**
 * Ajoute un nouvel article à la base de données.
 *
 * @param mysqli $mysqli Une instance de la connexion MySQLi à la base de données.
 * @param string $nom Le nom de l'article à ajouter.
 * @param string $references Les références de l'article à ajouter.
 * @param float $prixHT Le prix HT de l'article à ajouter.
 * @param float $TVA La TVA de l'article à ajouter.
 * @param float $pourcentagePromotion Le pourcentage de promotion de l'article à ajouter.
 * @param int $nouveaute La valeur de nouveauté de l'article à ajouter.
 *
 * @return bool Retourne true en cas de succès de l'ajout, sinon retourne false.
 */

function addArticle($mysqli, $nom, $references, $prixHT, $TVA, $pourcentagePromotion, $nouveaute) {
    $insertArticleSql = "INSERT INTO articles (nom, `references`, prixHT, TVA, pourcentagePromotion, nouveaute) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $mysqli->prepare($insertArticleSql);
    $stmt->bind_param("siiiii", $nom, $references, $prixHT, $TVA, $pourcentagePromotion, $nouveaute);

    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}

/**
 * Met à jour les informations d'un article dans la base de données en utilisant son ID.
 *
 * @param  $mysqli Une instance de la connexion MySQLi à la base de données.
 * @param int $articleId L'ID de l'article à mettre à jour.
 * @param string $nom Le nouveau nom de l'article.
 * @param string $references Les nouvelles références de l'article.
 * @param float $prixHT Le nouveau prix HT de l'article.
 * @param float $TVA La nouvelle TVA de l'article.
 * @param float $pourcentagePromotion Le nouveau pourcentage de promotion de l'article.
 * @param int $nouveaute La nouvelle valeur de nouveauté de l'article.
 *
 * @return bool Retourne true en cas de succès de la mise à jour, sinon retourne false.
 */
function updateArticle($mysqli, $articleId, $nom, $references, $prixHT, $TVA, $pourcentagePromotion, $nouveaute) {
    $updateArticleSql = "UPDATE articles 
                        SET nom = ?, `references` = ?, prixHT = ?, TVA = ?, pourcentagePromotion = ?, nouveaute = ?
                        WHERE articlesId = ?";
    $stmt = $mysqli->prepare($updateArticleSql);
    $stmt->bind_param("siiiiii", $nom, $references, $prixHT, $TVA, $pourcentagePromotion, $nouveaute, $articleId);

    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}
/**
 * Supprime un article de la base de données en utilisant son ID.
 *
 * @param  $mysqli Une instance de la connexion MySQLi à la base de données.
 * @param int $articleId L'ID de l'article à supprimer.
 *
 * @return bool Retourne true en cas de succès de la suppression, sinon retourne false.
 */
function deleteArticle($mysqli, $articleId) {
    $deleteArticleSql = "DELETE FROM articles WHERE articlesId = ?";
    $stmt = $mysqli->prepare($deleteArticleSql);
    $stmt->bind_param("i", $articleId);

    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}


///----------------------- SQL USERS---------------------------------///
/**
 * Ajoute un nouvel utilisateur à la base de données.
 *
 * @param  $mysqli Une instance de la connexion MySQLi à la base de données.
 * @param string $nom Le nom de l'utilisateur à ajouter.
 * @param string $prenom Le prénom de l'utilisateur à ajouter.
 * @param int $group La valeur de groupe de l'utilisateur à ajouter.
 * @param string $mail L'adresse e-mail de l'utilisateur à ajouter.
 * @param string $pays Le pays de l'utilisateur à ajouter.
 * @param string $numeros Le numéro de rue de l'utilisateur à ajouter.
 * @param string $rue La rue de l'utilisateur à ajouter.
 * @param string $ville La ville de l'utilisateur à ajouter.
 * @param string $telephone Le numéro de téléphone de l'utilisateur à ajouter.
 *
 * @return bool Retourne true en cas de succès de l'ajout, sinon retourne false.
 */
function addUsers($mysqli, $nom, $prenom, $group, $mail, $pays, $numeros, $rue, $ville, $telephone) {
    // Requête SQL pour insérer un nouvel utilisateur dans la table "users" (contenant group, mail)
    $insertUsersSql = "INSERT INTO users (group, mail) VALUES (?, ?)";
    $stmtUsers = $mysqli->prepare($insertUsersSql);
    $stmtUsers->bind_param("is", $group, $mail);

    // Exécutez la première insertion dans la table "users"
    $successUsers = $stmtUsers->execute();

    if ($successUsers) {
        $userId = $stmtUsers->insert_id;

        // Requête SQL pour insérer le reste des informations de l'utilisateur dans la table "usersInfos"
        $insertUsersInfosSql = "INSERT INTO usersInfos (userId, nom, prenom, pays, numeros, rue, ville, telephone) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmtUsersInfos = $mysqli->prepare($insertUsersInfosSql);
        $stmtUsersInfos->bind_param("isssisss", $userId, $nom, $prenom, $pays, $numeros, $rue, $ville, $telephone);

        // Exécutez la deuxième insertion dans la table "usersInfos"
        $successUsersInfos = $stmtUsersInfos->execute();

        if ($successUsersInfos) {
            return true; 
        } else {
            return false; // Échec de l'ajout dans la table "usersInfos"
        }
    } else {
        return false; // Échec de l'ajout dans la table "users"
    }
}

/**
 * Met à jour les informations de l'utilisateur dans la base de données en utilisant son ID.
 *
 * @param  $mysqli Une instance de la connexion MySQLi à la base de données.
 * @param int $userId L'ID de l'utilisateur à mettre à jour.
 * @param string $nom Le nouveau nom de l'utilisateur.
 * @param string $prenom Le nouveau prénom de l'utilisateur.
 * @param int $group La nouvelle valeur de groupe de l'utilisateur.
 * @param string $mail La nouvelle adresse e-mail de l'utilisateur.
 * @param string $pays Le nouveau pays de l'utilisateur.
 * @param string $numeros Le nouveau numéro de rue de l'utilisateur.
 * @param string $rue La nouvelle rue de l'utilisateur.
 * @param string $ville La nouvelle ville de l'utilisateur.
 * @param string $telephone Le nouveau numéro de téléphone de l'utilisateur.
 *
 * @return bool Retourne true en cas de succès de la mise à jour, sinon retourne false.
 */
function updateUsers($mysqli, $userId, $nom, $prenom, $group, $mail, $pays, $numeros, $rue, $ville, $telephone) {
    // Mettre à jour la table "users" 
    $updateUsersSql = "UPDATE users
                      SET `group` = ?, mail = ?
                      WHERE usersId = ?";
    $stmtUsers = $mysqli->prepare($updateUsersSql);
    $stmtUsers->bind_param("isi", $group, $mail, $userId);

    // Mettre à jour la table "usersInfos" 
    $updateUsersInfosSql = "UPDATE usersInfos
                            SET nom = ?, prenom = ?, pays = ?, numeros = ?, rue = ?, ville = ?, telephone = ?
                            WHERE userId = ?";
    $stmtUsersInfos = $mysqli->prepare($updateUsersInfosSql);
    $stmtUsersInfos->bind_param("sssisssi", $nom, $prenom, $pays, $numeros, $rue, $ville, $telephone, $userId);

    // Exécutez les deux mises à jour
    $successUsers = $stmtUsers->execute();
    $successUsersInfos = $stmtUsersInfos->execute();

    if ($successUsers && $successUsersInfos) {
        return true; // La mise à jour a réussi
    } else {
        return false; // Échec de la mise à jour
    }
}

/**
 * Supprime un utilisateur de la table "users" de la base de données en utilisant son ID.
 *
 * @param mysqli $mysqli Une instance de la connexion MySQLi à la base de données.
 * @param int $userIdToDelete L'ID de l'utilisateur à supprimer.
 *
 * @return bool Retourne true en cas de succès de la suppression, sinon retourne false.
 */
function deleteUsers($mysqli, $userIdToDelete) {
    // Requête SQL pour supprimer l'utilisateur de la table "users" en utilisant l'ID
    $deleteUserSql = "DELETE FROM users WHERE usersId = ?";
    $stmt = $mysqli->prepare($deleteUserSql);
    $stmt->bind_param("i", $userIdToDelete);

    if ($stmt->execute()) {
        return true; // La suppression a réussi
    } else {
        return false; // Échec de la suppression
    }
}

/**
 * Réinitialise le mot de passe d'un utilisateur et stocke le mot de passe haché dans la base de données.
 *
 * @param mysqli $mysqli Une instance de la connexion MySQLi à la base de données.
 * @param int $userId L'ID de l'utilisateur dont le mot de passe doit être réinitialisé.
 *
 * @return mixed Retourne le nouveau mot de passe en clair s'il a été réinitialisé avec succès, sinon retourne false en cas d'échec.
 */
function resetMdp($mysqli, $userId) {
    $nouveauMdp = generateRandomPassword();
    $hashedMdp = password_hash($nouveauMdp, PASSWORD_DEFAULT);
    $query = "UPDATE users SET password = ? WHERE usersId = ?";
    
    if ($stmt = $mysqli->prepare($query)) {
        $stmt->bind_param("si", $hashedMdp, $userId);
        if ($stmt->execute()) {
            // La mise à jour du mot de passe a réussi
            return $nouveauMdp; // Retournez le nouveau mot de passe pour affichage
        } else {
            // Erreur lors de la mise à jour
            return false;
        }
    }
    
    return false;
}
///----------------------- SQL ---------------------------------///

/**
 * Génère un mot de passe aléatoire.
 *
 * @param int $length (Facultatif) La longueur du mot de passe. Par défaut, la longueur est de 8 caractères.
 * @return string Retourne un mot de passe aléatoirement généré.
 */
function generateRandomPassword($length = 8) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ?,;/!@#$%^&*()_+=-123456789';
    $password = '';
    
    for ($i = 0; $i < $length; $i++) {
        $password .= $characters[rand(0, strlen($characters) - 1)];
    }
    
    return $password;
}
