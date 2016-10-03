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
	Inserting New Value
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
  echo "<div class=\"fixed\"><a href=\"../index.php\">Home</a><br><a href=\"admins.php\">Admin Module</a></div>";
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
  $i = 0;
  echo "<div class=\"style1\">";
  if(isset($_POST['submit'])){
	 //echo $_POST['Name'] . $_POST['Size,Alignment']. $_POST['Stats']. $_POST['Actions/Abilities`'];
	  if ($_GET['type'] == "Monsters"){
		  if (!($query = $con->prepare("INSERT INTO `casagra1_dnd`.`Monsters` (`Name`, `Size, Alignment`, `Stats`, `Actions/Abilities`) VALUES (:name, :sial, :stats, :acab)"))) {
					echo "Prepare failed: (" . $con->errno . ") " . $con->error;
		  }
		  $query->bindValue(":name", $_POST['Name'], PDO::PARAM_STR);
		  $query->bindValue(":sial", $_POST['Size,Alignment'], PDO::PARAM_STR);
		  $query->bindValue(":stats", $_POST['Stats'], PDO::PARAM_STR);
		  $query->bindValue(":acab", $_POST['Actions/Abilities'], PDO::PARAM_STR);
		  $query->execute();
	  }
	  else if ($_GET['type'] == "Items"){
		  if (!($query = $con->prepare("INSERT INTO `casagra1_dnd`.`Items` (`Name`, `Rarity/Type`, `Description`) VALUES (:name, :rare, :desc)"))) {
					echo "Prepare failed: (" . $con->errno . ") " . $con->error;
		  }
		  $query->bindValue(":name", $_POST['Name'], PDO::PARAM_STR);
		  $query->bindValue(":rare", $_POST['Rarity/Type'], PDO::PARAM_STR);
		  $query->bindValue(":desc", $_POST['Description'], PDO::PARAM_STR);
		  $query->execute();
	  }
	  else if ($_GET['type'] == "Spells"){
		  if (!($query = $con->prepare("INSERT INTO `casagra1_dnd`.`Spells` (`Level`, `Name`, `Stats`, `Description`) VALUES (:lvl, :name, :stats, :desc)"))) {
					echo "Prepare failed: (" . $con->errno . ") " . $con->error;
		  }
		  $query->bindValue(":name", $_POST['Name'], PDO::PARAM_STR);
		  $query->bindValue(":stats", $_POST['Stats'], PDO::PARAM_STR);
		  $query->bindValue(":lvl", $_POST['Level'], PDO::PARAM_STR);
		  $query->bindValue(":desc", $_POST['Description'], PDO::PARAM_STR);
		  $query->execute();
	  }
	  $str = "add.php?type=".$_GET['type'];
	  header("location:".$str);
	  exit();
  }
  if ($_GET['type'] == "Monsters"){?>
  <textarea form="form1" style="align:center;width:100%" name="Name" placeholder="Name" required></textarea>
  <textarea form="form1" style="align:center;width:100%" name="Size,Alignment" placeholder="Size,Alignment" required></textarea>
  <textarea form="form1" style="align:center;width:100%" name="Stats" placeholder="Stats" required></textarea>
  <textarea form="form1" style="align:center;width:100%" name="Actions/Abilities" placeholder="Actions/Abilities" required></textarea>
  <?php } else if ($_GET['type'] == "Items"){?>
  <textarea form="form1" style="align:center;width:100%" name="Name" placeholder="Name" required></textarea>
  <textarea form="form1" style="align:center;width:100%" name="Rarity/Type" placeholder="Rarity/Type" required></textarea>
  <textarea form="form1" style="align:center;width:100%" name="Description" placeholder="Description" required></textarea>
  <?php } else if ($_GET['type'] == "Spells"){?>
  <textarea form="form1" style="align:center;width:100%" name="Level" placeholder="Level" required></textarea>
  <textarea form="form1" style="align:center;width:100%" name="Name" placeholder="Name" required></textarea>
  <textarea form="form1" style="align:center;width:100%" name="Stats" placeholder="Stats" required></textarea>
  <textarea form="form1" style="align:center;width:100%" name="Description" placeholder="Description" required></textarea><?php } ?>
  <div style="clear:both;"></div>
  <form method="post" action="" id="form1">
  <input type="submit" value="Submit" name="submit"/>
  </form>
  </div>
</body>
</html>
