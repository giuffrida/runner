<?
require_once "dbcon.class.php";
class runner extends Database{

		protected $userid = "";
		protected $nick = "";
		protected $wpid = "";
		protected $nikeeml = "";
		protected $nikepwd = "";
		protected $profile = "";
		protected $pb5k = "";
		protected $pb5kevent = "";
		protected $pb10k = "";
		protected $pb10kevent = "";
		protected $pbhalf = "";
		protected $pbhalfevent = "";
		protected $pbmarathon = "";
		protected $pbmarathonevent = "";
		protected $graphstartdate = "";
		protected $graphenddate = "";
		

	//usrObj creates object runner from nick
	public static function runnerObj($nick){
		$pdo = parent::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM users where nick = ?";
		$q = $pdo->prepare($sql);
		$q->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'runner');
		$q->execute(array($nick));
		$row = $q->fetch();
		return $row;
		parent::disconnect();
	}
	
	//usrObjUserid creates object runner from userid
	public static function usrObjUserid($userid){
		$pdo = parent::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM users where userid = ?";
		$q = $pdo->prepare($sql);
		$q->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'runner');
		$q->execute(array($userid));
		$row = $q->fetch();
		return $row;
		parent::disconnect();
	}
	
	//runnerObjList creates objects all users
	public function runnerObjList(){
		$pdo = parent::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM users ORDER BY nick";
		$q = $pdo->prepare($sql);
		$q->execute();
		$allusers = $q->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'runner');
		parent::disconnect();
		return $allusers;
	}
	
		//runnerTot returns an array with total runs and total km
		public static function runnerTot($userid){
			$pdo = parent::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "SELECT sum(distance) as somma, count(distance) as conto from runs WHERE userid = ? AND ((shoes != '-- Piscina --' AND shoes != '-- Bicicletta --') OR shoes IS NULL)";
			$q = $pdo->prepare($sql);
			$q->execute(array($userid));
			$tot = $q->fetch(PDO::FETCH_ASSOC);
			return $tot;
		 	parent::disconnect();
		}
	
		//runnerShoes array whith shoes in use
		public static function runnerShoes($userid){
			$pdo = parent::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "SELECT DISTINCT (shoe) FROM shoesnew WHERE userid = ? ORDER BY shoe";
			$q = $pdo->prepare($sql);
			$q->execute(array($userid));
			$shoes = $q->fetchall(PDO::FETCH_ASSOC);
			return $shoes;
		 	parent::disconnect();
		}
	
		//runnerShoesSum array whith shoes in use
		public static function runnerShoesSum($userid){
			$pdo = parent::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "SELECT sum(distance) as value, 
								shoes 
								FROM runs 
								WHERE userid = ? 
								AND shoes IS NOT NULL 
								AND length(shoes) > 0
								AND shoes != '-- Bicicletta --'
								AND shoes != '-- Piscina --'
								AND shoes NOT IN (SELECT shoe from shoesold WHERE userid = ?)
								GROUP BY shoes ORDER BY value desc";
			$q = $pdo->prepare($sql);
			$q->execute(array($userid, $userid));
			$shoes = $q->fetchall(PDO::FETCH_ASSOC);
			return $shoes;
		 	parent::disconnect();
		}

		//runnerShoesOldSum array whith old shoes
		public static function runnerShoesOldSum($userid){
			$pdo = parent::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "SELECT sum(distance) as value, 
								shoes 
								FROM runs 
								WHERE userid = ? 
								AND shoes IS NOT NULL 
								AND length(shoes) > 0
								AND shoes IN (SELECT shoes from shoesold WHERE userid = ?)
								GROUP BY shoes ORDER BY value desc";
			$q = $pdo->prepare($sql);
			$q->execute(array($userid, $userid));
			$shoes = $q->fetchall(PDO::FETCH_ASSOC);
			return $shoes;
		  	parent::disconnect();
		}

	//shoesList array whith all shoes
		public static function shoesList($userid){
		$pdo = parent::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT shoe from shoes WHERE shoe NOT IN (SELECT shoe from shoesnew WHERE userid = ?)order by shoe";
		$q = $pdo->prepare($sql);
		$q->execute(array($userid));
		$shoes = $q->fetchall(PDO::FETCH_ASSOC);
		return $shoes;
     	parent::disconnect();
	}

	//shoesList array whith using shoes
		public static function shoesUserList($userid){
			$pdo = parent::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "SELECT shoe from shoesnew WHERE userid = ? order by shoe";
			$q = $pdo->prepare($sql);
			$q->execute(array($userid));
			$shoes = $q->fetchall(PDO::FETCH_ASSOC);
			return $shoes;
		  	parent::disconnect();
		}

	//shoesOldUserList array whith old shoes
		public static function shoesOldUserList($userid){
			$pdo = parent::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "SELECT shoe from shoesold WHERE userid = ?  AND shoe != '-- Bicicletta --' AND shoe != '-- Piscina --' order by shoe";
			$q = $pdo->prepare($sql);
			$q->execute(array($userid));
			$shoes = $q->fetchall(PDO::FETCH_ASSOC);
			return $shoes;
		  	parent::disconnect();
		}

	//pwdUpdate nike pwd
	public static function pwdUpdate($nikeeml, $nikepwd, $userid){
		$pdo = parent::connect();
		$sql = "UPDATE users SET nikeeml=?, nikepwd=? WHERE userid=?";
		$q = $pdo->prepare($sql);
		$q->execute(array($nikeeml, $nikepwd, $userid));
		parent::disconnect();
	}
	
	//nikeReset nike pwd
	public static function nikeReset($userid){
		$pdo = parent::connect();
		$sql = "UPDATE users SET nikeeml=NULL, nikepwd=NULL WHERE userid=?";
		$q = $pdo->prepare($sql);
		$q->execute(array($userid));
		parent::disconnect();
	}

	//addShoe
	public static function addShoe($shoe, $userid){
		$pdo = parent::connect();
		$sql = "INSERT INTO shoesnew (shoe, userid) VALUES (?, ?)";
		$q = $pdo->prepare($sql);
		$q->execute(array($shoe, $userid));
		parent::disconnect();
	}

	//removeShoe
	public static function removeShoe($shoe, $userid){
		$pdo = parent::connect();
		$sql = "INSERT INTO shoesold (shoe, userid) VALUES (?, ?)";
		$q = $pdo->prepare($sql);
		$q->execute(array($shoe, $userid));
		$sqltwo = "DELETE FROM shoesnew WHERE shoe = ? AND userid = ?";
		$qtwo = $pdo->prepare($sqltwo);
		$qtwo->execute(array($shoe, $userid));
		parent::disconnect();
	}

	//readdShoe
	public static function readdShoe($shoe, $userid){
		$pdo = parent::connect();
		$sql = "INSERT INTO shoesnew (shoe, userid) VALUES (?, ?)";
		$q = $pdo->prepare($sql);
		$q->execute(array($shoe, $userid));
		$sqltwo = "DELETE FROM shoesold WHERE shoe = ? AND userid = ?";
		$qtwo = $pdo->prepare($sqltwo);
		$qtwo->execute(array($shoe, $userid));
		parent::disconnect();
	}

	//getUserid
	public function getUserid() {
     return $this->userid;
   }

  	//getNick
	public function getNick() {
     return $this->nick;
   }
   
	//getEml
	public function getEml() {
     return $this->nikeeml;
   }
	//getAut
	public function getAut() {
     return $this->nikepwd;
   }
   	//getGraph
	public function getGraph() {
     return $this->graphlevel;
   }
	//getProfile
	public function getProfile() {
     return $this->profile;
   }
   
   	//profileUpdate
	public static function profileUpdate($profile, $userid){
		$pdo = parent::connect();
		$sql = "UPDATE users SET profile=? WHERE userid=?";
		$q = $pdo->prepare($sql);
		$q->execute(array($profile, $userid));
		parent::disconnect();
	}

	//getPb5k
	public function getPb5k() {
     return $this->pb5k;
   }
   
	//getPb5kevent
	public function getPb5kevent() {
     return $this->pb5kevent;
   } 

   	//pb5kUpdate
	public static function pb5kUpdate($pb5k, $event, $userid){
		$pdo = parent::connect();
		$sql = "UPDATE users SET pb5k=?, pb5kevent=? WHERE userid=?";
		$q = $pdo->prepare($sql);
		$q->execute(array($pb5k, $event, $userid));
		parent::disconnect();
	}
	//getPb10k
	public function getPb10k() {
     return $this->pb10k;
   }
   
	//getPb10kevent
	public function getPb10kevent() {
     return $this->pb10kevent;
   }   
   
   	//pb10kUpdate
	public static function pb10kUpdate($pb10k, $event, $userid){
		$pdo = parent::connect();
		$sql = "UPDATE users SET pb10k=?, pb10kevent=? WHERE userid=?";
		$q = $pdo->prepare($sql);
		$q->execute(array($pb10k, $event, $userid));
		parent::disconnect();
	}
   
   	//getPbhalf
	public function getPbhalf() {
     return $this->pbhalf;
   }
   
    //getPbhalfevent
	public function getPbhalfevent() {
     return $this->pbhalfevent;
   }
   
   //pbhalfUpdate
	public static function pbhalfUpdate($pbhalf, $event, $userid){
		$pdo = parent::connect();
		$sql = "UPDATE users SET pbhalf=?, pbhalfevent=? WHERE userid=?";
		$q = $pdo->prepare($sql);
		$q->execute(array($pbhalf, $event, $userid));
		parent::disconnect();
	}
   
   	//getPbmarathon
	public function getPbmarathon() {
     return $this->pbmarathon;
   }
   
    //getPbmarathonEvent
	public function getPbmarathonevent() {
     return $this->pbmarathonevent;
   }
   
    //pbmarathonUpdate
	public static function pbmarathonUpdate($pbmarathon, $event, $userid){
		$pdo = parent::connect();
		$sql = "UPDATE users SET pbmarathon=?, pbmarathonevent=? WHERE userid=?";
		$q = $pdo->prepare($sql);
		$q->execute(array($pbmarathon, $event, $userid));
		parent::disconnect();
	}

	
	//getWpid
	public function getWpid() {
     return $this->wpid;
   }
   
   	//getGraphStartDate
	public function getGraphStartDate() {
     return $this->graphstartdate;
   }
   
   //setGraphStartDate
	public function setGraphStartDate($startdate, $userid) {
     $pdo = parent::connect($startdate, $userid);
		$sql = "UPDATE users SET graphstartdate=? WHERE userid=?";
		$q = $pdo->prepare($sql);
		$q->execute(array($startdate, $userid));
		parent::disconnect();
   }
   
    //getGraphEndDate
	public function getGraphEndDate() {
     return $this->graphenddate;
   }

   //setGraphEndDate
	public function setGraphEndDate($enddate, $userid) {
     $pdo = parent::connect($enddate, $userid);
		$sql = "UPDATE users SET graphenddate=? WHERE userid=?";
		$q = $pdo->prepare($sql);
		$q->execute(array($enddate, $userid));
		parent::disconnect();
   }

   	//insert runner
	public static function runnerInsert($userid, $nick, $userid){
		$pdo = parent::connect();
		$sql = "INSERT INTO users (userid, nick, wpid) VALUES (?, ?, ?)";
		$q = $pdo->prepare($sql);
		$q->execute(array($userid, $nick, $userid));
		parent::disconnect();
	}
}
?>
