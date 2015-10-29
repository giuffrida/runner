<?php
require_once "../../include/config.php";
class Database{
	private static $cont  = null; 
    //connect 
    public static function connect(){
       // One connection through whole application
		if ( null == self::$cont ){     
			try{
			  self::$cont =  new PDO( "mysql:host=".dbHost.";"."dbname=".dbName, dbUsername, dbUserPassword); 
			}
			catch(PDOException $e){
			  die($e->getMessage()); 
			}
		}
       return self::$cont;
    }
    //disconnect 
    public static function disconnect(){
        self::$cont = null;
    }
}
?>

