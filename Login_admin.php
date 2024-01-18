<?php
$errors = array();

if (isset($_POST['login'])) {
    $Admin_ID = strip_tags($_POST['Admin_ID']);
    $password = strip_tags($_POST['Password']);

    if (empty($Admin_ID) || empty($password)) {
        array_push($errors, "Admin_ID and password are required");
    }

    if (count($errors) === 0) {
        include 'C:\MAMP\htdocs\ECAD\DataBase.php';

        $consumer_check_query = "SELECT * FROM admin WHERE Admin_ID='$Admin_ID' LIMIT 1";
        $result_consumer = mysqli_query($conn, $consumer_check_query);

        if (mysqli_num_rows($result_consumer) > 0) {
            $consumer_row = mysqli_fetch_assoc($result_consumer);

            $password_check_query = "SELECT * FROM admin WHERE Password='$Admin_ID' LIMIT 1";
            $result_password = mysqli_query($conn, $password_check_query);

            if (mysqli_num_rows($result_password) > 0) {
                $password_row = mysqli_fetch_assoc($result_password);
                $stored_password = $password_row['Password'];

                if (password_verify($password, $stored_password)) {
                    session_start();
                    $_SESSION['Admin_ID'] = $Admin_ID;
                    

                    
                    exit();
                } else {
                    array_push($errors, "Invalid password");
                }
            } else {
                array_push($errors, "Password not found");
            }
        } else {
            array_push($errors, "ID not found");
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
    

    <title>Admin Login</title>
</head>

<body>

    <div class="Login">
        <form action="" method="POST">
            
                <h1>Sign in</h1>
                
            

           
                <label for="Admin_ID">ID</label><br>
                <input type="text" name="ID" id="Admin_ID" placeholder="ID">
            
            
                <label>Password</label><br>
                <input type="password" name="Password" id="Password" placeholder="Password">
            <br>
            <br><br>
            
                <input type="submit" value="Login" class="login" name="login">
                <P>Already Signed up? <a href="http://localhost/ECAD/admin_signup.php">Login here</a></P>
                <!-- Add your Signup button or link here -->
            
            <!-- <?php
            if (count($errors) > 0) {
                foreach ($errors as $error) {
                    echo "<div class='printErrors'>$error</div>";
                }
            }
            ?> -->
        </form>
    </div>
</body>

</html>
