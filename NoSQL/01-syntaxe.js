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

// Ci dessous insertion d'un employé dans la collection employes
db.employes.insertOne(
    {
        id_employes: 991,
        nom: "Lacaze",
        prenom: "Pierral",
        age: 35,
        service: "Web",
        salaire: 12000
    }
);

// On remarque que l'id de mongoDB s'est auto généré 
// Le système d'id de mongoDB utilise un encodage hexadécimal contenant plusieurs informations notamment date/heure, ce qui empêche toute possibilité de doublon d'id
// Il appelle ça un type objectId 


// On peut insérer aussi plusieurs employés dans la table en fournissant un array entre [] à la fonction insertMany 

db.employes.insertMany(
    [
        {
            nom: "Legris",
            prenom: "Gandalf",
            age: 2100,
            service: "Magie",
            salaire: 20000
        },

        {
            nom: "Sacquet",
            prenom: "Frodon",
            age: 45,
            service: "Aventure",
            salaire: 20
        }
    ]
);


// ---------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------
// ------ REQUETES DE SELECTION (On recherche dans la BDD) -------------------------
// ---------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------

// Affichage de tous les éléments de ma table employes en MySQL : 
// SELECT * FROM employes;

// Ici affichage complet de toutes les données de la collection en MongoDB
db.employes.find();

// Affichage d'un seul élément de notre collection en MongoDB
// Me sort le premier élément trouvé dans la collection 
db.employes.findOne();


// CONDITIONS / CRITERES : Selection avec une condition, équivalent au WHERE en MySQL 
// On fournit entre des {} les conditions que l'on souhaite appliquer 

// Affichage des employés du service informatique 
// en MySQL : 
// SELECT * FROM employes WHERE service = "informatique";
// en MongoDB : 
db.employes.find({ service: "informatique" });
db.employes.find({ service: 'informatique' });

// PROJECTION : la projection des données, c'est la selection de champs spécifiques à afficher
// Affichage des prénoms uniquement, sur la sélection du service informatique 

db.employes.find({ service: "informatique" }, { prenom: 1 });
db.employes.find({ service: "informatique" }, { prenom: 1, nom: 1, _id: 0 });

// EXERCICE : Tentez d'afficher la totalité des employés en affichant uniquement leur prénom et leur service 
db.employes.find({}, { prenom: 1, service: 1, _id: 0 });
// Si je souhaite faire une selection de champs à afficher/récupérer par ma projection, sans forcément appliquer des critères de recherche, je dois malgré tout fournir le premier argument attendu à la fonction find, à savoir les accolades de selection mais sans y insérer de conditions
// D'où la première paire d'accolades vides find({}, {........}) 

// EXERCICE : Même chose mais en affichant LA LISTE des services 
// Ici, si j'écris db.employes.find({}, {service:1, _id:0}); alors j'affiche simplement le service de chacun de mes documents
// On aimerait plutôt LA LISTE des services différents

// Pour ça, je peux utiliser l'instruction distinct qui va me sortir chaque service de façon unique, et éliminer tous les doublons

db.employes.distinct("service");


// EXERCICE : Affichage du NOMBRE de service distinct 
db.employes.distinct("service").length; // Je me sers de length ici et non pas count() car je manipule un array (c'est le return de l'instruction distinct)

// Affichage du nombre de personnes dans le service informatique : 
db.employes.find({ service: "informatique" }).count(); // Ici je me sers de count() et non pas length car je manipule un "result set" un "jeu de résultats" et pas un array (c'est le return d'une instruction find  tout comme un SELECT en MySQL)


// Je ne peux pas lancer les instructions ci dessous, erreur ou aucun résultat
db.employes.find({ service: "informatique" }).length; // un length sur un result set = ne fonctionne pas 
db.employes.distinct("service").count(); // un count() sur un array = ne fonctionne pas !  

// En MongoDB les instructions telles que count() s'appellent des "cursor modifier", ce sont des fonctions qui nous permettent d'intéragir directement sur le résultat, c'est comme les fonctions d'agrégation de MySQL


// OPERATEURS DE COMPARAISON 
// MongoDB possède tout un tas d'opérateur de comparaison qui nous permettent de manipuler nos requêtes en y appliquant des critères complexes 

// -- $eq       est égal 
// -- $ne       est différent d'une valeur (not equal)
// -- $gt       est strictement supérieur à (greater than)
// -- $gte      est supérieur ou égal à (greater than/equal)
// -- $lt       est strictement inférieur à  (lesser than)
// -- $lte      est strictement inférieur ou égal à (lesser than / equal)
// -- $in       est égale à une des valeurs parmis une liste (comme le IN en MySQL)  
// -- $nin      est différent des valeurs parmis une liste (not in)

// EXCLUSION 
// Tous les employés d'un service sauf un, par exemple sauf le service commercial 
db.employes.find({ service: { $ne: "commercial" } });

// Les employés ayant un salaire strictement supérieur à 3000 
db.employes.find({ salaire: { $gt: 3000 } }, { prenom: 1, nom: 1, service: 1, salaire: 1 });
db.employes.find({ salaire: { $gt: "3000" } });
// Attention... En fonction des types des champs de notre BDD ces manipulations de chiffres peuvent poser soucis !
// L'import de la bdd en MySQL nous a tout ajouté sous forme de string, le système ne comprends pas que ce sont malgré tout des valeurs numériques 
// Il ne sait pas faire le tri, contrairement à MySQL 

// Affichage des employés ayant été embauchés entre 2015 et aujourd'hui 
db.employes.find({
    date_embauche: {
        $gte: "2015-01-01",
        $lte: "2026-02-25"
    }
});

// Ici aussi problèmes de type, nos dates sont stockées en "string", normalement il faudrait qu'elles soient stockées en objet date 
// Ici objet Date, c'est la seule façon de manipuler une information équivalente au CURDATE() de MySQL, en tout cas de catégoriser un élément comme étant d'un type date

db.employes.find({
    date_embauche: {
        $gte: new Date("2015-01-01"),
        $lte: new Date()
    }
});


// Insertion avec un type Date 
db.employes.insertOne(
    {
        id_employes: 991,
        nom: "Lolo",
        prenom: "Pierro",
        age: 35,
        service: "Web",
        salaire: 120,
        date_embauche: new Date()
    }
);
// Ci dessus le new Date() nous permet vraiment de symboliser un type date


// ATTENTION si on ne mets pas new Date(), on va encore récupérer un string
//         db.employes.insertOne(
//     {
//         id_employes : 991,
//         nom : "Lola",
//         prenom : "Pierra",
//         age : 35,
//         service : "Web",
//         salaire : 130,
//         date_embauche : Date()
//     }
// );

// IN & NOT IN pour tester plusieurs valeurs 
// Affichage des employes des services commercial et comptabilite 
db.employes.find(
    {
        service: { $in: ["commercial", "comptabilite"] }
    }
)


// Affichage des employes ne faisant pas parti des services commercial et comptabilite 
db.employes.find(
    {
        service: { $nin: ["commercial", "comptabilite"] }
    }
)

// Plusieurs conditions : AND  
// Il suffit de spécifier les critères de selection les uns après les autres 
// On veut les employés du service commercial ayant un salaire inférieur ou égal à 2000 
db.employes.find({
    service: "commercial",
    salaire: { $lte: "2000" }
});

// L'une ou l'autre d'un ensemble de conditions : OR 
// Affichage des employes des services commercial ou comptabilite à nouveau 
db.employes.find({
    $or: [
        { service: "commercial" },
        { service: "comptabilite" }
    ]
});


// LES TYPES EN PROGRAMMATION : 
//  ----------------------------------------------------------
//    123 = integer = nombre entier 
//    12.50 = float/double = nombre decimal 
//    "coucou" = string = chaine de caractères 
//    true / false = boolean = vrai ou faux, valeur booléene 
//    ["lundi","mardi", "mercredi"] = array = tableau de données peut contenir plusieurs valeurs 
//    {
//     nom : "lacaze",
//     prenom : "pierra"
//    }                        = object = objet javascript, on peut nommer les propriétés et leur donner des valeurs 


// Ci dessous la doc 
// db.inventory.find( { $or: [ { quantity: { $lt: 20 } }, { price: 10 } ] } )

// EXERCICE : employes du service production ayant un salaire égal à 1900 ou 2300, VERIFIER BIEN LES RESULTATS

db.employes.find({
    service: "production",
    $or: [
        { salaire: "1900" },
        { salaire: "2300" }
    ]
});

db.employes.find({
    service: "production",
    salaire: { $in: ["1900", "2300"] }
})

// Recherche de la valeur approchante 
// Equivalent à LIKE en MySQL "on peut lancer une condition sans que la valeur soit saisie entièrement"
// En MongoDB on gère ça avec une regex (expression régulière)

// Affichage des prénoms commençant par la lettre "s"
db.employes.find({
    prenom: {
        $regex: "^s",
        $options: "i" // Option "i" pour une recherche insensible à la casse
    }
});

// Affichage des prénoms finissant par les lettre "ie"
db.employes.find({
    prenom: {
        $regex: "ie$",
        $options: "i" // Option "i" pour une recherche insensible à la casse
    }
});

// Affichage des prénoms contenant les lettres "ie" (début, fin, milieu)
db.employes.find({
    prenom: {
        $regex: "ie",
        $options: "i" // Option "i" pour une recherche insensible à la casse
    }
});

// On a toujours besoin d'utiliser des recherches à valeur approchante, pour des champs de recherche notamment
// Champ de recherche produit ou filtre par exemple 

// CLASSEMENT DES RESULTATS avec sort()   --- équivalent à ORDER BY en MySQL 

// Affichage des employes dans l'ordre alphabétique 
db.employes.find().sort({nom : 1});
// Affichage des employes dans l'ordre alphabétique inversé
db.employes.find().sort({nom : -1});

// Il est possible d'ordonner par plusieurs champs 
db.employes.find({}, {prenom : 1, nom : 1, service : 1}).sort({service : 1});

db.employes.find({}, {prenom : 1, nom : 1, service : 1}).sort({service : 1, nom : 1});
// On remarque que si nous avons des services avec des majuscules, ils apparaissent en premier !
// En informatique on commence d'abord par trier toutes les majuscules avant de passer aux minuscules

// Si jamais je veux rendre mon classement insensible à la casse, on peut appliquer l'instruction collation
// Elle va intégrer des règles de classement alphabétique spécifique en rapport à une langue, ici en fr
// Ou on va bien être capable de comparer les majuscules en meme temps que les minuscules 
db.employes.find({}, {prenom : 1, nom : 1, service : 1}).collation({locale: "fr" }).sort({service : 1, nom : 1});

// On peut faire en sorte de renommer nos champs en manipulant la projection
db.employes.find({}, {nomComplet : {$concat: ["$nom", " ", "$prenom"]}});


// LIMITER UN NOMBRE DE RESULTAT avec limit() puis skip()

// Affichage des employés 3 par 3 
db.employes.find().limit(3);

// skip() nous permet de sauter un certains nombre de résultat 
db.employes.find().skip(3).limit(3);
db.employes.find()
            .skip(6)
            .limit(3);


// ---------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------
// ------ REQUETES DE MODIFICATION -------------------------------------------------
// ---------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------

// Plusieurs fonctions sont disponibles 
// updateOne(), updateMany(), replaceOne() 

// updateOne pour modifier un seul document 
    // On modifie le salaire d'un employé 

// L'opérateur $set nous permet de modifier la valeur d'un champ 

// En MySQL :  UPDATE employes SET salaire = 1500 WHERE id_employes = 991 

// En MongoDB : 
db.employes.updateOne(
    {id_employes : "990"}, 
    {$set : {salaire : 1900}}
);

// ATTENTION AUX IDs en string ou int... :) 

// Plusieurs modifications : 
db.employes.updateOne(
    {id_employes : 991},
    {
        $set : {
            salaire : 1200,
            service : "informatique"
        }
    }
)

// updateMany() pour modifier plusieurs documents en une seule opération 
// On va changer le service informatique en web 
db.employes.updateMany(
    {service : "informatique"},
    {
        $set : {service : "web"}
    }
);

// replaceOne pour remplacer un document existant par un autre 
// Cela efface entièrement le document d'originez pour le remplacer par le document fourni

// db.employes.insertOne(
//     {
//         id_employes: 991,
//         nom: "Lacaze",
//         prenom: "Pierral",
//         age: 35,
//         service: "Web",
//         salaire: 12000,
//         date_modification : new Date()
//     }
// );

db.employes.replaceOne(
    {id_employes : 991},
    {
        id_employes: 991,
        prenom: "Polo",
        nom: "Lolo",
        service: "vente",
        salaire: 2000
    }
)

// On peut supprimer totalement un champ d'un document avec $unset 
// Avec unset le champ disparait totalement
db.employes.updateOne(
    {id_employes: 991},
    {$unset : {salaire : ""}}
);

// C'est différent que de mettre le champ sur null ou string vide
// db.employes.updateOne(
//     {id_employes : 991}, 
//     {$set : {salaire : ""}}
// );
// db.employes.updateOne(
//     {id_employes : 991}, 
//     {$set : {salaire : null}}
// );

// Si je set à nouveau le champ, il est rajouté au document 
db.employes.updateOne(
    {id_employes: 991},
    {$set : {salaire : 1800}}
);

// Il existe aussi un opérateur $currentDate pour mettre un champ sur la valeur de l'instant T
// Pas toujours utilisable sur les insertion donc approprié aux updates
db.employes.updateOne(
    {id_employes: 991},
    {$currentDate: {date_modification: true}}
);

// ---------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------
// --  REQUETES DE SUPPRESSION (On supprime un ou plusieurs documents) -------------------------
// ---------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------

// Deux fonctions concernent les suppressions : deleteOne() et deleteMany()
// Suppression de l'employé 991
db.employes.deleteOne({id_employes: 991});

// Suppression de tous les employés ayant un id supérieur à 990
db.employes.deleteMany({id_employes: { $gt: 990}});

// Le système de selection est exactement le même que pour les requêtes update et select, avec tous les opérateurs de comparaison


// --------------------------------------------------------------------------
// --------------------------------------------------------------------------
// -- EXERCICES :
// --------------------------------------------------------------------------
// --------------------------------------------------------------------------
// -- 1 -- Afficher la profession de l'employé 547.
// -- 2 -- Afficher la date d'embauche d'Amandine.	
// -- 3 -- Afficher le nom de famille de Guillaume	
// -- 4 -- Afficher le nombre de personne ayant un n° id_employes commençant par le chiffre 5.	
// -- 5 -- Afficher tous les employés du service commercial.
// -- 6 -- Afficher le nombre de commerciaux.
// -- 7 -- Afficher les 5 premiers employés après avoir classé leur nom de famille par ordre alphabétique. 
// -- 8 -- Afficher le nombre de recrutement sur l'année 2010.	
// -- 9 -- Afficher tous les employés sauf ceux du service production et secrétariat.
// -- 10 -- Afficher les commerciaux ayant été recrutés avant 2012 de sexe masculin et gagnant un salaire supérieur a 2500 €
// -- 11 -- Qui a été embauché en dernier
// -- 12 -- Afficher les informations sur l'employé du service commercial gagnant le salaire le plus élevé
// -- 13 -- Afficher le prénom du comptable gagnant le meilleur salaire
// -- 14 -- Afficher le prénom de l'informaticien ayant été recruté en premier
// -- 15 -- Modifier à 2800 le salaire de l'employé 990
// -- 16 -- Modifier le service de tous les employés masculins du service "secretariat" pour le mettre à "administration".
// -- 17 -- Modifier le service de l'employé avec l'ID 876 pour le mettre à "communication" et son salaire à 2800.
// -- 18 -- Supprimer les employés du service administration
// -- 19 -- Supprimer tous les employés dont le nom commence par "D"
// -- 20 -- Supprimer tous les employés féminins du service "secretariat" avec un salaire inférieur à 1600.








