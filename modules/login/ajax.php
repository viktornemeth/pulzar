<?php
session_start();
//                                           AJAX Header
//------------------------------------------------------
$is_admin = true;
// Load configuration files /config
require_once "../../config/config-autoload.php";

// Load includes
require_once "../../includes/includes.php";

// Check Hash
$core->checkAjaxSecure($private_key);

// Get command
isset($_POST["command"]) ? $command = $_POST["command"] : $command = "";

//                                          /AJAX Header
//------------------------------------------------------

switch ($command) {

//                                        Authentication
//------------------------------------------------------
case 'auth_facebook':
   $facebook_id = $_POST['facebook_id'];
   $fb_birthday = explode('/', $_POST['birthday']);
   $birthday = $fb_birthday[2].'-'.$fb_birthday[0].'-'.$fb_birthday[1];
   $email = $_POST['email'];
   $first_name = $_POST['first_name'];
   $last_name = $_POST['last_name'];
   
   //check email
   $check_me = $sql->select('users', 'facebook_id', ['email' => $email]);
   if ($check_me[0] == '') {
      $sql->update('users', [
         'facebook_id' => $facebook_id, 
         'birthday' => $birthday
      ], ['email' => $email]);
   }
   
   $me = $sql->select('users', '*', ['AND' => ['facebook_id' => $facebook_id, 'email' => $email]]);
   if ($me) {
      switch ($me[0]['status']) {
         case 'active':
            $_SESSION['my_uid'] = $me[0]['id'];
         break;
         case 'inactive':
            unset($_SESSION['my_uid']);
         break;
         case 'muted':
            $_SESSION['my_uid'] = $me[0]['id'];
         break;
         case 'banned':
            unset($_SESSION['my_uid']);
         break;
      }
      $_SESSION['my_age'] = $user->getMyAge();
   } else {
      $sql->insert('users', [
         'password' => md5(uniqid()),
         'confirm_code' => md5(uniqid()),
         'first_name' => $first_name,
         'last_name' => $last_name,
         'facebook_id' => $facebook_id,
         'email' => $email,
         'status' => 'active',
         'reg_date' => date('Y-m-d H:i:s'),
         'reg_ip' => $_SERVER['REMOTE_ADDR']
      ]);
      $me = $sql->select('users', 'id', ['AND' => ['facebook_id' => $facebook_id, 'email' => $email]]);
      $_SESSION['my_uid'] = $me[0];
      $_SESSION['my_age'] = $user->getMyAge();
   }
   
   echo 'MYUID:'.$_SESSION['my_uid'];
break;
}
?>
