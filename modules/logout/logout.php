<?php
defined('_KAITEN') or die('Restricted access');

session_start();
session_destroy();
header("Location: ".$_C['livesite']);