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
    $startDateTime = $_POST["startDateTime"];
    $endDateTime = $_POST["endDateTime"];
    $sql = "SELECT `fixtime`,`valid`,`latitude`,`longitude`,`speed`,`deviceid`,tc_positions.attributes
    FROM `tc_positions` 
    INNER JOIN tc_devices ON tc_devices.name = '$deviceName'
    WHERE deviceid = tc_devices.id
    AND fixtime > '$startDateTime'
    AND fixtime < '$endDateTime'";
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