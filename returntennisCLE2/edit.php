<?php


session_start();

// see if the user can enter the page
if (!isset($_SESSION['loggedInUser'])) {
    header("Location: login.php");
    exit;
}

// Get email from  login session
$email = $_SESSION['loggedInUser']['email'];
require_once('includes/database.php');


// Get method to select id from table
$id =  $_GET['id'];
$query = "SELECT * FROM reserveringen where id = $id";
$result = mysqli_query($db, $query);

//  Check if id is in the database
if($result->num_rows != 1){
    header('Location: index.php');

    die('id is not in db');
}



// postback to see if form is submit

if(isset($_POST['update'])) {
    $id = mysqli_escape_string($db, $_GET['id']);
    $timedate = mysqli_escape_string($db, $_POST['timedate']);
    $baan = mysqli_escape_string($db, $_POST['baan']);
    $trainer = mysqli_escape_string($db, $_POST['trainer']);

// update table with new user data from form
    $query = "UPDATE reserveringen SET timedate = '$timedate', baan = '$baan',  trainer = '$trainer' WHERE id=$id";
    $result = mysqli_query($db, $query);
// check if update was succesful
    if ($result) {

        mysqli_close($db);
      header('Location: index.php');
      exit;
      } else {
        $errors['db'] = 'Something went wrong in your database query: ' . mysqli_error($db);


    }


}



?>

<?php
// Get prefilled data from the dstabase

$id = $_GET['id'];
$query = "SELECT * FROM reserveringen WHERE id=$id";
$result = mysqli_query($db, $query);

// make a while loop to get the data from the database
// asign variable to show to the user

while ($data = mysqli_fetch_assoc($result)) {




?>


<!doctype html>
<html lang="en">
<head>
    <title>Edit</title>
    <meta charset="utf-8"/>
    <link rel="stylesheet" type="text/css" href="css/style.css"/>
</head>
<body>
<h1>Aanpassen</h1>
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



    <a href="logout.php">
        <img src="logout.png" class="logo3">
    </a>


</div>





<div class="main">

    <div class="profilename"><?= htmlentities($email)?></p></div>



    <img src="dropdown.png" class="downprof">

    <div class="editstyle">


        <h3>Reservering aanpassen</h3>

        <form action="" method="post" enctype="multipart/form-data">

            <div class="row">
                <div class="column">


                </div>


            </div>

    <div class="data-field">
        <label for="timedate">Datum & tijd</label>
        <input id="timedate" type="datetime-local" name="timedate" value="<?= $data['timedate'], isset($timedate) ? htmlentities($timedate) : '' ?>"/>
        <span class="errors"><?= $errors['timedate'] ?? '' ?></span>
    </div>


    <div class="data-field">
        <label for="baan">Baan</label>
        <input id="baan" type="text" name="baan" value="<?= $data['baan'], isset($baan) ? htmlentities($baan) : '' ?>"/>
        <span class="errors"><?= $errors['baan'] ?? '' ?></span>
    </div>

    <div> <h1>Kies trainer</h1></div>
    <div class="data-field">
        <label for="trainer">Jeroen</label>
        <input id="trainer" type="radio" name="trainer" value="<?= $data['trainer'], isset($trainer) ? htmlentities($trainer) : '' ?>"/>
        <span class="errors"><?= $errors['trainer'] ?? '' ?></span>
    </div>



    <div class="data-field">
        <label for="trainer">Kees</label>
        <input id="trainer" type="radio" name="trainer" value="<?= $data['trainer'], isset($trainer) ? htmlentities($trainer) : '' ?>"/>
        <span class="errors"><?= $errors['trainer'] ?? '' ?></span>
    </div>


            <div class="row">

    <div class="data-submit">
        <input type="submit" name="update" value="Save"/>
    </div>
</form>
    </div>

<div class="backlist">
    <a href="reserveringen.php">Go back to the list</a>
</div>


</body>
</html>
<?php
}
    ?>