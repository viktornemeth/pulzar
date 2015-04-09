<?php
/** class.email.php - Chakra Email class
** v 2.1 chidori
** 2013.06.19.
**
** ==============================================
** Using class.phpmailer.php class
**/

class Email {
	
	// PHP Mailer
	public $phpmailer;
	
	// From config (smtp)
	public $isAlive = true;
	public $livesite;
	public $sitename;
	public $site_email;
	public $site_email_noreply;
	public $smtp_host;
	public $smtp_debug;
	public $smtp_auth;
	public $smtp_port;
	public $smtp_username;
	public $smtp_password;
	public $smtp_charset;
	private $sql;
	
	
	public function __construct($livesite, $sitename, $site_email, $site_email_noreply, $smtp_host, $smtp_debug, $smtp_auth, $smtp_port, $smtp_username, $smtp_password, $smtp_charset, $sql) {
      $this->livesite           = $livesite;
	  $this->sitename           = $sitename;
	  $this->site_email         = $site_email;
	  $this->site_email_noreply = $site_email_noreply;
	  $this->smtp_host          = $smtp_host;
	  $this->smtp_debug         = $smtp_debug;
	  $this->smtp_auth          = $smtp_auth;
	  $this->smtp_port          = $smtp_port;
	  $this->smtp_username      = $smtp_username;
	  $this->smtp_password      = $smtp_password;
	  $this->smtp_charset       = $smtp_charset;
	  $this->sql                = $sql;
	}
	
	// Get email template and put the message into
	public function setMessage($template_id, $name, $email, $message, $unsubscribe){
		$template = file_get_contents($this->livesite.'/template/email-template-'.$template_id.'.html');
		$where = array("{EMAIL_name}", "{EMAIL_message}", "{EMAIL_unsubscribe}");
		$insert = array($name, $message, '<a href="'.$this->livesite.'/newsletter-unsubscribe/'.$email.'" style="font-size:10px;">'.$unsubscribe.'</a>');
		$fullMessage = str_replace($where, $insert, $template);
		return $fullMessage;
	}
    
    public function getMessage($url_id, $var1, $var2, $var3, $var4){
        $message = $this->sql->select("email_messages", ['*'], ['url_id'=>$url_id]);
        $where = array("{LIVESITE}", "{1}", "{2}", "{3}", "{4}");
        $insert = array($this->livesite, $var1, $var2, $var3, $var4);
        $fullMessage = str_replace($where, $insert, $message['message']);
		return $fullMessage;
    }
	
	// Email sender (after sent -> change result for next reload)
	public function send($to, $name, $subject, $message, $attachment) {
        $this->phpmailer = new phpmailer();
		$body = $message;
		$this->phpmailer->Issmtp(); 
		$this->phpmailer->Host 		= $this->smtp_host; 
		$this->phpmailer->Port 		= $this->smtp_port;
		$this->phpmailer->smtpAuth 	= $this->smtp_auth;
		$this->phpmailer->Username 	= $this->smtp_username;
		$this->phpmailer->Password 	= $this->smtp_password;
		$this->phpmailer->smtpDebug = $this->smtp_debug;
		$this->phpmailer->CharSet 	= $this->smtp_charset;
		$this->phpmailer->SetFrom($this->site_email, $this->sitename);
		$this->phpmailer->Subject 	= $subject;
		$this->phpmailer->MsgHTML($body);
		$this->phpmailer->AddAddress($to, $name);
		if ($attachment!='') { $this->phpmailer->addAttachment($attachment); }
		if(!$this->phpmailer->Send()) { 
			$_SESSION["res"] = "email_error";
		}
		else { 
			$_SESSION["res"] = "email_sent";
		}
    }
}