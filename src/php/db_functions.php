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
    $stmt = basic_prepareStatement("DELETE FROM `user` WHERE UserId=:userId");
    $stmt->bindParam(':userId', $userId);
    $stmt->execute();
}

function db_updateUserNicknameByUserId($userId, $nickname)
{
    $stmt = basic_prepareStatement("UPDATE `User` SET Nickname=:nickname WHERE UserId=:userId");
    $stmt->bindParam(':nickname', $nickname);
    $stmt->bindParam(':userId', $userId);
    $stmt->execute();
}

function db_updateUserPasswordByUserId($userId, $password)
{
    $stmt = basic_prepareStatement("UPDATE `User` SET Password=:password WHERE UserId=:userId");
    $newPw = db_hashPassword($password);
    $stmt->bindParam(':password', $newPw);
    $stmt->bindParam(':userId', $userId);
    $stmt->execute();
}

//TODO check db_getAllUsers
function db_getAllUsers()
{
    $stmt = basic_prepareStatement("SELECT * FROM `User`");
    $toReturn = array();
    if ($stmt->execute()) {
        while ($row = $stmt->fetch()) {
            array_push($toReturn, $row);
        }
    }
    return $toReturn;
//    $sql = "SELECT * FROM `User`;";
//    $answer = sqlSelect($sql);
//    $toReturn = array();
//    foreach($answer as $row){
//        array_push($toReturn, $row);
//    }
//    return $toReturn;
}

function db_createUser($email, $nickname, $password)
{
    $stmt = basic_prepareStatement("INSERT INTO `user` (Emailaddress, Password, Nickname, IsAdmin) VALUES (:emailAddress,:password,:nickname,0)");
    $hashPw = db_hashPassword($password);
    $stmt->bindParam(':emailAddress', $email);
    $stmt->bindParam(':password', $hashPw);
    $stmt->bindParam(':nickname', $nickname);
    $stmt->execute();
}

function db_userWithEmailaddressExists($email)
{
    $stmt = basic_prepareStatement("SELECT COUNT(UserId) FROM `user` WHERE Emailaddress=:emailAddress");
    $modifiedEmail = strtolower($email);
    $stmt->bindParam(':emailAddress', $modifiedEmail);
    if ($stmt->execute()) {
        while ($row = $stmt->fetch()) {
            if ($row['COUNT(UserId)'] >= 1) {
                return true;
            }
        }
    }
    return false;
}


function db_areUserCredentialsValid($email, $password)
{
    $stmt = basic_prepareStatement("SELECT Password FROM `user` WHERE Emailaddress=:emailaddress");
    $modifiedEmail = strtolower($email);
    $stmt->bindParam(':emailaddress', $modifiedEmail);

    if ($stmt->execute()) {
        while ($row = $stmt->fetch()) {
            if (!empty($row['Password'])) {
                if (password_verify($password, $row['Password'])) {
                    return true;
                }
            }
        }
    }
    return false;
}

function db_isUserPasswordMatching($userId, $raw)
{
    $stmt = basic_prepareStatement("SELECT Password FROM `user` WHERE  UserId=:userId");
    $stmt->bindParam(':userId', $userId);

    if ($stmt->execute()) {
        while ($row = $stmt->fetch()) {
            if (!empty($row['Password'])) {
                return password_verify($raw, $row['Password']);
            }
        }
    }
    return false;
}

function db_getUserByEmailaddress($emailaddress)
{
    $stmt = basic_prepareStatement("SELECT * FROM `user` WHERE Emailaddress=:emailAddress");
    $stmt->bindParam(':emailAddress', $emailaddress);
    if ($stmt->execute()) {
        while ($row = $stmt->fetch()) {
            return $row;
        }
    }
}

//TODO check db_getAdminUserIds
function db_getAdminUserIds()
{
    $stmt = basic_prepareStatement("SELECT UserId FROM `user` WHERE IsAdmin=1");
    $toReturn = array();
    if ($stmt->execute()) {
        while ($row = $stmt->fetch()) {
            array_push($toReturn, $row['UserId']);
        }
    }
    return $toReturn;
//    $sql = "SELECT UserId FROM `User` WHERE IsAdmin = 1  ;";
//    $answer = sqlSelect($sql);
//    $toReturn = array();
//    foreach($answer as $row){
//        array_push($toReturn, $row['UserId']);
//    }
//    return $toReturn;
}

/**
 * Image entity functions
 */

function db_getImagesByGalleryId($galleryId)
{
    $stmt = basic_prepareStatement("SELECT * FROM `image` WHERE GalleryId=:galleryId");
    $stmt->bindParam(':galleryId', $galleryId);
    $toReturn = array();
    if ($stmt->execute()) {
        while ($row = $stmt->fetch()) {
            array_push($toReturn, $row);
        }
    }
    return $toReturn;
}

function db_createImage($galleryId, $name, $relativepath, $thubmnailPath)
{
    $stmt = basic_prepareStatement("INSERT INTO `image` (GalleryId, Name, RelativePath, ThumbnailPath) VALUES (:galleryId,:name,:relativePath,:thumbnailPath)");
    $stmt->bindParam(':galleryId', $galleryId);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':relativePath', $relativepath);
    $stmt->bindParam(':thumbnailPath', $thubmnailPath);
    $stmt->execute();

    $stmt2 = basic_prepareStatement("SELECT ImageId FROM `image` WHERE GalleryId=:galleryId AND Name=:name");
    $stmt2->bindParam(':galleryId', $galleryId);
    $stmt2->bindParam(':name', $name);
    if ($stmt2->execute()) {
        while ($row = $stmt2->fetch()) {
            return $row['ImageId'];
        }
    }
}

function db_deleteImage($imageId)
{
    $stmt = basic_prepareStatement("DELETE FROM `image` WHERE ImageId=:imageId");
    $stmt->bindParam(':imageId', $imageId);
    $stmt->execute();
}

function db_getImageById($imageId)
{
    $stmt = basic_prepareStatement("SELECT * FROM `image` WHERE ImageId=:imageId");
    $stmt->bindParam(':imageId', $imageId);

    if($stmt->execute()){
        while ($row = $stmt->fetch()){
            return $row;
        }
    }
}

function db_updateImage($imageId, $imageName)
{
    $stmt = basic_prepareStatement("UPDATE `image` SET Name=:imageName WHERE ImageId=:imageId");
    $stmt->bindParam(':imageName', $imageName);
    $stmt->bindParam(':imageId', $imageId);
    $stmt->execute();
}

function db_getImageCountByEmailaddress($emailaddress)
{
    $stmt = basic_prepareStatement("SELECT COUNT(ImageId) FROM image WHERE GalleryId IN (SELECT GalleryId FROM gallery WHERE OwnerId = (SELECT UserId FROM `user` WHERE Emailaddress =:emailAddress))");
    $modifiedEmailaddres = strtolower($emailaddress);
    $stmt->bindParam(':emailAddress', $modifiedEmailaddres);

    if($stmt->execute()){
        while ($row = $stmt->fetch()){
            return $row['COUNT(ImageId)'];
        }
    }
}

function db_getImagePathsByGallery($galleryId)
{
    $stmt = basic_prepareStatement("SELECT RelativePath FROM `image` WHERE GalleryId=:galleryId");
    $stmt->bindParam(':galleryId', $galleryId);
    $answer = array();

    if($stmt->execute()){
        while ($row = $stmt->fetch()){
            array_push($answer, $row);
        }
    }
}

/**
 * Tag entity functions
 */

function db_addTagsToImage($imageId, $tagId)
{
    $stmt = basic_prepareStatement("INSERT INTO `imagetag` (TagId, ImageId) VALUES (:tagId, :imageId)");
    $stmt->bindParam(':tagId', $tagId);
    $stmt->bindParam(':imageId', $imageId);
    $stmt->execute();
}

function db_getAllTags($userId)
{
    $stmt = basic_prepareStatement("SELECT * FROM `tag` WHERE CreatorId=:creator");
    $stmt->bindParam(':creator', $userId);

    $toReturn = array();
    if($stmt->execute()){
        while($row = $stmt->fetch()){
            array_push($toReturn, $row);
        }
    }

    return $toReturn;
}

function db_getTagsByImageId($imageId)
{
    $stmt = basic_prepareStatement("SELECT t.TagId, t.Name FROM `imagetag` AS i JOIN `tag` AS t ON t.TagId = i.TagId AND i.ImageId=:imageId");
    $stmt->bindParam(':imageId', $imageId);

    $toReturn = array();
    if($stmt->execute()){
        while ($row = $stmt->fetch()){
            array_push($toReturn, $row);
        }
    }

    return $toReturn;
}

function db_getImagesByTagAndGallery($tagId, $galleryId)
{
    $stmt = basic_prepareStatement("SELECT i.ImageId, i.Name, i.GalleryId, i.ThumbnailPath, i.RelativePath FROM `image` AS i JOIN `imagetag` AS im ON i.ImageId = im.ImageId WHERE i.GalleryId=:galleryId AND im.TagId=:tagId");
    $stmt->bindParam(':galleryId', $galleryId);
    $stmt->bindParam(':tagId', $tagId);

    $toReturn = array();
    if($stmt->execute()){
        while ($row = $stmt->fetch()){
            array_push($toReturn, $row);
        }
    }
    return $toReturn;
}

function db_getImageCountAssociatedWithTagId($tagId){
    $stmt = basic_prepareStatement("SELECT Count(it.TagId), t.TagId, t.Name FROM `imagetag` AS it JOIN `tag` AS t ON it.TagId=t.TagId WHERE it.TagId=:tagId");
    $stmt->bindParam(':tagId', $tagId);

    if($stmt->execute()){
        while($row = $stmt->fetch()){
            return $row['Count(it.TagId)'];
        }
    }
}

function db_isTagExisting($tagName, $userId){
    $stmt = basic_prepareStatement("SELECT Count(TagId) FROM `tag` WHERE LOWER(Name)=:name AND CreatorId=:userId");
    $modifiedName = strtolower($tagName);
    $stmt->bindParam(':name', $modifiedName);
    $stmt->bindParam('userId', $userId);

    if($stmt->execute()){
        while ($row = $stmt->fetch()){
            if($row['Count(TagId)'] >= 1){
                return true;
            }else{
                return false;
            }
        }
    }
}

function db_createTag($tagName, $userId){
    $stmt = basic_prepareStatement("INSERT INTO `tag` (Name, CreatorId) VALUES (:name,:creator)");
    $stmt->bindParam(':name', $tagName);
    $stmt->bindParam(':creator', $userId);
    $stmt->execute();
}

function db_updateTag($tagId, $tagName){
    $stmt = basic_prepareStatement("UPDATE `tag` SET Name=:name WHERE TagId=:tagId");
    $stmt->bindParam(':tagId', $tagId);
    $stmt->bindParam(':name', $tagName);
    $stmt->execute();
}

function db_deleteTag($tagId){
    $stmt = basic_prepareStatement("DELETE FROM `tag` WHERE TagId=:tagId");
    $stmt->bindParam(':tagId', $tagId);
    $stmt->execute();
}

/**
 * Gallery entity functions
 */

function db_getGalleryCountByEmailaddress($emailaddress)
{
    $stmt = basic_prepareStatement("SELECT COUNT(GalleryId) FROM gallery WHERE OwnerId = (SELECT UserId FROM `user` WHERE Emailaddress =:emailAddress)");
    $stmt->bindParam(':emailAddress', $emailaddress);

    if($stmt->execute()){
        while ($row = $stmt->fetch()){
            return $row['COUNT(GalleryId)'];
        }
    }
}

function db_getGalleriesByUser($userId)
{
    $stmt = basic_prepareStatement("SELECT * FROM gallery WHERE OwnerId=:ownerId");
    $stmt->bindParam(':ownerId', $userId);

    $toReturn = array();
    if($stmt->execute()){
        while ($row = $stmt->fetch()){
            array_push($toReturn, $row);
        }
    }

    return $toReturn;
}

function db_createGallery($userId, $galleryTitle, $galleryShowTitle, $galleryDescription, $galleryPath)
{
    $stmt = basic_prepareStatement("INSERT INTO `gallery` (Title, ShowTitle ,Description, OwnerId,  DirectoryPath) VALUES(:galleryTitle,:galleryShowTitle,:galleryDescription,:userId,:galleryPath)");
    $modifiedPath = strtolower($galleryPath);
    $stmt->bindParam(':galleryTitle', $galleryTitle);
    $stmt->bindParam(':galleryShowTitle', $galleryShowTitle);
    $stmt->bindParam(':galleryDescription', $galleryDescription);
    $stmt->bindParam(':userId', $userId);
    $stmt->bindParam(':galleryPath', $modifiedPath);
    $stmt->execute();
}

function db_deleteGallery($galleryId)
{
    $stmt = basic_prepareStatement("DELETE FROM `gallery` WHERE GalleryId=:galleryId");
    $stmt->bindParam(':galleryId', $galleryId);
    $stmt->execute();
}

function db_isGalleryExisting($userId, $galleryTitle)
{
    consoleLog($galleryTitle);
    $stmt = basic_prepareStatement("SELECT Count(GalleryId) FROM `gallery` WHERE Title=:title AND OwnerId =:ownerId");
    $stmt->bindParam(':title', $galleryTitle);
    $stmt->bindParam(':ownerId', $userId);

    if($stmt->execute()){
        while ($row = $stmt->fetch()){
            if($row['Count(GalleryId)'] == 0){
                return false;
            }
            return true;
        }
    }
}

function db_getGalleryById($galleryId)
{
    $stmt = basic_prepareStatement("SELECT * FROM `gallery` WHERE GalleryId=:galleryId");
    $stmt->bindParam(':galleryId', $galleryId);

    if($stmt->execute()){
        while ($row = $stmt->fetch()){
            return $row;
        }
    }
}

function db_isGalleryIdBelongingToUser($galleryId, $userId)
{
    $stmt = basic_prepareStatement("SELECT COUNT(GalleryId) FROM `gallery` WHERE OwnerId=:userId AND GalleryId=:galleryId");
    $stmt->bindParam(':userId', $userId);
    $stmt->bindParam(':galleryId', $galleryId);

    if($stmt->execute()){
        while ($row = $stmt->fetch()){
            return $row['COUNT(GalleryId)'] != 0;
        }
    }
}


function db_updateGallery($galleryId, $galleryShowTitle, $galleryDescription)
{
    $stmt = basic_prepareStatement("UPDATE `gallery` SET ShowTitle=:showTitle, Description=:description WHERE GalleryId=:galleryId");
    $stmt->bindParam(':showTitle', $galleryShowTitle);
    $stmt->bindParam(':description', $galleryDescription);
    $stmt->bindParam('galleryId', $galleryId);
    $stmt->execute();
}

?>
