<?php

/*

Surcharge (Override)

La surcharge ou override permet à une classe enfant de réécrire une méthode héritée de la classe parente afin de modifier son comportement 

*/

class Animal
{
    public $nom;

    public function __construct($nom)
    {
        $this->nom = $nom;
    }

    public function seDeplacer()
    {
        echo "$this->nom se déplace<hr>";
    }
}

class Oiseau extends Animal {

// On rédéfinit la méthode seDeplacer, elle écrase alors le comportement d'origine de cette méthode qui est maintenant "vole dans les airs"
    public function seDeplacer() {
        echo "$this->nom vole dans les airs.<hr>";
    }

    // Si jamais j'ai la nécessité de réatteindre la méthode de la classe Mère, je peux le faire au travers de la syntaxe parent::nomDeMethode() 
    public function oldSeDeplacer() {
        parent::seDeplacer();
    }
}

$oiseau = new Oiseau("Yuzo");
$oiseau->seDeplacer();
$oiseau->oldSeDeplacer();
