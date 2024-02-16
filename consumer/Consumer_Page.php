<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/card.css">
    <title>Consumer</title>
</head>

<body>
    <header>
        <div class="mark">
            E.C.A.D
        </div>

        <nav class="navigation">
            <button onclick="window.location.href='../index.php'" class="home">Home</button>
            <button onclick="window.location.href='../admin/Admin_Page.php'" class="Sbtnlgoin">Admin</button>
            <button onclick="window.location.href='../consumer/Consumer_Page.php'"class="Sbtnlgoin">Consumer</button>
        </nav>
    </header>


    <div class="card-container">
        <!-- Admin Signup Card -->
        <div class="card" onclick="window.location.href='consumer_signup.php'">
            <h2>Consumer</h2><h2>Sign Up</h2>
            <!-- Add your signup form here -->
        </div>

        <!-- Admin Login Card -->
        <div class="card" onclick="window.location.href='consumer_signin.php'">
            <h2>Consumer</h2><h2>Sign In</h2>
            <!-- Add your login form here -->
        </div>
    </div>
</body>

</html>