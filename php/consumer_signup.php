<?php
include '../DB/DataBase.php';
include "navbar.php";

error_reporting(E_ALL);
ini_set('display_errors', 1);
$errors = array(
    'name' => '',
    'email' => '',
    'userName' => '',
    'password' => '',
    'phone' => '',
    'EnergyUnitNumber' => '',
    'registration' => ''
);



// Initialize variables to hold the submitted values or empty strings if not set
$submittedValues = array(
    'First_Name' => '',
    'Second_Name' => '',
    'Last_Name' => '',
    'UserName' => '',
    'Email' => '',
    'Password' => '',
    'EnergyUnitNumber' => '',
    'Phone_number' => '',
    'Streat_Name' => '',
    'Building_Number' => '',
    'District' => '',
    'PostalCode' => '',
    'City' => ''
);

if (isset($_POST['submit'])) {
    // Store the submitted values
    foreach ($_POST as $key => $value) {
        $submittedValues[$key] = $value;
    }

    $FirstName = mysqli_real_escape_string($conn, $_POST['First_Name']);
    $SecondName = mysqli_real_escape_string($conn, $_POST['Second_Name']);
    $LastName = mysqli_real_escape_string($conn, $_POST['Last_Name']);
    $phone = mysqli_real_escape_string($conn, $_POST['Phone_number']);
    $UserName = mysqli_real_escape_string($conn, $_POST['UserName']);
    $Email = mysqli_real_escape_string($conn, $_POST['Email']);
    $password1 = mysqli_real_escape_string($conn, $_POST['Password']);
    $EnergyUnitNumber = mysqli_real_escape_string($conn, $_POST['EnergyUnitNumber']);

    // Validation and error handling
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
        $errors['phone'] = "Phone number is required";
    }
    if (empty($EnergyUnitNumber)) {
        $errors['EnergyUnitNumber'] = "Energy unit number is required";
    }

    // Check if user with the same email already exists
    $email_check_query = "SELECT * FROM consumer WHERE Email=?";
    $stmt = mysqli_prepare($conn, $email_check_query);
    mysqli_stmt_bind_param($stmt, "s", $Email);
    mysqli_stmt_execute($stmt);
    $result_email = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result_email) > 0) {
        $errors['email'] = "Email already exists";
    }

    // If no errors, proceed with registration
    if (empty(array_filter($errors))) {
        // Generate a random Consumer_ID
        

        $password_hash = password_hash($password1, PASSWORD_DEFAULT);

        // Insert consumer information using prepared statements
        $sql_consumer = "INSERT INTO consumer (Consumer_ID, First_Name, Second_Name, Last_Name, UserName, Email, Phone_number, Password)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $Consumer_ID = NULL; 
        $stmt = mysqli_prepare($conn, $sql_consumer);
        mysqli_stmt_bind_param($stmt, "isssssss",$Consumer_ID, $FirstName, $SecondName, $LastName, $UserName, $Email, $phone, $password_hash);
        mysqli_stmt_execute($stmt);

        if (mysqli_stmt_affected_rows($stmt) > 0) {
            session_start();
            $_SESSION['email'] = $Email;
            header("Location: consumer_dashboard.php");
        } else {
            $errors['registration'] = "Error: " . mysqli_error($conn);
        }

        mysqli_stmt_close($stmt);

        // Insert house information
        $StreetName = mysqli_real_escape_string($conn, $_POST['Streat_Name']);
        $BuildingNumber = mysqli_real_escape_string($conn, $_POST['Building_Number']);
        $District = mysqli_real_escape_string($conn, $_POST['District']);
        $PostalCode = mysqli_real_escape_string($conn, $_POST['PostalCode']);
        $City = mysqli_real_escape_string($conn, $_POST['City']);


        $sql_house = "INSERT INTO house (Streat_Name, City, Building_Number, District, Postal_Code, EnergyUnitNumber, Consumer_ID) 
        VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql_house);
        mysqli_stmt_bind_param($stmt, "ssisssi", $StreetName, $City, $BuildingNumber, $District, $PostalCode, $EnergyUnitNumber, $Consumer_ID);

        mysqli_stmt_execute($stmt);

        if (mysqli_stmt_affected_rows($stmt) > 0) {
            echo "House information inserted successfully";
        } else {
            $errors['registration'] = "Error: " . mysqli_error($conn);
        }

        mysqli_stmt_close($stmt);

        mysqli_close($conn);
    }
}
?>


<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="Keywords" content="energy consumption, anomaly detection">
    <title>E.C.A.D Consumer Signup page</title>
    <link rel="stylesheet" href="../css/consumer/consumer-signup.css">
</head>

<body>
    <div class="Signup">
        <h1>Consumer Sign Up</h1>
 
        <form action="consumer_signup.php" method="POST">

            <!-- Existing fields -->
            <div class="inp">
                <label>Name</label>
                <span class="error"><?php echo isset($errors['name']) ? $errors['name'] : ''; ?></span><br>

                <input type="text" name="First_Name" placeholder="FirstName" value="<?php echo htmlspecialchars($submittedValues['First_Name']); ?>">
                <input type="text" name="Second_Name" placeholder="MiddleName" value="<?php echo htmlspecialchars($submittedValues['Second_Name']); ?>">
                <input type="text" name="Last_Name" placeholder="LastName" value="<?php echo htmlspecialchars($submittedValues['Last_Name']); ?>">

                <label>Profile information</label>
                <span class="error"><?php echo isset($errors['userName']) ? $errors['userName'] : ''; ?></span>
                <span class="error"><?php echo isset($errors['email']) ? $errors['email'] : ''; ?></span>
                <span class="error"><?php echo isset($errors['password']) ? $errors['password'] : ''; ?></span>
                <br>
                <input type="text" name="UserName" placeholder="UserName" value="<?php echo htmlspecialchars($submittedValues['UserName']); ?>">
                <input type="email" name="Email" placeholder="Email" value="<?php echo htmlspecialchars($submittedValues['Email']); ?>">
                <input type="password" name="Password" placeholder="Password" value="<?php echo htmlspecialchars($submittedValues['Password']); ?>">
            </div>

            <label>Energy unit number</label>
            <span class="error"><?php echo isset($errors['EnergyUnitNumber']) ? $errors['EnergyUnitNumber'] : ''; ?></span><br>

            <input type="text" name="EnergyUnitNumber" placeholder="" value="<?php echo htmlspecialchars($submittedValues['EnergyUnitNumber']); ?>">

            <label>Phone number</label>
            <span class="error"><?php echo isset($errors['phone']) ? $errors['phone'] : ''; ?></span><br>

            <input type="text" name="Phone_number" placeholder="" value="<?php echo htmlspecialchars($submittedValues['Phone_number']); ?>">

            <div class="inp">
                <label>House information (Optional)</label>
                <input type="text" name="Streat_Name" placeholder="Street Name" value="<?php echo htmlspecialchars($submittedValues['Streat_Name']); ?>">
                <input type="text" name="Building_Number" placeholder="Building Number" value="<?php echo htmlspecialchars($submittedValues['Building_Number']); ?>">
                <input type="text" name="District" placeholder="District" value="<?php echo htmlspecialchars($submittedValues['District']); ?>">
                <input type="text" name="PostalCode" placeholder="Postal Code" value="<?php echo htmlspecialchars($submittedValues['PostalCode']); ?>">
                <input type="text" name="City" placeholder="City" value="<?php echo htmlspecialchars($submittedValues['City']); ?>">
            </div>

            <br><input type="submit" value="Sign Up" name='submit'>
            <P>Already Signed up? <a href="consumer_signin.php">Login here</a></P>
        </form>
    </div>
</body>

</html>
