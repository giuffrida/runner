<?php
require_once "functions.php";

class run extends Database{
	
	protected $userid = "";
	protected $runid = "";
	protected $date = "";
	protected $duration = "";
	protected $distance = "";
	protected $shoes = "";
	protected $diary = "";
	protected $device = "";
	protected $swimnote = "";
	protected $bikenote = "";
	protected $race = "";
	protected $pb = "";
	
	//runObj creates object run from runid
	public static function runObj($runid){
		$pdo = parent::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT userid, runid, DATE_FORMAT(startime,'%e-%c-%y') as date, duration, distance, shoes, diary, device, swimnote, bikenote FROM runs where runid = ?";
		$q = $pdo->prepare($sql);
		$q->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'run');
		$q->execute(array($runid));
		$row = $q->fetch();
		return $row;
		parent::disconnect();
	}

	//runObj creates objects last 10 runs for one user 
	public static function tenrunObj($userid){
		$pdo = parent::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT userid, runid, DATE_FORMAT(startime,'%e/%c/%y') as date, duration, distance, shoes, diary, device, swimnote, bikenote FROM runs WHERE userid = ? ORDER BY startime DESC LIMIT 10";
		$q = $pdo->prepare($sql);
		$q->execute(array($userid));
		$tenruns = $q->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'run');
		parent::disconnect();
		return $tenruns;
	}
	
//siderun creates objects last 20 runs for all users
	public static function sideRun(){
		$pdo = parent::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT userid, runid, DATE_FORMAT(startime,'%e/%c/%y') as date, duration, distance, shoes, diary, device, swimnote, bikenote FROM runs ORDER BY startime DESC LIMIT 20";
		$q = $pdo->prepare($sql);
		$q->execute();
		$sideruns = $q->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'run');
		parent::disconnect();
		return $sideruns;
	}	
	
	//graphRuns creates objects of graph runs
	public static function graphRuns($userid, $startdate, $enddate){
		$pdo = parent::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT userid, runid, DATE_FORMAT(startime,'%e/%c/%y') as date, duration, distance, shoes, diary, device 
				FROM runs 
				WHERE userid = ? 
				AND
				(startime BETWEEN ? AND ?)";
		$q = $pdo->prepare($sql);
		$q->execute(array($userid, $startdate, $enddate));
		$graphruns = $q->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'run');
		parent::disconnect();
		return $graphruns;
	}
	
	//allRunsObj creates objects all runs
	public static function allRunsObj($userid){
		$pdo = parent::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT userid, runid, DATE_FORMAT(startime,'%e/%c/%y') as date, duration, distance, shoes, diary, device, swimnote, bikenote FROM runs WHERE userid = ? ORDER BY startime DESC";
		$q = $pdo->prepare($sql);
		$q->execute(array($userid));
		$allruns = $q->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'run');
		parent::disconnect();
		return $allruns;
	}

	//runnerMonth retuns array of month runs in calendar
	public static function runnerMonth($userid, $curmonth, $curyear){
		$pdo = parent::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT DAY( startime ) AS GIORNO, SUM( distance ) AS KM 
					FROM runs 
					WHERE MONTH( startime ) = ?
					AND 
					YEAR( startime ) = ? 
					AND 
					userid = ? 
					AND 
					((shoes != '-- Piscina --'
					AND
					shoes != '-- Bicicletta --')
					OR 
					shoes IS NULL) 
					GROUP BY DAY( startime )  
					ORDER BY DAY( startime ) ";
		$q = $pdo->prepare($sql);
		$q->execute(array($curmonth, $curyear, $userid));
		$tot = $q->fetchall(PDO::FETCH_ASSOC);
		return $tot;
     	parent::disconnect();
	}

	//insert run
	public static function runInsert($userid, $runid, $startime, $duration, $distance, $device){
		$pdo = parent::connect();
		$sql = "INSERT INTO runs (userid, runid, startime, duration, distance, device) VALUES (?, ?, ?, ?, ?, ?)";
		$q = $pdo->prepare($sql);
		$q->execute(array($userid, $runid, $startime, $duration, $distance, $device));
		parent::disconnect();
	}

	//delete run
	public static function runDelete($runid){
		$pdo = parent::connect();
		$sql = "DELETE from runs WHERE runid = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($runid));
		parent::disconnect();
	}

	//update run
	public static function runUpdate($diary, $shoes, $runid){
		$pdo = parent::connect();
		$sql = "UPDATE runs SET diary=?, shoes=? WHERE runid=?";
		$q = $pdo->prepare($sql);
		$q->execute(array($diary, $shoes, $runid));
		parent::disconnect();
	}

	//Delete old wrong runs
	public static function delOld(){
			$pdo = parent::connect();
			$sql = "DELETE FROM runs WHERE startime < '2000-01-01'";
			$q = $pdo->prepare($sql);
			$q->execute();
			parent::disconnect();			
	}

	//graphWeek array runs of week for charts
	public static function graphWeek($userid){
		$pdo = parent::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT concat_ws('-',YEAR(startime),
				WEEK(startime,1)) as datasett, 
				SUM(distance) AS sommasett 
				FROM runs 
				WHERE userid = ? 
				and `startime` >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH) 
				GROUP BY WEEK(startime,1) ORDER BY startime";
		$q = $pdo->prepare($sql);
		$q->execute(array($userid));
		$tot = $q->fetchall(PDO::FETCH_ASSOC);
		return $tot;
     	parent::disconnect();
	}
	
	//graphMonth array runs of month for charts
	public static function graphMonth($userid){
		$pdo = parent::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT concat_ws('-', YEAR( startime ) , MONTHNAME( startime)) as datamese , SUM( distance ) as sommamese
				FROM runs
				WHERE userid = ?
				AND  `startime` >= DATE_SUB( CURDATE( ) , INTERVAL 12 
				MONTH ) 
				GROUP BY YEAR( startime ) , MONTH( startime )";
		$q = $pdo->prepare($sql);
		$q->execute(array($userid));
		$tot = $q->fetchall(PDO::FETCH_ASSOC);
		return $tot;
     	parent::disconnect();
	}
	
	//graphYear array runs of year for charts
	public static function graphYear($userid){
		$pdo = parent::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT YEAR(startime) as dataanno, SUM(distance) as sommaanno
				FROM runs
				WHERE userid = ?
				GROUP BY YEAR( startime )";
		$q = $pdo->prepare($sql);
		$q->execute(array($userid));
		$tot = $q->fetchall(PDO::FETCH_ASSOC);
		return $tot;
     	parent::disconnect();
	}	
	

	//getRunid
	public function getRunid() {
		return $this->runid;
	}
   
	//getUserid
	public function getUserid() {
		return $this->userid;
	}   
   
  	//getStarttime
	public function getStartime() {
		return $this->date;
	}
    //getDistance
	public function getDistance() {
		return $this->distance;
	}

    //getDistance
	public function getDate() {
		return $this->date;
	}
	
    //getAverage
	public function getAverage() {
		return sec2msp(round(($this->duration/$this->distance)/1000));
	}	
	//getDuration
	public function getDuration() {
		return $this->duration;
	}
	
    //getDiary
	public function getDiary() {
		return $this->diary;
   }
	//getShoes
	public function getShoes() {
		return $this->shoes;
   }
   	//getDevice
	public function getDevice() {
		return $this->device;
   }
}
?>
