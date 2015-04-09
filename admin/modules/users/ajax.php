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

//                                          Check URL ID
//------------------------------------------------------
case 'check_email':
   $email = $_POST['email'];

   $user = $sql->count("users", "id", [
      "email"=>$email
      ]);
   if ($user!=0) {
      $available = 'false';
   } else {
       $available = 'true';
   }
   echo json_encode(array(
      "response" => $available,
      "notify" => $lang['notify']['user_email_exists']
    ));
break;
//                                                  Save
//------------------------------------------------------
case 'save':
   $id = $_POST['id'];

   $submitdata = $core->serializedToArray($_POST['submitdata']);
   
   $access = "#public";
   if ($submitdata['acc_admin']=='1') { $access .= '#admin'; }
   if ($submitdata['acc_su']=='1') { $access .= '#su'; }
   if ($submitdata['acc_dev']=='1') { $access .= '#dev'; }
   
   if ($id!='~new~') {
      $sql->update("users", [
      "email" => $submitdata['email'],
      "category" => $submitdata['category'],
      "access" => $access,
      "status" => $submitdata['status'],
      "first_name" => $submitdata['first_name'],
      "last_name" => $submitdata['last_name'],
      "nick" => $submitdata['nick'],
      "gender" => $submitdata['gender'],
      "birthday" => $submitdata['birthday'],
      "mailing_name" => $submitdata['mailing_name'],
      "mailing_zip" => $submitdata['mailing_zip'],
      "mailing_city" => $submitdata['mailing_city'],
      "mailing_address" => $submitdata['mailing_address'],
      "mailing_country" => $submitdata['mailing_country'],
      "billing_name" => $submitdata['billing_name'],
      "billing_zip" => $submitdata['billing_zip'],
      "billing_city" => $submitdata['billing_city'],
      "billing_address" => $submitdata['billing_address'],
      "billing_country" => $submitdata['billing_country'],
      "phone" => $submitdata['phone']
      ],
      ["id"=>$id]
      );
   } else {
      if ($submitdata['password']=='') {$password = '123456';} else {$password = $submitdata['password'];}
      $sql->insert("users", [
      "password" => md5($password),
      "email" => $submitdata['email'],
      "first_name" => $submitdata['first_name'],
      "last_name" => $submitdata['last_name'],
      "nick" => $submitdata['nick'],
      "gender" => $submitdata['gender'],
      "birthday" => $submitdata['birthday'],
      "billing_name" => $submitdata['billing_name'],
      "billing_zip" => $submitdata['billing_zip'],
      "billing_city" => $submitdata['billing_city'],
      "billing_address" => $submitdata['billing_address'],
      "mailing_name" => $submitdata['mailing_name'],
      "mailing_zip" => $submitdata['mailing_zip'],
      "mailing_city" => $submitdata['mailing_city'],
      "mailing_address" => $submitdata['mailing_address'],
      "phone" => $submitdata['phone'],
      "access" => $access,
      "status" => $submitdata['status'],
      "reg_date" => date("Y-m-d H:i:s"),
      "reg_type" => "admin"
      ]);  
   }
   echo json_encode(array(
      "response" => "true",
      "notify" => $lang['notify']['save_success'],
      "reload_url" => '/users'
   )); 
break;

//                                       Change Password
//------------------------------------------------------
case 'change_user_password':
   $id = $_POST['id'];
   $password = $_POST['password'];
   $sql->update("users", [
      "password" => md5($password),
      ],
      ["id"=>$id]
      ); 
      
   echo json_encode(array(
      "response" => "true",
      "notify" => $lang['notify']['update_success']
   )); 
break;

//                                                Delete
//------------------------------------------------------
case 'delete':
   $id = $_POST['id'];
   $table = $_POST['table'];
   $sql->delete($table, ["id" => $id]);
   echo json_encode(array(
      "response" => 'true',
      "notify" => $lang['notify']['delete_success']
    ));
break;

}