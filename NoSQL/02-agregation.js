// -----------------------------------------------------------------------------------------------------------------------------
// -----------------------------------------------------------------------------------------------------------------------------
// ---------------------------- CHAPITRE 2: Agrégation de données  -------------------------------------------------------------
// -----------------------------------------------------------------------------------------------------------------------------
// -----------------------------------------------------------------------------------------------------------------------------


// Les fonctions d'agrégation dans MongoDB sont des outils spéciaux pour trier, calculer des données à partir de plusieurs éléments

// C'est assez similaire à MySQL SAUF que l'on utilise ça sous forme de "pipeline"

// Le pipeline c'est quoi ? C'est une séquence d'opération en plusieurs étapes de traitement

// On va manipuler non plus find() mais agregate(), le but étant d'appliquer des traiements sur un ensemble d'element


// Affichage des employés et de leur salaire annuel 
db.employes.aggregate([
    {
        $project: {
            _id : 0,
            prenom : 1,
            nom : 1,
            service : 1,
            salaire_annuel : { $multiply: ["$salaire", 12]}
        }
    }
]);

// Zut, mes salaires sont en string, on va utiliser un autre opérateur pour les convertir avant l'opération 

db.employes.aggregate([
    {
        $project: {
            _id : 0,
            prenom : 1,
            nom : 1,
            service : 1,
            salaire_annuel : { $multiply: [{ $toDouble : "$salaire"}, 12]}
        }
    }
]);

// Ici l'opérateur $project permet de définir la projection de mes champs 
// On utilise ensuite l'opérateur $multiply pour appliquer une multiplication à un champ spécifique (ici notre salaire_annuel)

// Si je veux la masse salariale annuelle de l'entreprise : 

db.employes.aggregate([
    {
        $project: {
            _id: 0,
            salaire_annuel: { $multiply: [{ $toDouble : "$salaire"}, 12]}
        }
    },
    // Groupement pour calculer la somme des salaires annuels
    {
        $group: {
            _id: null,  // Ici c'est le regroupement des documents par _id, donc simplement la requête concerne tous les documents
            masse_salariale: { $sum: "$salaire_annuel"} // ici l'opérateur $sum fait la somme de tous les salaire_annuels 
        }
    }
]);


db.employes.aggregate([
    {
        $project: {
            _id: 0,
            salaire: { $toDouble : "$salaire"}
        }
    },
    // Groupement pour calculer 
    {
        $group: {
            _id: null,  // Ici c'est le regroupement des documents par _id, donc simplement la requête concerne tous les documents
            salaireMoyen: { $avg: "$salaire"} // ici l'opérateur $avg fait la moyenne de tous les salaire
        }
    }
]);

// Le pipeline n'a pas de sens prédéfini, on peut appliquer les opérations dans l'ordre que l'on souhaite, elles vont s'exécuter de la première à la dernière
// Si je veux faire l'arrondi d'un calcul, evidemment, l'arrondi doit intervenir APRES le calcul
// Donc je vais faire ici un group avec le avg suivi du project avec l'arrondi 

db.employes.aggregate([
    {
        $group: {
            _id : null, 
            salaireMoyen: {$avg: {$toDouble: "$salaire"}}
        }
    },
    {
        $project: {
            _id : 0,
            salaireMoyenArrondi: { $round: ["$salaireMoyen"]} // arrondi à l'entier
            // salaireMoyenArrondi: { $round: ["$salaireMoyen", 2]} // arrondi à deux chiffres après la virgule
        }
    }
]);

// Affichage du salaire minimum de l'entreprise grâce à $min 
db.employes.aggregate([
    {
        $group: {
            _id : null,
            salaireMin: { $min: {$toDouble : "$salaire"}}
        }
    }
]);

// Affichage du salaire max de l'entreprise grâce à $max 
db.employes.aggregate([
    {
        $group: {
            _id : null,
            salaireMax: { $max: {$toDouble : "$salaire"}}
        }
    }
]);

db.employes.aggregate([
    {
        $group: {
            _id : null,
            salaireMax: { $max: {$toDouble : "$salaire"}}
        }
    }
]);

// Rappel GROUP BY MySQL 
// Le nombre d'employés par service en MySQL : 
// COUNT(*) : fonction d'agrégation MySQL me permet de compter le nombre de résultat dans un jeu de résultats 
// SELECT service, COUNT(*) AS nbr_employes FROM employes;
// SELECT service, COUNT(*) AS nbr_employes FROM employes GROUP BY service;

// SELECT * FROM employes ORDER BY service;

// +-------------+-------------+----------+------+---------------+---------------+---------+
// | id_employes | prenom      | nom      | sexe | service       | date_embauche | salaire |
// +-------------+-------------+----------+------+---------------+---------------+---------+
// |         990 | Stephanie   | Lafaye   | f    | assistant     | 2017-03-01    |    1775 |

// |         388 | Clement     | Gallet   | m    | commercial    | 2010-12-15    |    2300 |
// |         415 | Thomas      | Winter   | m    | commercial    | 2011-05-03    |    3550 |
// |         547 | Melanie     | Collier  | f    | commercial    | 2012-01-08    |    3100 |
// |         627 | Guillaume   | Miller   | m    | commercial    | 2012-07-02    |    1900 |
// |         655 | Celine      | Perrin   | f    | commercial    | 2012-09-10    |    2700 |
// |         933 | Emilie      | Sennard  | f    | commercial    | 2017-01-11    |    1800 |

// |         780 | Amandine    | Thoyer   | f    | communication | 2014-01-23    |    2100 |

// |         509 | Fabrice     | Grand    | m    | comptabilite  | 2011-12-30    |    2900 |

// |         350 | Jean-pierre | Laborde  | m    | direction     | 2010-12-09    |    5000 |
// |         592 | Laura       | Blanchet | f    | direction     | 2012-05-09    |    4500 |

// |         701 | Mathieu     | Vignal   | m    | informatique  | 2013-04-03    |    2500 |
// |         802 | Damien      | Durand   | m    | informatique  | 2014-07-05    |    2250 |
// |         854 | Daniel      | Chevel   | m    | informatique  | 2015-09-28    |    3100 |

// |         876 | Nathalie    | Martin   | f    | juridique     | 2016-01-12    |    3550 |

// |         417 | Chloe       | Dubar    | f    | production    | 2011-09-05    |    1900 |
// |         900 | Benoit      | Lagarde  | m    | production    | 2016-06-03    |    2550 |

// |         491 | Elodie      | Fellier  | f    | secretariat   | 2011-11-22    |    1600 |
// |         699 | Julien      | Cottet   | m    | secretariat   | 2013-01-05    |    1390 |
// |         739 | Thierry     | Desprez  | m    | secretariat   | 2013-07-17    |    1500 |
// +-------------+-------------+----------+------+---------------+---------------+---------+

// En MongoDB pour regrouper par un champ spécifique plutôt que null, c'est _id qui prends la valeur du champ de regroupement 
// Nombre d'employés par service : 
db.employes.aggregate([
    {
        $group: {
            _id: "$service",
            nombreEmployes: { $count: {}} // Compte le nombre total de document dans chaque groupe
        }
    }
]);


// Je peux trier les résultats dans le aggregate tout comme je peux faire .sort() dans mes requêtes find 


db.employes.aggregate([
    {
        $group: {
            _id: "$service",
            nombreEmployes: { $count: {}} // Compte le nombre total de document dans chaque groupe
        }
    }, 
    {
        $sort: { _id: 1} // Trie les résultats par l'_id (ici, c'est service) en ordre alphabétique
    }
]);

// Si je souhaite mettre une condition sur l'affichage des services ayant plus de 2 employés 


// Ci dessous un bon pipeline d'aggregate avec 5 instructions à la suite
// On a besoin des premières pour mener à bien les suivantes 
db.employes.aggregate([
    {
        $group: {
            _id : "$service",
            nombreEmployes: {$count: {}}
        }
    },
    {
        $match: {
            nombreEmployes: { $gt: 2}
        }
    }, 
    {
        $project: {
            service: "$_id",
            nombreEmployes: 1,
            _id: 0
        }
    },
    {
        $sort: {service : 1}
    }, 
    {
        $limit: 2
    }
]);

// Il existe des opérateurs de manipulation de date (objetDate) avec $year, $month, $dayOfMonth 

// $project: {
//     prenom : 1,
//     nom : 1 
//     anneeEmbauche: {$year: "$date_embauche"}
// }

// Recherche des éléments en fonction de si un certains champ est bien présent grâce à $exists 

db.employes.aggregate([
    {
        $match: {
            date_modification: {$exists: true} // On selectionne uniquement les documents qui possèdent ce champs là
        }
    }
]);

// --------------------------------------------------------------------------
// --------------------------------------------------------------------------
// -- EXERCICES :
// --------------------------------------------------------------------------
// --------------------------------------------------------------------------
// -- 1 -- Afficher le salaire moyen des informaticiens (+arrondi).
// -- 2 -- Afficher le coût des commerciaux sur une année.	
// -- 3 -- Afficher le salaire moyen par service. (nom du service + salaire moyen arrondi)
// -- 4 -- Afficher le salaire moyen appliqué lors des recrutements sur la période allant de 2015 à 2017
// -- 5 -- Afficher conjointement le nombre d'homme et de femme dans l'entreprise
// -- 6 -- Afficher le salaire maximum pour chaque sexe.
// -- 7 -- Affichez le nombre d'employés embauchés chaque année.
// -- 8 -- Affichez le total des salaires de tous les employés embauchés chaque année.
// -- 9 -- Affichez le nombre d'employés par sexe et par service.
// -- 10 -- Affichez le nombre d'employés ayant un salaire supérieur à 3000 pour chaque service.
