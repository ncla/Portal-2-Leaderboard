<?php
	class database extends mysqli {
		public function __construct($host = 'localhost', $user = 'root', $pass = 'root', $db = 'leaderboards') {
        	parent::__construct($host, $user, $pass, $db);
        	if ($this->connect_errno) { // ummm, connect_errno vai mysql_errno?
				trigger_error($this->connect_error);
			}
			$this->set_charset('utf8'); 
		}
		public function query($query, $resultmode = MYSQLI_STORE_RESULT) {
			$bob = parent::query($query, $resultmode);
			if(!$bob) {
				trigger_error($this->error);
			}
			return $bob;
		}
	}
?>