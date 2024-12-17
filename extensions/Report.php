<!-- Abstraction -->
<?php
abstract class Report {
    protected $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Abstract method to be implemented by child classes
    abstract public function generate($params);

    // Common utility for fetching data
    protected function fetchData($query, $params = []) {
        $stmt = $this->pdo->prepare($query);
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}
?>
