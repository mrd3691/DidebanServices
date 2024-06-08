
<?php
header('Access-Control-Allow-Origin: *'); 
header('Content-Type: text/html; charset=UTF-8');
?>
<?php 
  $db = "traccar";
  $dbuser = "root";
  $dbpassword = "";
  $dbhost = "localhost";
  $return["error"] = false;
  $return["message"] = "";
  try{
    $link = mysqli_connect($dbhost, $dbuser, $dbpassword, $db);
    $link->set_charset("utf8");
    $sql = " SELECT * FROM tc_groups";
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