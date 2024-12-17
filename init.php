<?php 
    session_start();
    include_once 'connection.php';
    include_once 'base.php';
    include_once 'user.php';
    include_once 'expense.php';
    include_once 'budget.php';
    include_once 'accounts.php'; 
    // include_once 'printing.php';

    global $pdo;

    $getFromU = new User($pdo);
    $getFromB = new Budget($pdo);
    $getFromE = new Expense($pdo);
    $getFromA = new Accounts($pdo);  

    define("BASE_URL", "http://localhost/expensetrail/");
?> 