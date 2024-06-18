<html>
<meta name="viewport" content="width=device-width, initial-scale=1">
<head>
    <link rel="stylesheet" type="text/css" href="style_verifyemail.css">  
<title>HaloFinder - Verifying email...</title>
<link rel="icon" type="image/png" href="favicon.png"/>
<style>
    
</style>
</head>
<body>
    <a href="http://halo1hub.com/playerfinder"><div class="logo"></div></a>
  </body>
  
<?php
require("credentials.php");
require("finder.php");

$id = filter_var($_GET["id"], FILTER_SANITIZE_EMAIL);
$edit_key = filter_var($_GET["key"], FILTER_SANITIZE_EMAIL);

if($id and $edit_key)
{
		

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_errno) {
		

	echo '<script language="javascript">';
	echo 'Connection failure.';
	echo '</script>';

		echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}

	if (!($sql = $conn->prepare("UPDATE FINDER.PLAYERS SET EMAIL_VERIFIED=1 WHERE ID=? AND EDIT_KEY=?"))) {
		echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
		

	echo '<script language="javascript">';
	echo 'alert("Prepare failed.")';
	echo '</script>';

	}


	if (!$sql->bind_param("is", $id, $edit_key)) {
		echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
		

	echo '<script language="javascript">';
	echo 'alert("Binding parameters failed.")';
	echo '</script>';

	}

	if (!$sql->execute()) {
		
		echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
		

	echo '<script language="javascript">';
	echo 'alert("Execute failed.")';
	echo '</script>';

	}
	else{
			if(!$conn->affected_rows){
		   echo '<script language="javascript">';
		   echo 'alert("Player ID or key mismatch")';
		   echo '</script>';
			}
		else{
		   
			  if (!($sql2 = $conn->prepare("SELECT ID,NAME,EMAIL,EDIT_KEY FROM FINDER.PLAYERS WHERE ID=? AND EDIT_KEY=?"))) {
				echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
				

			echo '<script language="javascript">';
			echo 'alert("Prepare failed.")';
			echo '</script>';

			}


			if (!$sql2->bind_param("is", $id, $edit_key)) {
				echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
				

			echo '<script language="javascript">';
			echo 'alert("Binding parameters failed.")';
			echo '</script>';

			}

			if (!$sql2->execute()) {
				
				echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
				

			echo '<script language="javascript">';
			echo 'alert("Execute failed.")';
			echo '</script>';

			}
			else{
				
				$sql2->store_result();
				while ($row = fetchAssocStatement($sql2)) {
					$to = $row['EMAIL'];
					$id = $row['ID'];
					$edit_key = $row['EDIT_KEY'];
					$name = $row['NAME'];
				
					//create a boundary for the email. This 
					$boundary = uniqid('np');
										
					$subject = 'HaloFinder: Email verified! Edit and delete info enclosed';
					$header = "MIME-Version: 1.0\r\n";
					$header .= "From: HaloFinder <no-reply@halo1hub.com>\r\n";
					$header .= "List-Unsubscribe: mailto:unsubscribe@halo1hub.com?subject=unsubscribe+" . $id . "+" . $edit_key . ", http://halo1hub.com/playerfinder/unsubscribe.php?email=" . $to . "&key=" . $edit_key. "\r\n";
					$header .= "Content-Type: multipart/alternative;boundary=" . $boundary . "\r\n";

					$message = "\r\n\r\n--" . $boundary . "\r\n";
					$message .= "Content-type: text/plain;charset=utf-8\r\n\r\n";

					//Plain text body
					$message .= "HaloFinder - Email verified! Edit and delete info enclosed.\n\n\n";
					$message .= "Thanks for verifying your email, " . $name . "! Now you're showing up on the HaloFinder map!\n\n";
					$message .= 'For future reference, your edit key is ' . $edit_key . '\n\n';
					$message .= 'This key allows you to make changes to your player data.\n\n';
					$message .= "To edit your player profile, please visit http://halo1hub.com/playerfinder/editplayer.php?id=" . $id . "&key=" . $edit_key . "\n\n";
					$message .= "You can also unsubscribe and delete your profile by visiting http://halo1hub.com/playerfinder/unsubscribe.php?email=" . $to . "&key=" . $edit_key . "\n";
					$message .= "\r\n\r\n--" . $boundary . "\r\n";
					$message .= "Content-type: text/html;charset=utf-8\r\n\r\n";
					
					//HTML body
					$message .= '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
					<html xmlns="http://www.w3.org/1999/xhtml">
					<html><head>
					<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
					<title>HaloFinder - Email verified! Edit and delete info enclosed</title>';
					$message .= '<meta name="viewport" content="width=device-width, initial-scale=1.0"/></head><body bgcolor=#222222><br>';
					$message .= "<table style='color:white;background:#222222;bgcolor:#222222;' cellpadding=0 cellspacing=0 width=600 bgcolor=#222222 color=#ffffff><tr bgcolor=#222222><img src='http://halo1hub.com/playerfinder/logo.png' alt='HaloFinder - powered by Halo1Hub.com'><br></tr>";
					$message .= '<tr bgcolor=#222222><h3 style="color:white;margin-left:15px;">HaloFinder - Email verified! Edit and delete info enclosed</h3>';
					$message .= "<p style='color:white;margin-left:15px;'>Thanks for verifying your email, " . $name . "! Now you're showing up on the HaloFinder map!";
					$message .= '<p style="color:white;margin-left:15px;">For future reference, your edit key is ' . $edit_key .
					'<p style="color:white;margin-left:15px;">This key allows you to make changes to your player data.
					<p style="color:white;margin-left:15px;">To edit your player profile, please click <a href="http://halo1hub.com/playerfinder/editplayer.php?id=' . $id . '&key=' . $edit_key . '"><font color="#2aea15">here</font></a>.
					<p style="color:white;margin-left:15px;font-size:x-small">You can also unsubscribe and delete your profile by clicking <a href="http://halo1hub.com/playerfinder/unsubscribe.php?email=' . $to . '&key=' . $edit_key. '"><font color="#2aea15">here.</font></a><br><br><br></tr></table></body></html>';
					
					$message .= "\r\n\r\n--" . $boundary . "--";
							

					$retval = mail ($to,$subject,$message,$header);

					 if( $retval == true ) {
						echo "<p>Email verification complete!<p>Your marker should appear on the map shortly.<p>Check your email for a link to edit your information if needed.<br>";
						echo '<p class="back_height"><a href="index.php"><span class="back"><<< </span>Back to the Player Finder</a></p>';
					 }else {
						echo "Verification failed.";
					 }
				}

			}
		}
	}

	$sql->close();
	mysqli_close($conn);
}
else{
	echo '<script language="javascript">';
	echo 'alert("Player not set.")';
	echo '</script>';
}
?>
</body>
</html>

