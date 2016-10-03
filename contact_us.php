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
	Contact Us
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
div.fixed2 {
    text-align: center;
    position: fixed;
    top: 25px;
    left: 25px;
    width: 100px;
    border-radius: 25px;
    background-color: rgba(255, 255, 255, 0.7);
}
.centre{
    margin: -5px;
    position: absolute;
    top: 50%;
    left: 50%;
    margin-right: -50%;
    transform: translate(-50%, -50%)
}
.back_white{
    border-radius: 25px;
    background-color: rgba(255, 255, 255, 0.7);
	padding: 12px 20px 12px 40px;
    max-width: 259px;
}
</style>
</head>
<body>
<div class="fixed2"><?php
  echo "<a href=\"index.php\">Home</a></div>";?>
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
?>
<div class="centre">
<div class="back_white" style="padding-left: 20px;">
 <p>Contact us at the following:<br>
Phone: 519-999-999<br>
Email: <a href="mailto:casagra1@dnd.myweb.cs.uwindsor.ca">casagra1@dnd.myweb.cs.uwindsor.ca</a></p>
</div>
</div>
</body>
</html>