<?php
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: text/html; charset=UTF-8');
 
  $db = "traccar";
  $dbuser = "root";
  $dbpassword = "";
  $dbhost = "localhost";
  $return["error"] = false;
  $return["message"] = "";
  try{
    $link = mysqli_connect($dbhost, $dbuser, $dbpassword, $db);
    $link->set_charset("utf8");
    $deviceName = $_POST["deviceName"];
    $sql = "SELECT `fixtime`,`longitude`,`latitude`,`speed`,tc_positions.attributes AS 'attributes', tc_drivers.name AS 'driver' FROM `tc_positions` 
INNER JOIN tc_devices ON tc_devices.name = '$deviceName' AND tc_devices.positionid = tc_positions.id
LEFT JOIN tc_device_driver ON tc_devices.id = tc_device_driver.deviceid
LEFT JOIN tc_drivers ON tc_drivers.id = tc_device_driver.driverid";
    $result = mysqli_query($link, $sql);
    $results = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_close($link); 
  }catch(Exception $e){
    $return["error"] = true;
    $return["message"] = "Error occured";
  }
  header('Content-Type: application/json');
  echo json_encode($results);
?>