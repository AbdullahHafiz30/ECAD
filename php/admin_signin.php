<?php
include "navbar.php";


$errors = array(); // Initialize $errors as an array
session_start(); 

// Initialize variables to hold submitted values
$submitted_ID = isset($_POST['ID']) ? $_POST['ID'] : '';
$submitted_Password = isset($_POST['Password']) ? $_POST['Password'] : '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $Admin_ID = $submitted_ID;
    $apassword = $submitted_Password;

    if (empty($Admin_ID)) {
        $errors[] = "ID is required"; // Append errors to the $errors array
    }
    if (empty($apassword)) {
        $errors[] = "Password is required"; // Append errors to the $errors array
    }

    if (count($errors) == 0) {
        include '../DB/DataBase.php'; // Ensure the path is correct

        $admin_check_query = "SELECT * FROM admin WHERE Admin_ID=? LIMIT 1";
        $stmt = $conn->prepare($admin_check_query);
        $stmt->bind_param("s", $Admin_ID);
        $stmt->execute();
        $result_admin = $stmt->get_result();

        if ($result_admin->num_rows > 0) {
            $admin_row = $result_admin->fetch_assoc();
            $stored_password = $admin_row['Password'];

            if (password_verify($apassword, $stored_password)) {
                $_SESSION['Admin_ID'] = $Admin_ID;
                header("Location: admin_dashboard.php");
                exit();
            } else {
                $errors[] = "Incorrect ID or password"; // Append errors to the $errors array
            }
        } else {
            $errors[] = "Incorrect ID or password"; // Append errors to the $errors array
        }

        $stmt->close(); 
        $conn->close(); 
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/admin/admin-signin.css">
    <title>E.C.A.D Admin Sign In</title>
</head>
<body>
    <div class="Login">
        <form action="" method="POST">
            <h1>Sign in</h1>

            <label for="Admin_ID">ID</label><br>
            <span class="error"><?php echo isset($errors) ? implode("<br>",$errors) : ''; ?></span>
            <input type="text" name="ID" id="Admin_ID" placeholder="ID" value="<?php echo htmlspecialchars($submitted_ID); ?>">
            <label>Password</label><br>
            <input type="password" name="Password" id="Password" placeholder="Password" value="<?php echo htmlspecialchars($submitted_Password); ?>">
            <br><br>
            <input type="submit" value="Login" class="login" name="login">
            <p>Don't have an account? <a href="admin_signup.php">Signup here</a></p>

        </form>
    </div>
</body>
</html>
