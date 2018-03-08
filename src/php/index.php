<?php
/*
 *  @autor Michael Abplanalp
 *  @version März 2018
 *  Ausschliesslich dieses Modul wird über die URL aufgerufen. Je nach übergebenem Parameter "id"
 *  wird die entsprechende Funktion ausgeführt. Am Schluss wird das Haupttemplate eingefügt.
 *  Beispielaufruf: http://localhost/index.php?id=show
 *  Im Beispiel wird die Funktion "show" ausgeführt.
 */
session_start();
require("basic_functions.php");
require("config.php");
require("db_functions.php");
require("appl_functions.php");

// Dispatching: Die über den Parameter "id" definierte Funktion ausführen
$func = getId();
// Falls  die verlangte Funktion nicht in der Liste der akzeptierten Funktionen ist, Default-Seite laden
$flist = getValue("cfg_func_list");
if (!in_array($func, $flist)) $func = $flist[0];
// Aktive Funktion global speichern, da diese später noch verwendet wird
setValue("func", $func);
// Funktion aufrufen und Rückgabewert in "inhalt" speichern
setValue("inhalt", $func());

// Haupttemplate aufrufen, Ausgabe an Client (Browser) senden
echo runTemplate("../templates/index.htm.php");
mysqli_close(getValue("cfg_db"));
?>
