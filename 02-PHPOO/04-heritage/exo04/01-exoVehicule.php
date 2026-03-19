<?php

/*

    Enoncé : 
        -- Modifier le code des classes ci dessous pour répondre aux questions suivantes : 

    1. Faire en sorte de ne pas avoir d'objet Vehicule : abstract sur la classe Vehicule
    2. OBLIGATION pour la Renault ainsi que la Peugeot de posséder EXACTEMENT la même méthode démarrer() que Vehicule : final sur la méthode demarrer dans class Vehicule
    3. OBLIGATION pour la Renault de déclarer un carburant diesel et pour la Peugeot de déclarer un carburant essence : abstract sur la méthode carburant et redéclaration dans les sous classes
    4. La Renault doit effectuer 30 test de plus qu'un Vehicule de base, la Peugeot elle, 70 de plus qu'un Vehicule de base : surcharge de nombreDeTests() dans les sous classes avec appel parent::
    5. Testez ! 

*/

abstract class Vehicule
{
    final public function demarrer()
    {
        return "je demarre";
    }

    abstract public function carburant();

    public function nombreDeTests()
    {
        return 100;
    }
}

class Peugeot extends Vehicule
{
    public function carburant()
    {
        return "essence";
    }

    public function nombreDeTests()
    {
        return parent::nombreDeTests() + 70;
    }
}

class Renault extends Vehicule
{
    public function carburant()
    {
        return "diesel";
    }

    public function nombreDeTests()
    {
        return parent::nombreDeTests() + 30;
    }
}
