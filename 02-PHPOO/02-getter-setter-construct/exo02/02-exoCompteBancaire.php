<?php

/* 

EXERCICE : 
            Création d'une classe CompteBancaire selon la modélisation suivante 

    ----------------------
    |   CompteBancaire   |
    ----------------------
    | -titulaire:string  |
    | -solde:float       |
    ----------------------
    | +__construct()     |
    | +getTitulaire()    |
    | +setTitulaire()    |
    | +getSolde()        |
    | +setSolde()        |
    | +afficherSolde()   |
    | +retirer()         |
    | +deposer()         |
    ----------------------

            // Développer cette classe CompteBancaire, définir les props, implémenter les méthodes 

            // Getter & Setters à mettre en place, avec les contrôles que vous pensez cohérents 
            // Puis implémentation des méthodes afficherSolde() pour afficher un message indiquant le solde en cours 
                // Méthode retirer() pour retirer de l'argent du compte (un retrait du solde, vérification si solde négatif ? ou dépasse 0 ?)
                // Méthode deposer() pour rajouter de l'argent dans le compte 

*/

class CompteBancaire {
    private $titulaire;
    private $solde;

    public function __construct($titulaire, $solde) {
        $this->setTitulaire($titulaire);
        $this->setSolde($solde);
    }

    public function getTitulaire() {
        return $this->titulaire;
    }

    public function setTitulaire(string $newTitulaire) {
        if (iconv_strlen($newTitulaire) >= 5 && iconv_strlen($newTitulaire) <= 20) {
        //     echo "Nom du titulaire valide" . "<hr></hr>";
            $this->titulaire = $newTitulaire;
        } else {
            trigger_error("Le nom du titulaire doit être compris entre 5 et 20 caractères", E_USER_NOTICE);
        }
        
    }

    public function getSolde() {
        return $this->solde;
    }

    public function setSolde(float $newsolde) {
        if (($newsolde) < 0) {
            trigger_error("Votre solde doit être positif !");
        } else {
        //     echo "Votre solde est correct !";
            $this->solde = $newsolde;
        }
    }

    public function afficherSolde() {
        return "Bonjour, votre solde est de " . $this->getSolde() . " €";
    } 
    
    public function retirer(float $montant) {
        $soldeActuel = $this->getSolde();
        if ($montant > $soldeActuel || $montant < 0) {
            trigger_error("Le montant choisi est trop important");
        } else 
            $this->setSolde($soldeActuel - $montant);
            echo "Votre solde est de " . $this->getSolde() ." €";
    }

    public function deposer(float $montant) {
        $soldeActuel = $this->getSolde();
        if ($montant < 0) {
        trigger_error("Le montant choisi doit être supérieur à 0 €");
            } else {
        $this->setSolde($soldeActuel + $montant);
        echo "Votre solde est de " . $this->getSolde() . " €";
        }
    }

}

$compte = new CompteBancaire("SuperPatate", 1500.00);

echo "<hr></hr>";

var_dump($compte);

echo "<hr></hr>";

echo $compte->getSolde();

echo "<hr></hr>";

echo $compte->retirer(500);
echo "<hr></hr>";
echo $compte->deposer(700);