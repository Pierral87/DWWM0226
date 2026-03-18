<?php

// Exemple d'utilisation static avec une classe qui permet de lancer des vérifications sur des champs de formulaire 

class FormValidator
{
    public static function isEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public static function isRequired($value)
    {
        return !empty($value);
    }

    public static function pseudoLength($pseudo)
    {
        if (iconv_strlen($pseudo) < 16 && iconv_strlen($pseudo) > 3) {
            return true;
        } else {
            return false;
        }
    }
}


// Utilisation 


// If isset POST // REQUEST_METHOD etc ...... 

// On enchainerait les vérifications des saisies grâce à notre classe 
$email = "pierra@mail.com";
if (FormValidator::isEmail($email)) {
    echo "email ok";
}

if (FormValidator::isRequired($email)) {
    echo "email bien saisi";
}

if (FormValidator::pseudoLength($pseudo)) {
    echo "pseudo ok";
}
