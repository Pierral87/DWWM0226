<?php 

/*


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