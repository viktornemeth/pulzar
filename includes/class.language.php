<?php
	class Language {
	
      public $siteroot;
      public $language_dir;
      public $default_language;
    	public $module;
      public $is_admin;
      
    	public function __construct($siteroot, $language_dir, $default_language, $module, $is_admin) {
          $this->siteroot = $siteroot;
          $this->language_dir = $language_dir;
          $this->default_language = $default_language;
          $this->module = $module;
          $this->is_admin = $is_admin;
    	}
        /*
         * Method to detect the locale browser automatically
         *
         * Return locale e.g es, en, de ...
         */
		public function detectLanguage() {
			if ($_SERVER['HTTP_ACCEPT_LANGUAGE']) {
				$this->languages = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
				$this->language = substr($this->languages,0,2);
				return $this->language;
			}
			else if ($_SERVER['HTTP_USER_AGENT']) {
                $this->user_agent = explode(";" , $_SERVER['HTTP_USER_AGENT']);

				for ($i=0; $i < sizeof($this->user_agent); $i++) {
					$this->languages = explode("-",$this->user_agent[$i]);
					if (sizeof($this->languages) == 2) {
						if (strlen(trim($this->languages[0])) == 2) {
							$size = sizeof($this->language);
							$this->language[$size]=trim($this->languages[0]);
						}
					}
				}
				return $this->language[0];
			}
			else {
				$this->language = $this->default_language;
				return $this->language;
			}
		}
		/*
		 * Method to detect if a language file exists in the Language directory
		 *
		 * Return bool TRUE if exist, FALSE if not.
		 */
		public function checkLanguage($language = null) {
			$language = $this->language_dir."/".$language."/".$language.".php";
			if (file_exists($language))
				return TRUE;
			else
				return FALSE;
		}
		/*
		 * Method to set language
		 */
		public function setLanguage($language = null){
			if ($language)
				$_SESSION['language'] = $language;

			if (@!$_SESSION['language'])
				$_SESSION['language'] = $this->default_language;
				//$_SESSION['language'] = $this->detectLanguage();

            if ($this->checkLanguage($_SESSION['language'])) {
            	$lang =  $_SESSION['language'];
            	return $lang;
            }
            else {
            	return  $this->default_language;
            }
		}
        /*
         * Method to get a language
         */
		public function getLanguage($language = null) {
         $actual_lang = $this->setLanguage($language);
			include_once $this->language_dir."/".$actual_lang."/".$actual_lang.".php";
         // check call from
         if ($this->is_admin == true) { $admin_dir = '/admin'; } else { $admin_dir = ''; } 
         $module_lang_file = $this->siteroot.$admin_dir."/modules/".$this->module."/languages/".$actual_lang."/".$actual_lang.".php";
         include_once $module_lang_file;
         if (file_exists($module_lang_file)) {
            $lang['module'] = $module_lang;
         }
			return $language = $lang;
		}			
	}
?>
