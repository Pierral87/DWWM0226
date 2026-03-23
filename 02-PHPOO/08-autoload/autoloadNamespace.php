<?php 

// Même chose avec les namespace, ici on les classes dans le dossier /src/ donc on specifie à notre autoload de d'abord rentrer dans src

// Finalement, comme notre classe possède un namespace, alors l'autoload sera capable de rentrer dans un dossier qui possède le meme nom que mon namespace

// Par exemple j'ai un fichier UtilisateurController.php qui possède une classe UtilisateurController (meme nom de classe = meme nom de fichier) qui lui même fait parti du namespace Controller (donc dossier Controller)

// Controller\UtilisateurController   .php
function inclusionAuto($class) {

    $file = __DIR__ . "/src/" . $class . ".php";

    require_once($file);
}

// spl_autoload_register est une fonction de PHP qui se déclenche dès lors qu'elle voit que l'on nomme une classe, que ce soit par une instanciation que par un appel d'un élément static 

// Il comprend ici qu'il doit lancer la fonction inclusionAuto que je viens de développer et il va récupérer et envoyer en paramètre le nom de la classe
spl_autoload_register("inclusionAuto");