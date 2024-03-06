<?php
require_once 'config.php';

class User {
    private $db;

    public function __construct() {
        // Stabilisci la connessione al database utilizzando il Singleton.
        $this->db = Database::getInstance();
    }

    public function register($username, $password) {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->execute([$username, $passwordHash]);
        return $stmt->rowCount() > 0;
    }

    public function checkLogin($username, $password) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch();
            return password_verify($password, $user['password']) ? $user : false;
        }
        return false;
    }

    public function isAdmin($userId) {
        $stmt = $this->db->prepare("SELECT role FROM users WHERE id = ?");
        $stmt->execute([$userId]);
        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch();
            return $user['role'] === 'admin';
        }
        return false;
    }

    public function updateUser($userId, $username, $password) {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("UPDATE users SET username = ?, password = ? WHERE id = ?");
        $stmt->execute([$username, $passwordHash, $userId]);
        return $stmt->rowCount() > 0;
    }

    //aggiunta per modifica dell'utente modale
    public function updateUsername($userId, $newUsername) {
        $stmt = $this->db->prepare("UPDATE users SET username = ? WHERE id = ?");
        return $stmt->execute([$newUsername, $userId]);
    }
    //fine aggiunta per modifica dell'utente modale    


    

    public function deleteUser($userId) {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$userId]);
        return $stmt->rowCount() > 0;
    }
}
?>
