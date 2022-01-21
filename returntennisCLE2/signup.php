<?php
// check if form is submitted by user and needs to be handled
if(isset($_POST['submit'])) {


//    make connection to database
require_once "includes/database.php";

/** @var mysqli $db */
// postback with the user for data and also set sql injection protection
$email = mysqli_escape_string($db, $_POST['email']);
$name = mysqli_escape_string($db, $_POST['name']);
$password = mysqli_escape_string($db, $_POST['password']);



// code for user input validation, check if al the forms are entered

$errors = [];
if($email == '') {
$errors['email'] = 'Voer uw e-mailadres in';
}

if($name == '') {
        $errors['name'] = 'Voer uw naam in';
    }
if($password == '') {
$errors['password'] = 'Voer een wachtwoord in';
}


// see if the error function is empty

if(empty($errors)) {

    // hash the password for better security
$password = password_hash($password, PASSWORD_DEFAULT);
// query to store the entered form in the database
$query = "INSERT INTO users (email, name, password) VALUES ('$email', '$name', '$password')";

$result = mysqli_query($db, $query)
or die('Db Error: '.mysqli_error($db).' with query: '.$query);

// if no errors direct user to login page
if ($result) {
header('Location: login.php');
exit;
}
}
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/style.css"/>
    <title>Registreren</title>
</head>
<body>



<div class="signupBox"


<img src="rtlogo.png" class="logo" alt="rtlogo">

<h2>Nieuwe gebruiker registeren</h2>


<form action="" method="post">
    <div class="data-field">
        <label for="email">Email</label>
        <input id="email" type="text" name="email" value="<?= $email ?? '' ?>"/>
        <span class="errors"><?= $errors['email'] ?? '' ?></span>
    </div>


    <div class="data-field">
        <label for="name">Name</label>
        <input id="name" type="text" name="name" value="<?= $name ?? '' ?>"/>
        <span class="errors"><?= $errors['name'] ?? '' ?></span>
    </div>
    <div class="data-field">
        <label for="password">Wachtwoord</label>
        <input id="password" type="password" name="password" value="<?= $password ?? '' ?>"/>
        <span class="errors"><?= $errors['password'] ?? '' ?></span>
    </div>
    <div class="data-submit">
        <input type="submit" name="submit" value="Registreren"/>
    </div>
</form>
</div>
</body>
</html>













</div>

</body>
</html>