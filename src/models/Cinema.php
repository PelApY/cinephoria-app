<?php

require_once __DIR__ . '/../config/db.php';

class Cinema {
    private $cinemaId;
    private $name;
    private $city;
    private $country;
    private $address;
    private $postalCode;
    private $phone;
    private $hours;
    private $email;

    // Constructeur
    public function __construct($cinemaId = null, $name = '', $city = '', $country = '', $address = '', $postalCode = '', $phone = '', $hours = '', $email = '') {
        $this->cinemaId = $cinemaId;
        $this->name = $name;
        $this->city = $city;
        $this->country = $country;
        $this->address = $address;
        $this->postalCode = $postalCode;
        $this->phone = $phone;
        $this->hours = $hours;
        $this->email = $email;
    }

    // Getters et Setters
    public function getCinemaId() { return $this->cinemaId; }
    public function getName() { return $this->name; }
    public function getCity() { return $this->city; }
    public function getCountry() { return $this->country; }
    public function getAddress() { return $this->address; }
    public function getPostalCode() { return $this->postalCode; }
    public function getPhone() { return $this->phone; }
    public function getHours() { return $this->hours; }
    public function getEmail() { return $this->email; }

    // Setters
    public function setCinemaId($cinemaId) { $this->cinemaId = $cinemaId; }
    public function setName($name) { $this->name = $name; }
    public function setCity($city) { $this->city = $city; }
    public function setCountry($country) { $this->country = $country; }
    public function setAddress($address) { $this->address = $address; }
    public function setPostalCode($postalCode) { $this->postalCode = $postalCode; }
    public function setPhone($phone) { $this->phone = $phone; }
    public function setHours($hours) { $this->hours = $hours; }
    public function setEmail($email) { $this->email = $email; }

    // CRUD Methods

    // Read All Cinemas
    public static function readAll() {
        global $pdo; // Utiliser la connexion PDO globale
        try {
            $query = "SELECT * FROM Cinema"; // Requête SQL
            $stmt = $pdo->query($query); // Exécution de la requête SQL
            return $stmt->fetchAll(PDO::FETCH_ASSOC); // Récupération de tous les cinémas
        } catch (PDOException $e) {
            die("Erreur : " . $e->getMessage()); // Gestion d'erreur
        }
    }

    // Create Cinema
    public function create() {
        global $pdo;
        try {
            $query = "INSERT INTO Cinema (cinema_nom, cinema_ville, cinema_pays, cinema_adresse, cinema_cp, cinema_numero, cinema_horaires, cinema_email) 
                      VALUES (:name, :city, :country, :address, :postalCode, :phone, :hours, :email)";
            $stmt = $pdo->prepare($query);
            $stmt->execute([
                ':name' => $this->name,
                ':city' => $this->city,
                ':country' => $this->country,
                ':address' => $this->address,
                ':postalCode' => $this->postalCode,
                ':phone' => $this->phone,
                ':hours' => $this->hours,
                ':email' => $this->email
            ]);
        } catch (PDOException $e) {
            // Gestion d'erreur en cas de problème avec la base de données
            die("Error: " . $e->getMessage());
        }
    }
    
    // Find Cinema by ID
    public static function find($id) {
        global $pdo;
        try {
            $query = "SELECT * FROM Cinema WHERE cinema_id = :id";
            $stmt = $pdo->prepare($query);
            $stmt->execute([':id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Gestion d'erreur
            die("Error: " . $e->getMessage());
        }
    }

    // Update Cinema
    public function update() {
        global $pdo;
        try {
            $query = "UPDATE Cinema SET cinema_nom = :name, cinema_ville = :city, cinema_pays = :country, 
                      cinema_adresse = :address, cinema_cp = :postalCode, cinema_numero = :phone, 
                      cinema_horaires = :hours, cinema_email = :email WHERE cinema_id = :id";
            $stmt = $pdo->prepare($query);
            $stmt->execute([
                ':id' => $this->cinemaId,
                ':name' => $this->name,
                ':city' => $this->city,
                ':country' => $this->country,
                ':address' => $this->address,
                ':postalCode' => $this->postalCode,
                ':phone' => $this->phone,
                ':hours' => $this->hours,
                ':email' => $this->email
            ]);
        } catch (PDOException $e) {
            // Gestion d'erreur
            die("Error: " . $e->getMessage());
        }
    }

    // Delete Cinema
    public static function delete($id) {
        global $pdo;
        try {
            $query = "DELETE FROM Cinema WHERE cinema_id = :id";
            $stmt = $pdo->prepare($query);
            $stmt->execute([':id' => $id]);
        } catch (PDOException $e) {
            // Gestion d'erreur
            die("Error: " . $e->getMessage());
        }
    }
}
