<?php  
  class Accounts extends Base {
    function __construct($pdo) {
      $this->pdo = $pdo;
    }

    // To set an account
    public function setAccount($user_id, $account_name) {
      $stmt = $this->pdo->prepare("INSERT INTO accounts(user_id, account_name) VALUES(:user_id , :account_name)");
      $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
      $stmt->bindParam(":account_name", $account_name, PDO::PARAM_STR);
      $stmt->execute();
    }

    // To check if account already exists
    public function checkAccountExists($user_id, $account_name) {
      $stmt = $this->pdo->prepare("SELECT * FROM accounts WHERE user_id = :user_id AND account_name = :account_name");
      $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
      $stmt->bindParam(":account_name", $account_name, PDO::PARAM_STR);
      $stmt->execute();
      return $stmt->fetch(PDO::FETCH_OBJ) ? true : false;
    }

    // To get all accounts for a user
    public function getAccounts($user_id) {
      $stmt = $this->pdo->prepare("SELECT account_name FROM accounts WHERE user_id = :user_id");
      $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
      $stmt->execute();
      return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
  }
?>
