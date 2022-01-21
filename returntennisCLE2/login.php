<?php
session_start();

if(isset($_SESSION['loggedInUser'])) {
    $login = true;
} else {
    $login = false;
}

/** @var mysqli $db */
require_once "includes/database.php";

// see if form is submitted by users
if (isset($_POST['submit'])) {
    $email = mysqli_escape_string($db, $_POST['email']);
    $password = $_POST['password'];

    $errors = [];
    if($email == '') {
        $errors['email'] = 'Voer uw e-mailadres in';
    }
    if($password == '') {
        $errors['password'] = 'Voer uw wachtwoord in';
    }

    if(empty($errors))
    {
        //Get record from DB based on first name
        $query = "SELECT * FROM users WHERE email='$email'";
        $result = mysqli_query($db, $query);
        if (mysqli_num_rows($result) == 1) {
            $user = mysqli_fetch_assoc($result);
            if (password_verify($password, $user['password'])) {
                $login = true;

                $_SESSION['loggedInUser'] = [
                    'email' => $user['email'],
                    'id' => $user['id']


                ];
            } else {
                //error onjuiste inloggegevens
                $errors['loginFailed'] = 'De combinatie van email en wachtwoord is bij ons niet bekend';
            }
        } else {
            //error onjuiste inloggegevens
            $errors['loginFailed'] = 'De combinatie van email en wachtwoord is bij ons niet bekend';
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <link rel="stylesheet" href="css/style.css">
    <title>Login</title>
</head>




<body>




<div class="loginBox">
    <img src="rtlogo.png" class="logo" alt="rtlogo">



    <?php if ($login) { ?>

        <p>Je bent ingelogd!</p>
        <p><a href="logout.php">Uitloggen</a> </p>
        <meta http-equiv = "refresh" content = "2; url = index.php" />
    <?php } else { ?>
        <form action="" method="post">
            <div>
                <label for="email">Email</label>
                <input id="email" type="text" name="email" value="<?= $email ?? '' ?>"/>
                <span class="errors"><?= $errors['email'] ?? '' ?></span>
            </div>
            <div>
                <label for="password">Wachtwoord</label>
                <input id="password" type="password" name="password" />
                <span class="errors"><?= $errors['password'] ?? '' ?></span>
            </div>
            <div>
                <p class="errors"><?= $errors['loginFailed'] ?? '' ?></p>
                <input type="submit" name="submit" value="Login"/>
            </div>


            <a href="#">Wachtwoord vergeten?</a><br>
            <a href="signup.php">Nog geen lid?</a>






        </form>





    <?php } ?>








</div>

</body>
</html>

