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
    if (isset($_POST['registration_email']) &&
        isset($_POST['registration_password'])) {
        $password = trim($_POST['registration_password']);
        $emailaddress = strtolower(trim($_POST['registration_email']));
        $nickname = trim($_POST['registration_nickname']);
        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $number = preg_match('@[0-9]@', $password);
        if ($uppercase && $lowercase && $number && strlen($password) >= 8) {
            if (userWithEmailaddressExists($emailaddress)) {
                setValue("message", "<div class='alert alert-danger' role = 'alert'> The user already exists</div >");
            } else {
                setValue("message", "<div class='alert alert-success' role = 'alert'>The user has been registered</div >");
                createUser($emailaddress, $nickname, $password);
            }
        } else {
            setValue("message", "<div class='alert alert-primary' role = 'alert'> The password doesn't match the rules</div >");
        }
    }
    setValue("phpmodule", $_SERVER['PHP_SELF'] . "?id=" . getValue("func"));
    return runTemplate("../templates/" . getValue("func") . ".htm.php");
}

?>