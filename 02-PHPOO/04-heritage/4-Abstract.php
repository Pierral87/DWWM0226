<?php

/* 

    Une classe abstract ne peut pas être instanciée directement, mais elle sert de modèle pour d'autres classes.
    Elle contient généralement des méthodes abstract qui doivent obligatoirement être définies et implémentées dans les classes enfants 

    Méthode abstraite : une méthode déclarée mais non implémentée, elle oblige les classes filles à définir cette méthode.

    L'utilisation des classes abstract permet de fournir un cadre strict de développement afin que tous les membres d'une équipe travaillant sur des sous classes s'assurent de travailler de la même manière en nommant la méthode communiquer() telle qu'elle est prévue dans la classe abstraite

*/

abstract class Animals // Ici je défini ma classe comme étant abstract, je ne peux plus l'instancier 
{
    public $nom;

    public function __construct($nom)
    {
        $this->nom = $nom;
    }

    abstract public function communiquer(); // Ici méthode abstract à définir obligatoirement dans les classes filles 
                                            // Cette méthode ne peut pas contenir de body (on doit supprimer les accolades)
}

// $animal = new Animal("Pilou");
// var_dump($animal);

class Chien extends Animals // Ici obligation de définir et d'implémenter la méthode communiquer()
{
    public function communiquer()
    {
        echo "$this->nom aboie : woof !";
    }
}

class Chat extends Animals // Ici pareil, grâce à ça on s'assure que les appels sur Chien comme sur Chat seront les mêmes au travers de la méthode communiquer()
{
        public function communiquer()
    {
        echo "$this->nom miaule : miaou !";
    }
}

$chien = new Chien("Pilou");
var_dump($chien);
$chien->communiquer();
