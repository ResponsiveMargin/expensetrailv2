<!-- Abstraction -->
<?php
require_once 'Report.php';

class ExpenseReport extends Report {
    public function generate($params) {
        $query = "SELECT * FROM expense WHERE UserId = :UserId AND Date BETWEEN :start AND :end";
        return $this->fetchData($query, [
            ':UserId' => $params['UserId'],
            ':start' => $params['start_date'],
            ':end' => $params['end_date']
        ]);
    }
}
?>
