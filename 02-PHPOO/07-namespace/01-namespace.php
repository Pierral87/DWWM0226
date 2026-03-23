<?php 

// Les namespaces en Orienté Objet
// Les namespaces nous permettent d'organiser nos classes dans des sortes de "dossiers virtuels", plutôt qu'elles soient toutes présentes dans le scope global de PHP
// Cela nous évite des conflits de nom qui pourraient arrriver lorsque l'on travaille à plusieurs ou lorsque l'on intègre des librairies extérieures
// On fera en sorte que nos namespace correspondent à des vrais dossiers dans notre arborescence pour respecter les normes PSR3 ou PSR4 pour le bon fonctionnement de notre autoload (voir chapitre suivant)

use LibrairieA\Utilisateurr;
use LibrairieB\Utilisateurr as User;

include("librairieAUtilisateur.php"); // Dans ce fichier se trouve la classe Utilisateurr mais faisant partie du namespace LibrairieA
include("librairieBUtilisateur.php"); // Dans ce fichier se trouve la classe Utilisateurr mais faisant partie du namespace LibrairieB DONC pas de conflit entre les deux, elles sont dans des namespace différents

// Si je veux instancier un objet qui vient d'un namespace alors je dois procéder d'une façon particulière

// 1ère façon au travers du FQN 
// FQN : Fully Qualified Name c'est à dire le nom entier de l'objet et de ses namespaces
$userA = new LibrairieA\Utilisateurr;
$userB = new LibrairieB\Utilisateurr;

var_dump($userA);
var_dump($userB);

// 2ème façon au travers de l'instruction "use" qui va importer la classe sur notre fichier 

// A partir du moment où j'ai la ligne d'importation "use" je n'ai plus besoin de spécifier le FQN
$user = new Utilisateurr;
$userr = new User;

// Il existe une constante magique qui nous indique le namespace dans lequel on se trouve 




