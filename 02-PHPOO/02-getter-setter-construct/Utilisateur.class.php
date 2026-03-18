<?php
/* 
    02 - Getter, Setter, Construct, This

Dans la programmation orientée objet (POO) en PHP, les concepts de getter, setter, constructeur (__construct), et $this sont des mécanismes essentiels qui permettent d’organiser et de structurer les classes, tout en contrôlant la manipulation des propriétés des objets.

--- Le Constructeur (__construct)
Le constructeur est une méthode spéciale dans une classe qui est automatiquement appelée lors de la création d'un objet à partir de cette classe. Il permet d'initialiser les propriétés de l'objet dès sa création.

--- Le mot-clé $this 
En PHP, le mot-clé $this fait référence à l'objet courant dans lequel il est utilisé. Il permet d'accéder aux propriétés et méthodes de cet objet depuis l'intérieur de la classe.

--- Les Getters 
Un getter est une méthode publique qui permet d'accéder aux propriétés d'une classe, tout en gardant les propriétés elles-mêmes protégées ou privées. Cela permet de mieux contrôler et sécuriser l'accès aux données.

--- Les Setters
Un setter est une méthode publique qui permet de modifier la valeur d'une propriété privée ou protégée. Comme pour les getters, cela permet de valider et contrôler les changements sur les propriétés.

  Il y aura toujours une paire getter/setter pour chaque propriété de l'objet !!!

       // Un setter sans vérification est toujours utile ! Il faut penser à l'avenir de notre application 
        // Il est toujours bon de normaliser les appels des props de nos objets (c'est à dire, toujours en faisant un appel d'une prop d'un objet en appelant une méthode getProp()) pour s'assurer que ce n'est pas différent d'un objet à l'autre 
        // Idem pour les setters et leurs vérifications, si je n'ai pas de vérification à faire pour le moment, c'est pas grave, je sais que je normalise l'appel d'un changement de prop par ces méthodes setProp()
        // Si un jour je veux rajouter un contrôle sur une prop, j'ai simplement à modifier le code dans la méthode set associée et rien d'autre dans le reste de mon code 
        // Si je défini un setter avec une validation, je m'assure que la propriété en question reçoit uniquement des valeurs valides.

*/

// Déclaration de la classe Utilisateur
class Utilisateur
{
    private $nom; // Ici mes props sont private je n'y ai pas accès depuis l'espace global, comment leur définir des valeurs ? au travers des setters 
    private $email;

    // Constructeur pour initialiser nos propriétés
    // Ici le __construct se lance dès que j'instancie un objet, il récupère les params fournis à l'instanciation (qui sont maintenant des params obligatoires) et me permet de les répercuter dans les props de l'objet 
    public function __construct($nom, $email)
    {
        echo "<h1>Passage dans le construct</h1>";
        echo "<h2>Voilà les informations reçues : $nom - $email </h2>";
        // Il est déjà bon d'appeler nos setter dans le constructeur 
        $this->setNom($nom);
        $this->setEmail($email);
    }

    public function saluer()
    {
        // Le mot clé $this me permet de représenter l'objet en cours d'utilisation plus tard dans le code 
        return "Bonjour, je m'appelle " . $this->nom;
    }


    // Ci dessous une paire de getter/setter pour CHAQUE propriétés !

    // getNom pour récupérer le nom
    // le but d'un getter est uniquement de récupérer la valeur d'une propriété (pour l'afficher ou la traiter)
    public function getNom()
    {
        return $this->nom;
    }

    // setNom pour affecter une valeur à la prop nom de l'objet 
    // Le but d'un setter est de pouvoir permettre une affectation dans une prop protected ou private tout en contrôlant l'information
    // Ci dessous je vérifie bien que la valeur envoyée est un string et qu'elle fait au moins 1 caractère 
    public function setNom(string $newNom)
    {
        if (iconv_strlen($newNom) >= 1) {
            $this->nom = $newNom;
        } else {
            trigger_error("Le nom ne peut pas être vide", E_USER_NOTICE);
        }
    }

    public function getEmail() {}

    public function setEmail($newEmail)
    {
        $this->email = $newEmail;
    }
}

// Création d'un objet Utilisateur
$utilisateur = new Utilisateur("Pierra", "pierra@mail.com");
var_dump($utilisateur);
echo $utilisateur->saluer();
// Affectation de valeurs dans les props de l'objet $utiliseteur 
// $utilisateur->nom = "Pierra";
// $utilisateur->setNom("Pierra");
// // echo $utilisateur->nom;
echo $utilisateur->getNom();
// // $utilisateur->email = "pierra@mail.com";


// echo $utilisateur->saluer();