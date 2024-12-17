<?php
error_reporting(0); // Suppress all errors
ob_start(); // Start output buffering
require('fpdf.php');
include_once 'init.php';

// User login check
if (!isset($getFromU) || $getFromU->loggedIn() === false) {
    header('Location: ../index.php');
    exit();
}

// Create a new PDF document
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);

// Title
$pdf->Cell(0, 10, 'Expenses incurred between ' . date("d-m-Y", strtotime($_POST['dtfrom'])) . ' and ' . date("d-m-Y", strtotime($_POST['dtto'])), 0, 1, 'C');

// Line break
$pdf->Ln(10);

// Column headers
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(10, 10, '#', 1);
$pdf->Cell(80, 10, 'Desc.', 1);
$pdf->Cell(30, 10, 'Cost', 1);
$pdf->Cell(40, 10, 'Date', 1);
$pdf->Ln();

// Set font for table rows
$pdf->SetFont('Arial', '', 12);

// Initialize the total expenses variable
$total_expenses = 0;
$dtexp = $getFromE->dtwise($_SESSION['UserId'], $_POST['dtfrom'], $_POST['dtto']);
if ($dtexp !== NULL) {
    foreach ($dtexp as $index => $expense) {
        // Sum up the total expenses
        $total_expenses += $expense->Cost;

        // Display individual expenses
        $pdf->Cell(10, 10, ($index + 1), 1);
        $pdf->Cell(80, 10, htmlspecialchars($expense->Item), 1);
        $pdf->Cell(30, 10, 'P ' . htmlspecialchars(number_format($expense->Cost, 2)), 1);
        $pdf->Cell(40, 10, date("d-m-Y", strtotime($expense->Date)), 1);
        $pdf->Ln();    
    }
} else {
    $pdf->Cell(0, 10, 'No expenses found for this date range.', 1, 1, 'C');
}

// Display total expenses
$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, 'Total Expenses: P ' . number_format($total_expenses, 2), 0, 1, 'C');

// Clear output buffer before sending PDF, if needed
if (ob_get_length()) {
    ob_end_clean();
}

// Output the PDF
$pdf->Output('I', 'Expenses_Report.pdf'); // D for download
exit(); // Ensure script stops here
?>
