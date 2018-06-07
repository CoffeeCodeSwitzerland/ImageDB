<?php
  header("Content-type: image/jpeg");
  if(isset($_GET['imageId'])) {
      $image = db_getImageById($_GET['imageId']);
      if (db_isGalleryIdBelongingToUser($image['GalleryId'], getSessionUserId())) {
          $gallery = db_getGalleryById($image['GalleryId']);
          readfile( "../storage/galleries/" . getSessionEmailaddress() . "/" . $gallery['Title'] . "/" . $image['RelativePath']);
      }
  }
?>