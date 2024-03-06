<?php
// Includi il file che contiene la classe User
require_once 'User.php';

// Inizializza la variabile di errore e successo
$error = '';
$success = '';

// Controlla se il form è stato inviato
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        $error = 'Per favore, compila tutti i campi.';
    } else {
        // Crea un'istanza della classe User e tenta di registrare l'utente
        $user = new User();
        $result = $user->register($username, $password);

        if ($result) {
            $success = 'Registrazione completata con successo. Ora puoi fare il <a href="login.php">login</a>.';
        } else {
            $error = 'Si è verificato un errore durante la registrazione. Forse lo username è già in uso.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrazione</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2>Registrazione</h2>
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>
        <form method="POST" action="register.php">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Registra</button>
            <a href="login.php" class="btn btn-secondary">Login</a>
        </form>
    </div>
</body>
</html>
