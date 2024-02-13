<?php
$errors = array();
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $Email = $_POST['Email'];
    $cpassword = $_POST['Password'];

    if (empty($Email) || empty($cpassword)) {
        $errors[] = "Email and password are required";
    }

    if (empty($errors)) {
        include 'DataBase.php';  // Consider a relative path

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
                $_SESSION['Email'] = $Email;
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
    <link rel="stylesheet" href="consumer-signin.css">
    <link rel="stylesheet" href="navbar.css">
    <title>Consumer Sign In</title>
</head>

<body>
    <header>
        <div class="mark">
            E.C.A.D
        </div>

        <nav class="navigation">
            <button onclick="window.location.href='index.php'" class="home">Home</button>
            <button onclick="window.location.href='Admin_Page.php'" class="Sbtnlgoin">Admin</button>
            <button onclick="window.location.href='Consumer_Page.php'" class="Sbtnlgoin">Consumer</button>
        </nav>
    </header>

    <div class="Login">
        <form action="consumer_signin.php" method="POST">
            <h1>Sign In</h1>

            <label for="Email">Email</label><br>
            <span class="error">
                <?php echo isset($errors) ? implode("<br>", $errors) : ''; ?>
            </span>
            <input type="email" name="Email" id="Email" placeholder="Email"
                value="<?php echo htmlspecialchars($Email); ?>">
            <label for="Password">Password</label><br>
            <input type="password" name="Password" id="Password" placeholder="Password"
                value="<?php echo htmlspecialchars($cpassword); ?>">
            <br><br>
            <input type="submit" value="Login" class="login" name="login">
            <p>Don't have an account? <a href="consumer_signup.php">Signup here</a></p>
        </form>
    </div>
</body>

</html>