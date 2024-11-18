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
        }

        // Validation de la ville
        if (empty($data['city'])) {
            $errors[] = 'La ville est requise.';
        }

        // Validation du pays
        if (empty($data['country'])) {
            $errors[] = 'Le pays est requis.';
        }

        // Validation de l'adresse
        if (empty($data['address'])) {
            $errors[] = 'L\'adresse est requise.';
        }

        // Validation du code postal (optionnel mais on peut ajouter une vérification de format)
        if (empty($data['postalCode'])) {
            $errors[] = 'Le code postal est requis.';
        } elseif (!preg_match('/^\d{5}$/', $data['postalCode'])) {
            // Vérifie que le code postal contient 5 chiffres (ajuste selon ton pays)
            $errors[] = 'Le code postal doit être constitué de 5 chiffres.';
        }

        // Validation du numéro de téléphone (optionnel mais on peut vérifier un format standard)
        if (empty($data['phone'])) {
            $errors[] = 'Le numéro de téléphone est requis.';
        } elseif (!preg_match('/^\+?[0-9]{10,15}$/', $data['phone'])) {
            // Vérifie un format international de numéro de téléphone
            $errors[] = 'Le numéro de téléphone n\'est pas valide.';
        }

        // Validation des horaires (si requis)
        if (empty($data['hours'])) {
            $errors[] = 'Les horaires d\'ouverture sont requis.';
        }

        // Validation de l'email (s'assurer que c'est un email valide)
        if (empty($data['email'])) {
            $errors[] = 'L\'email est requis.';
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'L\'email n\'est pas valide.';
        }

        return $errors;
    }
}
