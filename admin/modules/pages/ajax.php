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
case 'check_url_id':
   $url_id = $_POST['field'];

   $page = $sql->count("pages", "id", [
      "url_id"=>$url_id
      ]);
   if ($page!=0) {
      $available = 'false';
   } else {
      $available = 'true';
   }
   echo json_encode(array(
      "response" => $available,
      "notify_true" => '',
      "notify_false" => $lang['notify']['url_id_exists']
    ));
break;

//                                                  Save
//------------------------------------------------------
case 'save':
   $submitdata = $core->serializedToArray($_POST['submitdata']);
   $url_id = $submitdata['url_id'];
   
   $page = $sql->select("pages", "id", ["AND" => [
      "language" => $actual_language,
      "url_id"=>$url_id
      ]]);
   if ($page) {
      $sql->update("pages", [
      "language" => $submitdata['language'],
      "title" => $submitdata['title'],
      "text" => $submitdata['content']
      ],
      ["AND" => [
      "url_id"=>$url_id,
      "language" => $submitdata['language']
      ]]
      );
   } else {
      $sql->insert("pages", [
      "url_id" => $submitdata['url_id'],
      "language" => $submitdata['language'],
      "title" => $submitdata['title'],
      "text" => $submitdata['content']
      ]);
      
   }
   
   // META
   $page_meta = $sql->select("meta", "id", ["AND" => [
      "language" => $submitdata['language'],
      "url_module" => "page",
      "url_id" => $url_id  
   ]]);
   if ($page_meta) {
      $sql->update("meta", [
      "language" => $submitdata['language'],
      "url_module" => 'page',
      "url_id" => $url_id,
      "prefix" => $submitdata['meta_prefix'],
      "keywords" => $submitdata['meta_keywords'],
      "description" => $submitdata['meta_description']
      ],
      ["AND" => [
      "language" => $submitdata['language'],
      "url_module" => "page",
      "url_id" => $url_id
      ]]
      );
   } else {
      $sql->insert("meta", [
      "language" => $submitdata['language'],
      "url_module" => 'page',
      "url_id" => $url_id,
      "prefix" => $submitdata['meta_prefix'],
      "keywords" => $submitdata['meta_keywords'],
      "description" => $submitdata['meta_description']
      ]);
      
   }
   
   echo json_encode(array(
      "response" => 'true',
      "notify" => $lang['notify']['save_success']
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
?>