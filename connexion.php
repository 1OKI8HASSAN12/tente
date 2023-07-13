<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Connexion à la base de données
$connexion = new PDO("mysql:host=localhost;dbname=notres", "root", "");

// Vérifier si la connexion a réussi
if ($connexion === false) {
    die("Erreur de connexion à la base de données");
}
?>
