<?php
/** 
*This function allows you to obtain the price including tax of an item.
* @param float  $price  price without tax
* @param float  $tva  percent of the tax
* @return float $priceWithTax price including tax
*/
function calculedPriceWithTva(float $price,float $tva):float{
    if ($price < 0 || $tva < 0) {
        //? Check if value are positives
        return "Les valeurs doivent être positives.";
    }
    $priceTTC = $price + ($price * ($tva / 100));

    return $priceTTC;
}

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
function addUsers($mysqli, ) {
    $insertArticleSql = "INSERT INTO  VALUES ()";
    $stmt = $mysqli->prepare($insertArticleSql);
    $stmt->bind_param("siiiii", );

    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}

function updateUsers($mysqli, ) {
    $updateArticleSql = "UPDATE 
                        SET 
                        WHERE ";
    $stmt = $mysqli->prepare($updateArticleSql);
    $stmt->bind_param("siiiiii", );

    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}

function deleteUsers($mysqli, $articleId) {
    $deleteArticleSql = "DELETE FROM  WHERE ";
    $stmt = $mysqli->prepare($deleteArticleSql);
    $stmt->bind_param("i", $articleId);

    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}
///----------------------- SQL ---------------------------------///