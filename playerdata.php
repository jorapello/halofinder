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


$f_xbox = $_GET['f_xbox'];
$f_xlan = $_GET['f_xlan'];
$f_mcc = $_GET['f_mcc'];
$f_hpc = $_GET['f_hpc'];
$f_host = $_GET['f_host'];
$f_confirmed = $_GET['f_confirmed'];




$query = "SET NAMES utf8";
if ($result = mysqli_query($connection, $query . $queryCondition)) {

}



$query = "SELECT ID, NAME, LAT, LNG, CITY, GAMERTAG, DISCORD, XBOX, MCC, XLAN, HPC, HOST, NOTES, CONFIRMED, EMAIL_VERIFIED FROM PLAYERS WHERE 1=1 AND (CONFIRMED = 1 OR EMAIL_VERIFIED = 1) ";
$queryCondition = "";

if($f_xbox){
	$queryCondition = $queryCondition . " AND XBOX = 1 ";
}

if($f_xlan){
	$queryCondition = $queryCondition . " AND XLAN = 1 ";
}

if($f_mcc){
	$queryCondition = $queryCondition . " AND MCC = 1 ";
}

if($f_hpc){
	$queryCondition = $queryCondition . " AND HPC = 1 ";
}
if($f_host){
	$queryCondition = $queryCondition . " AND HOST = 1 ";
}
if($f_confirmed){
	$queryCondition = $queryCondition . " AND CONFIRMED = 1 ";
}




if ($result = mysqli_query($connection, $query . $queryCondition)) {

}

header("Content-type: text/xml");



// Start XML file, echo parent node
echo "<?xml version='1.0' encoding='utf-8' standalone='no'?>
";
echo '<markers>
';
$ind=0;
// Iterate through the rows, printing XML nodes for each
while ($row = @mysqli_fetch_assoc($result)){
  // Add to XML document node
  echo '<marker ';
  echo 'id="' . $row['ID'] . '" ';
  echo 'name="' . parseToXML($row['NAME']) . '" ';
  echo 'lat="' . $row['LAT'] . '" ';
  echo 'lng="' . $row['LNG'] . '" ';
  echo 'city="' . parseToXML($row['CITY']) . '" ';
  echo 'gamertag="' . parseToXML($row['GAMERTAG']) . '" ';
  echo 'discord="' . parseToXML($row['DISCORD']) . '" ';
  echo 'xbox="' . $row['XBOX'] . '" ';
  echo 'mcc="' . $row['MCC'] . '" ';
  echo 'xlan="' . $row['XLAN'] . '" ';
  echo 'hpc="' . $row['HPC'] . '" ';
  echo 'host="' . $row['HOST'] . '" ';
  echo 'notes="' . parseToXML($row['NOTES']) . '" ';
  echo 'confirmed="' . $row['CONFIRMED'] . '" ';
  echo 'email_verified="' . $row['EMAIL_VERIFIED'] . '" ';
  echo '/>
  ';
  $ind = $ind + 1;
}

// End XML file
echo '</markers>';
?>