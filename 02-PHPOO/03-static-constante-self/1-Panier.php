<?php 
/* 

-------------------- 1. Les constantes

Les constantes dans une classe permettent de définir des valeurs immuables, c'est à dire que l'on ne peut pas modifier plus tard.
Contrairement aux constantes globales définie avec define, ici on parle de constante de classe ! On les appelle au travers de la classe 
avec la syntaxe Classe::CONSTANTE  
Une constante est par défaut de visibilité public 
On peut accéder à une constante sans avoir besoin de créer un objet, elles font partie des éléments que l'on appelle "static"
Toujours en majuscule par convention d'écriture 

-------------------- 2. Les propriétés et méthodes static 

Les éléments static d'une classe, propriétés et méthodes, appartiennent non pas aux objets créés, MAIS à la classe elle même ! 
On peut les manipuler sans avoir besoin de créer un objet au préalable 

Pour manipuler un élément static on utilise la syntaxe Classe::props   ou Classe::method()    

-------------------- 3. Le mot clé self 

Le mot clé self est utilisé pour représenter une classe à l'intérieur d'elle même. C'est exactement comme le $this dans son contexte objet, ici c'est self:: dans le contexte static 

--------------------
Pourquoi est ce que l'on se sert d'élément static ? Pour ranger notre code ! 
On appréciera toujours, ne pas déclarer nos constantes dans le scope global, mais plutôt de les classer au travers de classe
Idem pour des fonctions, on pourra toujours les mettre dans le global, mais on préfère les classer dans une entité qui les regroupera par thème
Par exemple une classe de gestion des dates, une classe de calcul de tarif, une classe de gestion de session, une classe de gestion des informations de config, etc etc etc  

*/

class Panier {
    public static $totalProduits = 0;
    const TVA = 20;
    public $nomPanier = "MonPanier";

    public static function ajouterProduit($prix) {
        self::$totalProduits += $prix * (1 + self::TVA / 100);
    }

    public function hello() {
        echo "Salut !";
    }

}

// $panier = new Panier;
// var_dump($panier);
// echo $panier->totalProduits;

echo Panier::$totalProduits;
// Panier::$totalProduits = 1;
Panier::ajouterProduit(100);
echo "<br>";
echo Panier::$totalProduits;
echo "<br>";
echo Panier::TVA;


$panier = new Panier;

// Tests de syntaxes PHP entre static et non static 

echo $panier->nomPanier; // Syntaxe normale, j'appelle sur un objet, un élément contexte objet, c'est une propriété normale, appartenant à l'objet 
$panier->hello(); // Ici aussi syntaxe normale, j'appelle une méthode appartenant à l'objet 
// $panier->TVA; // Erreur, je ne peux pas appeler une constant de classe via un contexte objet 
echo "<hr>";
// Par contre... 
echo $panier::TVA;
echo $panier::$totalProduits;
$panier::ajouterProduit(200);
echo $panier::$totalProduits;

// ATTENTION AUX SYNTAXES CI DESSUS ! 
    // PHP est un langage souple et permissif, il autorise des appels d'éléments static sur des objet, alors que nous sommes dans des contextes différents
        // Dans d'autres langages, c'est l'erreur assurée !
