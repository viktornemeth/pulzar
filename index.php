<?php
session_start(); ob_start();

// This is not admin
$is_admin = false;

// Load configuration files /config
require_once "config/config-autoload.php";

// Load includes
require_once "includes/includes.php";

// Start Body
// Include default template. The router call in template index.php file.
include $_C['site_template_dir']."/index.php";
// End Body

// Start Footer
ob_end_flush();
// End Footer
?>