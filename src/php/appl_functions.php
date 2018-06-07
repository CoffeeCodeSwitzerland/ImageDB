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

    if(isset($_POST['resetPassword'])){
        appl_resetPassword($_POST['resetEmail']);
        setValue("phpmodule", $_SERVER['PHP_SELF'] . "?id=" . getValue("func"));
        return runTemplate("../templates/" . getValue("func") . ".htm.php");
    }

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
            setValue('login_emailaddress', $email);
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
        setValue('gid', $gid);
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
                    appl_advancedThumbnail($imagePath, 400, 400, $thumbnailPath);
                    $imageId = db_createImage($gid, $_POST['images_newImageName'], $fileName . "." . $extentsion, $fileName . "." . $extentsion);
                    if (isset($_POST['image_tags'])) {
                        $raw = $_POST['image_tags'];
                        if (strlen($raw) > 0) {
                            $tags = explode(",", $raw);
                            foreach ($tags as $tag) {
                                db_addTagsToImage($imageId, $tag);
                            }
                        }
                    }
                } elseif ($action == 'image_delete') {
                    $imageId = $_POST['images_imageId'];
                    $image = db_getImageById($imageId);
                    db_deleteImage($imageId);
                    app_deleteImagePath($image['RelativePath'], $gid);
                } elseif ($action == 'image_edit') {
                    $imageId = $_POST['images_imageId'];
                    db_updateImage($imageId, $_POST['image_editImageName']);
                } elseif ($action == 'image_sort') {
                    setValue('currentTag', $_POST['image_sortTag']);
                    $gid = getValue('currentGalleryId');
                    $result = db_getImagesByTagAndGallery(getValue('currentTag'), $gid);
                    if (empty($result)) {
                        appl_setMessage('No image with this tag could be found in the current gallery', 'alert-warning');
                        setValue('tagChoosen', 'no');
                    } else {
                        setValue('tagChoosen', 'yes');
                    }
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


function tags()
{
    if (isset($_POST['tag_formAction'])) {
        $action = $_POST['tag_formAction'];
        if ($action == 'tag_add') {
            $tagName = $_POST['tags_newTagName'];
            if (!db_isTagExisting($tagName, getSessionUserId())) {
                db_createTag($tagName, getSessionUserId());
            } else {
                appl_setMessage('A tag with this name already exists', 'alert-danger');
            }
        } elseif ($action == 'tag_edit') {
            $tagName = $_POST['tags_editTagName'];
            if (!db_isTagExisting($tagName, getSessionUserId())) {
                db_updateTag($_POST['tag_tagId'], $tagName);
            } else {
                appl_setMessage('A tag with this name already exists', 'alert-danger');
            }
        } elseif ($action == 'tag_delete') {
            $id = $_POST['tag_tagId'];
            db_deleteTag($id);
        }
    }

    setValue("phpmodule", $_SERVER['PHP_SELF'] . "?id=" . getValue("func"));
    return runTemplate("../templates/" . getValue("func") . ".htm.php");
}

/**
 * Additional tag logic
 */

function appl_getAllTagsAsTable()
{
    $tags = db_getAllTags(getSessionUserId());
    $modified = false;
    $html = "<table class='table'>
    <thead class='thead-light'>
    <tr>
        <th scope='col'>#</th>
        <th scope='col'>Name</th>
        <th scope='col'><i class='fas fa-image'></i> Associated images</th>
    </tr>
    </thead>
    <tbody>";
    $counter = 1;

    if (!empty($tags)) {
        foreach ($tags as $tag) {
            $modified = true;
            $html .= "<tr tagId='" . $tag['TagId'] . "' class='tagItem'>
                            <th scope='row'>" . $counter . "</th>
                            <td id='tagName_" . $tag['TagId'] . "' >" . $tag['Name'] . "</td>
                            <td>" . db_getImageCountAssociatedWithTagId($tag['TagId']) . "</td>
                      </tr>";
            $counter++;
        }
    }

    $html .= "</tbody></table>";

    if(!$modified){
        $html = "";
        $html .= "<div class='alert alert-info m-3' role = 'alert'>There are no tags yet</div >";
    }

    return $html;
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
                                   <p class='card-text' id='tags_" . $gallery['GalleryId'] . "'></p>
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
 * Check if the image selection should be sorted
 * @return string
 */
function appl_getImagesByGallery()
{
    $gid = getValue('currentGalleryId');
    $gallery = db_getGalleryById($gid);

    if (!empty(getValue('currentTag'))) {
        $customImages = db_getImagesByTagAndGallery(getValue('currentTag'), $gid);
        if (!empty($customImages)) {
            return appl_generateImages($customImages, $gallery);
        }
    } else {
        $images = db_getImagesByGalleryId($gid);
        return appl_generateImages($images, $gallery);
    }
}

/**
 * Generates the image views with the following db attributes:
 * -Image.Name
 * @param $images
 * @param $gallery
 * @return string
 */
function appl_generateImages($images, $gallery)
{
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
                                <img data-toggle='toolip' data-placement='top' class='img-thumbnail rounded mx-auto d-block w-100' src='../storage/galleries/" . getSessionEmailaddress() . "/" . $gallery['Title'] . "/thumbnails/" . $image['ThumbnailPath'] . "' alt='Card image cap'>
                                <div class='card-body'>
                                    <h5 class='card-title' id='title_" . $image['ImageId'] . "' >" . $image['Name'] . "</h5>
                                    <a data-lightbox='images' id='lightbox_" . $image['ImageId'] . "'  data-title='" . $image['Name'] . "' class='a' href='../storage/galleries/" . getSessionEmailaddress() . "/" . $gallery['Title'] . "/" . $image['RelativePath'] . "''>
                                  </a>
                                 </div>
                                 <div class='card-footer text-muted'>
                                     " . appl_getTagsByImageId($image['ImageId']) . "
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
    if (empty(getValue('message'))) {
        return "<div class='alert alert-info m-3' role = 'alert'> There aren't any images yet </div >";
    }
    return "";
}

/**
 * Additional tag logic
 */

/**
 * Get all tags as bootstrap badge
 * @return string
 */
function appl_getTagOverview()
{
    $tags = db_getAllTags(getSessionUserId());
    $html = "";
    $html = "<div class='row'>";
    foreach ($tags as $tag) {
        $html .= "<a href='#' name='" . $tag['TagId'] . "' class='badge badge-primary m-1 imageTag'>" . $tag["Name"] . "</a>";
    }
    $html .= "</div>";
    return $html;
}

function appl_getEditTagOverview()
{
    $tags = db_getAllTags(getSessionUserId());
    $html = "";
    $html = "<div class='row'>";
    foreach ($tags as $tag) {
        $html .= "<a href='#' name='" . $tag['TagId'] . "' class='badge badge-primary m-1 imageEditTag'>" . $tag["Name"] . "</a>";
    }
    $html .= "</div>";
    return $html;
}

/**
 * Get all tags as buttons
 * @return string
 */
function appl_getAllTagsAsButton()
{
    $html = "";
    $tags = db_getAllTagsByGallery(getValue('gid'));
    $changed = false;

    $html .= "<div class='btn-group'>
    <button type='button' class='btn btn-secondary dropdown-toggle' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                        <i class='fa fa-tag'></i>
						
						
 </button>
    <div class='dropdown-menu dropdown-menu-right'>
        <form id='image_tagSort' method='post' action='" . getValue('phpmodule') ."'>";

    if (is_array($tags)) {
        foreach ($tags as $tag) {
            $changed = true;
            $html .= "<button name='" . $tag['TagId'] . "' class='dropdown-item tagSortItem' type='button'>" . $tag['Name'] . "</button>";
        }
    }

    $html .= "<input type='hidden' id='image_sortTag' name='image_sortTag'>
                            <input type='hidden' name='image_formAction' value='image_sort'>		
	                        </form>
                    </div>
                </div>";

    if(!$changed){
        $html = "";
    }

    return $html;
}

/**
 * Get those tags which badge the image
 * @param $imageId
 * @return string
 */
function appl_getTagsByImageId($imageId)
{
    $tags = db_getTagsByImageId($imageId);
    $html = "";
    if (is_array($tags)) {
        foreach ($tags as $item) {
            $html .= "<a href='#' name='" . $item['TagId'] . "' class='badge badge-primary m-1 imageTag'>" . $item['Name'] . "</a>";
        }
    }

    if ($html == "") {
        $html .= "<a href='#' class='badge badge-light m-1 imageTag'>No tags selected</a>";
    }
    return $html;
}


/**
 * Additional image logic
 */

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
 * @author Juan Valencia <jvalenciae@jveweb.net>
 * Copyright (C) 2010  Juan Valencia <jvalenciae@jveweb.net>
 * All rights reserved.
 * @param $image_path
 * @param $thumb_width
 * @param $thumb_height
 * @param $outputPath
 */

function appl_advancedThumbnail($image_path, $thumb_width, $thumb_height, $outputPath)
{

    if (!(is_integer($thumb_width) && $thumb_width > 0) && !($thumb_width === "*")) {
        echo "The width is invalid";
        exit(1);
    }

    if (!(is_integer($thumb_height) && $thumb_height > 0) && !($thumb_height === "*")) {
        echo "The height is invalid";
        exit(1);
    }

    $extension = pathinfo($image_path, PATHINFO_EXTENSION);
    switch (strtolower($extension)) {
        case "jpg":
        case "jpeg":
            $source_image = imagecreatefromjpeg($image_path);
            break;
        case "gif":
            $source_image = imagecreatefromgif($image_path);
            break;
        case "png":
            $source_image = imagecreatefrompng($image_path);
            break;
        default:
            exit(1);
            break;
    }


    $source_width = imageSX($source_image);
    $source_height = imageSY($source_image);

    if (($source_width / $source_height) == ($thumb_width / $thumb_height)) {
        $source_x = 0;
        $source_y = 0;
    }

    if (($source_width / $source_height) > ($thumb_width / $thumb_height)) {
        $source_y = 0;
        $temp_width = $source_height * $thumb_width / $thumb_height;
        $source_x = ($source_width - $temp_width) / 2;
        $source_width = $temp_width;
    }

    if (($source_width / $source_height) < ($thumb_width / $thumb_height)) {
        $source_x = 0;
        $temp_height = $source_width * $thumb_height / $thumb_width;
        $source_y = ($source_height - $temp_height) / 2;
        $source_height = $temp_height;
    }

    $target_image = ImageCreateTrueColor($thumb_width, $thumb_height);

    imagecopyresampled($target_image, $source_image, 0, 0, $source_x, $source_y, $thumb_width, $thumb_height, $source_width, $source_height);

    switch (strtolower($extension)) {
        case "jpg":
        case "jpeg":
            imagejpeg($target_image, $outputPath);
            break;
        case "gif":
            imagegif($target_image, $outputPath);
            break;
        case "png":
            imagepng($target_image, $outputPath);
            break;
        default:
            exit(1);
            break;
    }

    imagedestroy($target_image);
    imagedestroy($source_image);
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
        case "jpeg":
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
        case "jpeg":
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
    if (isset($_POST['adminUsers_formAction'])) {
        $action = $_POST['adminUsers_formAction'];
        if ($action === 'adminUsers_edit') {
            $emailaddress = $_POST['adminUsers_emailaddress'];
            $user = db_getUserByEmailaddress($emailaddress);
            if ($user != null) {
                $userId = $user['UserId'];
                db_updateUserNicknameByUserId($userId, $_POST['adminUsers_nickname']);
                if (isset($_POST['adminUsers_password'])) {
                    if ($_POST['adminUsers_password'] == $_POST['adminUsers_passwordConfirmation']) {
                        db_updateUserPasswordByUserId($userId, $_POST['adminUsers_password']);
                    } else {
                        appl_setMessage("The passwords were not equal.", "alert-danger");
                    }
                }
            } else {
                appl_setMessage("User not found. This should not happen...", "alert-danger");
            }
        } elseif ($action === 'adminUsers_delete') {
            $emailaddress = $_POST['adminUsers_emailaddress'];
            $user = db_getUserByEmailaddress($emailaddress);
            appl_deleteUserPathByEmailaddress($emailaddress);
            db_deleteUserByUserId($user['UserId']);
        }
    }

    setValue("phpmodule", $_SERVER['PHP_SELF'] . "?id=" . getValue("func"));
    return runTemplate("../templates/" . getValue("func") . ".htm.php");
}

function showUsersForAdmin()
{
    foreach(db_getAllUsers() as $user){
        echo "
          <div class='card' style='width: 18rem; margin-bottom: 20px;'>
            <div class='card-header'>".
            $user['Emailaddress']."
            </div>
            <ul class='list-group list-group-flush'>
              <li class='list-group-item'>Nickname: ".
            $user['Nickname']."</li>
              <li class='list-group-item'><div class='btn btn-secondary adminUsers-EditButton' data-toggle='modal' data-target='#adminUsers_modalEditUser'
                   id='adminUsers_editUser' name='".$user['Emailaddress']."' data-nickname='".$user['Nickname']."' style='margin-right: 10px;'>Edit user
              </div><div class='btn btn-danger adminUsers-DeleteButton' data-toggle='modal' data-target='#adminUsers_modalDeleteUser'
                   id='adminUsers_deleteUser' name='".$user['Emailaddress']."' onclick=''>Delete user
              </div></li>
            </ul>
          </div>";
    }
}

/**
 * @return string
 */
function adminGalleries()
{
    if (isset($_POST['adminGalleries_formAction'])) {
        $action = $_POST['adminGalleries_formAction'];
        if ($action === 'adminGalleries_edit') {
            $id = $_POST['adminGalleries_editForm_galleryId'];
            $title = $_POST['adminGalleries_editForm_galleryName'];
            $description = $_POST['adminGalleries_editForm_galleryDescription'];
            db_updateGallery($id, $title, $description);
        } elseif ($action === 'adminGalleries_delete') {
            $id = $_POST['adminGalleries_deleteForm_galleryId'];
            $gallery = db_getGalleryById($id);
            appl_deleteGalleryPath($gallery['Title']);
            db_deleteGallery($id);
        }
    }

    setValue("phpmodule", $_SERVER['PHP_SELF'] . "?id=" . getValue("func"));
    return runTemplate("../templates/" . getValue("func") . ".htm.php");
}

function showGalleriesForAdmin()
{
    foreach(db_getAllUsers() as $user){
        $userId = $user['UserId'];
        if(!empty(db_getGalleriesByUser($userId))){
            echo "
            <div class='card' style='width: 18rem; margin-bottom: 20px;'>
              <div class='card-header' style='border-left: 1px solid black;border-right: 1px solid black;border-top: 1px solid black;'>".
                $user['Emailaddress']."
              </div>
              <ul class='list-group list-group-flush'>";
            foreach(db_getGalleriesByUser($userId) as $gallery){
                echo "<li class='list-group-item' style='border-left: 1px solid black;border-right: 1px solid black;border-top: 1px solid black;'>Title: ".$gallery['ShowTitle']."</li>
                <li class='list-group-item' style='color:gray;border-left: 1px solid black;border-right: 1px solid black;'>Description: ".$gallery['Description']."</li>
                <li class='list-group-item' style='border-left: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black;'>
                <div class='btn btn-secondary adminGalleries-EditButton' data-toggle='modal' data-target='#adminGalleries_modalEditGallery'
                   id='adminGalleries_editGallery' name='".$gallery['GalleryId']."' data-galleryName='".$gallery['ShowTitle']."' data-galleryDescription='".$gallery['Description']."' style='margin-right: 10px;'>Edit
              </div><div class='btn btn-danger adminGalleries-DeleteButton' data-toggle='modal' data-target='#adminGalleries_modalDeleteGallery'
                   id='adminGalleries_deleteGallery' name='".$gallery['GalleryId']."'>Delete
              </div></li>";
            }
            echo "</ul>
            </div>";
        }
    }
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
 * Deletes the whole user directory
 */
function appl_deleteUserPathByEmailaddress($emailaddress)
{
    $path = getValue('galleryRoot') . "\\" . $emailaddress;
    if (file_exists($path)) {
        exec("rd /s /q " . $path);
    }
}

/**
 * Additional general logic
 */

//TODO check setSessionValues -> without [0]
/**
 * Set all necessary variables in the $_SESSION array
 * @param $user
 */
function setSessionValues($user)
{
    $_SESSION['userId'] = $user['UserId'];
    $_SESSION['userNickname'] = $user['Nickname'];
    $_SESSION['userEmailaddress'] = $user['Emailaddress'];
    $_SESSION['userIsAdmin'] = $user['IsAdmin'];
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

function appl_resetPassword($email){
    $emailExistst = db_userWithEmailaddressExists($email);
    if($emailExistst){
        $rndPassword = appl_generateRandomPassword();
        $user = db_getUserByEmailaddress($email);
        db_updateUserPasswordByUserId($user['UserId'], $rndPassword);
        appl_sendResetMail($email, $rndPassword);
        appl_setMessage('An email has been sent containing a new password', 'alert-info');
    }else{
        appl_setMessage('Invalid emailaddress','alert-warning');
    }
}

function appl_generateRandomPassword(){

    $scope = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ123456789,.-$¨?';
    $password = substr( str_shuffle( $scope ), 0, 8 );
    return $password;
}

function appl_sendResetMail($email, $password){
    $user = db_getUserByEmailaddress($email);
    $subject = 'New password';
    $content = "Hey " . $user['Nickname'] . " here is you new password " . $password;
    mail($email, $subject, $content);
}

?>
