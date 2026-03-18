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
        if ($newReservoir <= 50 && $newReservoir >= 0) { // On autorise seulement entre 0 et 50 litres dans la voiture 
            $this->litresReservoir = $newReservoir;
        } else {
            trigger_error("Le réservoir ne peut pas être négatif ou supérieur à 50", E_USER_NOTICE);
        }
    }

    public function getLitresReservoir()
    {
        return $this->litresReservoir;
    }
}

class Pompe
{
    private $litresStock;

    public function setLitresStock(int $newStock)
    {
        if ($newStock >= 0) { // On autorise uniquement des litres positifs dans la pompe 
            $this->litresStock = $newStock;
        }
    }

    public function getLitresStock()
    {
        return $this->litresStock;
    }

    public function donnerEssence(Vehicule $vhc) // Ici ma méthode prends en param un objet Vehicule, dans ce cas, à l'intérieur de la méthode, j'ai accès à tout ce qui défini un objet Vehicule, à savoir, ses propriétés et ses méthodes
    {
        var_dump($vhc); // J'ai accès ici à l'objet vehicule ! ses props et ses méthodes ! 
        $litresVhc = $vhc->getLitresReservoir(); // Ici je comprends combien il reste d'essence dans le vehicule, donc je comprends facilement combien il lui en manque ! 
        $litresManquants = 50 - $litresVhc; // Ici une variable me permettant de comprendre combien il manque de litres dans le vehicule
        $litresPompe = $this->getLitresStock(); // Ici une variable me permettant de comprendre combien il reste de litres dans la pompe 

        // Le fait de créer ces trois variables rends le code plus lisible ! Plutôt que d'appeler à chaque fois les getters 

        if ($litresPompe == 0) {   // Ici scénario pompe vide, rien ne se passe, juste un message ! 
            var_dump($vhc);
            echo "Désolé la pompe est vide !<hr>";
        } elseif ($litresPompe >= $litresManquants) { // Ici scénario j'ai assez pour faire le plein (j'ai au moins autant de litres dans la pompe que de litres manquant dans le vehicule)
            $this->setLitresStock($litresPompe - $litresManquants); // Je retire à la pompe les litres que je vais donner à la voiture
            $vhc->setLitresReservoir(50); // La voiture se retrouve avec le plein ! 
            var_dump($vhc);
            echo "Plein effectué ! Vous avez rempli $litresManquants litres<hr>";
        } else { // Scénario, pas assez pour faire le plein, mais quelques litres quand même, on donne tout ce qu'on peut à la voiture !
            $vhc->setLitresReservoir($litresVhc + $litresPompe); // J'ajoute aux litres actuels de la voiture, les litres restant dans la pompe
            $this->setLitresStock(0); // La pompe se retrouve à 0 ! 
            var_dump($vhc);
            echo "Nous n'avons pu donner que $litresPompe litres sorry ! Vous n'avez pas le plein total <hr>";
        }

        // 3 cas possibles 
        // La pompe a assez pour donner le plein, très bien
        // La pompe n'a pas assez pour donner le plein mais a quand même quelques litres, on les donne tous au véhicule ! 
        // La pompe est vide ! On ne peut rien donner au véhicule 
    }
}

// Tests avec 3 vehicules 
$vehicule1 = new Vehicule;
$vehicule1->setLitresReservoir(40);
$vehicule2 = new Vehicule;
$vehicule2->setLitresReservoir(30);
$vehicule3 = new Vehicule;
$vehicule3->setLitresReservoir(10);
var_dump($vehicule1);
var_dump($vehicule2);
var_dump($vehicule3);

$pompe1 = new Pompe;
$pompe1->setLitresStock(25);
var_dump($pompe1);
echo "<hr>";
$pompe1->donnerEssence($vehicule1); // Scénar je peux faire le plein
$pompe1->donnerEssence($vehicule2); // Scénar je peux pas faire le plein, mais j'ai quelques litres à donner ! 
$pompe1->donnerEssence($vehicule3); // Scénar pompe vide ! 
