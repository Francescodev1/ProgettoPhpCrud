<?php
// Inizia la sessione e include la classe User
session_start();
require_once 'User.php';

// Se l'utente non è loggato, reindirizza al login
if (!isset($_SESSION['user_id']) || !isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

$userManager = new User();
$isAdmin = $userManager->isAdmin($_SESSION['user_id']);

// Logica per l'eliminazione dell'utente, solo se è admin
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_user_id']) && $isAdmin) {
    $userManager->deleteUser($_POST['delete_user_id']);
}

// Ottieni tutti gli utenti per mostrarli
$db = Database::getInstance();
$stmt = $db->query("SELECT id, username FROM users");
$users = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta http="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestione Utenti</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css">
    <script>
        function showAdminAlert() {
            alert("Accesso negato: non sei un amministratore.");
        }
    </script>
</head>
<body>
    <div class="container">
        <h2>Gestione Utenti</h2>
        <a href="logout.php" class="btn btn-warning">Logout</a>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Azioni</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $userRow): ?>
                <tr>
                    <td><?php echo htmlspecialchars($userRow['id']); ?></td>
                    <td><?php echo htmlspecialchars($userRow['username']); ?></td>
                    <td>
                        <?php if ($isAdmin): ?>
                            <form method="post">
                                <input type="hidden" name="delete_user_id" value="<?php echo $userRow['id']; ?>">
                                <button type="submit" class="btn btn-danger">Elimina</button>
                            </form>
                        <?php else: ?>
                            <button onclick="showAdminAlert()" class="btn btn-danger">Elimina</button>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
