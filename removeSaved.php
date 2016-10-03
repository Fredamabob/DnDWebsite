<?php
ob_start();
   session_start();
 error_reporting(E_ALL);
ini_set('display_errors', '1');
  try {
    $con = new PDO("mysql:dbname=casagra1_dnd;host=localhost","casagra1_user","password");
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
  $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	if (!($delQ = $con->prepare("UPDATE `Users` SET `Saved`=REPLACE(`Saved`,:del,'') WHERE`Username`=:user"))) {
		echo "Prepare failed: (" . $con->errno . ") " . $con->error;
	}
	$del = $_GET['search'].",".$_GET['type'].";";
	$delQ->bindValue(":user", $_SESSION['username'], PDO::PARAM_STR);
	$delQ->bindValue(":del", $del, PDO::PARAM_STR);
	$delQ->execute();
	
	header("location:/profile.php");
	exit();
?>