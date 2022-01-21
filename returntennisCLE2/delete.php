<?php

// this wil make the page secure after login
session_start();

// see if the user can enter the page
if (!isset($_SESSION['loggedInUser'])) {
    header("Location: login.php");
    exit;
}


//Get email from session
$email = $_SESSION['loggedInUser']['email'];

/** @var mysqli $db */

// make connection to database
require_once "includes/database.php";

// see if userdata is submitted
if (isset($_POST['submit'])) {

    // get the existing userdata from the database
    $ledenid = mysqli_escape_string($db, $_POST['id']);
    $query = "SELECT * FROM reserveringen WHERE id = '$ledenid'";
    $result = mysqli_query($db, $query) or die ('Error: ' . $query);

    $album = mysqli_fetch_assoc($result);



    // Query to delete the data from the database with the existing id

    $query = "DELETE FROM reserveringen WHERE id = '$ledenid'";
    mysqli_query($db, $query) or die ('Error: ' . mysqli_error($db));

    //Close  database connection
    mysqli_close($db);

    //Redirect to homepage after deletion & exit script
    header("Location: index.php");
    exit;

} else if (isset($_GET['id']) || $_GET['id'] != '') {

    $ledenid = mysqli_escape_string($db, $_GET['id']);


    $query = "SELECT * FROM reserveringen WHERE id = '$ledenid'";
    $result = mysqli_query($db, $query) or die ('Error: ' . $query);

    if (mysqli_num_rows($result) == 1) {
        $leden = mysqli_fetch_assoc($result);
    } else {

        header('Location: index.php');
        exit;
    }
} else {
    // Id was not present in the url OR the form was not submitted

    // redirect to index.php
    header('Location: index.php');
    exit;
}
?>

<!doctype html>
<html lang="en">
<head>
    <title>Nieuw lid</title>
    <meta charset="utf-8"/>
    <link rel="stylesheet" type="text/css" href="css/style.css"/>
</head>
<body>

<?php if (isset($errors['db'])) { ?>
    <div><span class="errors"><?= $errors['db']; ?></span></div>
<?php } ?>



<div class="sidenav">


    <img src="rtlogo.png" class="logo1">



    <a href="index.php">Home</a>
    <a class="active" href="">Reserveringen</a>
    <a href="">Lessen</a>
    <a href="">Trainers</a>
    <a href="">Info</a>



    <<a href="logout.php">
        <img src="logout.png" class="logo3">
    </a>


</div>





<div class="main">
















    <div class="profilename"><?= $email ?></p></div>



    <img src="dropdown.png" class="downprof">










    <div class="deletestyle">


        <h2><?= $leden['timedate'] ?></h2>


        <form action="" method="post" enctype="multipart/form-data">

            <div class="row">
                <div class="column">



                   <p>
                    Weet u zeker dat u deze tennisles wilt annuleren <?= $leden['timedate'] ?> ?
                    </p>
                    <input type="hidden" name="id" value="<?= $leden['id'] ?>"/>
                    <input type="submit" name="submit" value="Annuleren"/>





                </div>


            </div>






            <div>
                <a href="reserveringen.php">Go back to the list</a>
            </div>

</body>



        </form>
    </div>


</html>
