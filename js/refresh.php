<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
function connect() {
    return new PDO("mysql:dbname=casagra1_dnd;host=localhost","casagra1_user","password", array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    //return new PDO("mysql:dbname=casagra1_dnd;host=localhost","casagra1_user","password");
}
$pdo = connect();
$search = $_POST['search'];
$keyword = "Name";//$_POST['key'];
$type = $_POST['type'];
//echo "SELECT * FROM ".$type." WHERE ".$keyword." LIKE %".$search."% ORDER BY `Name` ASC LIMIT 0, 10";
if ($type == "Spells")
	$query = $pdo->prepare("SELECT * FROM `Spells` WHERE `Name` LIKE :search3 ORDER BY
  CASE WHEN `Name` LIKE :search1 THEN 1
   WHEN `Name` LIKE :search2 THEN 2
   WHEN `Name` LIKE :search3 THEN 3 ELSE 4 END ASC LIMIT 0, 10");
else if ($type == "Items")
	$query = $pdo->prepare("SELECT * FROM `Items` WHERE `Name` LIKE :search3 ORDER BY
  CASE WHEN `Name` LIKE :search1 THEN 1
   WHEN `Name` LIKE :search2 THEN 2
   WHEN `Name` LIKE :search3 THEN 3 ELSE 4 END ASC LIMIT 0, 10");
else
	$query = $pdo->prepare("SELECT * FROM `Monsters` WHERE `Name` LIKE :search3 ORDER BY
  CASE WHEN `Name` LIKE :search1 THEN 1
   WHEN `Name` LIKE :search2 THEN 2
   WHEN `Name` LIKE :search3 THEN 3 ELSE 4 END ASC LIMIT 0, 10");

$query->bindValue(":search1", $search . '%', PDO::PARAM_STR);
$query->bindValue(":search2", '%' . $search, PDO::PARAM_STR);
$query->bindValue(":search3", '%' . $search . '%', PDO::PARAM_STR);
$query->execute();
$list = $query->fetchAll();
foreach ($list as $rs) {
	$name = str_replace($_POST['search'], '<b>'.$_POST['search'].'</b>', $rs[$keyword]);
    echo '<li onclick="set_item(\''.str_replace("'", "\'", $rs[$keyword]).'\')">'.$name.'</li>';
}
?>