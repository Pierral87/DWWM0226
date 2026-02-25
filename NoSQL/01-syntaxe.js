// Documentation MongoDB : https://www.mongodb.com/docs/

// Le langage de requête de MongoDB est basé sur JS et sa manipulation de fichiers JSON, donc nous écrirons ce support sur un fichier .js pour profiter du code couleur de l'éditeur 

// Concept d'organisation des éléments dans MongoDB : 
// Base -> Collection -> Document

// C'est très similaire à MySQL et tout autre SGBDR ! : Base -> Tables -> Enregistrements(lignes)

// Pour installer MongoDB : Site officiel > Products > Community > Download 
    // Attention : bien installer MongoDB Compass pour pouvoir manipuler les créations de BDD, les requêtes etc 

    // Installation Complete -> Accepter tout 

// MongoDB Compass est l'interface graphique de manipulation de MongoDB 

// On pourra créer la base directement dans Compass puis ensuite les collections et insérer des documents 

// On remarque que l'on peut insérer dans une collection, n'importe quel type de données 
// Contrairement à MySQL, lorsque l'on travaille en MongoDB nous n'avons pas de schéma fixe ! C'est à dire nous sommes libre d'insérer dans une même collection des documents qui n'ont peut être pas de rapport entre eux...

// ATTENTION ! C'est évidemment totalement illogique de procéder de la sorte ! Il faudra donc redoubler de vigilance pour être sûr de rester cohérent dans nos insertions 

// C'est à dire faire attention à nommer nos éléments (les équivalents des colonnes mysql) de la même manière d'un document à l'autre 

// Il sera possible de mettre en place plus tard des "Validations" pour refuser ou accepter une insertion d'un document, c'est ce qui ressemblera le plus à la structure d'une table MySQL 

// On va récupérer la base entreprise et la table employes de notre cours MySQL classique pour l'importer dans MongoDB 

// On va dans PHPMyAdmin, on selectionne entreprise puis employes puis Export en format JSON ! (voir le doc)
// C'est super, MongoDB manipule des JSON, je suis donc capable d'importer ce JSON dans ma base MongoDB 

// ---------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------
// ------ REQUETES D'INSERTION (On va rajouter des éléments dans notre collection )-
// ---------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------

// On dispose de deux fonctions : 
    // insertOne() : Nous permet d'ajouter un document 
    // insertMany() : Nous permet d'ajouter plusieurs documents d'un coup (mais dans une seule et même collection)

// ATTENTION MongoDB est sensible à la casse ! Une majuscule est un caractère différent de la même lettre minuscule
// MongoDB est aussi sensible aux types des éléments qu'on lui fournit, ce qui impacte ensuite les opérations possibles (pas d'opération mathématique sur des strings numériques, pas de comparaison de date sur des dates en string)

// Pour sélectionner une base dans la console, tout comme dans MySQL on utilise l'instruction use 

// On va lancer l'instruction suivante dans la console de MongoDB (à côté de la connexion, petite icone ">_"  MondoDB Shell)
// use entreprise;

// A partir de là, je peux insérer un nouvel employé dans la COLLECTION

// En commande MySQL : 
// INSERT INTO employes (nom, prenom, service, salaire, date_embauche, sexe) VALUES ("Lacaze", "Pierre-Alexadre", "Formation", 12000, CURDATE(), "m");
db.employes.insertOne(
    {
        id_employes : 991,
        nom : "Lacaze",
        prenom : "Pierral",
        age : 35,
        service : "Web",
        salaire : 12000
    }
);




