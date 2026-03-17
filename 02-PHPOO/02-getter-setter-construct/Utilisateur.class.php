<?php 

// Déclaration de la classe Utilisateur
class Utilisateur {
    private $nom; 
    private $email;

    public function saluer() {
        return "Bonjour, je m'appelle " . $this->nom;
    }

    public function getNom() {
        return $this->nom;
    }

    public function setNom(string $newNom) {
        if (iconv_strlen($newNom) >= 1) {
             $this->nom = $newNom;
        } else {
            trigger_error("Le nom ne peut pas être vide", E_USER_NOTICE);
        }
    }

    public function getEmail() {

    }

    public function setEmail() {

    }
}

// Création d'un objet Utilisateur
$utilisateur = new Utilisateur;

// Affectation de valeurs dans les props de l'objet $utiliseteur 
// $utilisateur->nom = "Pierra";
$utilisateur->setNom("Pierra");
// echo $utilisateur->nom;
echo $utilisateur->getNom();
// $utilisateur->email = "pierra@mail.com";
var_dump($utilisateur);

echo $utilisateur->saluer();