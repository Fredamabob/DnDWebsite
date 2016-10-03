<!DOCTYPE html>
<?php
   ob_start();
   session_start();
?>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="base.css">
    <link rel="shortcut icon" href="favicon.png"/>
    <title>
	DnD Info Search
    </title>
<style>
div.fixed {
    text-align: center;
    position: fixed;
    top: 25px;
    left: 25px;
    width: 100px;
    border-radius: 25px;
    background-color: rgba(255, 255, 255, 0.7);
}
div.fixed2 {
    text-align: center;
    position: fixed;
    top: 25px;
    right: 25px;
    width: 115px;
    border-radius: 25px;
    background-color: rgba(255, 255, 255, 0.7);
}
body {text-align:center;}
table.centre {
    margin-left:auto; 
    margin-right:auto;
}
table {
    border-collapse: collapse;
}

table, td, th {
    background-color: rgba(255, 255, 255, 0.5);
    border: 1px solid black;
}
</style>
</head>
<body>
<div class="fixed"><?php
  $url = htmlspecialchars($_SERVER['HTTP_REFERER']);
  echo "<a href='$url'>Back</a></div><div class=\"fixed2\">";  
if ($_SESSION['valid'] == true){
  echo "Logged in as ". $_SESSION['username']."</div>";
}else
	echo "Not logged in. Click <a href = \"login.php\" title = \"Logout\">here</a> to login.</div>";
?>
<?php
try {
    $con = new PDO("mysql:dbname= ;host=localhost"," "," ");
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
  //$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $search = $_GET["search"];
  $key = $_GET["key"];
  echo "<table class=\"centre\">";
  if ($_GET["type"] == "Monsters"){
		if ($key == "Size/Alignment" || $key == "Stats" || $key == "Actions/Abilities"){
		  if (!($query = $con->prepare("SELECT * FROM `Monsters` WHERE" . $key . "LIKE :search ORDER BY `Name` ASC "))) {
				echo "Prepare failed: (" . $con->errno . ") " . $con->error;
		  }
		}else{
			if (!($query = $con->prepare("SELECT * FROM `Monsters` WHERE `Name` LIKE :search ORDER BY `Name` ASC "))) {
				echo "Prepare failed: (" . $con->errno . ") " . $con->error;
		  }
		}
		$search_tmp = '%' . $search . '%';
		$query->bindValue(":search", $search_tmp, PDO::PARAM_STR);
		$query->execute();
		//$query = "SELECT * FROM `Monsters` WHERE `" . $key ."` LIKE '%" . $search . "%' ORDER BY `Name` ASC ";
		//echo "<tr><td>Name</td><td>Size/Alignment</td><td>Stats</td><td>Actions/Abilities</td></tr>";
  }
  else if ($_GET["type"] == "Items"){
	  if ($key == "Size/Alignment" || $key == "Stats" || $key == "Actions/Abilities"){
		  if (!($query = $con->prepare("SELECT * FROM `Items` WHERE" . $key . "LIKE :search ORDER BY `Name` ASC "))) {
				echo "Prepare failed: (" . $con->errno . ") " . $con->error;
		  }
		}else{
			if (!($query = $con->prepare("SELECT * FROM `Items` WHERE `Name` LIKE :search ORDER BY `Name` ASC "))) {
				echo "Prepare failed: (" . $con->errno . ") " . $con->error;
		  }
		}
		$search_tmp = '%' . $search . '%';
		$query->bindValue(":search", $search_tmp, PDO::PARAM_STR);
		$query->execute();
		//$query = "SELECT * FROM `Items` WHERE `" . $key ."` LIKE '%" . $search . "%' ORDER BY `Name` ASC ";
		//echo "<tr><td>Name</td><td>Rarity/Type</td><td>Description</td></tr>";
  }
  else if ($_GET["type"] == "Spells"){
	  if ($key == "Size/Alignment" || $key == "Stats" || $key == "Actions/Abilities"){
		  if (!($query = $con->prepare("SELECT * FROM `Spells` WHERE" . $key . "LIKE :search ORDER BY `Spells`.`Level` ASC "))) {
				echo "Prepare failed: (" . $con->errno . ") " . $con->error;
		  }
		}else{
			if (!($query = $con->prepare("SELECT * FROM `Spells` WHERE `Name` LIKE :search ORDER BY `Spells`.`Level` ASC "))) {
				echo "Prepare failed: (" . $con->errno . ") " . $con->error;
		  }
		}
		$search_tmp = '%' . $search . '%';
		$query->bindValue(":search", $search_tmp, PDO::PARAM_STR);
		$query->execute();
		//$query = "SELECT * FROM `Spells` WHERE `" . $key ."` LIKE '%" . $search . "%' ORDER BY `Level` ASC ";
		//echo "<tr><td>Level</td><td>Name</td><td>Stats</td><td>Description</td></tr>";
  }
  $results = $query;
  $i = 0;
  while ($row = $results->fetch(PDO::FETCH_ASSOC)) {
    echo "<tr>";
    foreach($row as $field) {
		if($i == 1){
			if ($_GET["type"] == "Spells")
				echo "<td><a href=\"format.php?search=" . htmlspecialchars($field) . "&type=" . $_GET["type"] . "&key=Name\" target=\"_blank\">" . htmlspecialchars($field) . "</a></td>";
		}
		else if ($i == 0){
			if ($_GET["type"] != "Spells")
				echo "<td><a href=\"format.php?search=" . htmlspecialchars($field) . "&type=" . $_GET["type"] . "&key=Name\" target=\"_blank\">" . htmlspecialchars($field) . "</a></td>";
		}
		/*else
			echo '<td>' . htmlspecialchars($field) . '</td>';*/
		$i++;
    }
	$i = 0;
    echo "</tr>";
  }
  echo '</table>';
?>
</body>
</html>
