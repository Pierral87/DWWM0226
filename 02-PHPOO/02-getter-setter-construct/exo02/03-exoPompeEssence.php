<?php

/*********************
 
    EXERCICE :

        Création de la classe Vehicule et de la classe Pompe en suivant ces modélisations

    ----------------------
    |   Vehicule         |
    ----------------------
    |-litresReservoir:int|
    ----------------------
    |+setlitresReservoir()|
    |+getlitresReservoir()|
    ----------------------

    ----------------------
    |   Pompe            |
    ----------------------
    | -litresStock:int   |
    ----------------------
    | +setlitresStock()  |
    | +getlitresStock()  |
    | +donnerEssence()   |
    ----------------------

        Classe Véhicule, rien de spécial, une prop, son setter, son getter 

        Classe Pompe, une prop avec son setter son getter 

        Le but ici étant qu'un Vehicule passe à la pompe pour faire le plein !  

        Spécifications : 
                - Le réservoir d'une voiture est considéré à contenance max fixe de 50   (litres)
                - La méthode donnerEssence() distribue de l'essence au Vehicule, si possible, toujours le plein, sinon ? A voir :) 
                - Gérez les exceptions qui peuvent être rencontrées à l'appel de la méthode donnerEssence()   

    */

    class Vehicule 
    {
        private $litresReservoir; 

        public function setLitresReservoir(int $newReservoir)
        {

        }

        public function getLitresReservoir()
        {

        }
    }

    class Pompe 
    {
        private $litresStock;

        public function setLitresStock(int $newStock) 
        {

        } 

        public function getLitresStock()
        {

        }

        public function donnerEssence(Vehicule $vhc) // Ici ma méthode prends en param un objet Vehicule, dans ce cas, à l'intérieur de la méthode, j'ai accès à tout ce qui défini un objet Vehicule, à savoir, ses propriétés et ses méthodes
        {
            $litresVhc = $vhc->getLitresReservoir(); // Ici je comprends combien il reste d'essence dans le vehicule, donc je comprends facilement combien il lui en manque ! 

            // 3 cas possibles 
                // La pompe a assez pour donner le plein, très bien
                // La pompe n'a pas assez pour donner le plein mais a quand même quelques litres, on les donne tous au véhicule ! 
                // La pompe est vide ! On ne peut rien donner au véhicule 
        }
    }

    $vehicule1 = new Vehicule;
    $vehicule2 = new Vehicule; 
    $vehicule3 = new Vehicule;

    $pompe1 = new Pompe;

    $pompe1->donnerEssence($vehicule1);