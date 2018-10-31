<?php
/*
		stdClass Object
		(
			[unique_id] => 1160658
			[team-2] => England
			[team-1] => Sri Lanka Board XI
			[type] => 
			[date] => 2018-10-30T00:00:00.000Z
			[dateTimeGMT] => 2018-10-30T04:30:00.000Z
			[squad] => 1
			[toss_winner_team] => Sri Lanka Board XI
			[matchStarted] => 1
		)
*/


	function objectToArray($d) {
		if (is_object($d)) {
		    // Gets the properties of the given object
		    // with get_object_vars function
		    $d = get_object_vars($d);
		}
	
		if (is_array($d)) {
		    /*
		    * Return array converted to object
		    * Using __FUNCTION__ (Magic constant)
		    * for recursive call
		    */
		    return array_map(__FUNCTION__, $d);
		}
		else {
		    // Return array
		    return $d;
		}
	}
	
	$req = file_get_contents('http://cricapi.com/api/matches/?apikey=MKkBDwArfUOUSdtdUt8gXE51Qp22');
	$result = json_decode($req);
	$matches = $result->matches;
	
	echo "	[ Current ]\n";
	foreach($matches as $i){
		if($i->matchStarted == 1){
			$id = $i->unique_id;
			$i = objectToArray($i);		
			$score_url = "http://cricapi.com/api/cricketScore/?unique_id=$id&apikey=MKkBDwArfUOUSdtdUt8gXE51Qp22";
			$score_req = file_get_contents($score_url);
 			$score = json_decode($score_req);
 			
 			echo 
			"
			Match: ".$i["team-1"]." vs ".$i["team-2"]."
			Score: $score->score
			Type: $i[type]
";

		}
	}
	
	echo "
	Upcoming Matches	
	[ India ]\n";
	echo "____________________________________________________________________________\n";
	foreach($matches as $i){
	$i = objectToArray($i);
	
		if($i["team-1"] == "India" || $i["team-2"] == "India"){
 			echo 
"|                                                                                               
|			[$i[type]] 			".$i["team-1"]." vs ".$i["team-2"]."
|			Date:".date_format(date_create($i["date"]), "d-m-Y")."
|___________________________________________________________________________
";

		}
	}
	echo "\n";
?>
