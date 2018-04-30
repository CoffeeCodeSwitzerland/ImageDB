<?php
/*
 *  @autor Michael Abplanalp
 *  @version März 2018
 *  Dieses Modul beinhaltet Funktionen, welche die Anwendungslogik implementieren.
 */

/**
 * Logic of the pages
 */

/**
 * Login page logic
 * @return null|string
 */
function login()
{
    $canLogin = false;
    $userId = 0;
    if (isset($_POST['login_emailaddress']) && isset($_POST['login_password'])) {
        $email = $_POST['login_emailaddress'];
        $password = $_POST['login_password'];
        $userValid = db_areUserCredentialsValid($email, $password);
        //echo "<script>window.alert('" . $userValid ."');</script>";
        if ($userValid) {
            $canLogin = true;
            $user = db_getUserByEmailaddress($email);
            setSessionValues($user);
        } else {
            setValue("message", "<div class='alert alert-danger' id='login_invalidCredentials' role = 'alert'>Invalid credentials</div >");
        }
    }

    if (!$canLogin && isSessionActive()) {
        $canLogin = true;
    }

    if (isSessionUserAdmin()) {
        setValue("func", "adminUsers");
        setValue("phpmodule", "localhost/ImageDB/src/php/admin.php" . "?id=" . getValue("func"));
        echo "<script>window.location.href='admin.php?id=adminUsers'</script>";
        return null;
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

/**
 * Contains the following functionality:
 * -Register a new user considering the password rules
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
        if (appl_isPasswortMatchingRequirements($password)) {
            if (db_userWithEmailaddressExists($emailaddress)) {
                setValue("message", "<div class='alert alert-danger' role = 'alert'> The user already exists</div >");
            } else {
                setValue("message", "<div class='alert alert-success' role = 'alert'>The user has been registered</div >");
                db_createUser($emailaddress, $nickname, $password);
            }
        } else {
            setValue("message", "<div class='alert alert-primary' role = 'alert'> The password doesn't match the rules</div >");
        }
    }
    setValue("phpmodule", $_SERVER['PHP_SELF'] . "?id=" . getValue("func"));
    return runTemplate("../templates/" . getValue("func") . ".htm.php");
}

/**
 * Contains the following funciontality:
 * -Create gallery
 * -Remove gallery
 * -Edit gallery
 * -Refers to the associated images
 * @return string
 */
function galleries()
{
    if (isset($_POST['gallery_formAction'])) {
        $action = $_POST['gallery_formAction'];
        if ($action == 'gallery_create') {
            $galleryTitle = strtolower(str_replace(" ", "", $_POST['galleries_newGalleryName']));
            $galleryDescription = $_POST['galleries_newGalleryDescription'];
            $galleryShowTitle = $_POST['galleries_newGalleryName'];
            appl_setMessage("The gallery '" . $galleryTitle . "' is already taken", "alert-danger");
            if (!db_isGalleryExisting(getSessionUserId(), $galleryTitle)) {
                $galleryPath = appl_createGalleryPath($galleryTitle);
                if ($galleryPath != "") {
                    db_createGallery(getSessionUserId(), $galleryPath, $galleryShowTitle, $galleryDescription, appl_escapeString(getValue('galleryRoot') . "\\" . getSessionEmailaddress() . "\\" . $galleryPath));
                    appl_setMessage("The gallery has been created", "alert-success");
                }
            }
        } elseif ($action === 'gallery_edit') {
            $id = $_POST['gallery_galleryId'];
            db_updateGallery($id, $_POST['galleries_editGalleryName'], $_POST['galleries_editGalleryDescription']);
        } elseif ($action === 'gallery_delete') {
            $id = $_POST['gallery_galleryId'];
            $gallery = db_getGalleryById($id);
            appl_deleteGalleryPath($gallery['Title']);
            db_deleteGallery($id);
        }
    }
    setValue("phpmodule", $_SERVER['PHP_SELF'] . "?id=" . getValue("func"));
    return runTemplate("../templates/" . getValue("func") . ".htm.php");
}

/**
 * Contains the following functionality:
 * -Log the user out
 */
function logout()
{
    unsetSessionValues();
    setValue('isLoggedOut', true);
    setValue("message", "<div class='alert alert-success' role = 'alert'>Successfully logged out</div >");
    echo "<script>window.location.href='index.php?id=login'</script>";
}

/**
 * Contains the following functionality:
 * -Delete user
 * -Change user informations (.eg password, nickname)
 * -Shows a short overview about the count of images and galleries
 * @return string
 */
function overview()
{
    if (isset($_POST['overview_deleteContent'])) {
        appl_deleteUserFromPath();
        db_deleteUserByUserId(getSessionUserId());
        setValue('message', "<div class='alert alert-danger' role = 'alert'>The user has been removed</div >");
        unsetSessionValues();
        setValue('func', 'login');
        setValue("phpmodule", "localhost/ImageDB/src/php/index.php" . "?id=" . getValue("func"));
        echo "<script>window.location.href='user.php?id=overview'</script>";
    } else {
        if (isset($_POST['overview_nickname'])) {
            $nickName = $_POST['overview_nickname'];
            if ($nickName != getSessionNickname()) {
                db_updateUserNicknameByUserId(getSessionUserId(), $nickName);
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
                if (db_isUserPasswordMatching(getSessionUserId(), $currentPassword)) {
                    if (appl_isPasswortMatchingRequirements($newPassword)) {
                        db_updateUserPasswordByUserId(getSessionUserId(), $newPassword);
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

/**
 * Contains the logic for the following actions:
 * -Create image
 * -Edit image
 * -Delete image
 * @return string
 */
function images()
{
    $gid = 0;
    if (isset($_GET['gid'])) {
        $gid = $_GET['gid'];
        if (db_isGalleryIdBelongingToUser($gid, getSessionUserId())) {
            setValue('currentGalleryId', $gid);
            if (isset($_POST['image_formAction'])) {
                $action = $_POST['image_formAction'];
                if ($action == 'image_add') {
                    $gallery = db_getGalleryById($gid);
                    $info = pathinfo($_FILES['image_newImageFile']['name']);
                    $extentsion = $info['extension'];
                    $fileName = appl_createImageName($gid, $_FILES['image_newImageFile']['name'], $extentsion);
                    $imagePath = getValue('galleryRoot') . "\\" . getSessionEmailaddress() . "\\" . $gallery['Title'] . "\\" . $fileName . "." . $extentsion;
                    $thumbnailPath = getValue('galleryRoot') . "\\" . getSessionEmailaddress() . "\\" . $gallery['Title'] . "\\thumbnails\\" . $fileName . "." . $extentsion;

                    move_uploaded_file($_FILES['image_newImageFile']['tmp_name'], $imagePath);
                    appl_createThumbnail($imagePath, $thumbnailPath, 400, $extentsion);

                    db_createImage($gid, $_POST['images_newImageName'], $fileName . "." . $extentsion, $fileName . "." . $extentsion);
                } elseif ($action == 'image_delete') {
                    $imageId = $_POST['images_imageId'];
                    $image = db_getImageById($imageId);
                    db_deleteImage($imageId);
                    app_deleteImagePath($image['RelativePath'], $gid);
                } elseif ($action == 'image_edit') {
                    $imageId = $_POST['images_imageId'];
                    db_updateImage($imageId, $_POST['image_editImageName']);
                }
            }
        } else {
            setValue('func', 'galleries');
            appl_setMessage('You do not have the righ to access this gallery', 'alert-danger');
        }
    }

    setValue("phpmodule", $_SERVER['PHP_SELF'] . "?id=" . getValue("func") . "&gid=" . $gid);
    return runTemplate("../templates/" . getValue("func") . ".htm.php");
}

/**
 * Additonal gallery logic
 */

/**
 * Generates the gallerie views with the following db attributes:
 * -Gallery.ShowTitle
 * -Gallery.Description
 * @return string
 */
function appl_getGalleriesBySessionUser()
{
    $galleries = db_getGalleriesByUser(getSessionUserId());
    $html = "";
    if (!empty($galleries)) {
        $rowItems = 0;
        foreach ($galleries as $gallery) {
            if ($rowItems == 0) {
                $html .= "<div class='row m-3'>";
            }
            $galleryTitle = "";

            if (strlen($gallery['Description']) > 0) {
                $galleryTitle = $gallery['Description'];
            } else {
                $galleryTitle = "<label class='label font-italic'>No description available</label>";
            }

            $html .= "<div class='col-md-3'><div class='card border-secondary galleryItem' name='" . $gallery['GalleryId'] . "'>
                           <div class='card-header'></div>
                                <div class='card-body'>
                                   <h5 class='card-title' id='title_" . $gallery['GalleryId'] . "' >" . $gallery['ShowTitle'] . "</h5>
                                   <p class='card-text' id='description_" . $gallery['GalleryId'] . "'  >" . $galleryTitle . "</p>
                            </div>
                       </div></div>";
            $rowItems++;
            if ($rowItems == 4) {
                $html .= '</div>';
                $rowItems = 0;
            }
        }
        return $html;
    }
    return "<div class='alert alert-info m-3' role = 'alert'> There aren't any galleries yet </div >";
}

/**
 * Creates a new folder for the gallery
 * @param $galleryTitle
 * @return string
 */
function appl_createGalleryPath($galleryTitle)
{
    $basePath = getValue('galleryRoot') . "\\" . getSessionEmailaddress() . "\\";
    $pathNotTaken = false;
    $path = $galleryTitle;
    $temp = "";
    $counter = 0;

    while (!$pathNotTaken) {
        $counter++;
        $temp = $path . "_" . $counter;
        if (!file_exists($basePath . $temp)) {
            $path = $basePath . $temp;
            exec("md " . $basePath . $temp);
            exec("md " . $basePath . $temp . "\\thumbnails");
            $pathNotTaken = true;
        }
    }

    return $temp;
}

/**
 * Delets an existing gallery folder
 * @param $galleryTitle
 */
function appl_deleteGalleryPath($galleryTitle)
{
    $path = getValue('galleryRoot') . "\\" . getSessionEmailaddress() . "\\" . $galleryTitle;
    if (file_exists($path)) {
        exec("rd /s /q " . $path);
    }
}

/**
 * Get the whole path of a gallery
 * @param $galleryId
 * @return string
 */
function appl_getGalleryPath($galleryId)
{
    $gallery = db_getGalleryById($galleryId);
    return getValue('galleryRoot') . "\\" . getSessionEmailaddress() . "\\" . $gallery['Title'] . "\\";
}

/**
 * Additional image logic
 */

/**
 * Generates the image views with the following db attributes:
 * -Image.Name
 * @return string
 */
function appl_getImagesByGallery()
{
    $gid = getValue('currentGalleryId');
    $gallery = db_getGalleryById($gid);
    $images = db_getImagesByGalleryId($gid);

    $html = "";
    if (!empty($images)) {
        $rowItems = 0;
        foreach ($images as $image) {
            if ($rowItems == 0) {
                $html .= "<div class='row m-3'>";
            }
            $html .= "<div class='col-md-3'>
                        <div class='card border-secondary imageItem' name='" . $image['ImageId'] . "'>
                           <div class='card-header'></div> 
                                <img class='img-thumbnail rounded mx-auto d-block w-100' src='../storage/galleries/" . getSessionEmailaddress() . "/" . $gallery['Title'] . "/thumbnails/" . $image['ThumbnailPath'] . "' alt='Card image cap'>
                                <div class='card-body'>
                                    <h5 class='card-title' id='title_" . $image['ImageId'] . "' >" . $image['Name'] . "</h5>
                                 </div>
                           </div>
                        </div>";
            $rowItems++;
            if ($rowItems == 4) {
                $html .= '</div>';
                $rowItems = 0;
            }
        }
        return $html;
    }
    return "<div class='alert alert-info m-3' role = 'alert'> There aren't any images yet </div >";
}

/**
 * Gets a name for a new image considering that the same image may exists
 * @param $galleryId
 * @param $imageName
 * @param $imageExtension
 * @return string
 */
function appl_createImageName($galleryId, $imageName, $imageExtension)
{
    $gallery = db_getGalleryById($galleryId);
    $galleryNotTaken = false;
    $counter = 0;
    $path = getValue('galleryRoot') . "\\" . getSessionEmailaddress() . "\\" . $gallery['Title'] . "\\";
    $ar = explode(".", $imageName);
    $tempName = $ar[0];
    while (!$galleryNotTaken) {
        $counter++;
        if (file_exists($path . $tempName . "." . $imageExtension)) {
            $tempName = $ar[0] . "_" . $counter;
        } else {
            $galleryNotTaken = true;
        }
    }
    return $tempName;
}

/**
 * Delets an image by the path
 * @param $imageTitle
 * @param $galleryId
 */
function app_deleteImagePath($imageTitle, $galleryId)
{
    $gallery = db_getGalleryById($galleryId);
    $path = getValue('galleryRoot') . "\\" . getSessionEmailaddress() . "\\" . $gallery['Title'] . "\\";

    if (file_exists($path . $imageTitle)) exec('del ' . $path . $imageTitle);
    if (file_exists($path . "thumbnails\\" . $imageTitle)) exec('del ' . $path . "thumbnails\\" . $imageTitle);
}

/**
 * Creates a thumbnail out of the original image
 * @param $inputPath
 * @param $outputPath
 * @param $desired_width
 * @param $extension
 */
function appl_createThumbnail($inputPath, $outputPath, $desired_width, $extension)
{
    /* read the source image */
    $source_image = null;

    switch ($extension) {
        case "jpg":
            $source_image = imagecreatefromjpeg($inputPath);
            break;
        case "png":
            $source_image = imagecreatefrompng($inputPath);
            break;
    }

    $width = imagesx($source_image);
    $height = imagesy($source_image);

    /* find the "desired height" of this thumbnail, relative to the desired width  */
    $desired_height = floor($height * ($desired_width / $width));

    /* create a new, "virtual" image */
    $virtual_image = imagecreatetruecolor($desired_width, $desired_height);

    /* copy source image at a resized size */
    imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);

    /* create the physical thumbnail image to its destination */

    switch ($extension) {
        case "jpg":
            imagejpeg($virtual_image, $outputPath);;
            break;
        case "png":
            imagepng($virtual_image, $outputPath);;
            break;
    }
}

/**
 * Additional user logic
 */

/**
 * @return string
 */
function adminUsers()
{
    setValue("phpmodule", $_SERVER['PHP_SELF'] . "?id=" . getValue("func"));
    return runTemplate("../templates/" . getValue("func") . ".htm.php");
}

/**
 * @return string
 */
function adminGalleries()
{
    setValue("phpmodule", $_SERVER['PHP_SELF'] . "?id=" . getValue("func"));
    return runTemplate("../templates/" . getValue("func") . ".htm.php");
}

/**
 * Delets the whole user directory
 */
function appl_deleteUserFromPath()
{
    $path = getValue('galleryRoot') . "\\" . getSessionEmailaddress();
    if (file_exists($path)) {
        exec("rd /s /q " . $path);
    }
}

/**
 * Additional general logic
 */

/**
 * Set all necessary variables in the $_SESSION array
 * @param $user
 */
function setSessionValues($user)
{
    $_SESSION['userId'] = $user[0]['UserId'];
    $_SESSION['userNickname'] = $user[0]['Nickname'];
    $_SESSION['userEmailaddress'] = $user[0]['Emailaddress'];
    $_SESSION['userIsAdmin'] = $user[0]['IsAdmin'];
}

/**
 * Unsets all the variables which has been set in sesSesstionValues($user)
 */
function unsetSessionValues()
{
    unset($_SESSION['userId']);
    unset($_SESSION['userNickname']);
    unset($_SESSION['userEmailaddress']);
    unset($_SESSION['userIsAdmin']);
}

/**
 * Checks if the password is matching the folowing rules
 * -At least one uppercase letter
 * -At least one lowercase letter
 * -At least a number
 * -Minimal length of 8 chars
 * @param $password
 * @return bool
 */
function appl_isPasswortMatchingRequirements($password)
{
    $uppercase = preg_match('@[A-Z]@', $password);
    $lowercase = preg_match('@[a-z]@', $password);
    $number = preg_match('@[0-9]@', $password);
    return $uppercase && $lowercase && $number && strlen(trim($password)) >= 8;
}

/**
 * Escape the '\' in a string
 * @param $toEscape
 * @return mixed
 */
function appl_escapeString($toEscape)
{
    return str_replace('\\', '\\\\', $toEscape);
}

/**
 * Generates message which are shown to the user
 * @param $content
 * @param $bootstrapClass
 */
function appl_setMessage($content, $bootstrapClass)
{
    setValue('message', "<div class='alert " . $bootstrapClass . " m-3' role = 'alert'>" . $content . "</div >");
}

?>
