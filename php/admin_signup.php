<?php
session_start();
include '../DB/DataBase.php';
include "navbar.php";

$errors = array(
    'name' => '', // Consolidated error message for all name fields
    'email' => '',
    'userName' => '',
    'password' => '',
    'phone' => '',
    'adminID' => '',
    'emailExists' => '',
    'adminIDExists' => '',
    'registration' => ''
);

if (isset($_POST['submit'])) {
    // Sanitize user input
    $FirstName = mysqli_real_escape_string($conn, $_POST['First_Name']);
    $SecondName = mysqli_real_escape_string($conn, $_POST['Second_Name']);
    $LastName = mysqli_real_escape_string($conn, $_POST['Last_Name']);
    $Admin_ID = mysqli_real_escape_string($conn, $_POST['Admin_ID']);
    $phone = mysqli_real_escape_string($conn, $_POST['Phone_number']);
    $UserName = mysqli_real_escape_string($conn, $_POST['UserName']);
    $Email = mysqli_real_escape_string($conn, $_POST['Email']);
    $password1 = mysqli_real_escape_string($conn, $_POST['Password']);

    // Validate user input
    if (empty($FirstName) || empty($SecondName) || empty($LastName)) {
        $errors['name'] = "All name fields are required";
    }
    if (empty($Email)) {
        $errors['email'] = "Email is required";
    } elseif (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format";
    }
    if (empty($UserName)) {
        $errors['userName'] = "Username is required";
    }
    if (empty($password1)) {
        $errors['password'] = "Password is required";
    } elseif (strlen($password1) < 8) {
        $errors['password'] = "Password must be at least 8 characters long";
    }
    if (empty($phone)) {
        $errors['phone'] = "Phone is required";
    }
    if (empty($Admin_ID)) {
        $errors['adminID'] = "ID is required";
    }

    // Check for existing email or Admin ID
    $email_check_query = "SELECT * FROM admin WHERE Email='$Email' LIMIT 1";
    $Admin_ID_check_query = "SELECT * FROM admin WHERE Admin_ID='$Admin_ID' LIMIT 1";
    $result_email = mysqli_query($conn, $email_check_query);
    $result_ID = mysqli_query($conn, $Admin_ID_check_query);

    if (mysqli_num_rows($result_email) > 0) {
        $errors['emailExists'] = "Email already exists";
    }
    if (mysqli_num_rows($result_ID) > 0) {
        $errors['adminIDExists'] = "Admin ID already exists";
    }

    // If no errors, proceed with registration
    if (empty(array_filter($errors))) {
        $password_hash = password_hash($password1, PASSWORD_DEFAULT);

        $sql_admin = "INSERT INTO admin (Admin_ID, First_Name, Second_Name, Last_Name, UserName, Email, Phone_number, Password) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql_admin);
        mysqli_stmt_bind_param($stmt, "ssssssss", $Admin_ID, $FirstName, $SecondName, $LastName, $UserName, $Email, $phone, $password_hash);

        if (mysqli_stmt_execute($stmt)) {
            // Registration successful, redirect to dashboard
            header("Location: admin_dashboard.php");
            exit();
        } else {
            $errors['registration'] = "Error: " . mysqli_error($conn);
        }

        mysqli_stmt_close($stmt);
    }

    mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewreport" content="width=device-width, initial-scale=1.0">
    <meta name="Keywords" content="energy consumption , anomaly detection">
    <link rel="stylesheet" href="../css/admin/admin-signup.css">
    <title>E.C.A.D Admin Signup page</title>
</head>
<body>
    <div class="Signup">
        <h1>Admin Sign Up</h1>
        <form action="admin_signup.php" method="POST">
            <div class="inp">
                <label>Name</label>
                <span class="error"><?php echo isset($errors['name']) ? $errors['name'] : ''; ?></span>
                <br>
                <input type="text" name="First_Name" placeholder="FirstName" value="<?php echo isset($_POST['First_Name']) ? $_POST['First_Name'] : ''; ?>">
                <input type="text" name="Second_Name" placeholder="MiddleName" value="<?php echo isset($_POST['Second_Name']) ? $_POST['Second_Name'] : ''; ?>">
                <input type="text" name="Last_Name" placeholder="LastName" value="<?php echo isset($_POST['Last_Name']) ? $_POST['Last_Name'] : ''; ?>">
                <br>
                <label>Profile information</label>
                <span class="error"><?php echo isset($errors['userName']) ? $errors['userName'] : ''; ?></span>
                <span class="error"><?php echo isset($errors['email']) ? $errors['email'] : ''; ?></span>
                <span class="error"><?php echo isset($errors['password']) ? $errors['password'] : ''; ?></span>
                <br>
                <input type="text" name="UserName" placeholder="UserName" value="<?php echo isset($_POST['UserName']) ? $_POST['UserName'] : ''; ?>">
                <input type="email" name="Email" placeholder="Email" value="<?php echo isset($_POST['Email']) ? $_POST['Email'] : ''; ?>">
                <input type="password" name="Password" placeholder="Password" value="<?php echo isset($_POST['Password']) ? $_POST['Password'] : ''; ?>">
                <br>
            </div>
            <label>Admin ID</label>
            <span class="error"><?php echo isset($errors['adminID']) ? $errors['adminID'] : ''; ?></span>
            <br>
            <input type="text" name="Admin_ID" placeholder="Admin_ID" value="<?php echo isset($_POST['Admin_ID']) ? $_POST['Admin_ID'] : ''; ?>">
            <br>
            <label>Phone number</label>
            <span class="error"><?php echo isset($errors['phone']) ? $errors['phone'] : ''; ?></span>
            <br>
            <input type="text" name="Phone_number" placeholder="Phone" value="<?php echo isset($_POST['Phone_number']) ? $_POST['Phone_number'] : ''; ?>">
            <br>
            <br><br><input type="submit" value="Sign Up" name='submit'>
            <P>Already Signed up? <a href="admin_signin.php">Login here</a></P>
        </form>
    </div>
</body>
</html>
