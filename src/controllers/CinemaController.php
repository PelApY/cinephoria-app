<?php

// Inclure le modèle Cinema
require_once __DIR__ . '/../models/Cinema.php';

// Controller pour gérer les cinémas
class CinemaController {

    // Liste tous les cinémas
    public function index() {
        $cinemas = Cinema::readAll();  // Appel pour récupérer tous les cinémas
        include __DIR__ . '/../../templates/home.php';  // Afficher la liste des cinémas dans la vue
    }

    // Liste tous les cinémas pour Admin
    public function indexAdmin() {
        $cinemas = Cinema::readAll();  // Appel pour récupérer tous les cinémas
        include __DIR__ . '/../../templates/cinema_list.php';  // Afficher la liste des cinémas dans la vue
    }

    // Affiche les détails d'un cinéma par son ID
    public function show($id) {
        $cinema = Cinema::find($id);  // Appel au modèle pour récupérer un cinéma par son ID
        if ($cinema) {
            include __DIR__ . '/../../templates/cinema_detail.php';  // Afficher les détails du cinéma
        } else {
            echo "Cinéma non trouvé.";
        }
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupération des données du formulaire
            $data = [
                'name' => $_POST['name'],
                'city' => $_POST['city'],
                'country' => $_POST['country'],
                'address' => $_POST['address'],
                'postalCode' => $_POST['postalCode'],
                'phone' => $_POST['phone'],
                'hours' => $_POST['hours'],
                'email' => $_POST['email'],
            ];
    
            // Validation des données
            $errors = $this->validateCinemaData($data);
    
            if (!empty($errors)) {
                // Si des erreurs existent, renvoyer une réponse JSON avec l'erreur
                echo json_encode([
                    'success' => false,
                    'message' => implode(', ', $errors)
                ]);
                return;
            }
    
            try {
                // Connexion à la base de données via le global $pdo
                global $pdo;
                // Préparer la requête SQL avec des placeholders pour éviter les injections SQL
                $query = "INSERT INTO Cinema (cinema_nom, cinema_ville, cinema_pays, cinema_adresse, cinema_cp, cinema_numero, cinema_horaires, cinema_email)
                          VALUES (:name, :city, :country, :address, :postalCode, :phone, :hours, :email)";
                // Préparer la requête
                $stmt = $pdo->prepare($query);
                // Exécuter la requête en liant les paramètres à partir de l'array $data
                $stmt->execute([
                    ':name' => $data['name'],
                    ':city' => $data['city'],
                    ':country' => $data['country'],
                    ':address' => $data['address'],
                    ':postalCode' => $data['postalCode'],
                    ':phone' => $data['phone'],
                    ':hours' => $data['hours'],
                    ':email' => $data['email']
                ]);
    
                // Renvoyer une réponse JSON avec succès si l'insertion a été effectuée
                echo json_encode([
                    'success' => true,
                    'message' => 'Le cinéma a été ajouté avec succès!'
                ]);
                exit();

            } catch (PDOException $e) {
                // Si une erreur survient lors de l'exécution de la requête, envoyer une erreur en JSON
                echo json_encode([
                    'success' => false,
                    'message' => 'Une erreur est survenue: ' . $e->getMessage()
                ]);
                exit();
            }
        }
    }

    public function update($id) {
        try {
            // Récupérer les données existantes du cinéma pour pré-remplir le formulaire
            $cinema = Cinema::find($id);  // Utiliser la méthode find pour récupérer les informations du cinéma
    
            // Si le cinéma n'existe pas, envoyer un message d'erreur JSON
            if (!$cinema) {
                echo json_encode(['success' => false, 'message' => 'Cinéma non trouvé.']);
                return;
            }
    
            // Si la requête est en POST (lorsqu'on soumet le formulaire)
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Récupérer les données du formulaire envoyées en AJAX
                $data = [
                    'name' => $_POST['name'],
                    'city' => $_POST['city'],
                    'country' => $_POST['country'],
                    'address' => $_POST['address'],
                    'postalCode' => $_POST['postalCode'],
                    'phone' => $_POST['phone'],
                    'hours' => $_POST['hours'],
                    'email' => $_POST['email'],
                    'id' => $id  // Ajout de l'ID du cinéma à mettre à jour
                ];
    
                // Valider les données
                $errors = $this->validateCinemaData($data);
    
                // Si il y a des erreurs, retourner les erreurs en JSON
                if (!empty($errors)) {
                    echo json_encode([
                        'success' => false,
                        'message' => $errors
                    ]);
                    return;
                }
    
                // Si pas d'erreurs, mettre à jour les informations du cinéma dans la base de données
                // Utilisation d'une requête préparée pour la mise à jour
                global $pdo;
    
                $query = "UPDATE Cinema 
                          SET cinema_nom = :name, cinema_ville = :city, cinema_pays = :country, 
                              cinema_adresse = :address, cinema_cp = :postalCode, cinema_numero = :phone, 
                              cinema_horaires = :hours, cinema_email = :email
                          WHERE cinema_id = :id";
    
                $stmt = $pdo->prepare($query);
                $stmt->execute([
                    ':name' => $data['name'],
                    ':city' => $data['city'],
                    ':country' => $data['country'],
                    ':address' => $data['address'],
                    ':postalCode' => $data['postalCode'],
                    ':phone' => $data['phone'],
                    ':hours' => $data['hours'],
                    ':email' => $data['email'],
                    ':id' => $data['id']  // ID du cinéma à mettre à jour
                ]);
    
                // Si la mise à jour est réussie, retourner une réponse JSON de succès
                echo json_encode([
                    'success' => true,
                    'message' => 'Cinéma mis à jour avec succès!'
                ]);
                return;
            } else {
                // Si ce n'est pas un POST, envoyer une réponse JSON pour indiquer que la requête n'est pas valide
                echo json_encode([
                    'success' => false,
                    'message' => 'Méthode HTTP non valide.'
                ]);
                return;
            }
        } catch (Exception $e) {
            // Si une exception se produit, retourner un message d'erreur en JSON
            echo json_encode([
                'success' => false,
                'message' => 'Une erreur s\'est produite lors de la mise à jour du cinéma. ' . $e->getMessage()
            ]);
            // Logguer l'exception pour un débogage plus approfondi
            error_log('Erreur lors de la mise à jour du cinéma : ' . $e->getMessage());
            return;
        }
    }    

    // Supprimer un cinéma
    public function delete($id) {
        $cinema = Cinema::find($id);

        if ($cinema) {
            Cinema::delete($id);  // Appel à la méthode pour supprimer le cinéma
            header('Location: /index.php?controller=cinema&action=indexAdmin');  // Rediriger après suppression
            exit();
        } else {
            echo "Cinéma non trouvé.";
        }
    }

    // Fonction de validation des données pour un cinéma
    private function validateCinemaData($data) {
        $errors = [];

        // Validation du nom
        if (empty($data['name'])) {
            $errors[] = 'Le nom du cinéma est requis.';
        } elseif (strlen($data['name']) > 50) {
            $errors[] = 'Le nom du cinéma ne peut pas dépasser 50 caractères.';
        }

        // Validation de la ville
        if (empty($data['city'])) {
            $errors[] = 'La ville est requise.';
        } elseif (strlen($data['city']) > 30) {
            $errors[] = 'Le nom de la ville ne peut pas dépasser 30 caractères.';
        }

        // Validation du pays
        if (empty($data['country'])) {
            $errors[] = 'Le pays est requis.';
        } elseif (strlen($data['country']) > 30) {
            $errors[] = 'Le nom du pays ne peut pas dépasser 30 caractères.';
        }

        // Validation de l'adresse
        if (empty($data['address'])) {
            $errors[] = 'L\'adresse est requise.';
        } elseif (strlen($data['address']) > 100) {
            $errors[] = 'L\'adresse ne peut pas dépasser 100 caractères.';
        }

        // Validation du code postal
        if (empty($data['postalCode'])) {
            $errors[] = 'Le code postal est requis.';
        } elseif (strlen($data['postalCode']) > 10) {
            $errors[] = 'Le code postal ne peut pas dépasser 10 caractères.';
        }

        // Validation du numéro de téléphone
        if (empty($data['phone'])) {
            $errors[] = 'Le numéro de téléphone est requis.';
        } elseif (strlen($data['phone']) > 20) {
            $errors[] = 'Le numéro de téléphone ne peut pas dépasser 20 caractères.';
        } elseif (!preg_match('/^\+?[0-9]{10,15}$/', $data['phone'])) {
            $errors[] = 'Le numéro de téléphone n\'est pas valide.';
        }

        // Validation des horaires
        if (empty($data['hours'])) {
            $errors[] = 'Les horaires d\'ouverture sont requis.';
        } elseif (strlen($data['hours']) > 30) {
            $errors[] = 'Les horaires d\'ouverture ne peuvent pas dépasser 30 caractères.';
        }

        // Validation de l'email
        if (empty($data['email'])) {
            $errors[] = 'L\'email est requis.';
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'L\'email n\'est pas valide.';
        } elseif (strlen($data['email']) > 100) {
            $errors[] = 'L\'email ne peut pas dépasser 100 caractères.';
        }

        return $errors;
    }
}
