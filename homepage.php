<?php
session_start();

var_dump($_SESSION);  // Check the session variables

// Check if the user is not logged in
if (isset($_SESSION['Consumer_ID']) && isset($_SESSION['Password'])) {
    // The user is logged in, you can perform actions or display content here
    // For example, you can retrieve user data from the session
    $consumerID = $_SESSION['Consumer_ID'];
    
    // Display a welcome message or any other content
    echo "<p>Welcome, Consumer ID: $consumerID</p>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <title>Dashboard</title>
</head>
<body>
   <!-- The rest of your HTML content -->
   <p>DashBoard</p>
</body>
</html>
