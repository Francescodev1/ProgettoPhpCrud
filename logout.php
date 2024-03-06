<?php
// Inizia la sessione
session_start();

// Distruggi tutte le variabili di sessione
$_SESSION = array();

// Se desideri distruggere completamente la sessione, cancella anche il cookie di sessione.
// Questo distruggerà la sessione e non solo i dati di sessione!
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Infine, distruggi la sessione.
session_destroy();

// Reindirizza alla pagina di login o alla homepage
header("Location: login.php");
exit;
?>
