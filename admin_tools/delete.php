<?php
   ob_start();
   session_start();
 error_reporting(E_ALL);
ini_set('display_errors', '1');
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
	if (isset($_GET['toBeDeleted-Monsters'])){
		if (!($delQ = $con->prepare("DELETE FROM `Monsters` WHERE `Name`=:del"))) {
			echo "Prepare failed: (" . $con->errno . ") " . $con->error;
		}
		$delQ->bindValue(":del", $_GET['toBeDeleted-Monsters'], PDO::PARAM_STR);
		$delQ->execute();
	}
	else if (isset($_GET['toBeDeleted-Items'])){
		if (!($delQ = $con->prepare("DELETE FROM `Items` WHERE `Name`=:del"))) {
			echo "Prepare failed: (" . $con->errno . ") " . $con->error;
		}
		$delQ->bindValue(":del", $_GET['toBeDeleted-Items'], PDO::PARAM_STR);
		$delQ->execute();
	}
	else if (isset($_GET['toBeDeleted-Spells'])){
		if (!($delQ = $con->prepare("DELETE FROM `Spells` WHERE `Name`=:del"))) {
			echo "Prepare failed: (" . $con->errno . ") " . $con->error;
		}
		$delQ->bindValue(":del", $_GET['toBeDeleted-Spells'], PDO::PARAM_STR);
		$delQ->execute();
	}
	
	header("location:/admin_tools/admins.php");
	exit();
?>
