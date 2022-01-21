<?php

session_start();

// see if the user can enter the page
if (!isset($_SESSION['loggedInUser'])) {
    header("Location: login.php");
    exit;
}


// Get name from session
$email = $_SESSION['loggedInUser']['email'];

/** @var mysqli $db */

// maak database connectie
require_once "includes/database.php";

//haal resultaten uit database
$query = "SELECT * FROM reserveringen";
$result = mysqli_query($db, $query) or die ('Error: ' . $query );



$leden = [];
while ($row = mysqli_fetch_assoc($result)) {
    $leden[] = $row;
}

//Close connection
mysqli_close($db);
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css" integrity="sha512-NhSC1YmyruXifcj/KFRWoC561YpHpc5Jtzgvbuzx5VozKpWvQ+4nXhPdFgmx8xqexRcpAglTj9sIBWINXa8x5w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/style.css">
    <title>Home</title>
</head>




<body>



<div class="sidenav">


    <img src="rtlogo.png" class="logo1">



    <a class="active" href="">Home</a>
    <a href="reserveringen.php">Reserveringen</a>
    <a href="">Lessen</a>
    <a href="">Trainers</a>
    <a href="">Info</a>


    <a href="logout.php">
        <img src="logout.png" class="logo3">
    </a>



</div>





<div class="main">







    <div class="profilename"><?= htmlentities($email) ?></p></div>




    <img src="dropdown.png" class="downprof">






    <h1>Deze week</h1>


    <?php foreach ($leden as $leden) { ?>
    <tbody>





    <div class="rowlist">
        <div class="columnlist">
            <div class="card">

                <h2>Tennisles</h2>

                <p>Datum & tijd: <?= $leden['timedate'] ?></p>
                <p>Tennisbaan: <?= $leden['baan'] ?></p>
                <p>Trainer: <?= $leden['trainer'] ?></p>



            </div>
        </div>






        <?php } ?>








</div>




</body>
</html>