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
    $canLogin = false;
    $userId = 0;
    if (isset($_POST['login_emailaddress']) && isset($_POST['login_password'])) {
        $email = $_POST['login_emailaddress'];
        $password = $_POST['login_password'];
        $userValid = areUserCredentialsValid($email, $password);
        //echo "<script>window.alert('" . $userValid ."');</script>";
        if ($userValid) {
            $canLogin = true;
            $user = getUserByEmailaddress($email);
            setSessionValues($user);
        } else {
            setValue("message", "<div class='alert alert-danger' id='login_invalidCredentials' role = 'alert'>Invalid credentials</div >");
        }
    }

    if (!$canLogin && isSessionActive()) {
        $canLogin = true;
    }

    if ($canLogin) {
        setValue("func", "overview");
        setValue("phpmodule", "localhost/ImageDB/src/php/user.php" . "?id=" . getValue("func"));
        echo "<script>window.location.href='user.php?id=overview'</script>";
        return null;
    }

    setValue("phpmodule", $_SERVER['PHP_SELF'] . "?id=" . getValue("func"));
    return runTemplate("../templates/" . getValue("func") . ".htm.php");
}

function setSessionValues($user)
{
    $_SESSION['userId'] = $user[0]['UserId'];
    $_SESSION['userNickname'] = $user[0]['Nickname'];
    $_SESSION['userEmailaddress'] = $user[0]['Emailaddress'];
    $_SESSION['userIsAdmin'] = $user[0]['IsAdmin'];
}

function unsetSessionValues()
{
    unset($_SESSION['userId']);
    unset($_SESSION['userNickname']);
    unset($_SESSION['userEmailaddress']);
    unset($_SESSION['userIsAdmin']);
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
        if (strlen(trim($_POST['registration_nickname'])) > 0) {
            $nickname = trim($_POST['registration_nickname']);
        } else {
            $nickname = $emailaddress;
        }
        if (isPasswortMatchingRequirements($password)) {
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

function logout()
{
    unsetSessionValues();
    setValue('isLoggedOut', true);
    setValue("message", "<div class='alert alert-success' role = 'alert'>Successfully logged out</div >");
    echo "<script>window.location.href='index.php?id=login'</script>";

}

function overview()
{
    if (isset($_POST['overview_deleteContent'])) {

    } else {
        if (isset($_POST['overview_nickname'])) {
            $nickName = $_POST['overview_nickname'];
            if ($nickName != getSessionNickname()) {
                updateUserNicknameByUserId(getSessionUserId(), $nickName);
                setSessionNickname($nickName);
                setValue('message', "<div class='alert alert-success' role = 'alert'>The nickname has been updated</div >");
            }
        }

        if (isset($_POST['overview_currentPassword']) &&
            isset($_POST['overview_newPassword']) &&
            isset($_POST['overview_newPasswordRepeat'])) {
            $currentPassword = $_POST['overview_currentPassword'];
            $newPassword = $_POST['overview_newPassword'];
            $newPasswordRepeat = $_POST['overview_newPasswordRepeat'];
            if (strlen(trim($currentPassword)) > 0) {
                if (isUserPasswordMatching(getSessionUserId(), $currentPassword)) {
                    if (isPasswortMatchingRequirements($newPassword)) {
                        updateUserPasswordByUserId(getSessionUserId(), $newPassword);
                        setValue('message', getValue('message') . "<div class='alert alert-success' role = 'alert'>The password has been updated</div >");
                    } else {
                        setValue('message', "<div class='alert alert-danger' role = 'alert'>The password doesn't match the rules</div >");
                    }
                } else {
                    setValue('message', getValue('message') . "<div class='alert alert-danger' role = 'alert'>The credentials are invalid</div >");
                }
            }
        }
    }

    setValue("phpmodule", $_SERVER['PHP_SELF'] . "?id=" . getValue("func"));
    return runTemplate("../templates/" . getValue("func") . ".htm.php");
}

function galleries()
{
    if (isset($_POST['galleries_newGalleryName'])) {
        $galleryTitle = trim($_POST['galleries_newGalleryName']);
        $galleryDescription = $_POST['galleries_newGalleryDescription'];
        if (isGalleryExisting(getSessionUserId(), $galleryTitle)) {
            $galleryPath = getGalleryPath($galleryTitle);
            if ($galleryPath != "") {
                createGallery(getSessionUserId(), $galleryTitle, $galleryDescription, $galleryPath);
                setValue('message', "<div class='alert alert-danger' role = 'alert'>The gallery '" . $galleryTitle . "' is already taken</div >");
            } else {
                setValue('message', "<div class='alert alert-success' role = 'alert'>The gallery '" . $galleryTitle . "' has been created</div >");
            }
        }
    }
    setValue("phpmodule", $_SERVER['PHP_SELF'] . "?id=" . getValue("func"));
    return runTemplate("../templates/" . getValue("func") . ".htm.php");
}

function getGalleriesBySessionUser()
{
    $galleries = getGalleriesByUser(getSessionUserId());
    $html = "";
    if (!empty($galleries)) {

        foreach ($galleries as $gallery) {
            $html .= "<div class='card border-secondary mb-3' style='max-width: 18rem;'>
                           <div class='card-header'></div>
                                <div class='card-body text-secondary'>
                                   <h5 class='card-title'>" . $gallery['Title'] . "</h5>
                                   <p class='card-text'>" . $gallery['Description'] . "</p>
                            </div>
                       </div>";
        }
        windowAlert('in');
        return $html;
    }
    return "<div class='row justify-content-center'><div class='col-md-4'>There aren't any galleries yet</div></div>";
}

function isPasswortMatchingRequirements($password)
{
    $uppercase = preg_match('@[A-Z]@', $password);
    $lowercase = preg_match('@[a-z]@', $password);
    $number = preg_match('@[0-9]@', $password);
    return $uppercase && $lowercase && $number && strlen(trim($password)) >= 8;
}


function getGalleryPath($galleryTitle)
{
    $path = getValue('galleryRoot') . "\\" . getSessionEmailaddress() . "\\" . strtolower($galleryTitle);
    if (!file_exists($path)) {
        mkdir($path);
        return $path;
    }
    return "";
}

?>