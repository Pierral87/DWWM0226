<?php

/************************************
   
    EXERCICE :
        Création d'une classe Membre avec cette modélisation 

    ----------------------
    |   Membre           |
    ----------------------
    |  - pseudo :string  |
    |  - email :string   |
    ----------------------
    | + __construct()    |
    | + getPseudo()      |
    | + setPseudo()      |
    | + getEmail()       |
    | + setEmail()       |
    ----------------------

            // Développer cette classe en respectant la modélisation au dessus, mettre en place les props private ainsi que toutes les méthodes
            // S'assurer du bon fonctionnement de la classe à l'instanciation, à l'appel de ses props/méthodes
            // Appliquer des contrôles sur les setters et gérer les cas d'erreurs d'une façon ou d'une autre 

            // Quelques vérifications supposées : pseudo pas trop court pas trop long, email format email grâce à la fonction filter_var 

            // Le construct doit initialiser les informations dès l'instanciation 

   
************************** */

class Membre {
    // Propriétés
    private $pseudo;
    private $email;

    // Méthodes
    public function __construct($pseudo, $email) {
        echo "<h1>Exercice membre</h1>";
        echo "<h2>Voici les informations demandées pour l'exercice membre : $pseudo - $email </h2>";

        $this->setPseudo($pseudo);
        $this->setEmail($email);
    }

    // setter-getter pseudo
    public function getPseudo(){
        return $this->pseudo;
    }

    public function setPseudo(string $newPseudo){
    if(iconv_strlen($newPseudo)<= 5){
        trigger_error("Le pseudo est trop court !", E_USER_NOTICE);
    }elseif(iconv_strlen($newPseudo) >= 15) {
        trigger_error("Le pseudo est trop long !", E_USER_NOTICE);
    }else{
        $this->pseudo = $newPseudo;
    }
    }

    // setter-getter email
    public function getEmail(){
        return $this->email;
    }

    public function setEmail(string $newEmail){
        if(filter_var($newEmail, FILTER_VALIDATE_EMAIL)){
        $this->email = $newEmail;
    }else{
        trigger_error("Adresse mail non valide !", E_USER_NOTICE);
    }
    }
}

// Création objet membre
$membre = new Membre("Magali", "magexo1@gmail.com");
var_dump($membre);
echo "<br>";
echo $membre->getPseudo();
echo "<br>";
echo $membre->getEmail();

$membre->setEmail("pouet@pouet.com");
$membre->setPseudo("Lololo");
var_dump($membre);
echo "<br>";
echo $membre->getPseudo();
echo "<br>";
echo $membre->getEmail();
