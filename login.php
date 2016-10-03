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
      <title>Login</title>
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
		 	try {
			$con = new PDO("mysql:dbname=casagra1_dnd;host=localhost","casagra1_user","password");
			} catch (PDOException $e) {
				echo 'Connection failed: ' . $e->getMessage();
			}
			$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $msg = '';
            
            if (isset($_POST['login']) && !empty($_POST['username'])
               && !empty($_POST['password'])) {
				$pass = $_POST['password'];
				$user = $_POST['username'];
				/*$tmp = $con->prepare("INSERT INTO `Users`(`Username`, `Password`) VALUES (:user, :pass)");
				$tmp->bindValue(":user", $user, PDO::PARAM_STR);
				$tmp->bindValue(":pass", crypt($pass, uniqid(mt_rand(), true)), PDO::PARAM_STR);
				$tmp->execute();*/
				if (!($q1 = $con->prepare("SELECT `Password` FROM `Users` WHERE `Username`=:user"))) {
					echo "Prepare failed: (" . $con->errno . ") " . $con->error;
				}
				$q1->bindValue(":user", $user, PDO::PARAM_STR);
				$q1->execute();
				$row = $q1->fetch(PDO::FETCH_ASSOC);
               if (crypt($pass, $row["Password"]) == $row["Password"]) {
                  $_SESSION['valid'] = true;
                  $_SESSION['timeout'] = time();
                  $_SESSION['username'] = $user;
               }else {
                  $msg = 'Wrong username or password';
               }
            }
         ?>
      <div class="centre">
	  <?php
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
				header("location:/index.php");
				exit();
		 }?>
	  </div>
   </body>
</html>