<!DOCTYPE html>
<?php
   ob_start();
   session_start();
?>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="base.css">
    <link rel="shortcut icon" href="favicon.png"/>
    <script type="text/javascript" src="js/jquery-3.1.0.min.js"></script>
    <script type="text/javascript" src="js/autocompleter.js"></script>
    <title>
    DnD Info
    </title>
<style>
div.fixed {
    text-align: center;
    position: fixed;
    top: 25px;
    right: 25px;
    width: 115px;
    border-radius: 25px;
    background-color: rgba(255, 255, 255, 0.7);
}
.centre{
    margin: 0;
    position: absolute;
    top: 50%;
    left: 50%;
    margin-right: -50%;
    transform: translate(-50%, -50%)
}
.centre2{
    margin: -5px;
    position: absolute;
    bottom: 0%;
    left: 50%;
    margin-right: -50%;
    transform: translate(-50%, -50%)
}
select {
    width: 100px;
    min-height: 25px;
    border-width: 3px;
    background-color: rgba(255, 255, 255, 0.7);
    margin: 10px 10px 10px 0px;
}
.back_white{
    border-radius: 25px;
    background-color: rgba(255, 255, 255, 0.7);
    padding: 12px 20px 12px 40px;
    max-width: 259px;
}
input[type=text]:focus {
    outline: none;
    -webkit-box-shadow: none !important;
    -moz-box-shadow: none !important;
    box-shadow: none !important;
}
input[type=text] {
    border-radius: 25px;
    font-size: 16px;
    background-color: white;
    background-image: url('search.png');
    background-position: 10px 10px;
    background-repeat: no-repeat;
    padding: 15px 20px 12px 50px;
}
</style>
</head>
<body>
<p id="tmp"></p>
<div class="fixed"><?php
/*error_reporting(E_ALL);
ini_set('display_errors', '1');*/
if ($_SESSION['valid'] == true){
  echo "Logged in as ". $_SESSION['username'];
  echo "<br><a href=\"profile.php\">My Profile</a>";
  echo "<br><br><a href=\"logout.php\">Logout</a></div>";
}else{
    echo "Not logged in. Click <a href = \"login.php\" title = \"Login\">here</a> to login.<br>";
    echo "<br>New user?<br> Click <a href = \"newacc.php\" title = \"New Account\">here</a> to make a new account.</div>";
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
		echo "<div class=\"fixed\" style=\"left: 25px;right: 0px;\"><a href=\"admin_tools/admins.php\">Admin Module</a></div>";
  }
?>
<div class="centre">
<form method="get" action="format.php">
  <input type="text" name="search" placeholder="Search by name..." class="c_foc" autocomplete="off" id="name_id" onkeyup="autocompleter()">
  <div class="input_container">
  <ul id="name_list_id" hidden></ul></div>
  <div class="back_white" style="padding-left: 20px;">
  <input type="radio" name="type" value="Monsters" onclick="autocompleter()" checked>Monsters
  <input type="radio" name="type" value="Items" onclick="autocompleter()">Items
  <input type="radio" name="type" value="Spells" onclick="autocompleter()">Spells
  <!-- <select name="key" id="key">
    <option value="Name">Name</option>
    <option value="Size, Alignment">Size/Alignment</option>
    <option value="Stats">Stats</option>
    <option value="Actions/Abilities">Actions/Abilities</option>
  </select> -->
  </div>
</form>
</div>
<div class="centre2"><div class="back_white" style="background-color: rgba(200, 200, 200, 0.7);padding-left: 20px;"><a href="contact.xml"<!--"contact_us.php"-->Contact Us</a></div></div>
</body>
</html>
