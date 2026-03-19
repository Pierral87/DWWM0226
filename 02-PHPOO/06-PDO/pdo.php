<?php

// ------------------------------------------------------------------------------
// ------------------------------------------------------------------------------
// ---------- PDO : PHP DATA OBJECT ---------------------------------------------
// ------------------------------------------------------------------------------
// ------------------------------------------------------------------------------

// PDO est une classé prédéfinie de PHP, elle représente une connexion à un serveur de BDD 
// On va le manipuler ici avec MySQL mais on peut le manipuler avec d'autres SGBD
// On quelques sortes, on peut considérer que PDO est une "porte" vers notre BDD 

echo "<h2>01 - Connexion à la BDD</h2>";

// Pour créer une connexion à la BDD nous avons besoin de plusieurs informations (voir doc pour plus de details)
// - Le service, host et nom de BDD 
// - Le login du connexion à la BDD
// - Le password de connexion pour ce login 
// - Eventuellement un array contenant des options 

$host = "mysql:host=localhost;dbname=entreprise2"; // Attention pour MAMP, il faut parfois spécifier le port de localhost donc localhost:8080 ou localhost:8888
$login = "root";
$password = ""; // Attention pour MAMP le password c'est "root", pour les autres, pas de password
$options = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING
);

try {
    $pdo = new PDO($host, $login, $password, $options);
} catch (PDOException $e) {

    //  echo "Erreur : " . $e->getMessage(); 
    echo "Erreur de Base de données, revenez plus tard";
    die;
}

var_dump($pdo);
// object(PDO)[1] // si j'ai l'objet PDO, alors connexion réussie à notre BDD ! 

echo "<h2>02 - Requêtes de type action (INSERT / UPDATE / DELETE)</h2>";

// Enregistrement d'un nouvel employé dans la BDD 

// On va utiliser ici la méthode "query" pour lancer nos requêtes directement (un peu comme dans la console)
// ATTENTION !!!!! query est une méthode sensible aux injections SQL (tentative de piratage)
// A terme, sur une système fini, on utilisera à la place la méthode prepare() que nous verrons à la fin de ce chapitre, qui nous permet de lancer nos requêtes de manière sécurisée 

// $stmt = $pdo->query("INSERT INTO employes (prenom, nom, salaire, sexe, date_embauche, service) VALUES ('Pierral', 'Lacaze', 12000, 'm', CURDATE(), 'web')");


// $stmt est un objet de type PDOStatement, c'est une sorte de sous objet de PDO qui "représente" la réponse à une requête
// Attention, ce n'est pas encore la réponse exploitable pour affichage ! 

// Ici dans une requête action, pas vraiment de réponse à traiter, mais on peut accéder à quelques méthodes et informations
// Dans le var_dump on peut voir la requête qui a été lancée 
// var_dump($stmt);
// rowCount() quant à lui nous permet de récupérer le nombre de lignes impactées par la requête
// echo $stmt->rowCount();

echo "<h2>03 - Requêtes de sélection pour une seule ligne de résultat</h2>";

$stmt = $pdo->query("SELECT * FROM employes WHERE id_employes = 991");
// La requête ci dessus envoyée dans la console :
// +-------------+---------+--------+------+---------+---------------+---------+
// | id_employes | prenom  | nom    | sexe | service | date_embauche | salaire |
// +-------------+---------+--------+------+---------+---------------+---------+
// |         991 | Pierral | Lacaze | m    | web     | 2026-03-19    |   12000 |
// +-------------+---------+--------+------+---------+---------------+---------+

var_dump($stmt);
// Actuellement je n'ai pas accès au résultat de la requête, ce n'est pas exploitable !
// Je n'ai accès à aucune information sauf une propriété qui m'indique la requête lancée 

// Pour la rendre exploitable par mon PHP, je vais devoir la convertir/l'extraire du PDOstatement
// On fait ça avec la méthode fetch() 

// fetch() a plusieurs mode de fonctionnement qui définissent la forme du résultat exploitable 

// FETCH_ASSOC : Pour associatif, pour récupérer un array associatif ! (nom des colonnes du résultat = indice du array)
$data = $stmt->fetch(PDO::FETCH_ASSOC);
var_dump($data);
// array (size=7)
//   'id_employes' => string '991' (length=3)
//   'prenom' => string 'Pierral' (length=7)
//   'nom' => string 'Lacaze' (length=6)
//   'sexe' => string 'm' (length=1)
//   'service' => string 'web' (length=3)
//   'date_embauche' => string '2026-03-19' (length=10)
//   'salaire' => string '12000' (length=5)

// $data = $stmt->fetch(PDO::FETCH_NUM); // Pour un array indexé numériquement
// var_dump($data);
// array (size=7)
//   0 => string '991' (length=3)
//   1 => string 'Pierral' (length=7)
//   2 => string 'Lacaze' (length=6)
//   3 => string 'm' (length=1)
//   4 => string 'web' (length=3)
//   5 => string '2026-03-19' (length=10)
//   6 => string '12000' (length=5)

// $data = $stmt->fetch(PDO::FETCH_BOTH); // Pour un array indexé numériquement et aussi associativement, c'est le cas par défaut
// var_dump($data);
// array (size=14)
//   'id_employes' => string '991' (length=3)
//   0 => string '991' (length=3)
//   'prenom' => string 'Pierral' (length=7)
//   1 => string 'Pierral' (length=7)
//   'nom' => string 'Lacaze' (length=6)
//   2 => string 'Lacaze' (length=6)
//   'sexe' => string 'm' (length=1)
//   3 => string 'm' (length=1)
//   'service' => string 'web' (length=3)
//   4 => string 'web' (length=3)
//   'date_embauche' => string '2026-03-19' (length=10)
//   5 => string '2026-03-19' (length=10)
//   'salaire' => string '12000' (length=5)
//   6 => string '12000' (length=5)

// $data = $stmt->fetch(PDO::FETCH_OBJ); // Pour un objet générique StdClass avec pour props les noms des colonnes 
// var_dump($data);
// object(stdClass)[3]
//   public 'id_employes' => string '991' (length=3)
//   public 'prenom' => string 'Pierral' (length=7)
//   public 'nom' => string 'Lacaze' (length=6)
//   public 'sexe' => string 'm' (length=1)
//   public 'service' => string 'web' (length=3)
//   public 'date_embauche' => string '2026-03-19' (length=10)
//   public 'salaire' => string '12000' (length=5)

// Si je veux afficher, la syntaxe dépends de mon mode de FETCH
// Pour le prénom par exemple 
echo $data["prenom"]; // FETCH_ASSOC
// echo $data[1]; // FETCH_NUM 
// echo $data->prenom; // FETCH_OBJ

// Une ligne traitée avec fetch n'existe plus dans la réponse ! (on remarque que je ne peux pas faire fetch plusieurs fois sur le meme stmt de ma requête)

echo "<h2>03 - Requêtes de sélection pour plusieurs lignes de résultat</h2>";

$stmt = $pdo->query("SELECT * FROM employes");

echo "Nombre d'employés : " . $stmt->rowCount() . "<hr>";

// fetch() ne traite qu'une seule ligne à la fois ! 
// A chaque fois que je l'appelle il traite une ligne de plus et une autre et une autre, une par une ! 
// Pour traiter un résultat à plusieurs avec fetch, je peux faire une boucle ! 
// $data = $stmt->fetch(PDO::FETCH_ASSOC);
// var_dump($data);
// $data = $stmt->fetch(PDO::FETCH_ASSOC);
// var_dump($data);
// $data = $stmt->fetch(PDO::FETCH_ASSOC);
// var_dump($data);

// L'utilisation de la boucle while est judicieuse ici car elle tourne tant qu'il y a des résultats dans le stmt
// fetch() me renvoie false lorsqu'il n'y a plus de résultats, donc la boucle s'arrête d'elle même 

// while($data = $stmt->fetch(PDO::FETCH_ASSOC)){
//     var_dump($data);
//     echo "<hr>";
// }

// Maintenant que je sais traiter des résultats d'une BDD, je peux maintenant me poser la question de comment les afficher proprement
// Libre à moi en fonction du contexte de les afficher d'une manière ou d'une autre 
// Tableau, card, vignette, etc 

// Ici dans des div carré façon petite card 
?>

<div style="display:flex; flex-wrap: wrap; justify-content: space-between">

    <?php while ($ligne = $stmt->fetch(PDO::FETCH_ASSOC)) : ?>

        <div style="margin-top: 20px; padding: 5px; width: 20%; background-color: steelblue; color:white">
            ID : <?= $ligne["id_employes"] ?><br>
            Prénom : <?= $ligne["prenom"] ?><br>
            Nom : <?= $ligne["nom"] ?><br>
            Service : <?= $ligne["service"] ?><br>
            Salaire : <?= $ligne["salaire"] ?><br>
            Sexe : <?= $ligne["sexe"] ?><br>
            Date embauche : <?= $ligne["date_embauche"] ?><br>
        </div>

    <?php endwhile;
    echo "</div>";


    // Ici affichage en tableau html à structure fixe - façon backoffice - interface gestion admin
    $stmt = $pdo->query("SELECT * FROM employes");

    ?>
    <br>
    <hr></br>
    <style>
        th,
        td {
            padding: 10px;
        }
    </style>
    <table border="1" style="border-collapse : collapse; width:100%">

        <!-- Ici la structure fixe du tableau -->
        <tr>
            <th>ID employés</th>
            <th>Prénom</th>
            <th>Nom</th>
            <th>Sexe</th>
            <th>Service</th>
            <th>Date d'embauche</th>
            <th>Salaire</th>
            <th>Actions</th>
        </tr>
        <?php
        // Ici la boucle while qui execute un fetch pour chaque ligne de resultat 
        // Chaque tour va créer une ligne de tableau 
        while ($ligne = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            foreach ($ligne as $valeur) {
                echo "<td>$valeur</td>";
            }
            echo "<td>Supprimer - Modifier </td>";
            echo "</tr>";
        }
        echo "</table>";

        // Ici on va faire un tableau qui s'adapte sur la structure par rapport au nombre de colonnes dans la requête 

        $stmt = $pdo->query("SELECT salaire, service FROM employes");
        // Il existe une méthode dans PDOStatement columnCount()
        // Elle me permet de comprendre le nombre de colonnes dans la réponse 
        // Il existe aussi une méthode getColumnMeta() qui va me retourner des informations sur une colonne demandée (par exemple la colonne numéro 0, puis 1, puis 2 etc )

        // echo "Nombre de colonnes dans le résultat : " . $stmt->columnCount();
        // var_dump($stmt->getColumnMeta(0));


        echo '<table border="1" style="border-collapse : collapse; width:100%">';
        echo "<tr>";
        for ($i = 0; $i < $stmt->columnCount(); $i++) { // Ici je combine une boucle for à compteur numérique avec columncount et getColumMeta pour générer les colonnes du tableau dynamiquement
            $infoColonne = $stmt->getColumnMeta($i);
            echo "<th>" . $infoColonne["name"] . "</th>";
        }
        echo "</tr>";
        while ($ligne = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            foreach ($ligne as $valeur) {
                echo "<td>$valeur</td>";
            }
            echo "</tr>";
        }
        echo "</table>";

        echo "<h2>05 - Requêtes de séelection pour plusieurs lignes de résultat avec fetchAll()</h2>";

        // fetch() permet de traiter une seule ligne à la fois ! 
        // fetchAll() traite toutes les lignes en une seule fois sauf que on reçoit un array multidimensionnel (array à deux niveaux)

        $stmt = $pdo->query("SELECT * FROM employes");
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo "<pre>";
        print_r($data);
        echo "</pre>";


        //     array (size=25)
        //   0 => 
        //     array (size=7)
        //       'id_employes' => string '350' (length=3)
        //       'prenom' => string 'Jean-pierre' (length=11)
        //       'nom' => string 'Laborde' (length=7)
        //       'sexe' => string 'm' (length=1)
        //       'service' => string 'direction' (length=9)
        //       'date_embauche' => string '2010-12-09' (length=10)
        //       'salaire' => string '5000' (length=4)

        // Je veux afficher Jean-Pierre, comment est ce que j'écris ça ? 

        echo "Premier employé de la requête : " . $data[0]["prenom"]  .  "<hr>";

        // EXERCICE : Affichez les noms et prénoms des employés dans une liste ul li 
        // Le faire avec fetch 
        $stmt = $pdo->query("SELECT nom, prenom FROM employes");
        echo "<ul>";
        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<li>" . $data["nom"] . " " . $data["prenom"] . "</li>";
        }
        echo "</ul>";

        // Le faire avec fetchAll 
        $stmt = $pdo->query("SELECT nom, prenom FROM employes");
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo "<ul>";
        foreach ($data as $employe) {
            echo "<li>" . $employe["nom"] . " " . $employe["prenom"] . "</li>";
        }
        echo "</ul>";

        echo "<h2>06 - Requêtes préparées pour se protéger des injections SQL ! </h2>";

        // prepare() permet de sécuriser les requêtes pour éviter les injections SQL 
        // Si dans la requête on attend une information de l'utilisateur (via un clic ou une saisie) alors OBLIGATION de faire prepare (et non pas query), dans le doute, faisons toujours prepare() pour lancer nos requêtes 

        // On suppose un champ de recherche sur le nom d'un employé et une saisie récupérée ci dessous
        $nom = "laborde"; // Je suppose ça, récupéré d'un formulaire 

        // Première étape : Préparation de la requête 

        // Plusieurs syntaxes possibles 

        // Première syntaxe avec des "?" pour symboliser les trous dans la requête 
        $stmt = $pdo->prepare("SELECT * FROM employes WHERE nom = ?");
        $stmt->execute([$nom]); // On fourni dans les params du execute un array qui contient les valeurs à coller à la place de nos ? (DANS L'ORDRE)

        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        var_dump($data);

        // Cette syntaxe avec les ?, bien que rapide, manque de lisibilité...

        // Par exemple sur des requêtes à nombreux param, par exemple une inscription 
        // $stmt = $pdo->prepare("INSERT INTO employes (prenom, nom, sexe, service, salaire, date_embauche) VALUES (?, ?, ?, ?, ?, ?)");
        // $stmt->execute([$prenom, $nom, $sexe, $service, $salaire, $date_embauche]);


        // On préfèrera la façon utilisant des "tokens"  -- "marqueurs nominatif"
        $stmt = $pdo->prepare("SELECT * FROM employes WHERE nom = :nom"); // On nomme les valeurs attendues par un mot précédé de ":"
        $stmt->bindParam(":nom", $nom, PDO::PARAM_STR); // Pour chaque token, on fera une ligne de bindParam, pour lier la variable au token vide
        $stmt->execute();

        // Après, rien ne change, on fetch, on interprête et voila ! 
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        var_dump($data);


