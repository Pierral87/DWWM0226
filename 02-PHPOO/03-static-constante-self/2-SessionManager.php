<?php 

// Ici on montre comment se servir du contexte static
// On va définir ici une classe "SessionManager" qui nous permettra de manipuler la session sans manipuler la globale brute !  


class SessionManager {
    public static function start() {
        session_start();
    }

    public static function set($key, $value) {
        $_SESSION[$key] = $value;
    }

    public static function get($key) {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
    }

    public static function destroy() {
        session_destroy();
    }
}


// Utilisation 
SessionManager::start(); 

// Supposons une identification réussi par l'utilisateur Pierra, je vais stocker ses infos dans la session 
SessionManager::set("user", "Pierra");
SessionManager::set("role", "admin");
echo SessionManager::get("user");
echo SessionManager::get("role");