<html>
<meta name="viewport" content="width=device-width, initial-scale=1">
<head>
<link rel="stylesheet" type="text/css" href="style_addplayer.css">
  <script type="text/javascript" src="finder.js"></script>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<title>Resend Verification Emails</title>
<link rel="icon" type="image/png" href="favicon.png"/>
</head>
    
    
<body>
    
	<form name="addplayer" action="" method="post">
 <div class="button_cont" align="left"><input class="example_b" type="submit" name="submit" value="SEND EMAILS" />
        </div>
</form>
  
<?php
require("credentials.php");
require("finder.php");
	// Create connection
				$conn = new mysqli($servername, $username, $password, $dbname);
				// Check connection
				if ($conn->connect_errno) {
					echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
				}
	echo "pushed";
   if (!($sql = $conn->prepare("SELECT ID,EMAIL,EDIT_KEY,NAME FROM FINDER.PLAYERS WHERE EMAIL_VERIFIED IS NULL"))) {
		echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
	}

	if (!$sql->execute()) {
		
		echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
	}
	else{
		echo "success";
		$sql->store_result();
		while ($row = fetchAssocStatement($sql)) {
			$to = $row['EMAIL'];
			$id = $row['ID'];
			$edit_key = $row['EDIT_KEY'];
			$name = $row['NAME'];
			
			echo $to;
			echo $id;
			echo $edit_key;
			echo $name;
									
		//create a boundary for the email. This 
		$boundary = uniqid('np');
						
		//headers - specify your from email address and name here
		//and specify the boundary for the email
		$subject = 'HaloFinder: REALLY FINAL NOTICE: Verify your email address, ' . $name;
		$header = "MIME-Version: 1.0\r\n";
		$header .= "From: HaloFinder <no-reply@halo1hub.com>\r\n";
		$header .= "List-Unsubscribe: mailto:unsubscribe@halo1hub.com?subject=unsubscribe+" . $id . "+" . $edit_key . ", http://halo1hub.com/playerfinder/unsubscribe.php?id=" . $id . "&key=" . $edit_key. "\r\n";
		$header .= "Content-Type: multipart/alternative;boundary=" . $boundary . "\r\n";

		//here is the content body
		$message = "\r\n\r\n--" . $boundary . "\r\n";
		$message .= "Content-type: text/plain;charset=utf-8\r\n\r\n";

		//Plain text body
		$message .= "HaloFinder - REALLY FINAL NOTICE: Please verify your email address, " . $name . "\n\n\n";
		$message .= "Thank you for registering a player on HaloFinder.\n";
		$message .= "We have had several issues with our email provider which has prevented some verification emails from going out, so we are resending this to make sure you get it.\n";
		$message .= "Within 30 days of this email, your information will be removed from the HaloFinder database unless you verify.\n";
		$message .= "In order to be listed on the map, we require new users to verify their email.\n";
		$message .= "To verify your email, please visit http://halo1hub.com/playerfinder/verifyemail.php?id=" . $id . "&key=" . $edit_key . "\n\n";
		$message .= "If you have received this email in error, please ignore it. Your email will automatically be removed from our database within 30 days.\n";
		$message .= "You can also unsubscribe and delete your profile by visiting http://halo1hub.com/playerfinder/unsubscribe.php?id=" . $id . "&key=" . $edit_key . "\n";
		$message .= "\r\n\r\n--" . $boundary . "\r\n";
		$message .= "Content-type: text/html;charset=utf-8\r\n\r\n";
		
		//HTML body
		$message .= '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">';
		$message .= '<html xmlns="http://www.w3.org/1999/xhtml">';
		$message .= "<html><head>";
		$message .= '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
		$message .= "<title>HaloFinder - FINAL NOTICE: Please verify your email address.</title>";
		$message .= '<meta name="viewport" content="width=device-width, initial-scale=1.0"/></head>';
		$message .= "<table style='color:black;' cellpadding=0 cellspacing=0 width=600 bgcolor=#ffffff color=#ffffff><tr><img src='http://halo1hub.com/playerfinder/logo.png' alt='HaloFinder - powered by Halo1Hub.com'></tr>";
		$message .= "<tr><h3 style='color:black;margin-left:15px;'>HaloFinder - REALLY FINAL NOTICE: Please verify your email address, " . $name . "</h3>";
		$message .= "<p style='color:black;margin-left:15px;'>Thank you for registering a player on HaloFinder.";
		$message .= "<p style='color:black;margin-left:15px;'>We have had several issues with our email provider which has prevented some verification emails from going out, so we are resending this to make sure you get it.\n";
		$message .= "<p style='color:black;margin-left:15px;'>Within 30 days of this email, your information will be removed from the HaloFinder database unless you verify.\n";
		$message .= "<p style='color:black;margin-left:15px;'>In order to be listed on the map, we require new users to verify their email.";
		$message .= '<p style="color:black;margin-left:15px;">To verify your email, click <a href="http://halo1hub.com/playerfinder/verifyemail.php?id=' . $id . '&key=' . $edit_key .'" style="color:blue!important;text-decoration:underline;"><font color="blue">here.</font></a>';
		$message .= "<p style='color:black;margin-left:15px;'>If you have received this email in error, please ignore it. Your email will automatically be removed from our database within 30 days.";
		$message .= "<p style='color:black;margin-left:15px;'>You can also unsubscribe and delete your profile by clicking <a href='http://halo1hub.com/playerfinder/unsubscribe.php?id=" . $id . "&key=" . $edit_key. "' style='color:blue!important;text-decoration:underline;'><font color='blue'>here.</font></a></tr></table></body></html>";
		
		$message .= "\r\n\r\n--" . $boundary . "--";

		 $retval = mail ($to,$subject,$message,$header);
			 
			 if( $retval == true ) {
				
			   echo '<script language="javascript">';
			   echo 'alert("Message sent to' . $to . '")';
			   echo '</script>';
			 }else {
				echo "Message failed.";
			 }
								
								
		}
	}
$sql->close();
mysqli_close($conn);	

?>
</body>
</html>

