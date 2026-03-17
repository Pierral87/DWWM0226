<?php

/* 

    La programmation orientée objet (POO), en PHP repose sur quelques concepts clés comme les classes, les objets et les instances.
    Elle inclut également des notions de visibilité qui contrôlent l'accès aux props et aux méthodes. 


*/


// 1. Déclaration d'une classe 
// Une classe en PHP est un modèle qui définit des propriétés (variables) et des méthodes (fonctions) qui seront partagées par les objets créés à partir de cette classe

// 3. Visibilité : 
    // La visibilité en POO définit le niveau d'accès aux propriétés et méthodes d'une classe
        // Public : Les props et méthodes publiques sont accessibles depuis n'importe où, scope global (partout dans le code) ou scope local (à l'intérieur de la classe)
        // Protected : Les props et méthodes protected sont accessible uniquement à l'intérieur de la classe (scope local), si je veux les manipuler, je dois transiter par une méthode 
        // Private : Les props et méthodes private sont accessible uniquement à l'intérieur de la classe (scope local), si je veux les manipuler, je dois transiter par une méthode 

    // Quelle différence entre protected et private ? 
            // C'est en rapport avec l'héritage ! Une props ou méthode protected sera récupérée dans la classe fille par héritage, alors que en private non !     
class Voiture
{
    // Propriétés
    public $marque;
    public $modele;
    public $couleur;
    protected $km = 0;  // Ici propriété protected je n'y ai pas accès dans le scope global, je peux la manipuler par contre à l'intérieur de la déclaration de Voiture
    private $carburant; // Pareil ici, propriété private, je n'y ai pas accès dans le scope global, je peux la manipuler à l'intérieur de la classe Voiture

    // Méthodes 
    public function demarrer()
    {
        return "La voiture démarre, vroum vroum !";
    }

    public function stopper() 
    {
        return "STOP LA VOITURE";
    }

    public function choixCarburant($carbu)
    {
        $this->carburant = $carbu;
    }
}

// 2. Instanciation d'un objet 
    // Pour utiliser une classe, on doit créer un objet à partir de celle-ci, c'est ce qu'on appelle l'instanciation
$voiture1 = new Voiture;

// Le var_dump me montre les propriétés de l'objet
var_dump($voiture1);
// object(Voiture)[1]
//   public 'marque' => null
//   public 'modele' => null
//   public 'couleur' => null

// Le get_class_methods me montre les méthodes de l'objet 
var_dump(get_class_methods($voiture1));


// Assignation de valeurs dans les propriétés de la voiture1 
$voiture1->marque = "Peugeot";
$voiture1->modele = "2008";
$voiture1->couleur = "bleue";
// $voiture1->km = 1000;  // Fatal error: Uncaught Error: Cannot access protected property Voiture::$km
// $voiture1->carburant = "essence";
// $voiture1->choixCarburant("essence");
var_dump($voiture1);

echo $voiture1->demarrer();

// Instanciation d'un nouvel objet voiture
$voiture2 = new Voiture;
$voiture2->marque = "Renault";
var_dump($voiture2);

/*

    La classe est un modèle qui contient des propriétés et des méthodes 
    Un objet est une instance de cette classe, chaque objet peut avoir ses propres valeurs indépendantes d'un autre objet 
    Les niveaux de visibilité permettent de contrôler l'accès aux données et aux fonctionnalités d'une classe
    Pour manipuler des éléments protected/private on utilisera ce qu'on appeller des getter et setter 


*/



