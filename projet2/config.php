<?php
$host = "localhost";
$dbname = "practice_db";
$username = "root"; // Utilisateur par défaut de WAMP
$password = "";     // Mot de passe par défaut de WAMP

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    // Configurer PDO pour générer des exceptions en cas d'erreur
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage() . "<br>Avez-vous bien importé le fichier database.sql ?");
}
?>
