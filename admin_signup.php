<?php
$errors = array();
session_start();
include 'DataBase.php';

// my name is abdullah hafiz

if (isset($_POST['submit'])) {
    $FirstName = mysqli_real_escape_string($conn, $_POST['First_Name']);
    $SecondName = mysqli_real_escape_string($conn, $_POST['Second_Name']);
    $LastName = mysqli_real_escape_string($conn, $_POST['Last_Name']);
    $Admin_ID = mysqli_real_escape_string($conn, $_POST['Admin_ID']);
    $phone = mysqli_real_escape_string($conn, $_POST['Phone_number']);
    $UserName = mysqli_real_escape_string($conn, $_POST['UserName']);
    $Email = mysqli_real_escape_string($conn, $_POST['Email']);
    $password1 = mysqli_real_escape_string($conn, $_POST['Password']);

    if (empty($FirstName) || empty($SecondName) || empty($LastName) || empty($Email) || empty($UserName) || empty($password1) || empty($phone)) {
        array_push($errors, "All fields are required");
    }
    if (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
        array_push($errors, "Email is not valid");
    }
    if (strlen($password1) < 8) {
        array_push($errors, "Password must be at least 8 characters long");
    }

    // Check if user with the same email or Admin_ID already exists
    $email_check_query = "SELECT * FROM admin WHERE Email='$Email' LIMIT 1";
    $Admin_ID_check_query = "SELECT * FROM admin WHERE Admin_ID='$Admin_ID' LIMIT 1";
    $result_email = mysqli_query($conn, $email_check_query);
    $result_ID = mysqli_query($conn, $Admin_ID_check_query);

    if (mysqli_num_rows($result_email) > 0) {
        array_push($errors, "Email already exists");
    }
    if (mysqli_num_rows($result_ID) > 0) {
        array_push($errors, "Admin_ID already exists");
    } else {
        $password_hash = password_hash($password1, PASSWORD_DEFAULT);

        // Prepare and execute the INSERT query
        $sql_admin = "INSERT INTO admin (Admin_ID,First_Name, Second_Name, Last_Name, UserName, Email, Phone_number, Password) VALUES ('$Admin_ID','$FirstName', '$SecondName', '$LastName','$UserName','$Email', '$phone', '$password_hash')";
        mysqli_query($conn, $sql_admin);
        echo $sql_admin;
        if (mysqli_query($conn, $sql_admin)) {
            echo "Record inserted successfully";
        } else {
            echo "Error: " . $sql_admin . "<br>" . mysqli_error($conn);
        }

        mysqli_close($conn);
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta name="viewreport" content="width=device-width, initial-scale=1.0">
    <meta name="Keywords" content="energy consumption , anomaly detection">
    <title>E.C.A.D Admin Signup page</title>
    <link rel="stylesheet" href="style2.css">
</head>

<body>

    <div class="Signup">
        <h1>Admin Sign Up</h1>
        <?php
        if (count($errors) > 0) {
            foreach ($errors as $error) {
                echo "<div class='printErrors'>$error</div>";
            }
        }
        ?>
        <form action="admin_signup.php" method="POST">
            <div class="inp">
                <label>Name</label><br>
                <input type="text" name="First_Name" placeholder="FirstName">
                <input type="text" name="Second_Name" placeholder="MiddleName">
                <input type="text" name="Last_Name" placeholder="LastName">
                <br>


                <label>Profile information</label><br>
                <input type="text" name="UserName" placeholder="UserName">
                <input type="email" name="Email" placeholder="Email">
                <input type="password" name="Password" placeholder="Password">
                <br>
            </div>
            <label>Admin ID</label><br>
            <input type="text" name="Admin_ID" placeholder="Admin_ID">
            <br>
            <label>Phone number</label><br>
            <input type="text" name="Phone_number" placeholder="Phone">
            <br>


            <br><br><input type="submit" value="Sign Up" name='submit'>
            <P>Already Signed up? <a href="http://localhost/ECAD/Login_admin.php">Login here</a></P>

        </form>
    </div>

</body>

</html>