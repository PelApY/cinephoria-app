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

    // Affiche les détails d'un cinéma par son ID
    public function show($id) {
        $cinema = Cinema::find($id);  // Appel au modèle pour récupérer un cinéma par son ID
        if ($cinema) {
            include __DIR__ . '/../../templates/cinema_detail.php';  // Afficher les détails du cinéma
        } else {
            echo "Cinéma non trouvé.";
        }
    }

    // Crée un nouveau cinéma
    public function create() {
        // Vérifier si les données sont envoyées via POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupérer les données du formulaire
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

            // Valider les données
            $errors = $this->validateCinemaData($data);

            // Si il y a des erreurs, afficher les erreurs et arrêter l'exécution
            if (!empty($errors)) {
                include __DIR__ . '/../../templates/cinema_create.php';  // Renvoyer le formulaire avec les erreurs
                return;
            }

            // Si pas d'erreurs, créer le cinéma
            $cinema = new Cinema(null, $data['name'], $data['city'], $data['country'], $data['address'], $data['postalCode'], $data['phone'], $data['hours'], $data['email']);
            $cinema->create();  // Appel à la méthode de création

            // Rediriger vers la liste des cinémas après l'ajout
            header('Location: /index.php?controller=cinema&action=index');
            exit();
        } else {
            // Si ce n'est pas un POST, afficher le formulaire de création
            include __DIR__ . '/../../templates/cinema_create.php';
        }
    }

    // Mettre à jour un cinéma
    public function update($id) {
        // Récupérer les données existantes du cinéma pour pré-remplir le formulaire
        $cinema = Cinema::find($id);

        if (!$cinema) {
            echo "Cinéma non trouvé.";
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupérer les données du formulaire
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

            // Valider les données
            $errors = $this->validateCinemaData($data);

            // Si il y a des erreurs, afficher les erreurs et arrêter l'exécution
            if (!empty($errors)) {
                include __DIR__ . '/../../templates/cinema_update.php';  // Renvoyer le formulaire avec les erreurs
                return;
            }

            // Si pas d'erreurs, mettre à jour les informations du cinéma
            $cinema->setName($data['name']);
            $cinema->setCity($data['city']);
            $cinema->setCountry($data['country']);
            $cinema->setAddress($data['address']);
            $cinema->setPostalCode($data['postalCode']);
            $cinema->setPhone($data['phone']);
            $cinema->setHours($data['hours']);
            $cinema->setEmail($data['email']);
            $cinema->update();  // Appel à la méthode de mise à jour

            // Rediriger vers la liste des cinémas après la mise à jour
            header('Location: /index.php?controller=cinema&action=index');
            exit();
        } else {
            // Si ce n'est pas un POST, afficher le formulaire avec les informations actuelles du cinéma
            include __DIR__ . '/../../templates/cinema_update.php';  // Formulaire de mise à jour
        }
    }

    // Supprimer un cinéma
    public function delete($id) {
        $cinema = Cinema::find($id);

        if ($cinema) {
            Cinema::delete($id);  // Appel à la méthode pour supprimer le cinéma
            header('Location: /index.php?controller=cinema&action=index');  // Rediriger après suppression
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
