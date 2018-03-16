<?php
/*
 *  @autor Michael Abplanalp
 *  @version März 2018
 *  Dieses Modul beinhaltet Funktionen, welche die Anwendungslogik implementieren.
 */

/*
 * Beinhaltet die Anwendungslogik zum Login
 */
function login()
{
    // Template abfüllen und Resultat zurückgeben
    setValue("phpmodule", $_SERVER['PHP_SELF'] . "?id=" . getValue("func"));
    return runTemplate("../templates/" . getValue("func") . ".htm.php");
}

/**
 * Contains the logic for the registstration
 * @return string
 */
function registration()
{
    $status = 'error';
    if (isset($_POST['registration_email']) &&
        isset($_POST['registration_password'])) {
        $password = trim($_POST['registration_password']);
        $emailaddress = strtolower(trim($_POST['registration_email']));
        $nickname = trim($_POST['registration_nickname']);
//        if(userWithEmailaddressNotExists($_POST['emailaddress'])){
//            $status = 'created';
//        } else {
//            $status = 'exists';
//        }
        $status = 'exists';
    }
    $status = 'exists';
    setValue("phpmodule", $_SERVER['PHP_SELF'] . "?id=" . getValue("func") . "&status=" . $status);
    return runTemplate("../templates/" . getValue("func") . ".htm.php");
}

?>