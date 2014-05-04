<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	class GamelogUser
	{		
		public function __construct( $gamelogID, $nickname)
		{
			$this->set_gamelogID($gamelogID);
			$this->set_nick($nickname);
		}
		
		public function get_gamelogID() { return $this->gamelogID; }
		public function set_gamelogID($value) {$this->gamelogID = $value; }
		
		public function get_nick() { return $this->nick; }
		public function set_nick($value) { $this->nick = $value; }
		
		public function __toString()
		{
			return "<p>" . get_class($this) ." UserID: {$this->gamelogID} Nick: {$this->nick} </p>";
		}
		
		private $gamelogID;
		private $nick;
	}	
?>
