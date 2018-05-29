<?php
/*
 *  @autor Michael Abplanalp
 *  @version März 2018
 *  Dieses Modul definert alle Konfigurationsparameter und stellt die DB-Verbindung her
 */

// Funktionen
setValue("cfg_func_list", array("login","registration"));
// Inhalt des Menus
setValue("cfg_menu_list", array("login"=>"Login","registration"=>"Registration"));

setValue("cfg_func_user_list", array("logout","overview","galleries", "images", "tags"));
// Inhalt des Menus
setValue("cfg_menu_user_list", array("logout"=>"Logout","overview"=>"Overview","galleries"=>"Galleries","tags"=>"Tags"));

setValue("cfg_func_admin_list", array("adminUsers","adminGalleries","logout"));
// Inhalt des Menus
setValue("cfg_menu_admin_list", array("adminUsers"=>"Users","adminGalleries"=>"Galleries","logout"=>"Logout"));

setValue("galleryRoot", "D:\\xampp\htdocs\ImageDB\src\storage\galleries");
//setValue("galleryRoot", "D:\\Xampp\\htdocs\\ImageDbSrc");

//PDO connection
$dbh = new PDO('mysql:host=127.0.0.1;dbname=imagedb', "root", "gibbiX12345");
setValue('dbh', $dbh);

// Datenbankverbindung herstellen
$db = mysqli_connect("127.0.0.1", "root", "gibbiX12345", "imagedb");
if (!$db) die("Verbindungsfehler: ".mysqli_connect_error());
setValue("cfg_db", $db);
?>
