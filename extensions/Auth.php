<!-- Encapsulation -->
<?php
class Auth {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function authenticate($username, $password) {
        $stmt = $this->pdo->prepare("SELECT UserId FROM user WHERE Username = :username AND Password = :password");
        $stmt->bindValue(':username', htmlspecialchars(trim($username)), PDO::PARAM_STR);
        $stmt->bindValue(':password', md5($password), PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_OBJ);
        if ($user) {
            $_SESSION['UserId'] = $user->UserId;
            return true;
        }
        return false;
    }
}
?>
