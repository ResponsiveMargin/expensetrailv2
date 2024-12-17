<!-- Abstraction -->
<?php
require_once 'Report.php';

class BudgetReport extends Report {
    public function generate($params) {
        $query = "SELECT * FROM budget WHERE UserId = :UserId";
        return $this->fetchData($query, [':UserId' => $params['UserId']]);
    }
}
?>
