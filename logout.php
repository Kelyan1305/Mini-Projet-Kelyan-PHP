<?php
session_start(); // Démarre la session
$_SESSION = []; // Vide toutes les variables de session
session_unset(); // Désactive la session en cours
session_destroy(); // Détruit la session

// Redirige l'utilisateur vers la page de connexion
header("Location: login.php");
exit();
?>

