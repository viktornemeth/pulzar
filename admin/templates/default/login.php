<?php
/*                                             login.php
.------------------------------------------------------.
|  Software: Kaiten - Administrator template login     |
|   Version: 3.0                                       |
|  Git Repo: https://bitbucket.org/integrian/chakra-3  |
|      Info: http://cms.chakra.hu                      |
|   Support: cms@chakra.hu                             |
'------------------------------------------------------'
                             © 2014 integrian industries
*/
?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<meta name="robots" content="noindex, nofollow"/>
<link rel="shortcut icon" href="<?php echo $_C['admin_template_url']; ?>/favicon.png">
<meta name="generator" content="C3KAITEN">
<title><?php echo $_C['sitename']; ?> backend login</title>
<!-- Google Fonts -->
<link href='http://fonts.googleapis.com/css?family=Ubuntu:300,400,700&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="<?php echo $_C['admin_template_url']; ?>/css/backend.css" type="text/css">
<?php
// Autoload plugins
require_once $_C['siteroot']."/plugins/load-plugins.php";
?>
</head>
<body class="login-bg">

<!-- Notify box -->
<div class="notify"></div>

<?php include $_C['siteroot']."/router.php"; // Call router, IMPORTANT AND REQUIRED ?>
</body>
</html>