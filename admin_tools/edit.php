<!DOCTYPE html>
<?php
   ob_start();
   session_start();
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" href="../wiki_page.css">
    <link rel="shortcut icon" href="../favicon.png"/>
    <title>
	Editing: <?php echo $_GET["search"]; ?>
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
<?php
  echo "<div class=\"fixed\"><a href=\"../index.php\">Home</a><br>
  <a href=\"admins.php\">Admin Module</a><br>
  <a href=\"../format.php?search=".$_GET['search']."&type=".$_GET["type"]."\">View Live</a></div>";
  echo "<div class=\"fixed2\">";  
if ($_SESSION['valid'] == true){
  echo "Logged in as<br>". $_SESSION['username'];
  echo "<br><a href=\"../profile.php\">My Profile</a>";
  echo "<br><br><a href=\"../logout.php\">Logout</a></div>";
}else{
	echo "Not logged in. Click <a href = \"../login.php\" title = \"Logout\">here</a> to login.<br>";
        echo "<br>New user?<br> Click <a href = \"../newacc.php\" title = \"New Account\">here</a> to make a new account.</div>";
}
?>
<?php
//error_reporting(E_ALL);
//ini_set('display_errors', '1');
//echo "<img src=\"http://www.aidedd.org/dnd/images/". lcfirst($_GET["search"]) .".jpg\" alt=\"". $_GET["search"] .".\" width=\"30%\" height=\"40%\" class=\"pic\">";
?>
<?php
  function rep_str($text, $str, $tag1, $tag2) {
    return str_replace($text, $tag1.$text.$tag2, $str);
  }
  try {
    $con = new PDO("mysql:dbname=casagra1_dnd;host=localhost","casagra1_user","password");
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
  if ($_GET["type"] == "Monsters"){
		if ($key == "Size/Alignment" || $key == "Stats" || $key == "Actions/Abilities"){
		  if (!($query = $con->prepare("SELECT * FROM `Monsters` WHERE" . $key . "=:search ORDER BY `Name` ASC "))) {
				echo "Prepare failed: (" . $con->errno . ") " . $con->error;
		  }
		}else{
			if (!($query = $con->prepare("SELECT * FROM `Monsters` WHERE `Name`=:search ORDER BY `Name` ASC "))) {
				echo "Prepare failed: (" . $con->errno . ") " . $con->error;
		  }
		}
		$query->bindValue(":search", $search, PDO::PARAM_STR);
		$query->execute();
		//$query = "SELECT * FROM `Monsters` WHERE `" . $key ."` LIKE '%" . $search . "%' ORDER BY `Name` ASC ";
		//echo "<tr><td>Name</td><td>Size/Alignment</td><td>Stats</td><td>Actions/Abilities</td></tr>";
  }
  else if ($_GET["type"] == "Items"){
	  if ($key == "Size/Alignment" || $key == "Stats" || $key == "Actions/Abilities"){
		  if (!($query = $con->prepare("SELECT * FROM `Items` WHERE" . $key . "=:search ORDER BY `Name` ASC "))) {
				echo "Prepare failed: (" . $con->errno . ") " . $con->error;
		  }
		}else{
			if (!($query = $con->prepare("SELECT * FROM `Items` WHERE `Name`=:search ORDER BY `Name` ASC "))) {
				echo "Prepare failed: (" . $con->errno . ") " . $con->error;
		  }
		}
		$query->bindValue(":search", $search, PDO::PARAM_STR);
		$query->execute();
		//$query = "SELECT * FROM `Items` WHERE `" . $key ."` LIKE '%" . $search . "%' ORDER BY `Name` ASC ";
		//echo "<tr><td>Name</td><td>Rarity/Type</td><td>Description</td></tr>";
  }
  else if ($_GET["type"] == "Spells"){
	  if ($key == "Size/Alignment" || $key == "Stats" || $key == "Actions/Abilities"){
		  if (!($query = $con->prepare("SELECT * FROM `Spells` WHERE" . $key . "=:search ORDER BY `Name` ASC "))) {
				echo "Prepare failed: (" . $con->errno . ") " . $con->error;
		  }
		}else{
			if (!($query = $con->prepare("SELECT * FROM `Spells` WHERE `Name`=:search ORDER BY `Name` ASC "))) {
				echo "Prepare failed: (" . $con->errno . ") " . $con->error;
		  }
		}
		$query->bindValue(":search", $search, PDO::PARAM_STR);
		$query->execute();
		//$query = "SELECT * FROM `Spells` WHERE `" . $key ."` LIKE '%" . $search . "%' ORDER BY `Level` ASC ";
		//echo "<tr><td>Level</td><td>Name</td><td>Stats</td><td>Description</td></tr>";
  }
  $results = $query;
  $i = 0;
  echo "<div class=\"style1\">";
  if(isset($_POST['submit'])){
	 //echo $_POST['Name'] . $_POST['Size,Alignment']. $_POST['Stats']. $_POST['Description'];
	  if (!($query = $con->prepare("UPDATE `Monsters` SET `Name`=:name2,`Size, Alignment`=:sial,`Stats`=:stats,`Actions/Abilities`=:acab WHERE `Name`=:name1"))) {
				echo "Prepare failed: (" . $con->errno . ") " . $con->error;
	  }
	  $query->bindValue(":name1", $search, PDO::PARAM_STR);
	  $query->bindValue(":name2", $_POST['Name'], PDO::PARAM_STR);
	  $query->bindValue(":sial", $_POST['Size,Alignment'], PDO::PARAM_STR);
	  $query->bindValue(":stats", $_POST['Stats'], PDO::PARAM_STR);
	  $query->bindValue(":acab", $_POST['Description'], PDO::PARAM_STR);
	  $query->execute();
	  $str = "edit.php?search=".$_POST['Name']."&type=".$_GET["type"];
	  header("location:".$str);
	  exit();
  }
  while ($row = $results->fetch(PDO::FETCH_ASSOC)) {
    foreach($row as $field) {
        $i++;
		if ($i == 1)
			$name = "Name";
		else if ($i == 2)
			$name = "Size,Alignment";
		else if ($i == 3)
			$name = "Stats";
		else if ($i == 4)
			$name = "Description";
		$temp = htmlspecialchars($field);?>
		<textarea form="form1" style="align:center;width:100%" value="<?php echo $temp . "\" "; echo "name=\"".$name."\">".$temp;?></textarea>
		<div style="clear:both;"></div>
		<?php
    }
    $i = 0;
  }
  echo "<form method=\"post\" action =\"\" id=\"form1\">";
  //". $_SERVER['PHP_SELF'] ."?>
  <input type="submit" value="Submit" name="submit"/>
  </form>
  </div>
</body>
</html>