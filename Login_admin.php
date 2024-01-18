<?php
session_start();
$errors = array();

if (isset($_POST['login'])) {
    $Admin_ID = strip_tags($_POST['Admin_ID']);
    $password = strip_tags($_POST['Password']);

    if (empty($Admin_ID) || empty($password)) {
        array_push($errors, "Admin_ID and password are required");
    }

    if (count($errors) === 0) {
        include 'C:\MAMP\htdocs\ECAD\DataBase.php';

        $stmt = $conn->prepare("SELECT * FROM admin WHERE Admin_ID = ?");
        $stmt->bind_param("s", $Admin_ID);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $admin_row = $result->fetch_assoc();
            $stored_password = $admin_row['Password'];

            if (password_verify($password, $stored_password)) {
                $_SESSION['Admin_ID'] = $Admin_ID;
                header("Location: [Your Dashboard Page]"); // Redirect to a specific page
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
