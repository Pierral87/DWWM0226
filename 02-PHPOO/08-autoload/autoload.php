<?php 

/* 

Le concept de l'autoload en PHP : Est d'avoir un outil qui include les fichiers contenant les classes que l'on utilise, et ça automatiquement ! 

Cela nous évite de faire trop d'inclusion à la main par exemple : 

require("Classes/ClasseA.php");
require("Classes/ClasseB.php");
require("Classes/ClasseC.php");
require("Classes/ClasseD.php");
require("Classes/ClasseE.php");
require("Classes/ClasseF.php");
require("Classes/ClasseG.php");
require("Classes/ClasseH.php");
require("Classes/ClasseI.php");
require("Classes/ClasseJ.php");

// C'est très contraignant ! On peut oublier des classes ou en mettre sans que l'on s'en serve !

L'autoload lui, sera capable de voir toutes les classes que l'on utilise sur notre fichier et les intégrer automatiquement ! (Dès qu'elles sont nommées)

*/


// Création d'un autoload basique manuel 

function inclusionAuto($class) {

    $file = __DIR__ . "/Classes/" . $class . ".php";
    // Le résultat de cette variable après instanciation de la classe Article
    // http://localhost/dwwm0226/02-PHPOO/08-autoload/Classes/Article.php 

    require_once($file);
}

// spl_autoload_register est une fonction de PHP qui se déclenche dès lors qu'elle voit que l'on nomme une classe, que ce soit par une instanciation que par un appel d'un élément static 

// Il comprend ici qu'il doit lancer la fonction inclusionAuto que je viens de développer et il va récupérer et envoyer en paramètre le nom de la classe
spl_autoload_register("inclusionAuto");


// $article = new Article;
// $product = new Product;
