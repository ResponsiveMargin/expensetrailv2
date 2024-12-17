<!-- Encapsulation -->
<?php
class ExpenseValidator {
    public function validate($data) {
        $errors = [];

        if (empty($data['Item'])) {
            $errors['Item'] = "Item name cannot be empty.";
        }
        if (empty($data['Cost']) || !is_numeric($data['Cost']) || $data['Cost'] <= 0) {
            $errors['Cost'] = "Invalid cost value.";
        }
        if (empty($data['Date']) || !strtotime($data['Date'])) {
            $errors['Date'] = "Invalid date.";
        }

        return $errors;
    }
}
?>
