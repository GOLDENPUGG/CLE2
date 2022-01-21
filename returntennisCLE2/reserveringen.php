<?php

// Start session for secure page for user
session_start();

// see if the user can enter the page
if (!isset($_SESSION['loggedInUser'])) {
    header("Location: login.php");
    exit;
}


//Get email from session this wil get the email linked on the user email
$email = $_SESSION['loggedInUser']['email'];


/** @var mysqli $db */

// make database connection
require_once "includes/database.php";

//Get results from de database
$query = "SELECT * FROM reserveringen";
$result = mysqli_query($db, $query) or die ('Error: ' . $query );


// Make a list to show the userdata from the database
$leden = [];
while ($row = mysqli_fetch_assoc($result)) {
    $leden[] = $row;
}

//Close database  connection
mysqli_close($db);
?>






<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css" integrity="sha512-NhSC1YmyruXifcj/KFRWoC561YpHpc5Jtzgvbuzx5VozKpWvQ+4nXhPdFgmx8xqexRcpAglTj9sIBWINXa8x5w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp" rel="stylesheet">
    <title>Login</title>
</head>




<body>



<div class="sidenav">


    <img src="rtlogo.png" class="logo1">



    <a href="index.php">Home</a>
    <a class="active" href="">Reserveringen</a>
    <a href="">Lessen</a>
    <a href="">Trainers</a>
    <a href="">Info</a>



    <a href="logout.php">
        <img src="logout.png" class="logo3">
    </a>


</div>





<div class="main">




    <a class="btn" href="create.php">Nieuwe Reservering</a>







<


// This wil show the profile name of user. This wil show the email.
    // this is also xss protected with htmlentities
    <div class="profilename"><?= htmlentities($email)?></p></div>



    <img src="dropdown.png" class="downprof">






    <h1>Deze week</h1>


// make a loop to show the user the arrays from the database
    <?php foreach ($leden as $leden) { ?>



    <div class="rowlist">
        <div class="columnlist">
            <div class="card">

                <h2>Tennisles</h2>

                <p>Datum & tijd: <?= $leden['timedate'] ?></p>
                <p>Tennisbaan: <?= $leden['baan'] ?></p>
                <p>Trainer: <?= $leden['trainer'] ?></p>


                <td><a href="edit.php?id=<?=$leden['id'] ?>">Wijzigen</a></td>
                <td><a href="delete.php?id=<?= $leden['id'] ?>">Annuleren</a></td>




            </div>
        </div>





        <?php } ?>






</body>
</html>