<?php

// Déclaration de la classe Utilisateur
class Utilisateur
{
    private $nom; // Ici mes props sont private je n'y ai pas accès depuis l'espace global, comment leur définir des valeurs ? au travers des setters 
    private $email;

    // Constructeur pour initialiser nos propriétés
    // Ici le __construct se lance dès que j'instancie un objet, il récupère les params fournis à l'instanciation (qui sont maintenant des params obligatoires) et me permet de les répercuter dans les props de l'objet 
    public function __construct($nom, $email)
    {
        echo "<h1>Passage dans le construct</h1>";
        echo "<h2>Voilà les informations reçues : $nom - $email </h2>";
        // Il est déjà bon d'appeler nos setter dans le constructeur 
        $this->setNom($nom);
        $this->setEmail($email);
    }

    public function saluer()
    {
        // Le mot clé $this me permet de représenter l'objet en cours d'utilisation plus tard dans le code 
        return "Bonjour, je m'appelle " . $this->nom;
    }


    // Ci dessous une paire de getter/setter pour CHAQUE propriétés !

    // getNom pour récupérer le nom
    // le but d'un getter est uniquement de récupérer la valeur d'une propriété (pour l'afficher ou la traiter)
    public function getNom()
    {
        return $this->nom;
    }

    // setNom pour affecter une valeur à la prop nom de l'objet 
    // Le but d'un setter est de pouvoir permettre une affectation dans une prop protected ou private tout en contrôlant l'information
    // Ci dessous je vérifie bien que la valeur envoyée est un string et qu'elle fait au moins 1 caractère 
    public function setNom(string $newNom)
    {
        if (iconv_strlen($newNom) >= 1) {
            $this->nom = $newNom;
        } else {
            trigger_error("Le nom ne peut pas être vide", E_USER_NOTICE);
        }
    }

    public function getEmail() {}

    public function setEmail($newEmail)
    {
        $this->email = $newEmail;
    }
}

// Création d'un objet Utilisateur
$utilisateur = new Utilisateur("Pierra", "pierra@mail.com");
var_dump($utilisateur);
echo $utilisateur->saluer();
// Affectation de valeurs dans les props de l'objet $utiliseteur 
// $utilisateur->nom = "Pierra";
// $utilisateur->setNom("Pierra");
// // echo $utilisateur->nom;
echo $utilisateur->getNom();
// // $utilisateur->email = "pierra@mail.com";


// echo $utilisateur->saluer();