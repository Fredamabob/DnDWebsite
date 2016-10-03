<!DOCTYPE html>
<?php
   ob_start();
   session_start();
?>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="wiki_page.css">
    <link rel="shortcut icon" href="favicon.png"/>
    <title>
	<?php echo $_SESSION["username"]; ?>'s Profile Page
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
<?php  
if ($_SESSION['valid'] == true){
  echo "<div class=\"fixed2\">";
  echo "Logged in as<br>". $_SESSION['username'];
  echo "<br><br><a href=\"logout.php\">Logout</a></div>";
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
		echo "<div class=\"fixed\"><a href=\"index.php\">Home</a><br><a href=\"admin_tools/admins.php\">Admin Module</a></div>";
	}
	else{
		echo "<div class=\"fixed\"><a href=\"index.php\">Home</a></div>";
	}
  $search = $_GET["search"];
  $key = $_GET["key"];
  if (!($query = $con->prepare("SELECT `Saved` FROM `Users` WHERE `Username`=:user"))) {
		echo "Prepare failed: (" . $con->errno . ") " . $con->error;
  }
  $query->bindValue(":user", $_SESSION['username'], PDO::PARAM_STR);
  $query->execute();
  $results = $query;
  if ($_SESSION['valid'] == true){
	  echo "<div class=\"style1\"><b>Saved Pages:</b><br>";
	  while ($row = $results->fetch(PDO::FETCH_ASSOC)) {
		foreach($row as $field) {
			$temp = htmlspecialchars($field);
			$temp = preg_replace("/([0-9a-zA-Z-' ]+)\,([0-9a-zA-Z-' ]+)\;/", "<a href=\"format.php?search=$1&type=$2\">$1</a>  [<a href=\"removeSaved.php?search=$1&type=$2\">X</a>]<br>", $temp);
			echo $temp;
			echo "<div><svg width=\"100%\" viewBox=\"0 0 360 2.5\"><polyline points=\"0,0 360,2.5 0,5\" style=\"fill:#922610;stroke:#922610;\"></polyline></svg></div>";
		}
	  }
	  echo "</div>";
  }else{
	    echo "<div class=\"style1\">";
		echo "Not logged in. Click <a href = \"login.php\" title = \"Login\">here</a> to login.<br>";
		echo "New user?<br> Click <a href = \"newacc.php\" title = \"New Account\">here</a> to make a new account.</div>";
	  }
?>
</body>
</html>
