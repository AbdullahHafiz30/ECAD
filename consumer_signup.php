<?php
$errors = array();
session_start();
include 'DataBase.php';

if (isset($_POST['submit'])) {
    $FirstName = mysqli_real_escape_string($conn, $_POST['First_Name']);
    $SecondName = mysqli_real_escape_string($conn, $_POST['Second_Name']);
    $LastName = mysqli_real_escape_string($conn, $_POST['Last_Name']);
    $phone = mysqli_real_escape_string($conn, $_POST['Phone_number']);
    $UserName = mysqli_real_escape_string($conn, $_POST['UserName']);
    $Email = mysqli_real_escape_string($conn, $_POST['Email']);
    $password1 = mysqli_real_escape_string($conn, $_POST['Password']);
    $EnergyUnitNumber = mysqli_real_escape_string($conn, $_POST['EnergyUnitNumber']);

    if (empty($FirstName) || empty($SecondName) || empty($LastName) || empty($Email) || empty($UserName) || empty($password1) || empty($phone) || empty($EnergyUnitNumber)) {
        array_push($errors, "All fields are required");
    }
    if (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
        array_push($errors, "Email is not valid");
    }
    if (strlen($password1) < 8) {
        array_push($errors, "Password must be at least 8 characters long");
    }

    // Check if user with the same email already exists
    $email_check_query = "SELECT * FROM consumer WHERE Email='$Email' LIMIT 1";
    $result_email = mysqli_query($conn, $email_check_query);

    if (mysqli_num_rows($result_email) > 0) {
        array_push($errors, "Email already exists");
    } else {
        // Generate a random Consumer_ID
        $Consumer_ID = mt_rand(100000, 999999);

        $password_hash = password_hash($password1, PASSWORD_DEFAULT);

        // Insert consumer information
        $sql_consumer = "INSERT INTO consumer (Consumer_ID, First_Name, Second_Name, Last_Name, UserName, Email, Phone_number, Password) 
        VALUES ('$Consumer_ID', '$FirstName', '$SecondName', '$LastName', '$UserName', '$Email', '$phone', '$password_hash')";

        if (mysqli_query($conn, $sql_consumer)) {
            echo "Consumer record inserted successfully";
        } else {
            echo "Error: " . $sql_consumer . "<br>" . mysqli_error($conn);
        }

        // Insert house information
        $StreetName = mysqli_real_escape_string($conn, $_POST['Streat_Name']);
        $BuildingNumber = mysqli_real_escape_string($conn, $_POST['Building_Number']);
        $District = mysqli_real_escape_string($conn, $_POST['District']);
        $PostalCode = mysqli_real_escape_string($conn, $_POST['PostalCode']);
        $City = mysqli_real_escape_string($conn, $_POST['City']);
        $EnergyUnitNumber = mysqli_real_escape_string($conn, $_POST['EnergyUnitNumber']);
        $House_ID = mt_rand(100000, 999999);

        $sql_house = "INSERT INTO house (House_ID, Streat_Name,City,Building_Number, District, Postal_Code,EnergyUnitNumber,Consumer_ID) 
        VALUES ('$House_ID', '$StreetName','$City', '$BuildingNumber', '$District', '$PostalCode','$EnergyUnitNumber','$Consumer_ID')";

        if (mysqli_query($conn, $sql_house)) {
            echo "House information inserted successfully";
        } else {
            echo "Error: " . $sql_house . "<br>" . mysqli_error($conn);
        }

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
    <link rel="stylesheet" href="consumer-signup.css">
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
        <h1>Consumer Sign Up</h1>
        <form action="consumer_signup.php" method="POST">

            <!-- Existing fields -->
            <div class="inp">
                <label>Name</label>
                <input type="text" name="First_Name" placeholder="FirstName">
                <input type="text" name="Second_Name" placeholder="MiddleName">
                <input type="text" name="Last_Name" placeholder="LastName">

                <label>Profile information</label>
                <input type="text" name="UserName" placeholder="UserName">
                <input type="email" name="Email" placeholder="Email">
                <input type="password" name="Password" placeholder="Password">
            </div>

            <label>Energy unit number</label>
            <input type="text" name="EnergyUnitNumber" placeholder="">

            <label>Phone number</label>
            <input type="text" name="Phone_number" placeholder="">

            <div class="inp">
                <label>House information (not mandatory)</label>
                <input type="text" name="Streat_Name" placeholder="Street Name">
                <input type="text" name="Building_Number" placeholder="Building Number">
                <input type="text" name="District" placeholder="District">
                <input type="text" name="PostalCode" placeholder="Postal Code">
                <input type="text" name="City" placeholder="City">
            </div>

            <br><br><input type="submit" value="Sign Up" name='submit'>
            <P>Already Signed up? <a href="http://localhost/ECAD/Login_consumer.php">Login here</a></P>
        </form>
    </div>
</body>

</html>