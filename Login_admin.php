<?php
$errors = array();
session_start(); //hello my name abdullah


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $Admin_ID = $_POST['ID'];
    $apassword = $_POST['Password'];  // Corrected this line
       
echo "Admin ID: " . $Admin_ID . "<br>";   

    if (empty($Admin_ID) || empty($apassword)) {
        
        array_push($errors, "Admin_ID and password are required");
    }

    if (count($errors) === 0) {
        include 'DataBase.php';  // Consider a relative path

        // Prepared statement recommended here for security
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
                header("Location: http://localhost:8888/ECAD-Clone/ECAD/homepage.php");
                exit();
            } else {
                array_push($errors, "Invalid password");
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
    <link rel="stylesheet" href="style.css">
    

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
                <br><br>
                <input type="submit" value="Login" class="login" name="login">
                <P>Don't have an account ?  <a href="http://localhost/ECAD/admin_signup.php">Signup here</a></P>
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
