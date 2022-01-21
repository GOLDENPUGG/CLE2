<?php


session_start();

// see if the user can enter the page
if (!isset($_SESSION['loggedInUser'])) {
    header("Location: login.php");
    exit;
}
//Get email from  login session
$email = $_SESSION['loggedInUser']['email'];
//Get name from  login session
$email = $_SESSION['loggedInUser']['email'];
/** @var mysqli $db */

// postback if user sumbitted form
if (isset($_POST['submit'])){




    require_once "includes/database.php";




// postback and create varables for the form
    // sql injection protecion

    $timedate = mysqli_escape_string($db, $_POST['timedate']);
    $baan = mysqli_escape_string($db, $_POST['baan']);
    $trainer = mysqli_escape_string($db, $_POST['trainer']);




    require_once "includes/form-validation.php";

    if (empty($errors)) {



        //Save the data from the form to the database
        $query = "INSERT INTO reserveringen (timedate, baan, trainer)
                  VALUES ('$timedate', '$baan', '$trainer')";
        $result = mysqli_query($db, $query) or die('Error: '.mysqli_error($db). ' with query ' . $query);

        if ($result) {
            header('Location: index.php');
            exit;
        } else {
            $errors['db'] = 'Something went wrong in your database query: ' . mysqli_error($db);
        }

        //Close connection
        mysqli_close($db);
    }



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











    <div class="profilename"><?= htmlentities($email) ?></p></div>



    <img src="dropdown.png" class="downprof">




    <div class="editstyle">


        <h3>Nieuwe reservering</h3>


    <form action="" method="post" enctype="multipart/form-data">

    <div class="row">
        <div class="column">




    </div>


    </div>

    <div class="data-field">

        <label for="timedate">Datum & tijd</label>
        <input id="timedate" type="datetime-local" name="timedate" value="<?= isset($timedate) ? htmlentities($timedate) : '' ?>"/>
        <span class="errors"><?= $errors['timedate'] ?? '' ?></span>

    </div>


    <div class="data-field">


        <label for="baan">Tennisbaan</label>
        <input id="baan" type="text" name="baan" value="<?= isset($baan) ? htmlentities($baan) : '' ?>"/>
        <span class="errors"><?= $errors['baan'] ?? '' ?></span>

    </div>


    <div class="data-field">

        <label for="trainer">Kies een trainer</label>

            <input id="trainer" type="radio" name="trainer" value="Anne" /> Anne
        <input id="trainer" type="radio" name="trainer" value="Jeroen" /> Jeroen




    </div>






    <div class="row">
    <div class="data-submit">
        <input type="submit" name="submit" value="Save"/>
    </div>


</form>
    </div>

<div>

    <a href="index.php">Go back to the list</a>
</div>
</body>
</html>
