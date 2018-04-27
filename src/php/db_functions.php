<?php
/*
 *  @autor Michael Abplanalp
 *  @autor Philppe Krüttli
 *  @autor Frithjof Hoppe
 *  @version Februar 2018
 *  Dieses Modul beinhaltet sämtliche Datenbankfunktionen.
 *  Die Funktionen formulieren die SQL-Anweisungen und rufen dann die Funktionen
 *  sqlQuery() und sqlSelect() aus dem Modul basic_functions.php auf.
 */

/**
 * Utility functions
 */

/**
 * Has the plaintext password by the BCRYPTS algortihm
 * @param $password
 * @return bool|string: hashed password
 */
function db_hashPassword($password)
{
    $options = ['cost' => 12];
    return password_hash($password, PASSWORD_BCRYPT, $options);
}

/**
 * User entity functions
 */

function db_deleteUserByUserId($userId)
{
    $sql = "DELETE FROM `user` WHERE UserId =". $userId .";";
    sqlQuery($sql);
}

function db_updateUserNicknameByUserId($userId, $nickname)
{
    $sql = "UPDATE `User` SET Nickname = '" . $nickname . "' WHERE UserId=" . $userId . ";";
    sqlQuery($sql);
}

function db_updateUserPasswordByUserId($userId, $password)
{
    $sql = "UPDATE `User` SET Password = '" . db_hashPassword($password) . "' WHERE UserId =" . $userId . ";";
    sqlQuery($sql);
}

function db_getAllUsers(){
    $sql = "SELECT * FROM `User`;";
    $answer = sqlSelect($sql);
    $toReturn = array();
    foreach($answer as $row){
        array_push($toReturn, $row);
    }
    return $toReturn;
}

function db_createUser($email, $nickname, $password)
{
    $sql = "INSERT INTO `User` (Emailaddress, `Password`, Nickname, IsAdmin) VALUES ('" . $email . "','" . db_hashPassword($password) . "','" . $nickname . "',0)";
    sqlQuery($sql);
}

function db_userWithEmailaddressExists($email)
{
    $sql = "SELECT COUNT(UserId) FROM `User` WHERE Emailaddress = '" . strtolower($email) . "';";
    $answer = sqlSelect($sql);
    if ($answer[0]["COUNT(UserId)"] >= 1) {
        return true;
    }
    return false;
}


function db_areUserCredentialsValid($email, $password)
{
    $sql = "SELECT Password FROM `User` WHERE Emailaddress = '" . strtolower($email) . "';";
    $answer = sqlSelect($sql);
    if (!empty($answer[0]['Password'])) {
        if (password_verify($password, $answer[0]['Password'])) {
            return true;
        }

    }
    return false;
}

function db_isUserPasswordMatching($userId, $raw)
{
    $sql = "SELECT Password FROM `User` WHERE UserId = " . $userId . ";";
    $answer = sqlSelect($sql);
    if (!empty($answer[0]['Password'])) {
        return password_verify($raw, $answer[0]['Password']);
    }
    return false;
}

function db_getUserByEmailaddress($emailaddress)
{
    $sql = "SELECT * FROM `User` WHERE Emailaddress ='" . $emailaddress . "';";
    $answer = sqlSelect($sql);
    return $answer;
}

function db_getAdminUserIds()
{
    $sql = "SELECT UserId FROM `User` WHERE IsAdmin = 1  ;";
    $answer = sqlSelect($sql);
    $toReturn = array();
    foreach($answer as $row){
        array_push($toReturn, $row['UserId']);
    }
    return $toReturn;
}

/**
 * Image entity functions
 */

function db_getImagesByGalleryId($galleryId) {
    $sql = "SELECT * FROM `image` WHERE GalleryId=" . $galleryId .";";
    $answer = sqlSelect($sql);
    return $answer;
}

function db_createImage($galleryId, $name, $relativepath, $thubmnailPath){
    $sql = "INSERT INTO `image`  (GalleryId, Name, RelativePath, ThumbnailPath) VALUES (" . $galleryId . ",'" . $name . "','" . $relativepath . "','" . $thubmnailPath . "')";
    sqlQuery($sql);
}

function db_deleteImage($imageId){
    $sql = "DELETE FROM `image` WHERE ImageId=" . $imageId;
    sqlQuery($sql);
}

function db_getImageById($imageId) {
    $sql = "SELECT * FROM `image` WHERE ImageId =" . $imageId;
    $answer = sqlSelect($sql);
    return $answer[0];
}

function db_updateImage($imageId, $imageName) {
    $sql = "UPDATE `image` SET Name='" . $imageName . "' WHERE ImageId=" . $imageId . " ;";
    sqlQuery($sql);
}

function db_getImageCountByEmailaddress($emailaddress)
{
    $sql = "SELECT COUNT(ImageId) FROM image WHERE GalleryId IN (SELECT GalleryId FROM gallery WHERE OwnerId = (SELECT UserId FROM `user` WHERE Emailaddress ='" . strtolower($emailaddress) . "'))";
    $answer = sqlSelect($sql);
    return $answer[0]["COUNT(ImageId)"];
}

function db_getImagePathsByGallery($galleryId){
    $sql = "SELECT RelativePath FROM `image` WHERE GalleryId=" . $galleryId;
    $answer = sqlSelect($sql);
    $back = [];
    foreach ($answer['RelativePath'] as $image){
        $back.array_push($image);
    }
}

/**
 * Gallery entity functions
 */

function db_getGalleryCountByEmailaddress($emailaddress)
{
    $sql = "SELECT COUNT(GalleryId) FROM gallery WHERE OwnerId = (SELECT UserId FROM `user` WHERE Emailaddress ='" . strtolower($emailaddress) . "')";
    $answer = sqlSelect($sql);
    return $answer[0]["COUNT(GalleryId)"];
}

function db_getGalleriesByUser($userId)
{
    $sql = "SELECT * FROM gallery WHERE OwnerId=" . $userId . ";";
    $answer = sqlSelect($sql);
    return $answer;
}

function db_createGallery($userId, $galleryTitle, $galleryShowTitle, $galleryDescription, $galleryPath)
{
    $sql = "INSERT INTO `gallery` (Title, ShowTitle ,Description, OwnerId,  DirectoryPath) VALUES('" . $galleryTitle . "', '" . $galleryShowTitle . "', '" . $galleryDescription ."', '" . $userId . "' , '" . strtolower($galleryPath). "')";
    sqlQuery($sql);
}

function db_deleteGallery($galleryId) {
    $sql = "DELETE FROM `gallery` WHERE GalleryId=" . $galleryId .";";
    sqlQuery($sql);
}

function db_isGalleryExisting($userId, $galleryTitle)
{
    $sql = "SELECT Count(GalleryId) FROM `gallery` WHERE Title='" . $galleryTitle . "' AND OwnerId =" . $userId . ";";
    $answer = sqlSelect($sql);
    if ($answer[0]['Count(GalleryId)'] == 0) {
        return false;
    }
    return true;
}

function db_getGalleryById($galleryId){
    $sql = "SELECT * FROM `gallery` WHERE GalleryId=" . $galleryId . ";";
    $answer = sqlSelect($sql);
    return $answer[0];
}

function db_isGalleryIdBelongingToUser($galleryId, $userId){
    $sql = "SELECT COUNT(GalleryId) FROM `gallery` WHERE OwnerId =" . $userId ." AND GalleryId=" . $galleryId .";";
    $answer = sqlSelect($sql);
    return $answer[0]['COUNT(GalleryId)'] != 0;
}


function db_updateGallery($galleryId, $galleryShowTitle, $galleryDescription){
    $sql = "UPDATE `gallery` SET ShowTitle='" . $galleryShowTitle ."', Description = '" . $galleryDescription ."' WHERE GalleryId=" . $galleryId . ";";
    sqlQuery($sql);
}
?>
