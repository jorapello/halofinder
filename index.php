<!DOCTYPE html >
<html>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta property="og:image" content="h1hub_logo_-_lowres_on_black-1.png">
<meta property="og:site_name" content="HaloFinder"/>
<meta property="og:url" content="http://halofinder.com/">
<meta property="og:title" content="HaloFinder - the only Halo 1 player finder"/>
<meta property="og:description" content="HaloFinder helps you find Halo 1 players near you! Primarily intended to allow users to meet up and play 2v2 OG Xbox Halo 1!"/>
  <head>
      <link rel="stylesheet" type="text/css" href="style_index.css">
  <script type="text/javascript" src="finder.js"></script>
    <title>HaloFinder - the only Halo 1 Player Finder</title>
      <link rel="icon" type="image/png" href="favicon.png"/>
 
  </head>
  <body>
  
<?php
require("credentials.php");
require("finder.php");
  // Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_errno) {
		

	echo '<script language="javascript">';
	echo 'Connection failure.';
	echo '</script>';

		echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}

	if (!($sql = $conn->prepare("SELECT SUM(XBOX) AS XBOX_CNT, SUM(MCC) AS MCC_CNT, SUM(XLAN) AS XLAN_CNT, SUM(HPC) AS HPC_CNT, SUM(HOST) AS HOST_CNT, SUM(CONFIRMED) AS CONF_CNT FROM FINDER.PLAYERS WHERE EMAIL_VERIFIED IS NOT NULL"))) {
		echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
	}

	if (!$sql->execute()) {
		echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
	}		
	
	else{
			
		$sql->store_result();
		while ($row = fetchAssocStatement($sql)) {
			$xboxcnt = $row['XBOX_CNT'];
			$mcccnt = $row['MCC_CNT'];
			$xlancnt = $row['XLAN_CNT'];
			$hpccnt = $row['HPC_CNT'];
			$hostcnt = $row['HOST_CNT'];
			$confcnt = $row['CONF_CNT'];
		}
	}
	
	echo '<script language="javascript">';
	echo 'var xboxcnt = ' . $xboxcnt . ';';
	echo 'var mcccnt = ' . $mcccnt . ';';
	echo 'var xlancnt = ' . $xlancnt . ';';
	echo 'var hpccnt = ' . $hpccnt . ';';
	echo 'var hostcnt = ' . $hostcnt . ';';
	echo 'var confcnt = ' . $confcnt . ';';
	echo "</script>";
?>
        <div id="wrapper">
            <div class="shortlogo" id="first"><a href="http://halo1hub.com/"><div class="logo"></div></a></div>
            <div id="second"><h4><i>The only Halo 1 player finder</a></i></h4>
			<p>HaloFinder is intended to help players meet up in order to LAN Halo 1 on the original Xbox.<br>
			<a href="addplayer.php" style="text-decoration:underline!important">Add yourself</a> and verify your email to be listed and receive emails safely through HaloFinder.<br>
			<a href='http://halo1hub.com/halo-xbox-setup/' style="text-decoration:underline!important">How to set up an Xbox LAN</a> | <a href="https://www.youtube.com/watch?v=BU4saMGRF_M" style="text-decoration:underline!important">HaloFinder Ad Spot</a><br>
			<a href='resendinfo.php' style="text-decoration:underline!important">Resend Player Edit & Delete Info to Email</a><br>
			<a href='editplayer.php' style="text-decoration:underline!important">Edit Player</a> | <a href="unsubscribe.php" style="text-decoration:underline!important">Remove Player</a><br></div>
       </div>
           
  <div id="content" class="row">
    <div id="filters" class="block" width=20%>
        <hr></hr>
        <h2 id="version">Halo 1 Player Finder v1.2</h2>
        <h4>by johnthehero</h4>
        <h6>graphic design: Hurley</h6><br>
		<a href="playerlist.php" style="text-decoration:underline!important">View Full Player List</a>
    <div class="button_cont" align="left"><a class="example_b" href="addplayer.php" rel="nofollow noopener">ADD A NEW PLAYER</a>
        </div>
	<form action="index.php" method="get">
    <label>Show only players who play:</label>
        <br>
        <input type = "checkbox" name = "f_xbox" value = "1"><h5 class=categories>Xbox</h5> <span id="xbox_count" style="text-decoration:italic!important"><i>(0)</i></span><br>
     <input type = "checkbox" name = "f_xlan" value = "1"><h5 class=categories>xLAN</h5> <span id="xlan_count" style="text-decoration:italic!important"><i>(0)</i></span>  <a href="http://halo1hub.com/xlan/"><img src="infomark.png" alt="xLAN Info"></a><br>
     <input type = "checkbox" name = "f_mcc" value = "1"><h5 class=categories>MCC</h5> <span id="mcc_count" style="text-decoration:italic!important"><i>(0)</i></span><br>
     <input type = "checkbox" name = "f_hpc" value = "1"><h5 class=categories>Halo PC</h5> <span id="hpc_count" style="text-decoration:italic!important"><i>(0)</i></span><br>
        <br>
     <input type = "checkbox" name = "f_host" value = "1"><label> Show only players who can host</label> <span id="host_count" style="text-decoration:italic!important"><i>(0)</i></span><br>
        
     <input type = "checkbox" name = "f_confirmed" value = "1">
        <label>Show only confirmed players</label> <span id="conf_count" style="text-decoration:italic!important"><i>(0)</i></span> <span class="tooltip"><img src="infomark.png">
            <span class="tooltiptext">Confirmed players are players that have been verified as "down to play" by Halo1Hub staff.</span></span>
        <br>
        <br>
     <input type="submit" value="Update Map" name="submit"/><br />
	    
    </form>

	</div>
	<div id="map" class="block" width=80%>
	</div>
</div>
        
  <div id="content2" class="row2">
  <p><i>Javascript must be enabled. For support and bug reports, please email <a href="mailto:support@halofinder.com">support@halofinder.com</a>
  </div>
    <script>
    function initMap() {
      var dataUrl = 'playerdata.php?';
	  var $p_lat = getAllUrlParams().p_lat;
	  var $p_lng = getAllUrlParams().p_lng;
	  var $p_id = getAllUrlParams().p_id;
	  if($p_lat && $p_lng){
		var mapCenter = {lat: parseFloat($p_lat), lng: parseFloat($p_lng)};  
		var mapZoom = 9;
	  }
      else{
		var mapCenter = {lat: 42.877742, lng: -97.380979};
		var mapZoom = 4;
	  }
	  var prev_infowindow =false; 
      var map = new google.maps.Map(
      document.getElementById('map'), {zoom: mapZoom, center: mapCenter, mapTypeControl: false, scrollwheel: true, streetViewControl: false,        styles: [
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

    var oms = new OverlappingMarkerSpiderfier(map,
        {markersWontMove: true, markersWontHide: true, keepSpiderfied: true, circleSpiralSwitchover: 40 });
	  var $f_xbox = getAllUrlParams().f_xbox;
	  var $f_xlan = getAllUrlParams().f_xlan;
	  var $f_mcc = getAllUrlParams().f_mcc;
	  var $f_hpc = getAllUrlParams().f_hpc;
	  var $f_host = getAllUrlParams().f_host;
	  var $f_confirmed = getAllUrlParams().f_confirmed;
	  
	  if($f_xbox == 1)
	  {
		  dataUrl = dataUrl + "f_xbox=1&";
	  }
	  if($f_xlan == 1)
	  {
		  dataUrl = dataUrl + "f_xlan=1&";
	  }
	  
	  if($f_mcc == 1)
	  {
		  dataUrl = dataUrl + "f_mcc=1&";
	  }
	  
	  if($f_hpc == 1)
	  {
		  dataUrl = dataUrl + "f_hpc=1&";
	  }
	  
	  if($f_host == 1)
	  {
		  dataUrl = dataUrl + "f_host=1&";
	  }
	  
	  if($f_confirmed == 1)
	  {
		  dataUrl = dataUrl + "f_confirmed=1&";
	  }
	  
    if (navigator.geolocation) {
     navigator.geolocation.getCurrentPosition(function (position) {
         initialLocation = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
         map.setCenter(initialLocation);
     });
    }

    // Change this depending on the name of your PHP or XML file
    downloadUrl(dataUrl, function(data) {
      var xml = data.responseXML;
      var markers = xml.documentElement.getElementsByTagName('marker');
      Array.prototype.forEach.call(markers, function(markerElem) {
        var id = markerElem.getAttribute('id');
        var name = removeDiacritics(markerElem.getAttribute('name'));
	    var city = removeDiacritics(markerElem.getAttribute('city'));
        var gamertag = removeDiacritics(markerElem.getAttribute('gamertag'));
		var email = markerElem.getAttribute('email');
		var discord = removeDiacritics(markerElem.getAttribute('discord'));
		var platforms = '';
		var host = '';
		if(markerElem.getAttribute('xbox') == 1){
		   platforms += 'Xbox&nbsp;&nbsp;'};
		if(markerElem.getAttribute('xlan') == 1){
		   platforms += 'XLAN&nbsp;&nbsp;'};
		if(markerElem.getAttribute('hpc') == 1){
		   platforms += 'HPC&nbsp;&nbsp;'};
		if(markerElem.getAttribute('mcc') == 1){
		   platforms += 'MCC&nbsp;&nbsp;'};
		if(markerElem.getAttribute('host') == 1){
		   var host = 'Able to Host'};
		var notes = removeDiacritics(markerElem.getAttribute('notes'));
        var point = new google.maps.LatLng(
            parseFloat(markerElem.getAttribute('lat')),
            parseFloat(markerElem.getAttribute('lng')));
		if($p_id == id){
        var marker = new google.maps.Marker({
            map: map, title: name, position: point, icon: 'halo-marker-selected.png'
        });
		}
		else{
			var marker = new google.maps.Marker({
            map: map, title: name, position: point, icon: 'halo-marker.png'
        });
		}
		oms.addMarker(marker);

        var content = '<div id="contentWindow" height=100% width=100%>' +
              '<h3>' + name + '</h3>' + 
			  '<a href="emailplayer.php?id=' + id + '&name=' + name + '">Email Player</a><br><p>';
	    if(city){
			  content += '<b>Nearby: </b>' + city + '<br>';
	    }
		if(gamertag){
			  content += '<b>XBL GT: </b>' + gamertag + '<br>';
		}
		if(discord){
			  content += '<b>Discord: </b>' + discord + '<br>';
		}
		if(host){
			  content += '<b>' + host + '</b>';
		}
			  content += '<br><div class="platforms" id="idplat">' + platforms + '</div>';

		if(notes){
			  content += '<p>' + notes;
		}
		content += '</div>';
					  

      var infowindow = new google.maps.InfoWindow()

	  google.maps.event.addListener(marker,'click', (function(marker,content,infowindow){ 
          return function() {
		  if( prev_infowindow ) {
            prev_infowindow.close();
        }

          prev_infowindow = infowindow;
            infowindow.setContent(content);
            infowindow.open(map,marker);
         };
     })(marker,content,infowindow)); 
            });
          });
        }

    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA0JA3sjMgwAboqsaFv2DLLRX7zA12lfQw&callback=initMap">
    </script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/OverlappingMarkerSpiderfier/1.0.3/oms.min.js"></script>
	<script async defer language="javascript">
	document.getElementById("xbox_count").innerHTML = "<i>(" + xboxcnt + ")</i>";
	document.getElementById("mcc_count").innerHTML = "<i>(" + mcccnt + ")</i>";
	document.getElementById("xlan_count").innerHTML = "<i>(" + xlancnt + ")</i>";
	document.getElementById("hpc_count").innerHTML = "<i>(" + hpccnt + ")</i>";
	document.getElementById("host_count").innerHTML = "<i>(" + hostcnt + ")</i>";
	document.getElementById("conf_count").innerHTML = "<i>(" + confcnt + ")</i>";
	</script>
  </body>
</html>