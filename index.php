<?php
// index.php (Point d'entrée)

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Inclure la configuration de la base de données et les classes nécessaires
require_once 'src/config/db.php';
require_once 'src/controllers/CinemaController.php';

// Récupérer l'action et le contrôleur à partir de l'URL (par exemple ?controller=cinema&action=index)
$controller = isset($_GET['controller']) ? $_GET['controller'] : 'cinema';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

// Instancier le contrôleur demandé
$controllerClass = ucfirst($controller) . 'Controller';
if (class_exists($controllerClass)) {
    $controllerObject = new $controllerClass();
    
    // Appeler l'action demandée
    if (method_exists($controllerObject, $action)) {
        $controllerObject->$action();  // Appel de l'action
    } else {
        echo "Action '$action' non trouvée.";
    }
} else {
    echo "Contrôleur '$controllerClass' non trouvé.";
}

