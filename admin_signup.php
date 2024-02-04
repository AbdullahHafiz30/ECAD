<?php
$errors = array();
session_start();
include 'DataBase.php';

if (isset($_POST['submit'])) {
    $FirstName = mysqli_real_escape_string($conn, $_POST['First_Name']);
    $SecondName = mysqli_real_escape_string($conn, $_POST['Second_Name']);
    $LastName = mysqli_real_escape_string($conn, $_POST['Last_Name']);
    $Admin_ID = mysqli_real_escape_string($conn, $_POST['Admin_ID']);
    $phone = mysqli_real_escape_string($conn, $_POST['Phone_number']);
    $UserName = mysqli_real_escape_string($conn, $_POST['UserName']);
    $Email = mysqli_real_escape_string($conn, $_POST['Email']);
    $password1 = mysqli_real_escape_string($conn, $_POST['Password']);

    if (empty($FirstName)) {
        array_push($errors, "First Name is required");
    }
    
    if (empty($SecondName)) {
        array_push($errors, "Second Name is required");
    }
    
    if (empty($LastName)) {
        array_push($errors, "Last Name is required");
    }
    
    if (empty($Email)) {
        array_push($errors, "Email is required");
    } elseif (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
        array_push($errors, "Email is not valid");
    }
    
    if (empty($UserName)) {
        array_push($errors, "Username is required");
    }
    
    if (empty($password1)) {
        array_push($errors, "Password is required");
    } elseif (strlen($password1) < 8) {
        array_push($errors, "Password must be at least 8 characters long");
    }
    
    if (empty($phone)) {
        array_push($errors, "Phone is required");
    }

    if (empty($Admin_ID)) {
        array_push($errors, "ID is required");
    }

    // Check if user with the same email or Admin_ID already exists
    $email_check_query = "SELECT * FROM admin WHERE Email='$Email' LIMIT 1";
    $Admin_ID_check_query = "SELECT * FROM admin WHERE Admin_ID='$Admin_ID' LIMIT 1";
    $result_email = mysqli_query($conn, $email_check_query);
    $result_ID = mysqli_query($conn, $Admin_ID_check_query);

    if (mysqli_num_rows($result_email) > 0) {
        array_push($errors, "Email already exists");
    }elseif(mysqli_num_rows($result_ID) > 0) {
        array_push($errors, "Admin_ID already exists");
    } elseif(!empty($FirstName) && !empty($SecondName) && !empty($LastName) && !empty($Email) && !empty($UserName) && !empty($password1) && !empty($phone) && !empty($Admin_ID)){
        $password_hash = password_hash($password1, PASSWORD_DEFAULT);

        // Prepare and execute the INSERT query
        $sql_admin = "INSERT INTO admin (Admin_ID,First_Name, Second_Name, Last_Name, UserName, Email, Phone_number, Password) VALUES ('$Admin_ID','$FirstName', '$SecondName', '$LastName','$UserName','$Email', '$phone', '$password_hash')";
        mysqli_query($conn, $sql_admin);
        if (mysqli_query($conn, $sql_admin)) {
            echo "Record inserted successfully";
        } else {
            //echo "Error: " . $sql_admin . "<br>" . mysqli_error($conn);
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
    <link rel="stylesheet" href="admin-signup.css">
    <link rel="stylesheet" href="navbar.css">
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
            <P>Already Signed up? <a href="http://localhost/ECAD/admin_signin.php">Login here</a></P>

        </form>
    </div>

</body>

</html>