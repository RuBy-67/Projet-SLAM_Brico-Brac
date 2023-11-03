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
