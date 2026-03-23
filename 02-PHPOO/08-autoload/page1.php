<?php 

// Je ferai un seul require sur mon site, l'autoload
require("autoload.php");


// Grâce à l'autoload je n'ai plus besoin de me poser de questions sur les fichiers à ajouter à une page, il va les ajouter automatiquement
// On parle bien sur uniquement des fichiers rattachés à des classes (pas des header, footer, nav etc)
$article = new Article;
$product = new Product;