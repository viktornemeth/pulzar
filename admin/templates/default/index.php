<?php
/*                                             index.php
.------------------------------------------------------.
|  Software: Kaiten - Administrator template index     |
|   Version: 3.0                                       |
|  Git Repo: https://bitbucket.org/integrian/chakra-3  |
|      Info: http://cms.chakra.hu                      |
|   Support: cms@chakra.hu                             |
'------------------------------------------------------'
                             © 2014 integrian industries
*/
$core->lock('su#admin');
?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<meta name="robots" content="noindex, nofollow">
<link rel="shortcut icon" href="<?php echo $_C['admin_template_url']; ?>/favicon.png">
<meta name="generator" content="C3KAITEN">
<title><?php echo $_C['sitename']; ?> backend</title>
<?php
// Autoload plugins
require_once $_C['siteroot']."/plugins/load-plugins.php";
?>

<link rel="stylesheet" href="<?php echo $_C['livesite']; ?>/plugins/html5-file-upload/assets/css/html5fileupload.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $_C['admin_template_url']; ?>/css/colpick.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $_C['admin_template_url']; ?>/css/pikaday.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $_C['admin_template_url']; ?>/css/backend.css" type="text/css" />

<script src="<?php echo $_C['livesite']; ?>/plugins/ckeditor-4.4.5/ckeditor.js"></script>
<script src="<?php echo $_C['livesite']; ?>/plugins/cropit/dist/jquery.cropit.min.js"></script>
<script src="<?php echo $_C['livesite']; ?>/plugins/html5-file-upload/assets/js/html5fileupload.js"></script>
<script src="<?php echo $_C['admin_template_url']; ?>/js/jquery.formatCurrency-1.4.0.min.js"></script>
<script src="<?php echo $_C['admin_template_url']; ?>/js/pikaday.js"></script>
<script src="<?php echo $_C['admin_template_url']; ?>/js/pikaday.jquery.js"></script>
<script src="<?php echo $_C['admin_template_url']; ?>/js/colpick.js"></script>
<script src="<?php echo $_C['admin_template_url']; ?>/js/jquery.sortable.min.js"></script>
<script src="<?php echo $_C['admin_template_url']; ?>/js/backend.js"></script>
</head>
<body>

<!-- Notify box -->
<div class="notify"></div>

<header>
<div class="header-toolbar">
   <span class="loading"><img src="<?php echo $_C['admin_template_url'] ?>/images/loader.gif"/></span>
    <a href="<?php echo $_C['livesite']; ?>" target="_blank" class="button tiny"><i class="fa fa-laptop"></i> <?php echo capitalize($lang['sys']['preview']);?></a>
    <a href="<?php echo $_C['livesite']; ?>/logout" class="button tiny alert"><i class="fa fa-power-off"></i> <?php echo capitalize($lang['auth']['logout']);?></a>
</div>
</header>

<section>
<div class="menubar">
    <div class="icon-bar vertical five-up">
      <a class="item" href="<?php echo $_C['liveadmin'] ?>">
        <i class="fa fa-dashboard"></i>
        <label><?php echo capitalize($lang['sys']['dashboard']);?></label>
      </a>
      
      <a class="item <?php if ($module=="users") { echo "active"; } ?>" data-dropdown="users_sub" data-options="align:right" href="#">
        <i class="fa fa-user"></i>
        <label><?php echo capitalize($lang['sys']['users']);?></label>
      </a>
      <a class="item <?php if ($module=="pages") { echo "active"; } ?>" data-dropdown="pages_sub" data-options="align:right" href="#">
        <i class="fa fa-copy"></i>
        <label><?php echo capitalize($lang['sys']['contents']);?></label>
      </a>
      <a class="item <?php if ($module=="rovatok") { echo "active"; } ?>" data-dropdown="rovatok_sub" data-options="align:right" href="#">
        <i class="fa fa-list-alt"></i>
        <label>Rovatok</label>
      </a>
      <a class="item <?php if ($module=="videos") { echo "active"; } ?>" data-dropdown="videos_sub" data-options="align:right" href="#">
        <i class="fa fa-video-camera"></i>
        <label>Alföld TV</label>
      </a>
      <a class="item <?php if ($module=="polls") { echo "active"; } ?>" data-dropdown="polls_sub" data-options="align:right" href="#">
        <i class="fa fa-check-circle-o"></i>
        <label><?php echo capitalize($lang['sys']['poll']);?></label>
      </a>
      <a class="item <?php if ($module=="jatek") { echo "active"; } ?>" data-dropdown="jatek_sub" data-options="align:right" href="#">
        <i class="fa fa-trophy"></i>
        <label>Nyereményjáték</label>
      </a>
      <a class="item <?php if ($module=="newsletters") { echo "active"; } ?>" data-dropdown="newsletter_sub" data-options="align:right" href="#">
        <i class="fa fa-newspaper-o"></i>
        <label><?php echo capitalize($lang['sys']['newsletter']);?></label>
      </a>
      <a class="item <?php if ($module=="banners") { echo "active"; } ?>" data-dropdown="banners_sub" data-options="align:right" href="#">
        <i class="fa fa-bookmark-o"></i>
        <label><?php echo capitalize($lang['sys']['banners']);?></label>
      </a>
      <!--
      <a class="item" href="<?php echo $_C['liveadmin'] ?>/templates">
        <i class="fa fa-cubes"></i>
        <label><?php echo capitalize($lang['sys']['templates']);?></label>
      </a>
      -->
    </div>
</div>

<ul id="users_sub" class="f-dropdown" data-dropdown-content>
  <li><a href="<?php echo $_C['liveadmin'] ?>/users/~new~/edit"><?php echo capitalize($lang['sys']['new']);?></a></li>
  <li><a href="<?php echo $_C['liveadmin'] ?>/users"><?php echo capitalize($lang['sys']['users']);?></a></li>
</ul>
<ul id="pages_sub" class="f-dropdown" data-dropdown-content>
  <li><a href="<?php echo $_C['liveadmin'] ?>/pages/~new~/edit"><?php echo capitalize($lang['sys']['new']);?></a></li>
  <li><a href="<?php echo $_C['liveadmin'] ?>/pages"><?php echo capitalize($lang['sys']['contents']);?></a></li>
</ul>
<ul id="rovatok_sub" class="f-dropdown" data-dropdown-content>
  <li><a href="<?php echo $_C['liveadmin'] ?>/rovatok/~show~/top-cikkek">Top cikkek a főoldalon</a></li>
  <li><a href="<?php echo $_C['liveadmin'] ?>/rovatok/~new~/edit">Új rovat</a></li>
  <li><a href="<?php echo $_C['liveadmin'] ?>/rovatok">Rovatok</a></li>
  <li><a href="<?php echo $_C['liveadmin'] ?>/rovatok/~new~/cikk-edit">Új cikk egy rovatban</a></li>
</ul>
<ul id="videos_sub" class="f-dropdown" data-dropdown-content>
  <li><a href="<?php echo $_C['liveadmin'] ?>/videos/~new~/edit"><?php echo capitalize($lang['sys']['new']);?> video</a></li>
  <li><a href="<?php echo $_C['liveadmin'] ?>/videos"><?php echo capitalize($lang['media']['videos']);?></a></li>
  <li><a href="<?php echo $_C['liveadmin'] ?>/videos/~new~/channel-edit"><?php echo capitalize($lang['sys']['new'].' '.$lang['media']['channel']);?></a></li>
  <li><a href="<?php echo $_C['liveadmin'] ?>/videos/~show~/channels"><?php echo capitalize($lang['media']['channels']);?></a></li>
</ul>
<ul id="polls_sub" class="f-dropdown" data-dropdown-content>
  <li><a href="<?php echo $_C['liveadmin'] ?>/polls/~new~/edit"><?php echo capitalize($lang['sys']['new']);?></a></li>
  <li><a href="<?php echo $_C['liveadmin'] ?>/polls"><?php echo capitalize($lang['sys']['polls']);?></a></li>
</ul>
<ul id="jatek_sub" class="f-dropdown" data-dropdown-content>
  <li><a href="<?php echo $_C['liveadmin'] ?>/jatekok/~new~/edit">Új játék</a></li>
  <li><a href="<?php echo $_C['liveadmin'] ?>/jatekok">Nyereményjátékok</a></li>
</ul>
<ul id="newsletter_sub" class="f-dropdown" data-dropdown-content>
  <li><a href="<?php echo $_C['liveadmin'] ?>/newsletters/~new~/edit"><?php echo capitalize($lang['sys']['new']);?></a></li>
  <li><a href="<?php echo $_C['liveadmin'] ?>/newsletters"><?php echo capitalize($lang['sys']['newsletters']);?></a></li>
</ul>
<ul id="banners_sub" class="f-dropdown" data-dropdown-content>
  <li><a href="<?php echo $_C['liveadmin'] ?>/banners/~new~/edit"><?php echo capitalize($lang['sys']['new']);?></a></li>
  <li><a href="<?php echo $_C['liveadmin'] ?>/banners"><?php echo capitalize($lang['sys']['banners']);?></a></li>
  <li><a href="<?php echo $_C['liveadmin'] ?>/banners/list/zones"><?php echo capitalize($lang['sys']['zones']);?></a></li>
</ul>

<div class="content-wrapper">
<?php include $_C['siteroot']."/router.php"; // Call router, IMPORTANT AND REQUIRED ?>
<br/>
</div>

</section>

<footer>
Chakra 3 KAITEN &copy; <?php echo date('Y'); ?>
</footer>

</body>
</html>