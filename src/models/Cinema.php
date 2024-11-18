<?php

require_once '/../config/db.php';

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

    // Create Cinema
    public static function create($name, $city, $country, $address, $postalCode, $phone, $hours, $email) {
        global $pdo;
        $query = "INSERT INTO Cinema (cinema_nom, cinema_ville, cinema_pays, cinema_adresse, cinema_cp, cinema_numero, cinema_horaires, cinema_email) 
                  VALUES (:name, :city, :country, :address, :postalCode, :phone, :hours, :email)";
        $stmt = $pdo->prepare($query);
        $stmt->execute([
            'name' => $name,
            'city' => $city,
            'country' => $country,
            'address' => $address,
            'postalCode' => $postalCode,
            'phone' => $phone,
            'hours' => $hours,
            'email' => $email
        ]);
    }

    // Read All Cinemas
    public static function readAll() {
        global $pdo;
        $query = "SELECT * FROM Cinema";
        $stmt = $pdo->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Update Cinema
    public static function update($id, $name, $city, $country, $address, $postalCode, $phone, $hours, $email) {
        global $pdo;
        $query = "UPDATE Cinema SET cinema_nom = :name, cinema_ville = :city, cinema_pays = :country, 
                  cinema_adresse = :address, cinema_cp = :postalCode, cinema_numero = :phone, 
                  cinema_horaires = :hours, cinema_email = :email WHERE cinema_id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->execute([
            'id' => $id,
            'name' => $name,
            'city' => $city,
            'country' => $country,
            'address' => $address,
            'postalCode' => $postalCode,
            'phone' => $phone,
            'hours' => $hours,
            'email' => $email
        ]);
    }

    // Find Cinema by ID
    public static function find($id) {
        global $pdo;
        $query = "SELECT * FROM Cinema WHERE cinema_id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Delete Cinema
    public static function delete($id) {
        global $pdo;
        $query = "DELETE FROM Cinema WHERE cinema_id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->execute(['id' => $id]);
    }
}
