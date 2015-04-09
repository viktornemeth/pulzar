<?php
session_start();
//                                           AJAX Header
//------------------------------------------------------
$is_admin = true;
// Load configuration files /config
require_once "../../../config/config-autoload.php";

// Load includes
require_once "../../../includes/includes.php";

// Check Hash
$core->checkAjaxSecure($private_key);

// Get command
isset($_POST["command"]) ? $command = $_POST["command"] : $command = "";

//                                          /AJAX Header
//------------------------------------------------------

switch ($command) {

//                                          Authenticate
//------------------------------------------------------
case 'authenticate':
    $submitdata = array();
    $submitdata = $_POST['submitdata'];
    $email 		= $submitdata[0]['value']; 
	 $password 	= md5($submitdata[1]['value']);
	 $result     = $sql->select("users", ["id", "access"], [ "AND" => ["email"=>$email, "password"=>$password]]);
    $my_data    = $result[0];
    $accept = explode("#", $my_data['access']);
    if (in_array("admin", $accept)) {$user_is_admin = 1;} else {$user_is_admin = 0;}
	
	if($user_is_admin==1 ){
		$_SESSION['myuid'] = $my_data["id"]; 
      $_SESSION["myaccess"] = $my_data['access'];
  		echo 'true';
	} 
	else {
		echo 'false';
	}
    break;
}
?>