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
?>