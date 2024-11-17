<?php
// backend/index.php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Inclure la configuration de la base de données
require_once 'src/config/db.php';

// Récupérer la connexion à la base de données
$db = require_once 'src/config/db.php';
