<?
require_once "dbcon.class.php";
class shoe extends Database{

		protected $shoeid = "";
		protected $shoe = "";
		
	//insert shoe
	public static function shoeInsert($shoe){
		$pdo = parent::connect();
		$sql = "INSERT INTO shoes (shoe) VALUES (?)";
		$q = $pdo->prepare($sql);
		$q->execute(array($shoe));
		parent::disconnect();
	}

}

?>
