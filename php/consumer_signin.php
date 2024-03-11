<?php
include "navbar.php";

$errors = array();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $Email = $_POST['Email'];
    $cpassword = $_POST['Password'];

    if (empty($Email) || empty($cpassword)) {
        $errors[] = "Email and password are required";
    }

    if (empty($errors)) {
        include '../DB/DataBase.php';  // Consider a relative path

        // Prepared statement recommended here for security
        $consumer_check_query = "SELECT * FROM consumer WHERE Email=? LIMIT 1";
        $stmt = $conn->prepare($consumer_check_query);

        if (!$stmt) {
            die('Error preparing statement: ' . $conn->error);
        }

        $stmt->bind_param("s", $Email);

        if (!$stmt->execute()) {
            die('Error executing statement: ' . $stmt->error);
        }
        
        $stmt->execute();
        $result_consumer = $stmt->get_result();

        if ($result_consumer->num_rows > 0) {
            $consumer_row = $result_consumer->fetch_assoc();
            $stored_password = $consumer_row['Password'];

            if (password_verify($cpassword, $stored_password)) {
                session_start();
                $_SESSION['email'] = $Email;
                header("Location: consumer_dashboard.php");
                exit();
            } else {
                $errors[] = "Invalid email or password";
            }
        } else {
            $errors[] = "Invalid email or password";
        }

        $stmt->close();
        mysqli_close($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/consumer/consumer-signin.css">
    <title>Consumer Sign In</title>
</head>

<body>

    <div class="Login">
        <form action="consumer_signin.php" method="POST">
            <h1>Sign In</h1>

            <label for="Email">Email</label><br>
            <span class="error"><?php echo isset($errors) ? implode("<br>",$errors) : ''; ?></span>

            <input type="email" name="Email" id="Email" placeholder="Email" value="<?php echo isset($Email) ? htmlspecialchars($Email) : ''; ?>">

            <label for="Password">Password</label><br>
            <input type="password" name="Password" id="Password" placeholder="Password" value="<?php echo isset($cpassword) ? htmlspecialchars($cpassword) : ''; ?>">
            <br><br>
            <input type="submit" value="Login" class="login" name="login">
            <p>Don't have an account? <a href="consumer_signup.php">Signup here</a></p>
        </form>
    </div>
</body>

</html>