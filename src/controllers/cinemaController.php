<?php

// Inclure le modèle Cinema
require_once __DIR__ . '/../models/Cinema.php';

// Controller pour gérer les cinémas
class CinemaController {

    // Liste tous les cinémas
    public function index() {
        $cinemas = Cinema::readAll();  // Appel au modèle pour récupérer tous les cinémas
        include __DIR__ . '/../templates/cinemas_list.php';  // Afficher la liste des cinémas dans la vue
    }

    // Affiche les détails d'un cinéma par son ID
    public function show($id) {
        $cinema = Cinema::find($id);  // Appel au modèle pour récupérer un cinéma par son ID
        if ($cinema) {
            include __DIR__ . '/../templates/cinema_detail.php';  // Afficher les détails du cinéma
        } else {
            echo "Cinéma non trouvé.";
        }
    }

    // Crée un nouveau cinéma
    public function create() {
        // Vérifier si les données sont envoyées via POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupérer les données du formulaire
            $name = $_POST['name'];
            $city = $_POST['city'];
            $country = $_POST['country'];
            $address = $_POST['address'];
            $postalCode = $_POST['postalCode'];
            $phone = $_POST['phone'];
            $hours = $_POST['hours'];
            $email = $_POST['email'];

            // Créer un nouvel objet Cinema et enregistrer dans la base
            $cinema = new Cinema(null, $name, $city, $country, $address, $postalCode, $phone, $hours, $email);
            $cinema->create();  // Appel à la méthode de création dans le modèle

            // Rediriger vers la liste des cinémas après l'ajout
            header('Location: /index.php?controller=cinema&action=index');
            exit();
        } else {
            // Si ce n'est pas un POST, afficher le formulaire de création
            include __DIR__ . '/../templates/cinema_create.php';  // Formulaire de création
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
            $name = $_POST['name'];
            $city = $_POST['city'];
            $country = $_POST['country'];
            $address = $_POST['address'];
            $postalCode = $_POST['postalCode'];
            $phone = $_POST['phone'];
            $hours = $_POST['hours'];
            $email = $_POST['email'];

            // Mettre à jour les informations du cinéma
            $cinema->setName($name);
            $cinema->setCity($city);
            $cinema->setCountry($country);
            $cinema->setAddress($address);
            $cinema->setPostalCode($postalCode);
            $cinema->setPhone($phone);
            $cinema->setHours($hours);
            $cinema->setEmail($email);
            $cinema->update();  // Appel à la méthode de mise à jour

            // Rediriger vers la liste des cinémas après la mise à jour
            header('Location: /index.php?controller=cinema&action=index');
            exit();
        } else {
            // Si ce n'est pas un POST, afficher le formulaire avec les informations actuelles du cinéma
            include __DIR__ . '/../templates/cinema_update.php';  // Formulaire de mise à jour
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
}