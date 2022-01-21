<?php

$errors = [];



if ($timedate == "") {
    $errors['timedate'] = 'Datum & tijd mag niet leeg zijn';
    
}

if ($baan == "") {
    $errors['baan'] = 'Dit veld mag niet leeg zijn';
}




