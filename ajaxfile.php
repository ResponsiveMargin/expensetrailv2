<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Check Username</title>
</head>
<body>
    <form method="POST" action="check_username.php">
        <label for="username">Enter Username:</label>
        <input type="text" name="username" id="username" required>
        <button type="submit">Check Availability</button>
    </form>

    <?php
    // Include your initialization script
    include "init.php";

    // Check if the form was submitted
    if (isset($_POST['username'])) {
        $username = $_POST['username'];

        // Check if the username is available
        $result = $getFromU->checkUsername($username);
        $response = "Available.";

        if ($result) {
            $response = "Not Available.";
        }
        echo "<p>$response</p>"; // Display the response
    }
    ?>
</body>
</html>
