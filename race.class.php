<?
require_once "dbcon.class.php";
class race extends Database{

		protected $raceid = "";
		protected $userid = "";
		protected $racedate = "";
		protected $type = "";
		protected $event = "";
		protected $timing = "";
		protected $pb = "";

	//insert race
	public static function raceInsert($userid, $date, $type, $event, $timing){
		$pdo = parent::connect();
		$sql = "INSERT INTO races (userid, date, type, name, timing) VALUES (?, ?, ?, ?, ?)";
		$q = $pdo->prepare($sql);
		$q->execute(array($userid, $date, $type, $event, $timing));
		parent::disconnect();
	}

	//delete race
	public static function raceDelete($raceid){
		$pdo = parent::connect();
		$sql = "DELETE from races WHERE raceid = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($raceid));
		parent::disconnect();
	}

	//allRaces creates objects all races
	public static function allRaces($userid){
		$pdo = parent::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT raceid, userid, DATE_FORMAT(date,'%e/%c/%y') as racedate, type , name, timing, pb FROM races WHERE userid = ? ORDER BY date DESC";
		$q = $pdo->prepare($sql);
		$q->execute(array($userid));
		$allraces = $q->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'race');
		parent::disconnect();
		return $allraces;
	}

	//getRaceid
	public function getRaceid() {
		return $this->raceid;
	}

	//getUserid
	public function getUserid() {
		return $this->userid;
	}

	//getDate
	public function getDate() {
		return $this->racedate;
	}

	//getType
	public function getType() {
		return $this->type;
	}

	//getName
	public function getName() {
		return $this->name;
	}

	//getTiming
	public function getTiming() {
		return $this->timing;
	}

	//getPb
	public function getPb() {
		return $this->pb;
	}
}
?>
