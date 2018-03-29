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

setValue("cfg_func_user_list", array("logout","overview","galleries"));
// Inhalt des Menus
setValue("cfg_menu_user_list", array("logout"=>"Logout","overview"=>"Overview","galleries"=>"Galleries"));

setValue("galleryRoot", "C:\\xampp\htdocs\ImageDB\src\storage\galleries\\");

// Datenbankverbindung herstellen
$db = mysqli_connect("127.0.0.1", "root", "gibbiX12345", "imagedb");
if (!$db) die("Verbindungsfehler: ".mysqli_connect_error());
setValue("cfg_db", $db);
?>
