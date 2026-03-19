<?php

/* 

3. Les exceptions en PHP

Les exceptions en PHP permettent de gérer les erreurs et les conditions anormales de manière contrôlée. Contrairement aux fatal error qui arrêtent le script immédiatement, les exceptions offrent un moyen d'intercepter les erreurs et de les traiter proprement.

On utilisera toujours les exceptions via des blocs try/catch  
Structure de base des exceptions :

    try : Bloc où l'on place le code qui peut potentiellement générer une exception.
    throw : Lance une exception.
    catch : Intercepte une exception lancée et permet de la traiter.
     finally : est un bloc que l'on peut rajouter après le try/catch et qui s'exécutera quoi qu'il en soit, que l'on soit passé dans le catch ou pas 


    On appelera les Exception pour du code qui "normalement" fonctionne, mais qui potentiellement peut bugger pour une raison ou une autre, généralement lorsque l'on fait appel à des services extérieurs 
    Par exemple : 
                Appels API
                Connexion/Requête vers BDD 

*/ 

function diviser($nbr1, $nbr2)
{

    if ($nbr2 == 0) {
        // trigger_error("Erreur pas de division par zero ! ", E_USER_ERROR); // Je peux déclencher une erreur simple php avec trigger error
        throw new Exception("Division par zéro interdite !"); // Mais je peux aussi déclencher une erreur en "lançant" une exception, je pourrais l'attraper plus tard via le bloc try/catch 
    }

    return $nbr1 / $nbr2;
}



try {  // Dans le bloc try "j'essaye" du code 
// Si tout va bien dans le bloc try, je passe à la suite, je ne rentrerai pas dans le bloc catch
echo diviser(10, 2);
echo diviser(10, 0); // Ici problème ! Cas d'erreur, lancement d'exception, je vais aterrir dans le bloc catch 
} catch(Exception $e) {

// J'arrive ici si une exception est lancée au travers du bloc try et j'ai accès à diverses informations sur l'erreur (l'exception) à l'intérieur du paramètres $e qui reçoit l'exception lancée 

// var_dump($e);
// var_dump(get_class_methods($e));

// On remarque dans le var_dump différentes informations, telles que, le message d'erreur, la ligne de lancement d'exception ainsi que la trace
// La trace c'est les détails de l'erreur rencontrée

echo "<h3>Attention erreur, problème de code </h3>";
echo "Erreur : " . $e->getMessage();
echo "Erreur : " . $e->getTraceAsString();

// Souvent, après être tombé dans un catch, je stoppe l'exécution du code avec un exit ou un die 
// exit; 
// die;


// Si je ne stoppe pas le code, je suis libre de poursuivre ! Malgré cette erreur (alors qu'une fatal error stoppe forcément l'exécution du code)
}


echo "<h2>JE SUIS APRES L'EXCEPTION</h2>";
