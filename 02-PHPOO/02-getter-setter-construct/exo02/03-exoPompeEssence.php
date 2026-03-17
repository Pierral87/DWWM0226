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