<?php

/*

    Enoncé : 
        -- Modifier le code des classes ci dessous pour répondre aux questions suivantes : 

    1. Faire en sorte de ne pas avoir d'objet Vehicule 
    2. OBLIGATION pour la Renault ainsi que la Peugeot de posséder EXACTEMENT la même méthode démarrer() que Vehicule 
    3. OBLIGATION pour la Renault de déclarer un carburant diesel et pour la Peugeot de déclarer un carburant essence 
    4. La Renault doit effectuer 30 test de plus qu'un Vehicule de base, la Peugeot elle, 70 de plus qu'un Vehicule de base 
    5. Testez ! 

*/

class Vehicule
{
    public function demarrer()
    {
        return "je demarre";
    }

    public function carburant()
    {
        return "Essence ou Diesel ou Electrique";
    }

    public function nombreDeTests()
    {
        return 100;
    }
}

class Peugeot {

}

class Renault {

}
