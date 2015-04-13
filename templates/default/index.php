<!doctype html>
<html xmlns:fb="http://ogp.me/ns/fb#">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<meta name="robots" content="<?php echo $_C['robots']; ?>">
<link rel="shortcut icon" href="<?php echo $_C['site_template_url']; ?>/favicon.png">
<meta name="keywords" content="<?php echo $meta[0]['keywords']; ?>">
<meta name="description" content="<?php echo $meta[0]['description']; ?>">
<meta name="generator" content="C3KAITEN">
<meta property="og:title" content="<?php echo $meta[0]['prefix']; ?>" />
<meta property="og:site_name" content="<?php echo $_C['sitename']; ?>" />
<title><?php if ( $meta[0]['prefix'] != '' ) { echo $meta[0]['prefix'].' - '; } echo $_C['sitename']; ?></title>
<?php
// Autoload plugins
require_once $_C['siteroot']."/plugins/load-plugins.php";
?>
<script src="<?php echo $_C['livesite']; ?>/plugins/cropit/dist/jquery.cropit.min.js"></script>
<script src="<?php echo $_C['site_template_url']; ?>/js/video.js"></script>
<script src="<?php echo $_C['site_template_url']; ?>/js/jquery.slides.min.js"></script>
<script src="<?php echo $_C['site_template_url']; ?>/js/hajdupress.js"></script>
<!-- ANALYTICS -->
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', '', 'auto');
  ga('send', 'pageview');

</script>

<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="<?php echo $_C['site_template_url']; ?>/css/frontend.css" type="text/css" />

</head>
<body>
<div id="fb-root"></div>

<header>
</header>

<main>
</main>

<footer>
</footer>

</body>
</html>
