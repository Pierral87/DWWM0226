<?php 
// Ici je définie que ce fichier utilisera le namespace LibrairieA;
namespace LibrairieA;

class Utilisateurr {
    public function getNom(){
        return "Pierre";
    }
}



// echo __NAMESPACE__; // Ici une constante magique qui m'indique le namespace dans lequel je me trouve
// $pdo = new \PDO(); // ATTENTION si je suis dans un fichier à namespace, il faudra que je rajoute un antislash devant les instructions venant du global de PHP, par exemple PDO devient \PDO,  Exception, devient \Exception  etc   (en fonction des architectures (MVC ou autre)) ce ne sera pas obligatoire