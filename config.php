<?php
$server = 'localhost'; 
$database = 'test'; 
$username = 'root'; // Remplacez par votre nom d'utilisateur
$password = ''; // Remplacez par votre mot de passe

try {
    $connection = new PDO("mysql:host=$server;dbname=$database;charset=utf8", $username, $password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $exception) {
    exit("Connexion échouée : " . $exception->getMessage());
}
?>

