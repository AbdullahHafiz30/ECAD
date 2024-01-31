<?php
$errors = array();
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $Consumer_ID = 910955;
    $cpassword = 123456789;

    echo "Consumer ID: " . $Consumer_ID . "<br>";
    echo "Password: " . $cpassword . "<br>";

    if (empty($Consumer_ID) || empty($cpassword)) {
        array_push($errors, "Consumer_ID and password are required");
    }

    if (count($errors) === 0) {
        include 'DataBase.php';  // Consider a relative path

        // Prepared statement recommended here for security
        $consumer_check_query = "SELECT * FROM consumer WHERE Consumer_ID=? LIMIT 1";
        $stmt = $conn->prepare($consumer_check_query);
        $stmt->bind_param("s", $Consumer_ID);
        $stmt->execute();
        $result_consumer = $stmt->get_result();

        if ($result_consumer->num_rows > 0) {
            $consumer_row = $result_consumer->fetch_assoc();
            $stored_password = $consumer_row['Password'];

            if (password_verify($cpassword, $stored_password)) {
                $_SESSION['Consumer_ID'] = $Consumer_ID;
                header("Location: http://localhost:8888/ECAD-Clone/ECAD/homepage.php");
                exit();
            } else {
                array_push($errors, "Invalid password");
            }
        } else {
            array_push($errors, "Consumer ID not found");
        }

        mysqli_close($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style1.css">
    <link rel="stylesheet" href="navbar.css">
    <title>Consumer Sign In</title>
</head>

<body>
    <header>
        <div class="mark">
            E.C.A.D
        </div>

        <nav class="navigation">
            <button onclick="window.location.href='//localhost/ECAD/Landing_Page.php'" class="home">Home</button>
            <button onclick="window.location.href='//localhost/ECAD/Admin_Page.php'" class="Sbtnlgoin">Admin</button>

            <button onclick="window.location.href='//localhost/ECAD/Consumer_Page.php'"
                class="Sbtnlgoin">Consumer</button>
        </nav>
    </header>

    <div class="Login">
        <form action="Login_consumer.php" method="POST">
            <h1>Sign In</h1>

            <label for="Consumer_ID">ID</label><br>
            <input type="text" name="Consumer_ID" id="Consumer_ID" placeholder="ID">

            <label>Password</label><br>
            <input type="password" name="Password" id="Password" placeholder="Password">
            <br><br>

            <input type="submit" value="Login" class="login" name="login">
            <p>Don't have an account ? <a href="http://localhost/ECAD/consumer_signup.php">Signup here</a></p>
        </form>
    </div>
</body>

</html>