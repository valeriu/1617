<?php
//Meteo CSS Class
	function meteoclass($i) {
		$i = round(($i-32)*5/9);
		if ($i > 69){
			$meteoclass = "meteo-70";
		}
		else if($i > 59) {
			$meteoclass = "meteo-60";
		}
		else if($i > 49) {
			$meteoclass = "meteo-50";
		}
		else if($i > 39) {
			$meteoclass = "meteo-40";
		}
		else if($i > 29) {
			$meteoclass = "meteo-30";
		}
		else if($i > 19) {
			$meteoclass = "meteo-20";
		}
		else if($i > 9) {
			$meteoclass = "meteo-10";
		}
		else if($i > 0) {
			$meteoclass = "meteo-0";
		}								
		else if($i > -9) {
			$meteoclass = "meteo--10";
		}
		else if($i > -19) {
			$meteoclass = "meteo--20";
		}
		else if($i > -29) {
			$meteoclass = "meteo--30";
		}
		else if($i > -39) {
			$meteoclass = "meteo--40";
		}
		else if($i > -49) {
			$meteoclass = "meteo--50";
		}
		else if($i > -59) {
			$meteoclass = "meteo--60";
		}
		else if($i > -69) {
			$meteoclass = "meteo--70";
		}
		else {
			$meteoclass = "meteo";
		}
		return $meteoclass;	
	}
?>