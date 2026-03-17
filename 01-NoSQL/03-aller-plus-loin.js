// Pour aller plus loin en MongoDB

// Les index : 
    // Les index nous servent à optimiser les requêtes de lecture sur nos bases 
        // En fait en NoSQL on dissocie les serveurs d'écriture et de lecture, on facilite ainsi la tâche en lecture grâce aux index
            // Un index créer une sorte de "sous table" avec moins d'information pour optimiser les requêtes 

// Les tableaux : 
    // Les tableaux array, on peut les manipuler directement dans MongoDB car au travers des JSON nous avons régulièrement des informations sous forme de tableau array à taille variable ! 
        // Il existe des fonctions associées pour les manipuler (ressemblant à JS natif)

// Archi / Tolérance aux pannes : 
    // Les Replica Sets & le Sharding 
        // Le replica set c'est un ensemble de serveurs qui travaillent ensemble pour fournir de meilleures performances
    
        // Le sharding c'e'st un mécanisme de distribution de données dans MongoDB pour gérer les charges de données massives 