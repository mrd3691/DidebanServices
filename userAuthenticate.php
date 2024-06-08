<?php 
header('Access-Control-Allow-Origin: *');
header('Content-Type: text/html; charset=UTF-8');
$db = "traccar";
$dbuser = "root";
$dbpassword = "";
$dbhost = "localhost";
$return["id"] = null;
$return["username"] = null;
$return["name"] = null;
$return["disabled"] = null;
$return["error"] = false;
$return["message"] = "";
$link = mysqli_connect($dbhost, $dbuser, $dbpassword, $db);
$userName = $_POST["userName"]; 
$password = $_POST["password"]; 
$val = isset($_POST["userName"]);
if($val){
  $sql = "SELECT * FROM `tc_users` WHERE `email`='$userName' ";
  $result = mysqli_query($link, $sql);
  if (mysqli_num_rows($result) > 0) {          
    $obj = mysqli_fetch_object($result);
    //$obj = mysqli_fetch_all($result, MYSQLI_ASSOC);
    if($password == $obj->hashedpassword){
      $return["id"] = $obj->id;
      $return["username"] = $obj->email;
      $return["name"] = $obj->name;
      $return["disabled"] = $obj->disabled;
      $return["error"] = false;
      $return["message"] = "Authenticated";
      $found =true;
    }else{
      $return["error"] = true;
      $return["message"] = "Incorrect password";
    }
  }else{
    $return["error"] = true;
    $return["message"] = 'Incorrect username';
  }
}else{
  $return["error"] = true;
  $return["message"] = 'input username and password';
}
mysqli_close($link); 
header('Content-Type: application/json');
echo json_encode($return);
?>