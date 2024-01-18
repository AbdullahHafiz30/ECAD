<?php
$errors = array();
session_start();
include 'DataBase.php';

if (isset($_POST['Login'])) {
    $Consumer_ID = strip_tags($_POST['Consumer_ID']);
    $password = strip_tags($_POST['Password']);

    if (empty($Consumer_ID) || empty($password)) {
        array_push($errors, "Consumer_ID and password are required");
    }

    if (count($errors) === 0) {
        $consumer_check_query = "SELECT * FROM consumer WHERE Consumer_ID ='$Consumer_ID' LIMIT 1";
        $result_consumer = mysqli_query($conn, $consumer_check_query);

        if (mysqli_num_rows($result_consumer) > 0) {
            $consumer_row = mysqli_fetch_assoc($result_consumer);
            $stored_password = $consumer_row['Password'];
            
            if (password_verify($password, $stored_password)) {
                $_SESSION['Consumer_ID'] = $consumer_row['Consumer_ID'];

                header("Location: homepage.php");
                exit();
            } else {
                array_push($errors, "Invalid password");
            }
        } else {
            array_push($errors, "Invalid credentials");
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
    <link rel="stylesheet" href="style.css">
    <title>Consumer Login</title>
</head>

<body>

    <div class="Login">
        <form action="Login_consumer.php" method="POST">
            <h1>Sign in</h1>

            <label for="Consumer_ID">ID</label><br>
            <input type="text" name="Consumer_ID" id="Consumer_ID" placeholder="ID">

            <label>Password</label><br>
            <input type="password" name="Password" id="Password" placeholder="Password">
            <br><br>

            <button type="butten">Login</button>
            <P>Don't have an account? <a href="http://localhost/ECAD/consumer_signup.php">Signup here</a></P>

            <?php
            // if (count($errors) > 0) {
            //     echo '<div class="error">';
            //     foreach ($errors as $error) {
            //         echo $error . '<br>';
            //     }
            //     echo '</div>';
            // }
            ?>
        </form>
    </div>
</body>

</html>
