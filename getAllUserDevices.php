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
    $userId = $_POST["userId"];
    $sql = "SELECT tc_devices.name AS 'deviceName',tc_groups.name AS 'groupName', tc_devices.uniqueid AS 'IMEI', tc_drivers.name AS 'driver'
    FROM tc_devices
    LEFT JOIN tc_groups ON tc_devices.groupid = tc_groups.id
    LEFT JOIN tc_device_driver ON tc_devices.id = tc_device_driver.deviceid
    LEFT JOIN tc_drivers ON tc_drivers.id = tc_device_driver.driverid
    LEFT JOIN tc_user_device ON tc_user_device.deviceid = tc_devices.id
    WHERE tc_user_device.userid = '$userId'
    ORDER BY tc_devices.groupid";
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