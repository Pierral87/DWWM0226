<?php

/*

// Pour éviter les injections XSS (du code css et/ou js mis dans les commentaires)
// il est possible de modifier les carac notamment les < > qui représentent des balises.
// à l'affichage (voir en bas de page) on appelle htmlspecialchars() qui permet de transformer ces caractères problématiques en entités html
// exemple :
// Là une boucle infinie qui lance un alert 
// <script>while(true){alert('truc');}</script>
// sera écrit dans le code source sous cette forme :
// &lt;script&gt;while(true){alert('truc');}&lt;/script&gt;

// On pourrait aussi injecter du code css, là le body n'apparait plus
// <style>body{display:none;}</style>

// Outils proche de htmlspecialchars() : htmlentities() / strip_tags()


// Pour tester les injections SQL, depuis le champ message 
// pour injection SQL ', ''); DROP DATABASE dialogue;
// ou 
// pour injection SQL ', NOW()); DROP DATABASE dialogue;

// Depuis le champ pseudo 
// pour injection SQL ', '', NOW()); DELETE FROM commentaire;

// ', '', NOW()); DO SLEEP(10);  injection en aveugle, permet de voir si l'injection est possible en mettant un temps de délais à la requete (on remarque le chargement, comme ça, même sans message d'erreur on peut comprendre que le système est sensible aux injections)


// Là avec wamp, on peut généralement accéder au dossier tmp/temp d'un serveur, on en profite pour utiliser l'instruction SELECT INTO OUTFILE MySQL pour enregistrer dans un fichier txt une selection (par exemple le contenu d'une table user)
// Pour insérer dans un fichier.txt   la selection d'une table via injection 
// ', NOW()); SELECT * INTO OUTFILE 'c:/wamp64/tmp/fichier2.txt' FROM commentaire; #

// Ensuite on réinsère dans la table visible pour nous (ici commentaire), pour voir le détails de tous les users ( et peut être les password s'ils ne sont pas hashé en bdd aie aie aie)
// ', NOW()); INSERT INTO commentaire (pseudo, message, date_enregistrement) VALUES ('1', LOAD_FILE('c:/wamp64/tmp/fichier2.txt'), NOW());

// On gardera donc en tête de TOUJOURS envoyer nos requêtes avec prepare() pour nous protéger des injections, SINON, l'entièreté de notre base est compromise !

TP Espace de Tchat :
-----------
- Création d'un espace de dialogue / de tchat en ligne en PHP 

- 01 - Création de la BDD : dialogue  (via PhpMyAdmin)
     -  Table : commentaire
     - Champs de la table commentaire :
        - id_commentaire        INT PK AI
        - pseudo                VARCHAR 255
        - message               TEXT
        - date_enregistrement   DATETIME
        
- 02 - Créer une connexion à cette base avec PDO (instanciation de l'objet PDO, vérification avec var_dump)
- 03 - Création d'un formulaire html permettant de poster un message (html classique, pour un formuler géré avec POST)
     - Champs du formulaire : 
        - pseudo (input type="text")
        - message (textarea)
        - bouton de validation
- 04 - Récupération des saisies du form avec controle (Récupération au travers de la globale POST, contrôle des saisies, champs pas vide, champs d'une certaine longueur minimale)
- 05 - Déclenchement d'une requete d'enregistrement pour enregistrer les saisies dans la BDD (Si les contrôle sont bons, on lance une requête insert into vers notre table, pour sauvegarder ces saisies)
- 06 - Requete de récupération des messages afin de les afficher dans cette page (Requête de selection pour récupérer les messages enregistrés)
- 07 - Affichage des messages avec un peu mise en forme (on manipule pdo, pdostatement, fetch, pour gérer l'affichage comme on le souhaite)

--- Bonus ---
- 08 - Affichage en haut des messages du nombre de messages présents dans la bdd
- 09 - Affichage de la date en français
- 10 - Amélioration du css
*/




// Etape 02 : Créer une connexion à cette base avec PDO 
$host = "mysql:host=localhost;dbname=dialogue"; // Attention pour MAMP, il faut parfois spécifier le port de localhost donc localhost:8080 ou localhost:8888
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

// var_dump($pdo);

// Déclaration de nos variables à vide, toujours une bonne pratique ! Nous évite les erreurs undefined variable
$pseudo = "";
$message = "";
$req = "";
$msgError = "";

// - 04 - Récupération des saisies du form avec controle 
var_dump($_POST);

// Ici pour s'assurer que le form est bien saisie et non manipulé 
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["pseudo"], $_POST["message"])) {
        $pseudo = trim($_POST["pseudo"]);
        $message = trim($_POST["message"]);

        // Chaque cas d'erreur insère une valeur dans $msgError pour afficher les messages d'erreur
        if (empty($pseudo) || empty($message)) {
                $msgError .= '<div class="alert alert-danger" role="alert">Veuillez saisir tous les champs !</div>';
        }

        if (iconv_strlen($pseudo) < 4 || iconv_strlen($pseudo) > 15) {
                $msgError .= '<div class="alert alert-danger" role="alert">La taille du pseudo doit être entre 4 et 15 caractères</div>';
        }

        if (iconv_strlen($message) < 3) {
                $msgError .= '<div class="alert alert-danger" role="alert">Le message doit au moins faire 3 caractères</div>';
        }


        // - 05 - Déclenchement d'une requete d'enregistrement pour enregistrer les saisies dans la BDD 
        $req = "INSERT INTO commentaire (pseudo, message, date_enregistrement) VALUES ('$pseudo', '$message', NOW())";

        // On peut envoyer la requête avec query mais on aura des failles de sécurité face aux injections SQL
        
        // S'il n'y a pas de contenu dans $msgError alors tous mes contrôles sont OK et je peux insérer 
        if (empty($msgError)) {
                // $stmt = $pdo->query($req);
                // Toute opération vers une bdd se lance au travers d'un try catch et ici surtout avec un prepare() pour éviter les injections 
                try {
                        $stmt = $pdo->prepare("INSERT INTO commentaire (pseudo, message, date_enregistrement) VALUES (:pseudo, :message, NOW())");
                        $stmt->bindParam(':pseudo', $pseudo, PDO::PARAM_STR); // Ici on bind les :pseudo et :message avec les valeurs de $pseudo et $message
                        $stmt->bindParam(':message', $message, PDO::PARAM_STR);
                        $stmt->execute();
                } catch (PDOException $e) {
                        echo "Problème BDD ! ";
                        exit;
                }
        }
        // On préfère donc utiliser prepare() car on a ici avec $pseudo et $message des valeurs qui viennent d'une saisie utilisateur, donc potentiellement dangereuse
}


// - 06 - Requete de récupération des messages afin de les afficher dans cette page 
// Ici pas obligatoire de faire un prepare car pas d'information de l'utilisateur dans la requête (pas de saisies ou clic qui declenchent cette action)
$stmt = $pdo->query("SELECT pseudo, message, date_format(date_enregistrement, '%d/%m/%Y à %T') AS date_fr FROM commentaire ORDER BY date_enregistrement DESC");

// On fetchAll pour récupérer la totalité des messages dans une seule variable 
$commentaires = $stmt->fetchAll(PDO::FETCH_ASSOC); // Ici dans $commentaires grâce à fetchAll, j'ai tout mes messages, je vais aller les afficher plus bas 

// var_dump($commentaires);

?>
<!DOCTYPE html>
<html lang="en">
<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

<!-- Google font -->
<link rel="preconnect" href="https://fonts.gstatic.com">
<!-- Playfair display -->
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500&display=swap" rel="stylesheet">
<!-- Roboto -->
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">

<!-- FontAwesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<style>
        * {
                font-family: 'Roboto', sans-serif;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
                font-family: 'Playfair Display', serif;
        }
</style>

<title>Dialogue</title>
</head>

<body class="bg-secondary">
        <div class="container bg-light g-0">
                <div class='row '>
                        <div class="col-12">
                                <h2 class="text-center text-dark fs-1 bg-light p-5 border-bottom"><i class="far fa-comments"></i> Espace de dialogue <i class="far fa-comments"></i></h2>

                                <!-- - 03 - Création d'un formulaire html permettant de poster un message -->
                                <form method="POST" class="mt-5 mx-auto w-50 border p-3 bg-white">
                                        <!-- On affiche la requête SQL que l'on lance (pour les tests futurs) -->
                                        <?= $req; ?>
                                        <!-- On affiche ici les messages d'erreurs -->
                                        <?= $msgError; ?>
                                        <hr>
                                        <div class="mb-3">
                                                <label for="pseudo" class="form-label">Pseudo <i class="fas fa-user-alt"></i></label>
                                                <input type="text" class="form-control" id="pseudo" name="pseudo" value="<?= $pseudo ?>">
                                        </div>
                                        <div class="mb-3">
                                                <label for="message" class="form-label">Message <i class="fas fa-feather-alt"></i></label>
                                                <textarea class="form-control" id="message" name="message"><?= $message ?></textarea>
                                        </div>
                                        <div class="mb-3">
                                                <hr>
                                                <button type="submit" class="btn btn-secondary w-100" id="enregistrer" name="enregistrer"><i class="fas fa-keyboard"></i> Enregistrer <i class="fas fa-keyboard"></i></button>
                                        </div>
                                </form>

                        </div>
                </div>

                <!-- - 07 - Affichage des messages avec un peu mise en forme  -->
                <div class='row mt-5'>
                        <div class="col-12">
                                <p class="w-75 mx-auto mb-3">Il y a : <?= count($commentaires) ?> messages dans la bdd</p>
                                <?php
                                // On boucle sur notre array contenant tous les commentaires, chaque tout de boucle foreach représente la manipulation et l'affichage d'un seul commentaire 
                                foreach ($commentaires as $commentaire) : ?>

                                        <div class="card w-75 mx-auto mb-3">
                                                <div class="card-header bg-dark text-white">
                                                        <!-- htmlspecialchars pour ne pas interpréter le code html/css/js -->
                                                        Par : <?= htmlspecialchars($commentaire["pseudo"]) ?>, le : <?= htmlspecialchars($commentaire["date_fr"]) ?>
                                                </div>
                                                <div class="card-body">
                                                        <p class="card-text"><?= htmlspecialchars($commentaire["message"]) ?></p>
                                                </div>
                                        </div>

                                <?php endforeach; ?>
                        </div>
                </div>


        </div>

        <!-- Option 1: Bootstrap Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
</body>

</html>