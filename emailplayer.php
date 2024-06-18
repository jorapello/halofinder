<html>
<meta name="viewport" content="width=device-width, initial-scale=1">
<head>
<link rel="stylesheet" type="text/css" href="style_emailplayer.css">
 
  <script type="text/javascript" src="finder.js"></script>
 <script type="text/javascript" src='https://www.google.com/recaptcha/api.js' async defer></script>
<title>Email Player</title>
<link rel="icon" type="image/png" href="favicon.png"/>
</head>
<body>
<h1>Email Player Form v.3335</h1>
<p><a href="index.php"><<< Back to the Player Finder</a>


    <div id="playerinfo" class="block"></div>
    <div class="shortlogo"><a href="http://halo1hub.com/playerfinder"><div class="logo"></div></a></div>
<h2 id="title"></h2>
    <hr></hr>
<p class="email_info">
<br><br><form action="" name="emailplayer" method="post">
<label>Your email:</label><br><br>
<input type="hidden" name="id" id="id">
<input type="email" name="replyto" id="replyto" required="required" placeholder="example@gmail.com" autocorrect=off/><br/><br />
<label>Verify email:</label><br><br>
<input type="email" name="verifyemail" id="verifyemail" required="required" placeholder="example@gmail.com" autocorrect=off/><br><br />
<label>Subject:</label><br><br>
<input type="text" name="subject" id="subject" required="required" size=60 placeholder="I'm looking to play Halo!" autocorrect=off/><br/><br />
<label>Message:</label><br><br>
<textarea name="message" id="playermsg" rows="5" cols="80" method="post" ></textarea><br><br>
  <div class="g-recaptcha" data-theme="dark" data-sitekey="6Le_04wUAAAAAF3lM7Q5TdrQ6Z6Pj8BMfAI13Ccb"></div><br>
<input type="submit" value="Send Message" name="submit"/><br />
</form>
</div>
<script>
var name = getAllUrlParams().name;
var id = getAllUrlParams().id;
document.getElementById("title").innerHTML  = "Send an email to " + decodeURI(name);
document.getElementById("id").value = getAllUrlParams().id;


</script>
  </body>

  
<?php
require("credentials.php");
require("finder.php");
	
	
if(isset($_POST["submit"])){   
	$id = filter_var($_POST["id"], FILTER_SANITIZE_EMAIL);
	if($id){
		if(checkCaptcha()){
			if(filter_var($_POST["replyto"], FILTER_SANITIZE_EMAIL) == filter_var($_POST["verifyemail"], FILTER_SANITIZE_EMAIL))
			{
				// Create connection
				$conn = new mysqli($servername, $username, $password, $dbname);
				// Check connection
				if ($conn->connect_errno) {
				  echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
				} 

				if (!($sql = $conn->prepare("SELECT ID, NAME, EMAIL FROM PLAYERS WHERE ID=?"))) {
					echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
				}

				if (!$sql->bind_param("i", $id)) {
					echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
				}

				if (!($result=$sql->execute())) {
					echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
				}
				
				$sql->store_result();
				
				while ($row = fetchAssocStatement($sql)) {
					$to = $row['EMAIL'];
					$name = $row['NAME'];
				}
				
				$boundary = uniqid('np');
								
				$subject = 'HaloFinder: A player emailed you, ' . $name . '!';
				$header = "MIME-Version: 1.0\r\n";
				$header .= "From: HaloFinder <no-reply@halo1hub.com>\r\n";
				$header .= "List-Unsubscribe: mailto:unsubscribe@halo1hub.com?subject=unsubscribe+" . $id . "+" . $edit_key . ", http://halo1hub.com/playerfinder/unsubscribe.php?email=" . $to . "&key=" . $edit_key. "\r\n";
				$header .= "Content-Type: multipart/alternative;boundary=" . $boundary . "\r\n";

				$message = "\r\n\r\n--" . $boundary . "\r\n";
				$message .= "Content-type: text/plain;charset=utf-8\r\n\r\n";

				//Plain text body
				$message .= "HaloFinder - A player emailed you, " . $name . "!\n\n\n";
				$message .= '\n\nThe player provided this reply-to email address: ' . $_POST["replyto"] . '\n\n';
				$message .= '\n\nPlease do not reply directly to this email. Instead, use the email provided above.\n\n';
				$message .= 'Message: \n\n' . $_POST["message"] . '\n\n';
				$message .= "You can also unsubscribe and delete your profile by visiting http://halo1hub.com/playerfinder/unsubscribe.php?id=" . $id . "&key=" . $edit_key . "\n";
				$message .= "\r\n\r\n--" . $boundary . "\r\n";
				$message .= "Content-type: text/html;charset=utf-8\r\n\r\n";
				
				//HTML body
				$message .= '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
				<html xmlns="http://www.w3.org/1999/xhtml">
				<html><head>
				<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
				<title>HaloFinder - A player emailed you!</title>';
				$message .= '<meta name="viewport" content="width=device-width, initial-scale=1.0"/></head><body bgcolor=#222222><br>';
				$message .= "<table style='color:white;bgcolor:#222222;background:#222222;' cellpadding=0 cellspacing=0 width=600 bgcolor=#222222 color=#ffffff><tr bgcolor=#222222><img src='http://halo1hub.com/playerfinder/logo.png' alt='HaloFinder - powered by Halo1Hub.com'><br></tr>";
				$message .= '<tr bgcolor=#222222><h3 style="color:white;margin-left:15px;">HaloFinder - A player emailed you, ' . $name . '!</h3>
				<p style="color:white;margin-left:15px;">The player provided this reply-to email address: ' . $_POST["replyto"] . 
				'<p style="color:white;margin-left:15px;">Please do not reply directly to this email. Instead, use the email provided above.' . 
				'<p style="color:white;margin-left:15px;">Message:<br> <blockquote style="color:white">' . $_POST["message"] . '</blockquote><br>' .
				'<p style="color:white;margin-left:15px;font-size:x-small">You can also unsubscribe and delete your profile by clicking <a href="http://halo1hub.com/playerfinder/unsubscribe.php?id=' . $id . '&key=' . $edit_key. '"><font color="#2aea15">here.</font></a><br><br><br></tr></table></body></html>';
				
				$message .= "\r\n\r\n--" . $boundary . "--";

				 $retval = mail ($to,$subject,$message,$header);
				 
					 if( $retval == true ) {
						echo "Message sent successfully!";
					 }else {
						echo "Message failed.";
					 }
					$sql->close();
					mysqli_close($conn);
				}
			else{
				echo 'Emails do not match.';
			}
		}
		else{
			echo 'Captcha failed.';
		}
	}
	else{
		echo 'Recipient player not set.';
	}
}
?>
</body>
</html>

