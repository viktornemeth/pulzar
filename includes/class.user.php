<?php
/*                                        class.user.php
.------------------------------------------------------.
|  Software: Kaiten - User Class                       |
|   Version: 3.0                                       |
|  Git Repo: https://bitbucket.org/integrian/chakra-3  |
|      Info: http://cms.chakra.hu                      |
|   Support: cms@chakra.hu                             |
'------------------------------------------------------'
                             © 2014 integrian industries
*/

class User {
	
    private $sql;
    public $livesite;
	
	public function __construct($sql, $livesite) {
	  $this->sql = $sql;
      $this->livesite = $livesite;
	}
	
	// Get My
	function getMy ($what) {
		$result = $this->sql->select("users", [$what], ['id'=>$_SESSION['my_uid']]);
		return $result[0][$what];
	}
   
   // Get My Age
	function getMyAge () {
		$result = $this->sql->select("users", "birthday", ['id'=>$_SESSION['my_uid']]);
      $from = new DateTime($result[0]);
      $to   = new DateTime('today');
      return $from->diff($to)->y;
	}
    
    // Get Who
	function getWho ($what, $who) {
        $result = $this->sql->select("users", [$what], ['id'=>$who]);
		return $result[0][$what];
	}
}
?>