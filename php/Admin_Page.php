<?php include "navbar.php"; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/card.css">
    <title>Admin</title>
</head>

<body>
    
    <div class="card-container">
        <!-- Admin Signup Card -->
        <div class="card" onclick="window.location.href='admin_signup.php'">
            <h2>Admin</h2>
            <h2>Sign Up</h2>
            <!-- Add your signup form here -->
        </div>

        <!-- Admin Login Card -->
        <div class="card" onclick="window.location.href='admin_signin.php'">
            <h2>Admin</h2>
            <h2>Sign In</h2>
            <!-- Add your login form here -->
        </div>
    </div>
</body>

</html>