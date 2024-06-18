<html>
<meta name="viewport" content="width=device-width, initial-scale=1">
<head>
<link rel="stylesheet" type="text/css" href="style_addplayer.css">
  <script type="text/javascript" src="finder.js"></script>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<title>Delete or Unsubscribe Player</title>
<link rel="icon" type="image/png" href="favicon.png"/>
</head>
    
    
<body>
    <h1>Delete or Unsubscribe Player</h1>
<p class="back_height"><a href="index.php"><span class="back"><<< </span>Back to the Player Finder</a></p>
    <div class="shortlogo"><a href="http://halo1hub.com/playerfinder"><div class="logo"></div></a></div>
<div id="playerinfo" class="block">
	<p class="call_action">If you use the unsubscribe link that you received after verifying your email, your edit key will be automatically populated. You can resend this link by clicking <a href="resendinfo.php">here</a>.
	<form name="addplayer" action="" method="post">

<label>Email:</label><br><div class="space"></div><br>
<input type="email" name="player_email" id="email" required="required" placeholder="example@gmail.com" autocorrect=off/><br/><br />
<label>Key:</label><br><div class="space"></div><br>
<input type="text" name="edit_key" id="edit_key" required="required" autocorrect=off/><br/><br />
  <div class="g-recaptcha" data-theme="dark" data-sitekey="6Le_04wUAAAAAF3lM7Q5TdrQ6Z6Pj8BMfAI13Ccb"></div>
	 <div class="button_cont" align="left"><input class="example_b" type="submit" name="submit" value="DELETE/UNSUBSCRIBE PLAYER" />
        </div>
</form>
</div>

  <script>
var key = getAllUrlParams().key;
var email = getAllUrlParams().email;
document.getElementById("edit_key").value = getAllUrlParams().key;
document.getElementById("email").value = getAllUrlParams().email;
</script>
  
<?php
require("credentials.php");
require("finder.php");

if(isset($_POST["submit"])){
	if(checkCaptcha()){
		$edit_key = $_POST["edit_key"];
		$email = filter_var($_POST["player_email"], FILTER_SANITIZE_EMAIL);
		
			// Create connection
			$conn = new mysqli($servername, $username, $password, $dbname);
			// Check connection
			if ($conn->connect_errno) {
				echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
			}

			if (!($sql = $conn->prepare("SELECT ID FROM FINDER.PLAYERS WHERE EMAIL=? AND (EDIT_KEY=? OR COALESCE(EMAIL_VERIFIED,0) <> 1)"))) {
				echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
			}

			if (!$sql->bind_param("ss", $email, $edit_key)) {
				echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
			}

			if (!$sql->execute()) {
				echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
			}
			else{
				
				$sql->store_result();
				while($row = fetchAssocStatement($sql)) {
					$id = $row['ID'];
				}
				
			   if (!($sql2 = $conn->prepare("DELETE FROM FINDER.PLAYERS WHERE ID=? AND EMAIL=?"))) {
					echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
				}


				if (!$sql2->bind_param("is", $id, $email)) {
					echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
				}

				if (!$sql2->execute()) {
					
					echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
				}
				else{
					
					$sql2->store_result();
					echo 'Player successfully deleted.';	 
				}
			}
			$sql->close();
			mysqli_close($conn);
	
		}
		else{
			echo '<script language="javascript">';
			echo 'alert("Captcha not set!")';
			echo '</script>';
		}		
}
?>
</body>


</html>

