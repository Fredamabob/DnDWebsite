<!DOCTYPE html>
<?php
   ob_start();
   session_start();
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" href="wiki_page.css">
    <link rel="shortcut icon" href="favicon.png"/>
    <title>
	<?php echo $_GET["search"]; ?> - DnD Info
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
<?php echo "<div class=\"fixed2\">";  
if ($_SESSION['valid'] == true){
  echo "Logged in as<br>". $_SESSION['username'];
  echo "<br><a href=\"profile.php\">My Profile</a>";
  echo "<br><a href=\"save.php?search=".$_GET["search"]."&type=".$_GET["type"]."\">Save this page</a>";
  echo "<br><br><a href=\"logout.php\">Logout</a></div>";
}else{
	echo "Not logged in. Click <a href = \"login.php\" title = \"Logout\">here</a> to login.<br>";
        echo "<br>New user?<br> Click <a href = \"newacc.php\" title = \"New Account\">here</a> to make a new account.</div>";
}
?>
<?php
//error_reporting(E_ALL);
//ini_set('display_errors', '1');
//echo "<img src=\"http://www.aidedd.org/dnd/images/". lcfirst($_GET["search"]) .".jpg\" alt=\"". $_GET["search"] .".\" width=\"30%\" height=\"40%\" class=\"pic\">";
?>
<?php
  $search = $_GET["search"];
  $key = $_GET["key"];
  function rep_str($text, $str, $tag1, $tag2) {
    return str_replace($text, $tag1.$text.$tag2, $str);
  }
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
	if (!empty($tmp)) {
		echo "<div class=\"fixed\"><a href=\"index.php\">Home</a><br><a href=\"admin_tools/admins.php\">Admin Module</a>
		<br><a href=\"admin_tools/edit.php?search=".$search."&type=".$_GET['type']."\">Edit this page</a></div>";
  }else{
	  echo "<div class=\"fixed\"><a href=\"index.php\">Home</a></div>";
  }
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
		  if (!($query = $con->prepare("SELECT * FROM `Spells` WHERE" . $key . "LIKE :search ORDER BY `Level` ASC "))) {
				echo "Prepare failed: (" . $con->errno . ") " . $con->error;
		  }
		}else{
			if (!($query = $con->prepare("SELECT * FROM `Spells` WHERE `Name` LIKE :search ORDER BY `Level` ASC "))) {
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
  echo "<div class=\"style1\">";
  while ($row = $results->fetch(PDO::FETCH_ASSOC)) {
    foreach($row as $field) {
        $i++;
		$temp = htmlspecialchars($field);
		if ($_GET["type"] == "Monsters"){
			//Format Abilities/Actions
			$temp = preg_replace("/(\n)([0-9]+\. )?([a-zA-Z']+ )(Rays?)/", "$1<br>$2<i>$3$4</i>", $temp);//Replace ray attacks
			$temp = preg_replace("/((\...|\..))([A-Z][a-zA-Z']+ ?([a-zA-Z']+)?)(\.| \()/s", "$1<br><i>$3</i>$5", $temp);//Replace all abilities
			$temp = preg_replace("/(:.|:..|:...)([A-Z][a-zA-Z']+ ?([a-zA-Z']+)?)(\.| \()/s", "$1<i>$2</i>$4", $temp);//Replace abilities under actions
			$temp = preg_replace("/^([A-Z][a-zA-Z']+ ?([a-zA-Z']+)?)(\.| \()/s", "<i>$1</i>$3", $temp);//Replace abilities at start
			$temp = preg_replace("/(Keen Hearing and Smell)(\.)/", "<i>$1</i>$2", $temp);
			$temp = preg_replace("/(\n|)(Tentacle Attack or Fling)(\.)/", "$1<br><i>$2</i>$3", $temp);
			$temp = preg_replace("/(Invisible in Water)(\.)/", "<i>$1</i>$2", $temp);
			$temp = preg_replace("/(Tail Spike Regrowth)(\.)/", "<i>$1</i>$2", $temp);
			$temp = preg_replace("/(\n|)(Freedom of Movement)(\.)/", "$1<br><i>$2</i>$3", $temp);
			$temp = preg_replace("/(Keen Hearing and Sight)(\.)/", "<i>$1</i>$2", $temp);
			//Format Stats
			$temp = preg_replace("/(.*)(STR.{11})(.*)(DEX.{11})(.*)(CON.{11})(.*)(INT.{11})(.*)(WIS.{11})(.*)(CHA.{11})(.*)/s", "$1$2$4$6$8$10$12$3$5$7$9$11$13", $temp);
			$temp = preg_replace("/(STR)([^:].*)(DEX)([^:].*)(CON)([^:].*)(INT)([^:].*)(WIS)([^:].*)(CHA)([^:])/s", "$1:$2$3:$4$5:$6$7:$8$9:$10$11:$12", $temp);
			$temp = rep_str("Armor Class:", $temp, "<strong>", "</strong>");
			$temp = rep_str("Hit Points:", $temp, "<br><strong>", "</strong>");
			$temp = rep_str("Speed:", $temp, "<br><strong>", "</strong>");
			$temp = rep_str("ACTIONS:", $temp, "<br><strong>", "</strong><br>");
			$temp = preg_replace("/(RE)<br><strong>(ACTIONS:)/", "<br><strong>$1$2</strong>", $temp);
			$temp = rep_str("LEGENDARY ACTIONS", $temp, "<br><strong>", ":</strong><br>");
			$temp = rep_str("STR:", $temp, "<br>", "");$temp = rep_str("DEX:", $temp, "<br>", "");$temp = rep_str("CON:", $temp, "<br>", "");
			$temp = rep_str("INT:", $temp, "<br>", "");$temp = rep_str("WIS:", $temp, "<br>", "");$temp = rep_str("CHA:", $temp, "<br>", "");
			$temp = rep_str("Skills:", $temp, "<br><strong>", "</strong>");
			$temp = rep_str("Damage Resistances:", $temp, "<br><strong>", "</strong>");
			$temp = rep_str("Damage Vulnerabilities:", $temp, "<br><strong>", "</strong>");
			$temp = rep_str("Damage Immunities:", $temp, "<br><strong>", "</strong>");
			$temp = rep_str("Condition Immunities:", $temp, "<br><strong>", "</strong>");
			$temp = rep_str("Senses:", $temp, "<br><strong>", "</strong>");
			$temp = rep_str("Languages:", $temp, "<br><strong>", "</strong>");
			$temp = rep_str("Challenge:", $temp, "<br><strong>", "</strong>");
			$temp = rep_str("Saving Throws:", $temp, "<br><strong>", "</strong>");
		}
		else if ($_GET["type"] == "Items"){
		}
		else if ($_GET["type"] == "Spells"){
			$temp = rep_str("Constitution", $temp, "<i>", "</i>");
			$temp = rep_str("Intelligence", $temp, "<i>", "</i>");
			$temp = rep_str("Wisdom", $temp, "<i>", "</i>");
			$temp = rep_str("Charisma", $temp, "<i>", "</i>");
			$temp = rep_str("Strength", $temp, "<i>", "</i>");
			$temp = rep_str("Dexterity", $temp, "<i>", "</i>");
			$temp = rep_str("Casting Time:", $temp, "<strong>", "</strong>");
			$temp = rep_str("Range:", $temp, "<strong>", "</strong>");
			$temp = rep_str("Components:", $temp, "<strong>", "</strong>");
			$temp = rep_str("Duration:", $temp, "<strong>", "</strong>");
			$temp = rep_str("At Higher Levels. ", $temp, "<strong>", "</strong>");
			$temp = preg_replace("/(\n)/", "<br>", $temp);
			$temp = preg_replace("/(<br>.<br>)/", "<br>", $temp);
			$temp = preg_replace("/([0-9][a-zA-Z]{2}-level)/", "<strong>$1:</strong>", $temp);
			$temp = preg_replace("/([a-zA-Z]+)( cantrip)/", "<strong>Cantrip: </strong>$1", $temp);
		}
        if($i == 1)
            echo "<div class=\"name\">";
		else
			echo "<div><svg width=\"100%\" viewBox=\"0 0 360 2.5\"><polyline points=\"0,0 360,2.5 0,5\" style=\"fill:#922610;stroke:#922610;\"></polyline></svg></div>";
		echo $temp;
        if($i == 1)
            echo "</div>";
    }
    $i = 0;
  }
  echo "</div>";
?>
</body>
</html>
