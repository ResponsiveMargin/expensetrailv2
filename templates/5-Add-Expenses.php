<?php 
    include_once "../init.php";

    // Set the correct timezone
    date_default_timezone_set('Asia/Manila'); // Change this to your local timezone

    // User login checker
    if ($getFromU->loggedIn() === false) {
        header('Location: ../index.php');
    }

    include_once 'skeleton.php'; 

    // Initialize Accounts class to fetch user's accounts
    $getFromA = new Accounts($pdo);
    $user_id = $_SESSION['UserId'];
    $accounts = $getFromA->getAccounts($user_id); // Fetch all accounts for the user

    $error = ''; // Variable to hold error messages
    $successMessage = ''; // Variable to hold success messages
    $currentDate = ''; // Variable to hold the current date when expense is added

    if (isset($_POST['addexpense'])) {
        // Automatically set the current date and time with timezone
        $dt = date("Y-m-d H:i:s"); // This is the current date and time
        $account = $_POST['account']; // Selected account from dropdown
        $itemcost = $_POST['costitem'];

        // Validate item cost input
        if (!is_numeric($itemcost) || $itemcost < 0) {
            $error = 'Please enter a valid positive number for the cost of the item.';
        } else {
            // Create expense record
            $getFromE->create("expense", array('UserId' => $_SESSION['UserId'], 'Item' => $account, 'Cost' => $itemcost, 'Date' => $dt));
            $successMessage = 'Expense added successfully';
            $currentDate = $dt; // Store the current date to display later
        }
    }
?>

<div class="wrapper">
    <div class="row">
        <div class="col-12 col-m-12 col-sm-12">
            <div class="card">
                <div class="counter" style="height: 60vh; display: flex; align-items: center; justify-content: center;">
                    <form action="" method="post">
                        <div>
                            <label style="font-family: 'Source Sans Pro'; font-size: 1.3em;">Account:</label><br>
                            <select name="account" class="text-input" required="true" style="width: 100%; padding-top: 10px;">
                                <option value="" disabled selected>Select Account</option>
                                <?php foreach ($accounts as $account): ?>
                                    <option value="<?php echo htmlspecialchars($account->account_name); ?>">
                                        <?php echo htmlspecialchars($account->account_name); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select><br><br>
                        </div>
                        <div>
                            <label style="font-family: 'Source Sans Pro'; font-size: 1.3em;">Cost of Item:</label><br>
                            <input class="text-input" type="text" name="costitem" required="true" style="width: 100%; padding-top: 10px;"><br><br>
                            <?php if ($error): ?>
                                <div style="color: red; font-size: 1em;"><?php echo $error; ?></div>
                            <?php elseif ($successMessage): ?>
                                <div style="color: green; font-size: 1em;"><?php echo $successMessage; ?></div>
                                <div style="color: green; font-size: 1em;">Date added: <?php echo date("F j, Y, g:i a", strtotime($currentDate)); ?></div>
                            <?php endif; ?>
                        </div>
                        <div><br>
                            <button type="submit" class="pressbutton" name="addexpense">Add</button>
                        </div>                                
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
