<?php

// for auth
include_once 'extensions/Auth.php';
$auth = new Auth($pdo);
if ($auth->authenticate($username, $password)) {
    echo "Login successful!";
} else {
    echo "Login failed.";
}




// for budgetreport

require_once 'Report.php';

class BudgetReport extends Report {
    public function generate($startDate = null, $endDate = null) {
        $stmt = $this->pdo->prepare("
            SELECT b.BudgetName, b.Amount, SUM(e.Cost) AS TotalSpent 
            FROM budget b
            LEFT JOIN expense e ON b.BudgetId = e.BudgetId
            WHERE b.UserId = :userId
            AND (:startDate IS NULL OR e.Date >= :startDate)
            AND (:endDate IS NULL OR e.Date <= :endDate)
            GROUP BY b.BudgetId
        ");
        $stmt->bindParam(':userId', $this->userId, PDO::PARAM_INT);
        $stmt->bindParam(':startDate', $startDate, PDO::PARAM_STR);
        $stmt->bindParam(':endDate', $endDate, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}

// Initialize the BudgetReport object
$budgetReport = new BudgetReport($pdo, $_SESSION['UserId']);

// Generate a budget report for a specific date range
$startDate = '2024-01-01';
$endDate = '2024-12-31';
$reportData = $budgetReport->generate($startDate, $endDate);

// Display the budget report
foreach ($reportData as $row) {
    echo "Budget: {$row->BudgetName}, Amount: {$row->Amount}, Total Spent: {$row->TotalSpent}<br>";
}



// for expensereport
include_once 'extensions/ExpenseReport.php';
$expenseReport = new ExpenseReport($pdo);
$expenses = $expenseReport->generate(['UserId' => $_SESSION['UserId'], 'start_date' => '2024-01-01', 'end_date' => '2024-12-31']);
foreach ($expenses as $expense) {
    echo $expense->Item . " - " . $expense->Cost . "<br>";
}



// for expensevalidator
include_once 'extensions/ExpenseValidator.php';
$validator = new ExpenseValidator();
$errors = $validator->validate($_POST);
if (!empty($errors)) {
    foreach ($errors as $error) {
        echo $error . "<br>";
    }
} else {
    echo "Expense is valid.";
}



// for report

abstract class Report {
    protected $pdo;
    protected $userId;

    public function __construct($pdo, $userId) {
        $this->pdo = $pdo;
        $this->userId = $userId;
    }

    abstract public function generate(); // Abstract method for generating reports
}



// for sessionmanager

class SessionManager {
    public static function startSession() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function regenerateSession() {
        session_regenerate_id(true);
    }

    public static function destroySession() {
        session_unset();
        session_destroy();
    }

    public static function isLoggedIn() {
        return isset($_SESSION['UserId']);
    }

    public static function getUserId() {
        return $_SESSION['UserId'] ?? null;
    }
}

?>