<!DOCTYPE html>
<?php
   ob_start();
   session_start();
?>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="../wiki_page.css">
    <link rel="shortcut icon" href="../favicon.png"/>
    <title>
	Administration Module
    </title>
</head>
<style>
i{
	color:#6D0000;
}
div.fixed {
    text-align: center;
    position: fixed;
    top: 25px;
    left: 25px;
    width: 100px;
    border-radius: 25px;
    background-color: rgba(255, 255, 255, 0.7);
}div.fixed2 {
    text-align: center;
    position: fixed;
    top: 25px;
    right: 25px;
    width: 115px;
    border-radius: 25px;
    background-color: rgba(255, 255, 255, 0.7);
}
img.pic{
    position: absolute;
	border-radius: 25px;
	opacity: 0.7;
    filter: alpha(opacity=70); /* For IE8 and earlier */
}
div.style1 {
    text-align: center;
    border-radius: 25px;
    background-color: rgba(255, 255, 255, 0.7);
    width: 33%;
    padding: 15px;
    margin: 15px;
    margin-left:auto; 
    margin-right:auto;
}
</style>
<body>
<div class="fixed"><?php
  echo "<a href=\"../index.php\">Home</a><br>
  <a href=\"add.php?type=Monsters\">Add a Monster</a><br>
  <a href=\"add.php?type=Items\">Add an Item</a><br>
  <a href=\"add.php?type=Spells\">Add a Spell</a><br>
  </div><div class=\"fixed2\">";  
if ($_SESSION['valid'] == true){
  echo "Logged in as<br>". $_SESSION['username'];
    echo "<br><a href=\"../profile.php\">My Profile</a>";
  echo "<br><br><a href=\"../logout.php\">Logout</a></div>";
}else
	echo "Not logged in. Click <a href = \"../login.php\" title = \"Logout\">here</a> to login.</div>";
?>
<?php
//error_reporting(E_ALL);
//ini_set('display_errors', '1');
?>
<?php
  try {
    $con = new PDO("mysql:dbname= ;host=localhost"," "," ");
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
  $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  	if (!($is_admin = $con->prepare("SELECT `Username` FROM `Admins` WHERE `Username`=:user"))) {
		echo "Prepare failed: (" . $con->errno . ") " . $con->error;
	}
	$is_admin->bindValue(":user", $_SESSION['username'], PDO::PARAM_STR);
	$is_admin->execute();
	$tmp = $is_admin->fetch(PDO::FETCH_ASSOC); 
	if (empty($tmp)) {
		header("location:/index.php");
		exit();
	}
  $search = $_GET["search"];
  $key = $_GET["key"];
  if (!($query = $con->prepare("SELECT `Name` FROM `Monsters`"))) {
		echo "Prepare failed: (" . $con->errno . ") " . $con->error;
  }
  $query->execute();
  $results = $query;
  echo "<div class=\"style1\"><b>Current DB Items (Click name of item to edit, click DEL to delete):</b><br>";
   echo "<div><svg width=\"100%\" viewBox=\"0 0 360 2.5\"><polyline points=\"0,0 360,2.5 0,5\" style=\"fill:#922610;stroke:#922610;\"></polyline></svg></div>";
  echo "<i>Monsters:</i><br>";
  while ($row = $results->fetch(PDO::FETCH_ASSOC)) {
    foreach($row as $field) {
		$temp = htmlspecialchars($field);
		echo "<a href=\"edit.php?search=". $temp ."&type=Monsters\">". $temp ."</a>  [<a href=\"delete.php?toBeDeleted-Monsters=".$temp."\">DEL</a>]<br>";
    }
  }
  echo "<div><svg width=\"100%\" viewBox=\"0 0 360 2.5\"><polyline points=\"0,0 360,2.5 0,5\" style=\"fill:#922610;stroke:#922610;\"></polyline></svg></div>";
  echo "<i>Items:</i><br>";
  if (!($query = $con->prepare("SELECT `Name` FROM `Items`"))) {
		echo "Prepare failed: (" . $con->errno . ") " . $con->error;
  }
  $query->execute();
  $results = $query;
  while ($row = $results->fetch(PDO::FETCH_ASSOC)) {
    foreach($row as $field) {
		$temp = htmlspecialchars($field);
		echo "<a href=\"edit.php?search=". $temp ."&type=Items\">". $temp ."</a>  [<a href=\"delete.php?toBeDeleted-Items=".$temp."\">DEL</a>]<br>";
    }
  }
  echo "<div><svg width=\"100%\" viewBox=\"0 0 360 2.5\"><polyline points=\"0,0 360,2.5 0,5\" style=\"fill:#922610;stroke:#922610;\"></polyline></svg></div>";
  echo "<i>Spells:</i><br>";
  if (!($query = $con->prepare("SELECT `Name` FROM `Spells`"))) {
		echo "Prepare failed: (" . $con->errno . ") " . $con->error;
  }
  $query->execute();
  $results = $query;
  while ($row = $results->fetch(PDO::FETCH_ASSOC)) {
    foreach($row as $field) {
		$temp = htmlspecialchars($field);
		echo "<a href=\"edit.php?search=". $temp ."&type=Spells\">". $temp ."</a>  [<a href=\"delete.php?toBeDeleted-Spells=".$temp."\">DEL</a>]<br>";
    }
  }
  echo "</div>";
?>
</body>
</html>
