<?php
   ob_start();
   session_start();
?>

<?
   // error_reporting(E_ALL);
   // ini_set("display_errors", 1);
?>

<html lang = "en">
   
   <head>
      <title>Saving...</title>
	<link rel="stylesheet" type="text/css" href="wiki_page.css">
    <link rel="shortcut icon" href="favicon.png"/>
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
    width: 100px;
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
      
   </head>
	
   <body>
<div class="fixed"><?php
  echo "<a href=\"index.php\">Home</a></div>";?>
         <div class="style1">
         <?php
		 error_reporting(E_ALL);
ini_set('display_errors', '1');
		 	try {
			$con = new PDO("mysql:dbname=casagra1_dnd;host=localhost","casagra1_user","password");
			} catch (PDOException $e) {
				echo 'Connection failed: ' . $e->getMessage();
			}
			$search = $_GET["search"];
			$type = $_GET["type"];
			$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			if (!($q1 = $con->prepare("UPDATE `Users` SET `Saved`=CONCAT(`Saved`,'".$search.",".$type.";') WHERE `Username`='".$_SESSION['username']."'"))) {
					echo "Prepare failed: (" . $con->errno . ") " . $con->error;
			}
			$q1->execute();
         ?>
      <div class="centre">
	  <?php
		 header('Location: format.php?search='.$_GET["search"].'&type='.$_GET["type"]);
         if ($_SESSION['valid'] != true){
			 echo "<h2>Enter Username and Password</h2><form class = \"form-signin\" role = \"form\" 
            action =\"".htmlspecialchars($_SERVER['PHP_SELF']) ."
            \" method = \"post\">
            <h4 class = \"form-signin-heading\"><?php echo $msg; ?></h4>
            <input type = \"text\" class = \"form-control\" 
               name = \"username\" placeholder = \"username\" 
               required autofocus></br>
            <input type = \"password\" class = \"form-control\"
               name = \"password\" placeholder = \"password\" required></div>
            <button class = \"btn btn-lg btn-primary btn-block\" type = \"submit\" 
               name = \"login\">Login</button>
         </form>";
		 }
		 else{
			 echo "You are logged in as ". $_SESSION['username'] .".<br>
		 		Click <a href = \"logout.php\" title = \"Logout\">here</a> to logout.";
		 }?>
	  </div>
   </body>
</html>