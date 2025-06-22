<?php

require_once("classes/conn.php");

//Get ID from GET (better POST but for easy debug...)
if (isset($_GET["blot_photo"])) {
  $blot_photo = $_GET["blot_photo"];
} else {
  echo "Wrong input";
  exit;
}

//Prepare PDO SQL
$q = $conn->prepare("SELECT * FROM `tbl_blotter` WHERE `blot_photo`=:blot_photo");
$q->bindParam(":blot_photo", $blot_photo, PDO::PARAM_LOB);
$q->execute();

//If something found (always only 1 record!)
if ($q->rowCount() == 1) {

  //Get the content of the record into $row
  $row = $q->fetch(PDO::FETCH_ASSOC); //Everything with id=$id should be in record buffer

  //This is the image blob mysql item  
  $image = $row['blot_photo'];
  $id = $row['id_blotter'];

  //Now start the header, caution: do not output any other header or other data!
  header("Content-type: image/jpeg");
  header('Content-Disposition: attachment; filename="blotter_image_' . $id . '.jpg"');
  header("Content-Transfer-Encoding: binary");
  header('Expires: 0');
  header('Pragma: no-cache');
  header("Content-Length: " . strlen($image));
  //Output plain image from db
  echo $image;
} else {
  //Nothing found with that id, output some error
  echo "No image found";
}

//No output and exceution further this point
exit();
?>