<?php
/*                                      load-plugins.php
.------------------------------------------------------.
|  Software: Kaiten - Plug-in loader                   |
|   Version: 3.0                                       |
|  Git Repo: https://bitbucket.org/integrian/chakra-3  |
|      Info: http://cms.chakra.hu                      |
|   Support: cms@chakra.hu                             |
'------------------------------------------------------'
                             © 2014 integrian industries
*/
?>
<!-- Site Public Config -->
<script>
var _C = <?php echo json_encode($_C) ?>;
</script>

<!-- 
    jQuery 
    Documentation: http://api.jquery.com/
-->
<script src="<?php echo $_C['livesite']; ?>/plugins/jquery-1.11.2/jquery-1.11.2.min.js"></script>

<!-- 
    Foundation 5
    Documentation: http://foundation.zurb.com/index.html
-->
<link rel="stylesheet" href="<?php echo $_C['livesite']; ?>/plugins/foundation-5/css/normalize.css" type="text/css" media="screen">
<link rel="stylesheet" href="<?php echo $_C['livesite']; ?>/plugins/foundation-5/css/foundation.min.css" type="text/css" media="screen">
<script src="<?php echo $_C['livesite']; ?>/plugins/foundation-5/js/vendor/modernizr.js"></script>
<script src="<?php echo $_C['livesite']; ?>/plugins/foundation-5/js/foundation.min.js"></script>

<!-- 
    Moment.js 2
    Documentation: http://momentjs.com/docs/
-->
<script src="<?php echo $_C['livesite']; ?>/plugins/moment-2.9.0/moment-with-locales.min.js"></script>

<!-- 
    FontAwesome 4
    Icons: http://fortawesome.github.io/Font-Awesome/icons/
-->
<link rel="stylesheet" href="<?php echo $_C['livesite']; ?>/plugins/font-awesome-4.2.0/css/font-awesome.css" type="text/css">

<!-- 
    Lightbox Evolution - Envato Commercial Plugin
    Info: http://codecanyon.net/item/jquery-lightbox-evolution/115655
-->
<link rel="stylesheet" href="<?php echo $_C['livesite']; ?>/plugins/lightbox-evolution/js/lightbox/themes/facebook/jquery.lightbox.css" type="text/css">
<script src="<?php echo $_C['livesite']; ?>/plugins/lightbox-evolution/js/lightbox/jquery.lightbox.min.js"></script>
<script>$('.lightbox').lightbox();</script>

<!-- C3KAITEN JS -->
<script src="<?php echo $_C['livesite']; ?>/plugins/c3kaiten-3.0.0/c3kaiten.js"></script>