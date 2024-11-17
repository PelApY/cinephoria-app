<?php

// Inclure l'autoloader de Composer pour charger toutes les dépendances
require_once __DIR__ . '/../../vendor/autoload.php';

// Utilisation de Dotenv pour charger les variables d'environnement
use Dotenv\Dotenv;
// use MongoDB\Client;
use MongoDB\Driver\Manager;
use MongoDB\Driver\Query;

// Charger le fichier .env
$dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

// Initialisation du tableau pour stocker les connexions
$db = [];

// Connexion MySQL locale
function connectMysqlLocal($env) {
    try {
        // echo 'Connexion MySQL locale : Tentative de connexion...<br>'; // Désactivé pour la production
        $pdo = new PDO(
            "mysql:host=" . $env['DB_HOST_LOCAL'] . ";dbname=" . $env['DB_NAME_LOCAL'],
            $env['DB_USER_LOCAL'],
            $env['DB_PASSWORD_LOCAL']
        );
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Config des erreurs
        echo "Connexion réussie à MySQL local !<br>"; // Désactivé pour la production

        // Vérification de la base de données
        $base = $pdo->query("SELECT DATABASE()")->fetchColumn();
        echo "Base de données utilisée : $base<br>"; // Désactivé pour la production

        // Récupérer les 5 premiers cinémas
        $query = $pdo->query("SELECT * FROM Cinema LIMIT 5");
        $cinemaData = $query->fetchAll(PDO::FETCH_ASSOC);

        if ($cinemaData) {
            echo '<h4>Liste des cinémas (MySQL local) :</h4>'; // Désactivé pour la production
            echo '<table border="1"><tr><th>Nom</th><th>Ville</th><th>Pays</th><th>Adresse</th><th>Email</th></tr>'; // Désactivé pour la production
            foreach ($cinemaData as $cinema) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($cinema['cinema_nom']) . '</td>'; // Désactivé pour la production
                echo '<td>' . htmlspecialchars($cinema['cinema_ville']) . '</td>'; // Désactivé pour la production
                echo '<td>' . htmlspecialchars($cinema['cinema_pays']) . '</td>'; // Désactivé pour la production
                echo '<td>' . htmlspecialchars($cinema['cinema_adresse']) . '</td>'; // Désactivé pour la production
                echo '<td>' . htmlspecialchars($cinema['cinema_email']) . '</td>'; // Désactivé pour la production
                echo '</tr>';
            }
            echo '</table><br>'; // Désactivé pour la production
        } else {
            echo "Aucun cinéma trouvé en MySQL local !<br>"; // Désactivé pour la production
        }

        return $pdo;
        
    } catch (PDOException $e) {
        echo "Échec de la connexion MySQL local : " . $e->getMessage() . "<br>"; // Désactivé pour la production
        return false;
    }
}

// Fonction de connexion MySQL distante (AlwaysData)
function connectMysqlRemote($env) {
    try {
        echo 'Connexion MySQL distante : Tentative de connexion...<br>'; // Désactivé pour la production
        $pdo = new PDO(
            "mysql:host=" . $env['DB_HOST_REMOTE'] . ";dbname=" . $env['DB_NAME_REMOTE'],
            $env['DB_USER_REMOTE'],
            $env['DB_PASSWORD_REMOTE']
        );
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "Connexion réussie à MySQL distant !<br>"; // Désactivé pour la production

        // Récupérer les données de la table Cinema
        $query = $pdo->query("SELECT * FROM Cinema");
        $cinemaData = $query->fetchAll(PDO::FETCH_ASSOC);

        if ($cinemaData) {
            echo '<h4>Liste des cinémas (MySQL distant) :</h4>'; // Désactivé pour la production
            echo '<table border="1"><tr><th>Nom</th><th>Ville</th><th>Pays</th><th>Adresse</th><th>Email</th></tr>'; // Désactivé pour la production
            foreach ($cinemaData as $cinema) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($cinema['cinema_nom']) . '</td>'; // Désactivé pour la production
                echo '<td>' . htmlspecialchars($cinema['cinema_ville']) . '</td>'; // Désactivé pour la production
                echo '<td>' . htmlspecialchars($cinema['cinema_pays']) . '</td>'; // Désactivé pour la production
                echo '<td>' . htmlspecialchars($cinema['cinema_adresse']) . '</td>'; // Désactivé pour la production
                echo '<td>' . htmlspecialchars($cinema['cinema_email']) . '</td>'; // Désactivé pour la production
                echo '</tr>';
            }
            echo '</table><br>'; // Désactivé pour la production
        } else {
            echo "Aucun cinéma trouvé en MySQL distant !<br>"; // Désactivé pour la production
        }

        return $pdo;
    } catch (PDOException $e) {
        echo "Échec de la connexion MySQL distant : " . $e->getMessage() . "<br>"; // Désactivé pour la production
        return false;
    }
}

// Connexion MongoDB locale
function connectMongoLocal($env) {
    try {
        echo 'Connexion MongoDB locale : Tentative de connexion...<br>'; // Désactivé pour la production
        $mongoDbUri = $env['MONGO_DB_URI_LOCAL'];
        // $mongoDb = new Client($mongoDbUri);
        $mongoDb = new Manager($mongoDbUri);
        echo "Connexion réussie à MongoDB local !<br>"; // Désactivé pour la production

        // Récupérer les noms des utilisateurs dans la collection "users"
        $filter = []; // Pas de filtre, on récupère tous les utilisateurs
        $options = [
            'projection' => ['name' => 1], // On ne récupère que le champ "name"
            'limit' => 10, // Limite le nombre de résultats à 10
        ];
        $query = new Query($filter, $options);  // Utilisation de la classe Query correctement importée
        $cursor = $mongoDb->executeQuery($env['MONGO_DB_NAME_LOCAL'] . '.users', $query);

        $userNames = iterator_to_array($cursor);
        if ($userNames) {
            echo '<h4>Liste des noms des utilisateurs (MongoDB local) :</h4>'; // Désactivé pour la production
            echo '<table border="1"><tr><th>Name</th></tr>'; // Désactivé pour la production
            foreach ($userNames as $user) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($user->name) . '</td>'; // Désactivé pour la production
                echo '</tr>';
            }
            echo '</table><br>'; // Désactivé pour la production
        } else {
            echo "Aucun utilisateur trouvé en MongoDB local !<br>"; // Désactivé pour la production
        }

        return $mongoDb;
    } catch (Exception $e) {
        echo "Échec de la connexion MongoDB local : " . $e->getMessage() . "<br>"; // Désactivé pour la production
        return false;
    }
}

// Fonction de connexion MongoDB distante (MongoDB Atlas)
function connectMongoRemote($env) {
    try {
        echo 'Connexion MongoDB distante : Tentative de connexion...<br>'; // Désactivé pour la production
        $mongoDbUri = $env['MONGO_DB_URI_PROD'];
        $mongoDb = new Manager($mongoDbUri);
        echo "Connexion réussie à MongoDB distant !<br>"; // Désactivé pour la production

        // Récupérer les noms des utilisateurs dans la collection "users"
        $filter = []; // Pas de filtre, on récupère tous les utilisateurs
        $options = [
            'projection' => ['name' => 1], // On ne récupère que le champ "name"
            'limit' => 5, // Limite le nombre de résultats à 5
        ];
        $query = new Query($filter, $options);  // Utilisation de la classe Query correctement importée
        $cursor = $mongoDb->executeQuery($env['MONGO_DB_NAME_PROD'] . '.users', $query);

        $userNames = iterator_to_array($cursor);
        if ($userNames) {
            echo '<h4>Liste des noms des utilisateurs (MongoDB distant) :</h4>'; // Désactivé pour la production
            echo '<table border="1"><tr><th>Name</th></tr>'; // Désactivé pour la production
            foreach ($userNames as $user) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($user->name) . '</td>'; // Désactivé pour la production
                echo '</tr>';
            }
            echo '</table><br>'; // Désactivé pour la production
        } else {
            echo "Aucun utilisateur trouvé en MongoDB distant !<br>"; // Désactivé pour la production
        }

        return $mongoDb;
    } catch (Exception $e) {
        echo "Échec de la connexion MongoDB distant : " . $e->getMessage() . "<br>"; // Désactivé pour la production
        return false;
    }
}

// Connexion MySQL local
if ($_ENV['DB_ENV_MYSQL_LOCAL'] == 'local') {
    $db['mysql_local'] = connectMysqlLocal($_ENV);
}

// Connexion MySQL distant
if ($_ENV['DB_ENV_MYSQL_REMOTE'] == 'production') {
    $db['mysql_remote'] = connectMysqlRemote($_ENV);
}

// Connexion MongoDB local
if ($_ENV['DB_ENV_MONGO_LOCAL'] == 'local') {
    $db['mongodb_local'] = connectMongoLocal($_ENV);
}

// Connexion MongoDB distant
if ($_ENV['DB_ENV_MONGO_REMOTE'] == 'production') {
    $db['mongodb_remote'] = connectMongoRemote($_ENV);
}

// Retourner les connexions
return $db;
?>
