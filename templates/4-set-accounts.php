<?php 
    include_once "../init.php";
    if ($getFromU->loggedIn() === false) {
        header('Location: ../index.php');
    }

    // Initialize the Accounts class
    include_once 'skeleton.php'; 
    $getFromA = new Accounts($pdo); // Initialize Accounts class with database connection

    $error = ''; // Variable to hold error messages
    $successMessage = ''; // Variable to hold success messages

    // Check for existing accounts
    $user_id = $_SESSION['UserId'];
    $existingAccounts = $getFromA->getAccounts($user_id); // Fetch existing accounts

    if (isset($_POST['enteraccount'])) {
        $account = trim($_POST['account']);

        // Validate account input to allow only words/characters
        if (empty($account) || !preg_match("/^[a-zA-Z ]+$/", $account)) {
            $error = 'Please enter a valid account name (letters only).';
        } elseif ($getFromA->checkAccountExists($user_id, $account)) {
            $error = 'Account already exists. Please enter a different account.';
        } else {
            // Insert the new account
            $getFromA->setAccount($user_id, $account);

            // Set success message
            $successMessage = 'Account added successfully: ' . htmlspecialchars($account);
        }
    }
?>

<div class="wrapper">
    <div class="row">
        <div class="col-12 col-m-12 col-sm-12">
            <div class="card">
                <div class="counter" style="height: 40vh; display: flex; align-items: center; justify-content: center;">
                    <form action="" method="post">
                        <p style="font-size: 1.4em; color:black; font-family:'Source Sans Pro'">
                            Enter your account:
                        </p><br>
                        <input type='text' name="account" class="text-input" style="color:black; font-size: 1.2em; background: rgba(0,0,0,0); text-align: center; border: none; outline: none; border-bottom: 2px solid black;" required/><br><br>
                        
                        <!-- Display errors or success messages -->
                        <?php if ($error): ?>
                            <div style="color: red; font-size: 1em;"><?php echo $error; ?></div>
                        <?php elseif ($successMessage): ?>
                            <div style="color: green; font-size: 1em;"><?php echo $successMessage; ?></div>
                        <?php endif; ?>

                        <br>
                        <button type="submit" name="enteraccount" class="pressbutton">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
