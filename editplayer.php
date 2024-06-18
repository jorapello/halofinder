<html>
<meta name="viewport" content="width=device-width, initial-scale=1">
<head>
<link rel="stylesheet" type="text/css" href="style_editplayer.css">
  <script type="text/javascript" src="finder.js"></script>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<title>Edit Player</title>
<link rel="icon" type="image/png" href="favicon.png"/>
</head>
<body>
    <h1>Edit Player Data</h1>
    
<p class="back_height"><a href="index.php"><span class="back"><<< </span>Back to the Player Finder</a></p>
    <div class="shortlogo"><a href="http://halo1hub.com/playerfinder"><div class="logo"></div></a></div> 
	
	<p class="call_action">Please note you will have to fill out all fields again when updating your player info.
	<p class="call_action">You will also have to validate your email again before you show up on the player finder.
	<p class="call_action">If you use the edit link that you received after verifying your email, your edit key will be automatically populated. You can resend this link by clicking <a href="resendinfo.php">here</a>.
<h2 id="version">Step 1 - Location</h2>
<div id="location" class="row">
<div id="form" class="block">
<p class="call_action">Enter your location here to update your player info.</p><br>
    <ul>
        <li>You can use your zip code, city, or exact address, whatever your level of paranoia dictates.</li>
<li>A marker will appear on the map. Please make sure the marker represents where you want your player marker to be located.</li>
<li>Alternatively, you can click on the map and choose where to put the marker.</li>
<li>Only the latitude and longitude calculated by the pin is stored in our database.</li><br><br>
   </ul>
    <label>Location: <input id="address" type="textbox" style="width:60%" placeholder="Zip code, city, or exact address">
    <input type="button" value="Find Location" onclick="findAddress()"><br><br>

</div>
    <div id= "geocoder" class = "block">
	<div id = "map"  class="block"></div>
    </div>
</div>
<hr>
<div id="playerinfo" class="block">
<h2>Step 2 - Player Info</h2>
<p class="call_action">Fill out all the fields below with your information to update your player info.
    <p class="call_action">Fields with an * are required.</p><br><br>
<form name="addplayer" action="" method="post">
<input type="hidden" name="player_id" id="player_id" required="required"/>
<input type="hidden" name="player_lat" id="player_lat" required="required"/>
<input type="hidden" name="player_lng" id="player_lng" required="required" />
<label>Player Name*:</label><br><div class="space"></div><br>
<input type="text" name="player_name" id="name" required="required" maxlength=100 autocorrect=off/><br /><br />
<label>Player Email*:</label><br><div class="space"></div><br>
<input type="email" name="player_email" id="email" required="required" placeholder="example@gmail.com" autocorrect=off/><br/><br />
<p class="player_info">We will never sell your data to a third party and your email will be obscured when players contact you through HaloFinder.<br><br>
<label>Verify Email*:</label><br><div class="space"></div><br>
<input type="email" name="verify_email" id="verifyemail" required="required" placeholder="example@gmail.com" autocorrect=off/><br/><br />
<label>Edit Key*</label><br><div class="space"></div><br>
<input type="text" name="player_edit_key" id="player_edit_key" required="required" autocorrect=off/><br/><br />
<label>Nearby City or Landmark:</label><br><div class="space"></div><br>
<input type="text" name="player_city" id="city" placeholder="New York, NY" autocorrect=off/><br/><br />
<label>XBL Gamertag:</label><br><div class="space"></div><br>
<input type="text" name="gamertag" id="gamertag" maxlength=16 autocorrect=off/><br/><br />
<label>Discord:</label><br><div class="space"></div><br>
<input type="text" name="player_discord" id="player_discord" placeholder="Username#0000" autocorrect=off/><br/><br /><br>
<label>What platforms do you want to play?*</label><br><br>
<input type = "checkbox" name = "xbox" value = "1"><h5 class=categories>Xbox</h5><br>
<input type = "checkbox" name = "xlan" value = "1"><h5 class=categories>XLAN</h5><br>
<input type = "checkbox" name = "mcc" value = "1"><h5 class=categories>MCC</h5><br>
<input type = "checkbox" name = "hpc" value = "1"><h5 class=categories>Halo PC</h5><br><br>
<label>Are you able to host a LAN? (Mainly this just requires room and others can bring equipment.)</label><br><br>
    <input type = "checkbox" name = "host" value = "1"><h5 class=categories>Yes, I can host</h5><br><br>
<label>Other notes:</label><br>
<textarea name="notes" id="pnotes" rows="5" cols="80" maxlength=160 placeholder="Any locals? Need equipment? Are you so bad people should know?" autocorrect=off style="width: 390px;"></textarea><br/><br />
  <div class="g-recaptcha" data-theme="dark" data-sitekey="6Le_04wUAAAAAF3lM7Q5TdrQ6Z6Pj8BMfAI13Ccb"></div>
	 <div class="button_cont" align="left"><input class="example_b" type="submit" name="submit" value="CONFIRM PLAYER EDIT" />
        </div>
</form>
</div>
 <script>
      var geocoder;
      var map;
      var marker;
	  
	var form = document.getElementById("addplayer");

	document.getElementById("submitbutton").addEventListener("click", function () {
	form.submit();
	});
	

      function initMap() {
		  	var $player_id = getAllUrlParams().id;
	var $edit_key = getAllUrlParams().key;

	document.getElementById("player_id").value = $player_id;
	document.getElementById("player_edit_key").value = $edit_key;
        geocoder = new google.maps.Geocoder();
        var mapCenter = {lat: 42.877742, lng: -97.380979};
        map = new google.maps.Map(document.getElementById('map'), {zoom: 4, center: mapCenter, mapTypeControl: false, scrollwheel: true, streetViewControl: false,      styles: [
            {elementType: 'geometry', stylers: [{color: '#242f3e'}]},
            {elementType: 'labels.text.stroke', stylers: [{color: '#242f3e'}]},
            {elementType: 'labels.text.fill', stylers: [{color: '#746855'}]},
            {
              featureType: 'administrative.locality',
              elementType: 'labels.text.fill',
              stylers: [{color: '#d59563'}]
            },
            {
              featureType: 'poi',
              elementType: 'labels.text.fill',
              stylers: [{color: '#d59563'}]
            },
            {
              featureType: 'poi.park',
              elementType: 'geometry',
              stylers: [{color: '#263c3f'}]
            },
            {
              featureType: 'poi.park',
              elementType: 'labels.text.fill',
              stylers: [{color: '#6b9a76'}]
            },
            {
              featureType: 'road',
              elementType: 'geometry',
              stylers: [{color: '#38414e'}]
            },
            {
              featureType: 'road',
              elementType: 'geometry.stroke',
              stylers: [{color: '#212a37'}]
            },
            {
              featureType: 'road',
              elementType: 'labels.text.fill',
              stylers: [{color: '#9ca5b3'}]
            },
            {
              featureType: 'road.highway',
              elementType: 'geometry',
              stylers: [{color: '#746855'}]
            },
            {
              featureType: 'road.highway',
              elementType: 'geometry.stroke',
              stylers: [{color: '#1f2835'}]
            },
            {
              featureType: 'road.highway',
              elementType: 'labels.text.fill',
              stylers: [{color: '#f3d19c'}]
            },
            {
              featureType: 'transit',
              elementType: 'geometry',
              stylers: [{color: '#2f3948'}]
            },
            {
              featureType: 'transit.station',
              elementType: 'labels.text.fill',
              stylers: [{color: '#d59563'}]
            },
            {
              featureType: 'water',
              elementType: 'geometry',
              stylers: [{color: '#17263c'}]
            },
            {
              featureType: 'water',
              elementType: 'labels.text.fill',
              stylers: [{color: '#515c6d'}]
            },
            {
              featureType: 'water',
              elementType: 'labels.text.stroke',
              stylers: [{color: '#17263c'}]
            }
          ]

           });
        findAddress();
		if (navigator.geolocation) {
         navigator.geolocation.getCurrentPosition(function (position) {
         initialLocation = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
         map.setCenter(initialLocation);
         });
        }
		
       map.addListener('click', function(e) {
          placeMarker(e.latLng, map);
        });
    }
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA0JA3sjMgwAboqsaFv2DLLRX7zA12lfQw&callback=initMap">
    </script>
  </body>
  
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
		$name = $_POST["player_name"];
		$lat = $_POST["player_lat"];
		$lng = $_POST["player_lng"];
		$city = $_POST["player_city"];
		$verifyemail = filter_var($_POST["verify_email"], FILTER_SANITIZE_EMAIL);
		$email = filter_var($_POST["player_email"], FILTER_SANITIZE_EMAIL);
		$gt = $_POST["gamertag"];
		$discord = $_POST["player_discord"];
		$xbox = filter_var($_POST["xbox"], FILTER_SANITIZE_EMAIL);
		$mcc = filter_var($_POST["mcc"], FILTER_SANITIZE_EMAIL);
		$xlan = filter_var($_POST["xlan"], FILTER_SANITIZE_EMAIL);
		$hpc = filter_var($_POST["hpc"], FILTER_SANITIZE_EMAIL);
		$host = filter_var($_POST["host"], FILTER_SANITIZE_EMAIL);
		$notes = $_POST["notes"];
		$id = filter_var($_POST["player_id"], FILTER_SANITIZE_EMAIL);
		$edit_key = filter_var($_POST["player_edit_key"], FILTER_SANITIZE_EMAIL);

		if($lat and $lng)
		{
			if($email == $verifyemail)
			{
				// Create connection
				$conn = new mysqli($servername, $username, $password, $dbname);
				// Check connection
				if ($conn->connect_errno) {
					echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
				}

				if (!($sql = $conn->prepare("UPDATE FINDER.PLAYERS SET NAME=?, LAT=?, LNG=?, CITY=?, EMAIL=?, GAMERTAG=?, DISCORD=?, XBOX=?, MCC=?, XLAN=?, HPC=?, HOST=?, NOTES=?, EDIT_KEY=RandString(8), EMAIL_VERIFIED=0 WHERE ID=? AND EDIT_KEY=?"))) {
					echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
				}

				if (!$sql->bind_param("sddssssiiiiisis", $name, $lat, $lng, $city, $email, $gt, $discord, $xbox, $mcc, $xlan, $hpc, $host, $notes, $id, $edit_key)) {
					echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
				}

				if (!$sql->execute()) {			
					echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
				}
				else{
					if(!$conn->affected_rows){
				   echo '<script language="javascript">';
				   echo 'alert("Player ID or key mismatch")';
				   echo '</script>';
					}
					else{

					   if (!($sql2 = $conn->prepare("SELECT ID,EMAIL,EDIT_KEY FROM FINDER.PLAYERS WHERE ID=? AND EMAIL=?"))) 
					   {
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

							while ($row = fetchAssocStatement($sql2)) {
								$to = $row['EMAIL'];
								$id = $row['ID'];
								$edit_key = $row['EDIT_KEY'];
							}
										
							$boundary = uniqid('np');
										
							//headers - specify your from email address and name here
							//and specify the boundary for the email
							$subject = 'HaloFinder: Verify your email address, ' . $name;
							$header = "MIME-Version: 1.0\r\n";
							$header .= "From: HaloFinder <no-reply@halo1hub.com>\r\n";
							$header .= "List-Unsubscribe: mailto:unsubscribe@halo1hub.com?subject=unsubscribe+" . $id . "+" . $edit_key . ", http://halo1hub.com/playerfinder/unsubscribe.php?email=" . $to . "&key=" . $edit_key. "\r\n";
							$header .= "Content-Type: multipart/alternative;boundary=" . $boundary . "\r\n";

							//here is the content body
							$message = "\r\n\r\n--" . $boundary . "\r\n";
							$message .= "Content-type: text/plain;charset=utf-8\r\n\r\n";

							//Plain text body
							$message .= "HaloFinder - Please verify your email address, " . $name . "\n\n\n";
							$message .= "Thank you for registering a player on HaloFinder.\n";
							$message .= "In order to be listed on the map, new users are required to verify their email.\n";
							$message .= "To verify your email, please visit http://halo1hub.com/playerfinder/verifyemail.php?id=" . $id . "&key=" . $edit_key . "\n\n";
							$message .= "If you have received this email in error, please ignore it. Your email will automatically be removed from our database within 30 days.\n";
							$message .= "You can also unsubscribe and delete your profile by visiting http://halo1hub.com/playerfinder/unsubscribe.php?email=" . $to . "&key=" . $edit_key . "\n";
							$message .= "\r\n\r\n--" . $boundary . "\r\n";
							$message .= "Content-type: text/html;charset=utf-8\r\n\r\n";
							
							//HTML body
							$message .= '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
							<html xmlns="http://www.w3.org/1999/xhtml">
							<html><head>
							<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
							<title>HaloFinder - Please verify your email address.</title>';
							$message .= '<meta name="viewport" content="width=device-width, initial-scale=1.0"/></head><body bgcolor=#222222><br>';
							$message .= "<table style='color:white;bgcolor:#222222;background:#222222;' cellpadding=0 cellspacing=0 width=600 bgcolor=#222222 color=#ffffff><tr bgcolor=#222222><img src='http://halo1hub.com/playerfinder/logo.png' alt='HaloFinder - powered by Halo1Hub.com'><br></tr>";
							$message .= '<tr bgcolor=#222222><h3 style="color:white;margin-left:15px;">HaloFinder - Please verify your email address, ' . $name . '</h3>
							<p style="color:white;margin-left:15px;">Thank you for registering a player on HaloFinder.
							<p style="color:white;margin-left:15px;">In order to be listed on the map, new users are required to verify their email.
							<p style="color:white;margin-left:15px;">To verify your email, click <a href="http://halo1hub.com/playerfinder/verifyemail.php?id=' . $id . '&key=' . $edit_key .'"><font color="#2aea15">here.</font></a>
							<p style="color:white;margin-left:15px;">If you have received this email in error, please ignore it. Your email will automatically be removed from our database within 30 days.
							<p style="color:white;margin-left:15px;font-size:x-small">You can also unsubscribe and delete your profile by clicking <a href="http://halo1hub.com/playerfinder/unsubscribe.php?email=' . $to . '&key=' . $edit_key. '"><font color="#2aea15">here.</font></a><br><br><br></tr></table></body></html>';
							
							$message .= "\r\n\r\n--" . $boundary . "--";

							$retval = mail ($to,$subject,$message,$header);
							if( $retval == true ) {
							   echo '<script language="javascript">';
							   echo 'alert("Player successfully updated! Please check your email, including your spam folder, for further instructions. You will have to validate your email again before you appear on the map.")';
							   echo '</script>';
				   
							}else {
								echo "Update failed.";
							}
						}//successful new data pull
					}//any rows affected?
				}//player update sql executed

				$sql->close();
				mysqli_close($conn);
				}
			else{
				echo '<script language="javascript">';
				echo 'alert("Emails do not match.")';
				echo '</script>';
			}
		}
		else{
				
			echo '<script language="javascript">';
			echo 'alert("Location not set.")';
			echo '</script>';
		}
	}else{
		echo 'Captcha failure.';
	}
}//submit check
?>
</body>
</html>

