<?php
require("credentials.php");

function parseToXML($htmlStr)
{
$xmlStr=str_replace('<','&lt;',$htmlStr);
$xmlStr=str_replace('>','&gt;',$xmlStr);
$xmlStr=str_replace('"','&quot;',$xmlStr);
$xmlStr=str_replace("'",'&#39;',$xmlStr);
$xmlStr=str_replace("&",'&amp;',$xmlStr);
return $xmlStr;
}

$connection=mysqli_connect ($servername, $username, $password, $dbname);
if (!$connection) {
  die('Not connected : ' . mysqli_connect_error());
}

if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

$query = "SET NAMES utf8";
if ($result = mysqli_query($connection, $query . $queryCondition)) {

}



$query = "SELECT ID, NAME, LAT, LNG, CITY, GAMERTAG, DISCORD, CASE WHEN XBOX = 1 THEN '✓' ELSE '✗' END AS XBOX, CASE WHEN MCC = 1 THEN '✓' ELSE '✗' END AS MCC, CASE WHEN XLAN = 1 THEN '✓' ELSE '✗' END AS XLAN, CASE WHEN HPC = 1 THEN '✓' ELSE '✗' END AS HPC, CASE WHEN HOST = 1 THEN '✓' ELSE '✗' END AS HOST, NOTES, CONFIRMED, EMAIL_VERIFIED FROM PLAYERS WHERE 1=1 AND (CONFIRMED = 1 OR EMAIL_VERIFIED = 1) ";
$queryCondition = "";

if ($result = mysqli_query($connection, $query . $queryCondition)) {

}
echo '<html>
';
echo '<head><link rel="stylesheet" type="text/css" href="style_playerlist.css"></head>
';
echo '<body>
';
echo '<div id="logo-div"><a href="http://halofinder.com/"><div id="logo"></div></a></div>
';
echo "<p id='info'>Click on a player's name to highlight their marker on the map.
";
echo '<table>
';
echo '<tr>
';
echo '<th>Name</th>
';
echo '<th>City</th>
';
echo '<th>XBL Gamertag</th>
';
echo '<th>Discord</th>
';
echo '<th>Xbox</th>
';
echo '<th>MCC</th>
';
echo '<th>xLAN</th>
';
echo '<th>HPC</th>
';
echo '<th>Host</th>
';
echo '<th>Notes</th>
';
echo '<th>Email Player</th>
';

$ind=0;
// Iterate through the rows, printing XML nodes for each
while ($row = @mysqli_fetch_assoc($result)){
  // Add to XML document node
  echo '<tr>
  '; 
  echo '<td><a href="index.php?p_lat=' . $row['LAT'] . '&p_lng=' . $row['LNG'] . '&p_id=' . $row['ID'] . '">' . $row['NAME'] . '</a></td>
  ';
  echo '<td>' . $row['CITY'] . '</td>
  ';
  echo '<td>' . $row['GAMERTAG'] . '</td>
  ';
  echo '<td>' . $row['DISCORD'] . '</td>
  ';
  echo '<td align="center">' . $row['XBOX'] . '</td>
  ';
  echo '<td align="center">' . $row['MCC'] . '</td>
  ';
  echo '<td align="center">' . $row['XLAN'] . '</td>
';
  echo '<td align="center">' . $row['HPC'] . '</td>';
  echo '<td align="center">' . $row['HOST'] . '</td>';
  echo '<td>' . $row['NOTES'] . '</td>';
    echo '<td><a href="emailplayer.php?id=' . parseToXML($row['ID']) . '&name=' . parseToXML($row['NAME']) . '">Email ' . parseToXML($row['NAME']) . '</a></td>';

  $ind = $ind + 1;
}

echo '</table>';
echo '</body>';
echo '</html>';
?>