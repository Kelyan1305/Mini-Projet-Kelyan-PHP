<?php
session_start();
require 'config.php';

// Vérification de la connexion utilisateur
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newMessage = trim($_POST['message']);
    
    // Validation du message
    if (!empty($newMessage)) {
        $insertStmt = $connection->prepare("INSERT INTO messages (user_id, message) VALUES (?, ?)");
        $insertStmt->execute([$_SESSION['user_id'], $newMessage]);
    }
}

// Récupération des messages du livre d'or
$getMessages = $connection->query(
    "SELECT m.id, m.message, m.created_at, u.username 
     FROM messages m 
     JOIN users u ON m.user_id = u.id 
     ORDER BY m.created_at DESC"
)->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Livre d'Or</title>
</head>
<body>
    <h2>Livre d'Or</h2>
    <p>Bienvenue, <?php echo htmlspecialchars($_SESSION['username']); ?>! <a href="logout.php">Se déconnecter</a></p>
    
    <form action="" method="POST">
        <textarea name="message" placeholder="Votre message ici..." required></textarea>
        <button type="submit">Envoyer</button>
    </form>

    <h3>Messages Récents</h3>
    <?php foreach ($getMessages as $message): ?>
        <div>
            <strong><?php echo htmlspecialchars($message['username']); ?>:</strong>
            <p><?php echo htmlspecialchars($message['message']); ?></p>
            <small><?php echo $message['created_at']; ?></small>
        </div>
    <?php endforeach; ?>
</body>
</html>

