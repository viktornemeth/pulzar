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
<!-- YAHOO WEATHER -->
<script src="https://query.yahooapis.com/v1/public/yql?q=select item from weather.forecast where woeid in (select woeid from geo.places(1) where text='debrecen, hu')&format=json&callback=yqlCallback"></script>
<!-- ADSENSE -->
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- ANALYTICS -->
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-38180578-1', 'auto');
  ga('send', 'pageview');

</script>

<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="<?php echo $_C['site_template_url']; ?>/css/frontend.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $_C['site_template_url']; ?>/css/video-js.css" type="text/css" />

</head>
<body>
<div id="fb-root"></div>

<div class="search">
<form action="/search/" method="get">
<i class="fa fa-search"></i> <input type="text" name="query" id="query" placeholder="Keresés..." />
</form>
<a class="search-close" onClick="$('.search').fadeOut(300);"><i class="fa fa-times"></i></a>
</div>

<?php
// névnap
$nevnap = $sql->select("nevnap", [
	"nev1",
	"nev2"
], [
	"AND" => [
		"ho" => date("m"),
		"nap" => date("d")
]]);
if ($nevnap[0]['nev2']!='') {$nevnap2 = ' és '.$nevnap[0]['nev2'];}
$nevnap1 = $nevnap[0]['nev1'];

?>

<header>
   <a href="<?php echo $_C['livesite']; ?>"><div class="logo">&nbsp;</div></a>
   <a href="<?php echo $_C['livesite']; ?>/rss"><div class="rss"></div></a>
   <div class="info">
      <div class="weather"><span class="wlike"></span> <span class="celsius"></span> &deg;C</div>
      <span class="time">TIME</span> <span class="date">DATE</span>
      <div class="nevnap">Ma <?php echo $nevnap1.$nevnap2; ?> nap van.</div>
   </div>
   <div class="banner banner-728x90">
   <div class="arrow arrow-ad"></div><div class="section-title section-title-ad">Hirdetés</div>
      <!-- Top banner -->
      <?php
         echo $banner->render($banner->get(1), '9381313390');
      ?>
      
   </div>
</header>

<div class="menupoints" align="right">
<div class="menupoints-rovatok" align="left">
<a href="#" onClick="show_search()"><i class="fa fa-search"></i></a>
<?php 
$top_rovatok_query = $sql->query("SELECT title, url_id FROM rovatok WHERE status='frontend' ORDER BY clicks DESC,title ASC LIMIT 10");
while ($top_rovatok_array = $top_rovatok_query->fetch(PDO::FETCH_ASSOC)) {
   echo '<a href="'.$_C['livesite'].'/rovat/'.$top_rovatok_array['url_id'].'">'.$top_rovatok_array['title'].'</a>';
}
?>

</div>
<div class="minden_rovat"><a href="<?php echo $_C['livesite'].'/rovatok'; ?>" class="button tiny success" title="További rovatok"><i class="fa fa-ellipsis-v"></i></a></div>
<div class="minden_channel"><a href="<?php echo $_C['livesite'].'/alfoldtv'; ?>" title="Alföld TV"><div style="background-image:url(<?php echo $_C['site_template_url'].'/images/alfoldtv.jpg'; ?>); width:37px; height:37px; background-size:contain;" ></div></a></div>

<?php
if (isset($_SESSION['my_uid']) and $_SESSION['my_uid'] != ''){
   echo 'Szia '.$user->getMy('first_name').'!<br/>
   <a class="small-link" href="'.$_C['livesite'].'/logout">Kilépés</a> ';
   //<a class="small-link" href="'.$_C['livesite'].'/my-account">Beállításaim</a>';
   $tpl->assign("my_age", $_SESSION['my_age']);
} else {
   echo '<div class="fb-login">
   <fb:login-button scope="public_profile,email,user_birthday" onlogin="checkLoginState();"></fb:login-button>
   </div>';
   $tpl->assign("my_age", '1');
}
?>
</div>

<main>
<?php
// Szavazás
$poll = $sql->query("SELECT * FROM polls WHERE status='1' ORDER BY RAND() LIMIT 1")->fetchAll();
$poll_answers = $sql->count("polls_answers", ["poll" => $poll[0]['id']]);
$vote_max = $sql->sum("polls_answers", "votes", ["poll" => $poll[0]['id']]);
if ($poll_answers!=0){
   $pollbox = '<a onclick="show_poll()"><div class="poll"><i class="fa fa-tasks"></i> <strong>SZAVAZZ TE IS:</strong> '.$poll[0]['question'].' <strong><small>(KATTINTS IDE!)</small></strong>
   </div></a>
   <div class="poll poll-answers">
   <div class="panel callout" align="center">
  <p>'.$poll[0]['description'].'</p>
    </div>
   ';
   if ($_SESSION['my_uid']) {
      $answer_query = $sql->query("SELECT * FROM polls_answers WHERE poll='".$poll[0]['id']."' ORDER BY votes DESC");
      $answered = $sql->count("polls_votes", ["AND"=>["poll" => $poll[0]['id'], "user"=>$_SESSION['my_uid'] ]]);
      while ($answer = $answer_query->fetch(PDO::FETCH_ASSOC)) {
         $one_percent = $vote_max/100;
         $percent = round((100*$answer['votes'])/$vote_max);
      $pollbox .= '
      <div class="row">
            <div class="large-3 columns poll-answer" align="right">
               '.$answer['answer'].'
            </div>
            <div class="large-8 columns">
            <div class="progress small alert poll-progress">
              <span class="meter" style="width: '.$percent.'%"></span>
            </div>
            </div>
            <div class="large-1 columns" align="right">';
               if ($answered==0) {
               $pollbox .= '<a class="button tiny alert vote-button" onClick="vote(\''.$poll[0]['id'].'\', \''.$answer['id'].'\')"><i class="fa fa-thumbs-up"></i></a>';
               }
            $pollbox .= '</div>
         </div>';
      } 
   } else {
         $pollbox .= '<div data-alert class="alert-box alert">Jelentkezz be, hogy szavazhass!<a href="#" class="close">&times;</a></div>';
      }
   $pollbox .= '</div>';
   echo $pollbox;
}

include $_C['siteroot']."/router.php"; // Call admin router, IMPORTANT AND REQUIRED ?>
</main>

<footer>
<div class="footer-left">
<a href="<?php echo $_C['livesite']; ?>/page/mediaajanlat">Médiaajánlat / Hirdetési árak</a><br/>
<a href="<?php echo $_C['livesite']; ?>/page/adatkezeles">Adatkezelés</a><br/>
<a href="<?php echo $_C['livesite']; ?>/page/felhasznaloi-feltetelek">Felhasználói feltételek</a><br/>
<a href="<?php echo $_C['livesite']; ?>/page/szerzoi-jogok">Szerzői jogok</a><br/>
<a href="<?php echo $_C['livesite']; ?>/page/impressum">Impressum</a>
</div>
<div class="footer-logo">
</div>
<div class="footer-right">
<iframe src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2Fhajdupress&amp;width=80px&amp;layout=box_count&amp;action=like&amp;show_faces=false&amp;share=true&amp;height=65&amp;appId=548001842000790" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:80px; height:65px;" allowTransparency="true"></iframe>
</div>
<div class="clear"></div>
</footer>
<div class="copyright" align="center">HajduPress &copy; <?php echo date('Y'); ?> minden jog fenntartva</div>
<br/>

</body>
</html>