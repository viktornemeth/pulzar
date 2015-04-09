<?php
session_start(); ob_start();

// This is admin
$is_admin = true;

// Load configuration files /config
require_once "../config/config-autoload.php";

// Load includes
require_once "../includes/includes.php";

// Start Body
if ($module == 'login') {
    // Include separated login site
    include $_C['admin_template_dir']."/login.php";
} else {
   // Include default template. The router call in template index.php file.
    include $_C['admin_template_dir']."/index.php";
}
// End Body

// Start Footer
ob_end_flush();
// End Footer
?>