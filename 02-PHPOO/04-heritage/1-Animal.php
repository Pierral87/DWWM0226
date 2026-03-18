<?php 

/* 

1. Héritage simple 

L'héritage est un concept de la programmation orientée objet, il permet de créer des classes dérivées qui héritent des props et méthodes d'une classe parente.
Cela permet de réutiliser du code et d'ajouter des fonctionnalités supplémentaires spécifiques aux enfants 

Attention à respecter un contexte cohérent dans l'héritage 
    C'est à dire, il faut pouvoir dire que A est un B 
    Chien est un Animal 
    Voiture est un Vehicule 
    Admin est un User 

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

class Chien extends Animal // extends est le mot clé qui permet de définir un héritage entre deux classes
                            // Ici Chien hérite de Animal et va recevoir toutes ses props et méthodes pour peu qu'elles soient de visibilité public ou protected
                            // (le private lui n'est pas récupéré à l'héritage)
{
    public function aboyer()
    {
        echo "$this->nom aboie : Woof!<hr>";
    }
}

class Chat extends Animal // Ici idem, Chat récupère tous les éléments de Animal
{
    public function miauler() 
    {
        echo "$this->nom miaule : Miaou!<hr>";
    }
}

// Instanciation de l'objet Chien qui hérite de Animal 
$chien = new Chien("Pilou");
var_dump($chien);
var_dump(get_class_methods($chien));
// $chien->seDeplacer();
// $chien->aboyer();

$chat = new Chat("Neko");
// $chat->seDeplacer();
$chat->miauler() . $chat->seDeplacer();