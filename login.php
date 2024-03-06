<?php
// Inizia la sessione PHP per gestire la login session
session_start();

// Includi il file che contiene la classe User
require_once 'User.php';

// Inizializza la variabile di errore
$error = '';

// Controlla se il form è stato inviato
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Crea un'istanza della classe User e controlla le credenziali
    $user = new User();
    $userInfo = $user->checkLogin($username, $password);

    if ($userInfo) {
        // Se l'utente esiste e la password è corretta, registra l'ID utente nella sessione
        $_SESSION['user_id'] = $userInfo['id'];
        $_SESSION['username'] = $userInfo['username'];

        // Reindirizza l'utente al pannello di amministrazione
        header('Location: user_management.php');
        exit;
    } else {
        // Se le credenziali sono sbagliate, mostra un messaggio di errore
        $error = 'Username o password non corretti.';
    }
}



$password = 'admin'; // Sostituisci 'laTuaPassword' con la password effettiva
$hash = password_hash($password, PASSWORD_DEFAULT);
echo $hash;


?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="POST" action="login.php">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
            <a href="register.php" class="btn btn-secondary">Registrati</a>
        </form>
    </div>
</body>
</html>
