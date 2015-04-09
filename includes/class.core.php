<?php
/*                                        class.core.php
.------------------------------------------------------.
|  Software: Kaiten - Core Class                       |
|   Version: 3.0                                       |
|  Git Repo: https://bitbucket.org/integrian/chakra-3  |
|      Info: http://cms.chakra.hu                      |
|   Support: cms@chakra.hu                             |
'------------------------------------------------------'
                             © 2014 integrian industries
*/
class Core {
	
    public $livesite;
    public $siteroot;
    public $module;
    public $id;
    public $cmd;  
    private $sql;
    private $is_admin;
	
	public function __construct($sql, $livesite, $siteroot, $module, $id, $cmd, $is_admin) {
	   $this->sql = $sql;
      $this->livesite = $livesite;
      $this->siteroot = $siteroot;
      $this->module = $module;
      $this->id = $id;
      $this->cmd = $cmd;
      $this->is_admin = $is_admin;
	}
   
	//Lock Site or Admin
	public function lock($access) {
        if ($this->is_admin == true) {
            $location = $this->livesite."/admin/login";
        } else {
            $location = $this->livesite."/login";
        }
                
		if(!isset($_SESSION["myuid"])){
            header("Location:".$location); 
            exit();
        } else{
			$user_access 		= $_SESSION["myaccess"];
			$accepted_access 	= explode("#", $user_access);
			$page_access 		= explode("#", $access);
			$matches 			= array_intersect($accepted_access, $page_access);
			$acc 				   = count($matches);
			if ($acc != 0) {
				// ok, access granted
			}
			else {
				// access denied
            if ($this->is_admin == true) {
               header("Location:".$this->livesite."/admin/error/403");
            } else {
				   header("Location:".$this->livesite."/error/403");
            }
				exit();
			}
		}
	}

   public function serializedToArray($serialized) {
      $array = array();
      foreach ($serialized as $value) { 
        $array[$value['name']] = $value['value'];
      }
      return $array;
   }

	// Generate AJAX security hash keys
	public function setAjaxSecure($chakraKey) {
		$nonce = hash("sha256", crypt(microtime(true))); 
		$hash = hash("sha256", $nonce . $chakraKey); 
		$setAjaxSecure = $hash."#".$nonce;
		return $setAjaxSecure;
	}
	
	// Check AJAX security hash keys
	public function checkAjaxSecure($chakraKey) {
		$secure = $_REQUEST["secure"];
		$hash_nonce = explode("#", $secure);
		$hash = $hash_nonce[0];
		$nonce = $hash_nonce[1];
		$check_hash = hash("sha256", $nonce . $chakraKey); 
		if($hash === $check_hash) {
			// Hash accept, run the script
		} else { 
			// Hash not accept, die!
			echo "ACCESS DENIED";
			exit();
		}  
	}
	
}
?>