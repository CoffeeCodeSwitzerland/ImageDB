<?php
/*
 *  @autor Michael Abplanalp
 *  @version Februar 2018
 *  Dieses Modul beinhaltet sämtliche Datenbankfunktionen.
 *  Die Funktionen formulieren die SQL-Anweisungen und rufen dann die Funktionen
 *  sqlQuery() und sqlSelect() aus dem Modul basic_functions.php auf.
 */


function userWithEmailaddressExists($email)
{
    $sql = "SELECT COUNT(UserId) FROM `User` WHERE Emailaddress = '" . strtolower($email) . "';";
    $answer = sqlSelect($sql);
    if ($answer[0]["COUNT(UserId)"] >= 1) {
        return true;
    }
    return false;
}

function createUser($email, $nickname, $password) {
    $options = ['cost' => 12];
    $password = password_hash($password, PASSWORD_BCRYPT, $options);
    $sql = "INSERT INTO `User` (Emailaddress, `Password`, Nickname, IsAdmin) VALUES ('" . $email . "','" . $password . "','" . $nickname . "',0)";
    sqlQuery($sql);
}

function areUserCredentialsValid($email, $password) {
    $sql = "SELECT Password FROM `User` WHERE Emailaddress = '" . strtolower($email) . "';";
    $answer = sqlSelect($sql);
    //echo "<script>window.alert('" . $answer[0]["Password"] . "');</script>";
    if (password_verify($password, $answer[0]['Password'])) {
        return true;
    }
    return false;
}

function getUserByEmailaddress($emailaddress){
    $sql = "SELECT * FROM `User` WHERE Emailaddress ='". $emailaddress . "';";
    $answer = sqlSelect($sql);
    return $answer;
}

function getImageCountByEmailaddress($emailaddress){
    $sql = "SELECT COUNT(ImageId) FROM image WHERE GalleryId = (SELECT GalleryId FROM gallery WHERE OwnerId = (SELECT UserId FROM `user` WHERE Emailaddress ='" . strtolower($emailaddress) . "'))";
    $answer = sqlSelect($sql);
    return $answer[0]["COUNT(ImageId)"];
}

function getGalleryCountByEmailaddress($emailaddress){
    $sql = "SELECT COUNT(GalleryId) FROM gallery WHERE OwnerId = (SELECT UserId FROM `user` WHERE Emailaddress ='" . strtolower($emailaddress) . "')";
    $answer = sqlSelect($sql);
    return $answer[0]["COUNT(GalleryId)"];
}
?>