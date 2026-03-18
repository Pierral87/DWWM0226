<?php

/* 

    Finalisation des classes et des méthodes

Le mot-clé final peut être utilisé pour empêcher l'héritage d'une classe ou la surcharge d'une méthode.

    Classe finale : Une classe marquée comme final ne peut pas être extends.
    Méthode finale : Une méthode marquée comme final ne peut pas être surchargée dans les classes filles.

    */

class Animal
{
    public $nom;

    public function __construct($nom)
    {
        $this->nom = $nom;
    }

    final public function seDeplacer() // Ici méthode finale, ne peut pas être surchargée
    {
        echo "$this->nom se déplace<hr>";
    }
}

final class Chien extends Animal {  // Si je défini cette classe comme étant une classe finale, alors c'est la fin des héritages à partir de cette classe, elle ne pourra pas avoir de sous classe 
    // public function seDeplacer() Erreur, je ne peux pas override une méthode finale ! 
    // {}
}

// class Labrador extends Chien {} // 

$chien = new Chien("Rex");
$chien->seDeplacer();