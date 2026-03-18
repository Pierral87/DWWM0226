<?php 

class A {
    public function testA() 
    {
        return "testA";
    }
}

///////////////////////////////////////

class B extends A {
    public function testB() 
    {
        return "testB";
    }
}

///////////////////////////////////////

class C extends B {
    public function testC() 
    {
        return "testC";
    }
}

$c = new C; 

var_dump(get_class_methods($c));

/* 
    Si C hérite de B 
        que B hérite de A 
            alors C hérite de A même s'il n'y a pas un héritage direct entre les deux (cela passe par B)

    --- C'est ce qu'on appelle la transitivité --- 

    Autres détails sur l'héritage : 

        -- Non reflexif : class D extends D // Erreur pas possible, ne peut pas hériter d'elle même 
        -- Non symétrique : class F extends E // F hérite de E mais E n'hérite pas de F 
        -- Sans cycle : class X extends Y 
                        class Y extends X // Erreur ! Pas possible d'hériter dans un sens et dans l'autre 
        -- Pas d'héritage multiple : Class G extends I, J, K // Pas possible ! Pour ça il faudra passer par les "traits"


*/