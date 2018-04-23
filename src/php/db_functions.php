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

function createUser($email, $nickname, $password)
{
    $sql = "INSERT INTO `User` (Emailaddress, `Password`, Nickname, IsAdmin) VALUES ('" . $email . "','" . hashPassword($password) . "','" . $nickname . "',0)";
    sqlQuery($sql);
}

function areUserCredentialsValid($email, $password)
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

function isUserPasswordMatching($userId, $raw)
{
    $sql = "SELECT Password FROM `User` WHERE UserId = " . $userId . ";";
    $answer = sqlSelect($sql);
    if (!empty($answer[0]['Password'])) {
        return password_verify($raw, $answer[0]['Password']);
    }
    return false;
}

function getUserByEmailaddress($emailaddress)
{
    $sql = "SELECT * FROM `User` WHERE Emailaddress ='" . $emailaddress . "';";
    $answer = sqlSelect($sql);
    return $answer;
}

function getImageCountByEmailaddress($emailaddress)
{
    $sql = "SELECT COUNT(ImageId) FROM image WHERE GalleryId = (SELECT GalleryId FROM gallery WHERE OwnerId = (SELECT UserId FROM `user` WHERE Emailaddress ='" . strtolower($emailaddress) . "'))";
    $answer = sqlSelect($sql);
    return $answer[0]["COUNT(ImageId)"];

}

function getGalleryCountByEmailaddress($emailaddress)
{
    $sql = "SELECT COUNT(GalleryId) FROM gallery WHERE OwnerId = (SELECT UserId FROM `user` WHERE Emailaddress ='" . strtolower($emailaddress) . "')";
    $answer = sqlSelect($sql);
    return $answer[0]["COUNT(GalleryId)"];
}

function getGalleriesByUser($userId)
{
    $sql = "SELECT * FROM gallery WHERE OwnerId=" . $userId . ";";
    $answer = sqlSelect($sql);
    echo "<script>console.log('" . json_encode($answer) . "')</script>";
    return $answer;
}

function createGallery($userId, $galleryTitle, $galleryDescription, $galleryPath)
{
    $sql = "INSERT INTO `gallery` (Title, Description, OwnerId,  DirectoryPath) VALUES('" . $galleryTitle . "', '" . $galleryDescription . "', '" . $userId . "' , '" . $galleryPath . "')";
}

function isGalleryExisting($userId, $galleryTitle)
{
    $sql = "SELECT Count(GalleryId) FROM `gallery` WHERE GalleryTitle='" . $galleryTitle . "' AND OwnerId = '" . $userId . "'  ;";
    $answer = sqlSelect($sql);
    if ($answer[0]['Count(GalleryId)'] == 0) {
        return false;
    }
    return true;
}

function deleteUserByUserId($userId)
{
    $sql = "DELETE FROM `user` WHERE UserId =". $userId .";";
    sqlQuery($sql);
}

function updateUserNicknameByUserId($userId, $nickname)
{
    $sql = "UPDATE `User` SET Nickname = '" . $nickname . "' WHERE UserId=" . $userId . ";";
    sqlQuery($sql);
}

function updateUserPasswordByUserId($userId, $password)
{
    $sql = "UPDATE `User` SET Password = '" . hashPassword($password) . "' WHERE UserId =" . $userId . ";";
    sqlQuery($sql);
}

function hashPassword($password)
{
    $options = ['cost' => 12];
    return password_hash($password, PASSWORD_BCRYPT, $options);
}

?>