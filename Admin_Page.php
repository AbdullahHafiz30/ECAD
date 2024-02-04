<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="navbar.css">
    <link rel="stylesheet" href="card.css">
    <title>Admin</title>
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

    <div class="card-container">
        <!-- Admin Signup Card -->
        <div class="card" onclick="window.location.href='//localhost/ECAD/admin_signup.php'">
            <h2>Admin</h2>
            <h2>Sign Up</h2>
            <!-- Add your signup form here -->
        </div>

        <!-- Admin Login Card -->
        <div class="card" onclick="window.location.href='//localhost/ECAD/admin_signin.php'">
            <h2>Admin</h2>
            <h2>Sign In</h2>
            <!-- Add your login form here -->
        </div>
    </div>
</body>

</html>