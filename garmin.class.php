<?php
class garmin{
	protected $graphavg = "";
	protected $graphlaps = "";
	protected $graphbpm = "";

	public static function createRawGraph($runid){
		$tcx = simplexml_load_file("http://connect.garmin.com/proxy/activity-service-1.1/tcx/activity/$runid?full=true");
	
		foreach ($tcx->Activities->Activity->Lap as $laps0){
			foreach($laps0->Track->Trackpoint as $dist){
				//DistanceMeters
				$distarray []= (string)$dist->DistanceMeters;
				//Time
				$timearray []= strtotime((string)$dist->Time);
			}
		}
	
		for ($i=1;$i<count($timearray);$i++){
			$timediff[] = ($timearray[$i]-$timearray[$i-1]);
			$distdiff[] = round(($distarray[$i]-$distarray[$i-1]), 2);
		}
	
		for ($i=0;$i<count($distdiff);$i++){
			$mediamkm[] = sec2msp(($timediff[$i]*1000)/$distdiff[$i]);
		}

		//min & max
		//$min = min($mediamkm);
		//$max = max($mediamkm);

		for ($idx = 0; $idx < count($distarray)-1; $idx++){
			$graphavg .= "[" . round($distarray[$idx]/1000, 2) . ", " . $mediamkm[$idx] . "], ";
		}
		return $graphavg;
	}
	
	public static function createBpmGraph($runid){
		$tcx = simplexml_load_file("http://connect.garmin.com/proxy/activity-service-1.1/tcx/activity/$runid?full=true");
		foreach ($tcx->Activities->Activity->Lap as $laps0){
			foreach($laps0->Track->Trackpoint as $dist){
				//DistanceMeters
				$distarray []= (string)$dist->DistanceMeters;
				//bpm
				$arraybpm []= (string)$dist->HeartRateBpm->Value;
			}
		}
		if(array_sum($arraybpm) > 60){
			$graphbpm = "";
			for ($idx = 0; $idx < count($distarray)-1; $idx++){
				$graphbpm .= "[" . round($distarray[$idx]/1000, 2) . ", " . $arraybpm[$idx] . "], ";
			}
			return $graphbpm;
		}
	}
	
	public static function createLapsGraph($runid){
		$tcx = simplexml_load_file("http://connect.garmin.com/proxy/activity-service-1.1/tcx/activity/$runid?full=true");
		foreach ($tcx->Activities->Activity->Lap as $laps0){
			//laps
			$times0 []= (string)$laps0->TotalTimeSeconds;
			$laps1 [] = ((string)$laps0->DistanceMeters)/1000;
		}
		$lapscount = count($times0);
		$laps = array();
		$times = array();
		$laps [0]= $laps1[0];
		for ($idx = 1; $idx < $lapscount; $idx++){
			$laps[] = $laps1[$idx]+$laps[$idx-1];
		}
		for ($idx = 0; $idx < $lapscount; $idx++){
			$times[] = sec2msp($times0[$idx]/$laps1[$idx]);
		}
		
		$graphlaps = "";
		for ($idx = 0; $idx < $lapscount; $idx++){
			$graphlaps .= "[" . $laps[$idx] . ", " . $times[$idx] . "], ";
		}
		return($graphlaps);
	}
}	
?>
