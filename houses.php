<?php 
session_start();
include 'DB/DataBase.php';
include 'side-bar.php';
// Fetch and display houses from the database
$Email = $_SESSION['email'] ;
$sql = "SELECT * FROM house WHERE Consumer_ID = (SELECT Consumer_ID FROM consumer WHERE Email = '$Email')";
$result = mysqli_query($conn, $sql);
if ($result) {
    // Debugging output
    var_dump($result->num_rows); // Check the number of rows returned

    $houses = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    echo 'Error: ' . mysqli_error($conn);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/houses.css">
    <title>Houses</title>
    </head>
<body>
    <section class="home">
        <div class="text">
        <div class="container">
        <h2>Houses</h2>
        <?php
        if (!empty($houses)) {
            $hID = 1;
            foreach ($houses as $house) {
                echo "<div class='house'>";
                echo "<h3>House  ".$hID."</h3>";
                echo "<p>Street Name: ".$house['Streat_Name']."</p>";
                echo "<p>City: ".$house['City']."</p>";
                echo "<p>Building Number: ".$house['Building_Number']."</p>";
                echo "<p>District: ".$house['District']."</p>";
                echo "<p>Postal Code: ".$house['Postal_Code']."</p>";
                echo "<p>Energy Unit Number: ".$house['EnergyUnitNumber']."</p>";
                echo "<p>Consumer ID: ".$house['Consumer_ID']."</p>";
                echo "</div>";
                $hID++;
            }
        } else {
            echo "<p>0 houses</p>";
        }
        ?>
    </div>
        </div>
    </section>
    
</body>
</html>
