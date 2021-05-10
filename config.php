<?php
$servername = "localhost";
$username = "root";
$password = "";
$db = "wtc_teilnehmer";
// Verbindung aufbauen
$conn = mysqli_connect($servername, $username, $password, $db);
// Verbindung prüfen
if (!$conn) {
   die("Connection failed: " . mysqli_connect_error());
}
