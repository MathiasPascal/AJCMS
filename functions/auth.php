<?php
class AuthController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function register($email, $password) {
        $stmt = $this->pdo->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        try {
            return $stmt->execute([$email, $hashedPassword]);
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function login($email, $password) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user;
            return true;
        }
        return false;
    }

    public function getUserRole($userId) {
        $stmt = $this->pdo->prepare("SELECT role FROM users WHERE id = ?");
        $stmt->execute([$userId]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user ? $user['role'] : null;
    }
}
?>
