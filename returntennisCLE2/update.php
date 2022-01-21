<?php
require_once "includes/database.php";

if(isset($_GET['id']) && isset($_POST['editForm'])){
    $id = $_GET['id'];
    $email = $_POST['email'];
    $timedate = $_POST['timedate'];
    $baan = $_POST['baan'];
    $trainer = $_POST['trainer'];


    $query = "UPDATE reserveringen SET 
                `email`= '$email',
                `timedate`= '$timedate',`baan`= '$baan', `trainer`= '$trainer' WHERE id = $id";

    if($db->query($query) === TRUE){

        header('Location: index.php');
    }else{
        echo "something went wrong";
    }

}else{
    echo "invalid";
}

