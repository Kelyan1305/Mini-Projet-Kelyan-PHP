<?php
session_start();
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $inputUsername = trim($_POST['username']);
    $inputPassword = trim($_POST['password']);
    $loginErrors = [];

    // Vérification des champs obligatoires
    if (empty($inputUsername) || empty($inputPassword)) {
        $loginErrors[] = 'Veuillez remplir tous les champs.';
    }

    if (empty($loginErrors)) {
        // Vérification des informations d'identification dans la base de données
        $userCheck = $connection->prepare("SELECT * FROM users WHERE username = ?");
        $userCheck->execute([$inputUsername]);
        $retrievedUser = $userCheck->fetch();

        // Validation du mot de passe
        if ($retrievedUser && password_verify($inputPassword, $retrievedUser['password'])) {
            $_SESSION['username'] = $retrievedUser['username'];
            $_SESSION['user_id'] = $retrievedUser['id']; // Enregistrement de l'ID utilisateur
            header("Location: index.php");
            exit();
        } else {
            $loginErrors[] = 'Identifiant ou mot de passe incorrect.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Page de Connexion</title>
</head>
<body>
    <h2>Se Connecter</h2>
    <?php if (!empty($loginErrors)): ?>
        <div><?php echo implode('<br>', $loginErrors); ?></div>
    <?php endif; ?>
    <form action="" method="POST">
        <input type="text" name="username" placeholder="Entrez votre nom d'utilisateur" required>
        <input type="password" name="password" placeholder="Entrez votre mot de passe" required>
        <button type="submit">Connexion</button>
    </form>
</body>
</html>
