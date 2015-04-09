<?php
/*                                      class.banner.php
.------------------------------------------------------.
|  Software: Kaiten - Banner Class                     |
|   Version: 3.0                                       |
|  Git Repo: https://bitbucket.org/integrian/chakra-3  |
|      Info: http://cms.chakra.hu                      |
|   Support: cms@chakra.hu                             |
'------------------------------------------------------'
                             © 2014 integrian industries
*/
class Banner {
	
   public $livesite;
   public $siteroot;
   private $sql;
	
	public function __construct($sql, $livesite, $siteroot) {
	   $this->sql = $sql;
      $this->livesite = $livesite;
      $this->siteroot = $siteroot;
	}
   
   // render data
   public function get($zone) {
      $banner_zone = $this->sql->query("SELECT * FROM banners WHERE zone='".$zone."' AND status='1' AND start_date<='".date('Y-m-d')."' AND end_date>='".date('Y-m-d')."' ORDER BY RAND() LIMIT 1")->fetchAll();
      $this->sql->update("banners", ["appearance[+]"=>1], ["id"=>$banner_zone[0]['id']] );
      return $banner_zone[0];
   }
   
   public function render($data, $as_slot='0') {
      
      // get zone dimension
      $zone = $this->sql->select("banners_zones", "*", ["id"=>$data['zone']]);
      
      if ($data['source']=='adsense') {
            $render = '<ins class="adsbygoogle"
              style="display:inline-block;width:'.$zone[0]['width'].'px;height:'.$zone[0]['height'].'px"
              data-ad-client="ca-pub-8333480890054621"
              data-ad-slot="'.$as_slot.'">
            </ins> 
            <script>
            // ADSENSE PUSH
            (adsbygoogle = window.adsbygoogle || []).push({});
            </script>';
         } else {
            if ($data['type']=='flash') {
               //http://getclicktag.com/get-clicktag-code/
               $render = '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/
               cabs/flash/swflash.cab#version=8,0,0,0" width="'.$zone[0]['width'].'" height="'.$zone[0]['height'].'">
               <param name="movie" value="'.$this->livesite.$data['file'].'?clickTAG=/banner/'.$data['unique_id'].'" />
               <param name="quality" value="high" />
               <embed src="'.$this->livesite.$data['file'].'?clickTAG=/banner/'.$data['unique_id'].'"
               quality="high" type="application/x-shockwave-flash"
               width="'.$zone[0]['width'].'" height="'.$zone[0]['height'].'"
               pluginspage="http://www.macromedia.com/go/getflashplayer" />
               </object>';
            } else if ($data['type']=='image') {
               $render = '<a href="'.$this->livesite.'/banner/'.$data['unique_id'].'" target="_blank"><img src="'.$this->livesite.$data['file'].'"/></a>';
            }
         }
      return $render;
   }
}
?>