<?php
	header('Content-Type: text/html; charset=utf-8'); 
	require_once "inc/variable.php";
	require_once "inc/library.php";
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Meteo - Yan et Valeriu</title>
	<link href="./css/styles.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript">
	window.addEventListener('load', function(){
		var selectPays = document.getElementById('paysList');
		var selectCity = document.getElementById('cityList');
		
		selectPays.addEventListener('change', function(){ window.location =  "meteo.php?pays=" + this.value;}, false);
		selectCity.addEventListener('change', function(){  window.location =  "meteo.php?pays=<?php if(isset($_GET["pays"])) echo $_GET["pays"];?>&city="+this.value;	}, false);
	}, false);
	</script>
	<!--[if IE]>
    	<script src="./js/lte-ie7.js"></script>
	<![endif]-->
</head>
<body>
<form action="#" method="GET">
<select name="pays" id="paysList">
	<option>Sélectionnez une pays</option>
	<?php
		for($i = 0, $j = count($pays); $i < $j; $i++)
		{
			if(isset($_GET["pays"]) && $pays[$i] == $_GET["pays"])
				echo "<option selected='selected'>" . $pays[$i] . "</option>";	
			else
				echo "<option>" . $pays[$i] . "</option>";
		}
	?>
</select>
	<?php
		if(isset($_GET["pays"])){
			//oras
			//$cityurl = "http://www.webservicex.net/globalweather.asmx/GetCitiesByCountry?CountryName=Moldova,%20Republic%20of";
			$cityurl = "http://www.webservicex.net/globalweather.asmx/GetCitiesByCountry?CountryName=".urlencode($_GET["pays"]);

	//cache start
			$cache_file_pays = "cache/pays-".urlencode($_GET["pays"]).".xml";
			$cache_life_pays = '86400'; //in seconds

			$filem_time = @filemtime($cache_file_pays); 

			if (!$filem_time or (time() - $filem_time >= $cache_life_pays)){
				if (!copy($cityurl, $cache_file_pays)) {
					echo "failed to copy $cache_file_pays...\n";
				} 
			}


			if (file_exists($cache_file_pays)) {
				// echo "The file $cache_file_pays exists";
				$cityurl = $cache_file_pays;
			} else {
				echo "The file $cache_file_pays does not exist";
			}
		//	echo  $cityurl;
	//cashe end


			$getcityurl = file_get_contents($cityurl);

			$City = preg_match_all('/City&gt;(.*)&lt;/', $getcityurl, $myCity, PREG_SET_ORDER);
				
			if(!$City)
				echo "<div class='error'>No data for ".$_GET["pays"]."</div>";
			else {	
				echo "<select id=\"cityList\" name=\"city\">";
				echo "<option>Sélectionnez une Ville</option>";
				foreach($myCity as $citybycountry) {
					if(isset($_GET["city"]) && $citybycountry[1] == $_GET["city"])
						echo "<option selected='selected'>" .$citybycountry[1]. "</option>";
					else	
						echo "<option>" .$citybycountry[1]. "</option>";
				}
				echo "</select></form>";
			
				// start
				if(isset($_GET["city"])){
					$meteourl = "http://www.webservicex.net/globalweather.asmx/GetWeather?CityName=".urlencode($_GET["city"])."&CountryName=".urlencode($_GET["pays"]);
				// start cache
					$cache_file_city = "cache/".urlencode($_GET["city"])."-".urlencode($_GET["pays"]).".xml";
					$cache_life_city = '600'; //in seconds

					$filem_time = @filemtime($cache_file_city); 

					if (!$filem_time or (time() - $filem_time >= $cache_life_city)){
						if (!copy($meteourl, $cache_file_city)) {
							echo "failed to copy $cache_file_city...\n";
						} 
					}

					if (file_exists($cache_file_city)) {
						// echo "The file $cache_file_city exists";
						$meteourl = $cache_file_city;
					} else {
						echo "The file $cache_file_city does not exist";
					}

				// end cache
					
					$getmeteourl = file_get_contents($meteourl);

						$Location = 		preg_match('/Location&gt;(.*)\(/', $getmeteourl, $myLocation);
						$Time = 			preg_match('/Time&gt;(.*)\/ /', $getmeteourl, $myTime);
						$Wind =	 			preg_match('/Wind&gt;(.*)&lt;/', $getmeteourl, $myWind);
						$Visibility = 		preg_match('/Visibility&gt;(.*)&lt;/', $getmeteourl, $myVisibility);
						$SkyConditions = 	preg_match('/SkyConditions&gt;(.*)&lt;/', $getmeteourl, $mySkyConditions);
						$Temperature = 		preg_match('/Temperature&gt;(.*)&lt;/', $getmeteourl, $myTemperature);
						$TemperatureC = 	preg_match('/Temperature&gt;(.*)F/', $getmeteourl, $myTemperatureC);
						$DewPoint = 		preg_match('/DewPoint&gt;(.*)&lt;/', $getmeteourl, $myDewPoint);
						$RelativeHumidity = preg_match('/RelativeHumidity&gt;(.*)&lt;/', $getmeteourl, $myRelativeHumidity);
						$Pressure = 		preg_match('/Pressure&gt;(.*)&lt;/', $getmeteourl, $myPressure);
						$Status = 			preg_match('/Status&gt;(.*)&lt;/', $getmeteourl, $myStatus);
							
				if (isset($myTemperatureC[1])) echo "<div class='meteo' id=".meteoclass($myTemperatureC[1]).">";
					if (isset($myStatus[1]) && $myStatus[1] == "Success") {
						//if (isset($myTemperatureC[1])) meteoclass($myTemperatureC[1]). "";
						if (isset($myLocation[1])) echo "<br><div class='location'>" . $myLocation[1] . "</div>";
						if (isset($myTemperature[1])) echo "<div class='temperature-icon'><div class='temperature fleft'>" . $myTemperature[1] . "</div>";
						echo "<div class='" . meteoclass($myTemperatureC[1]) . " icon fright'><span aria-hidden='true' id='skycondition' class='icon-" . skyclass($mySkyConditions[1]) . "'></span></div>";
						echo "<div class='clear'></div></div>";
						if (isset($myTime[1])) echo "<div class='time'><strong>Time :&nbsp;</strong>" . $myTime[1] . "</div>";
						if (isset($myWind[1])) echo "<div class='wind'><strong>Wind :&nbsp;</strong>" . $myWind[1] . "</div>";
						if (isset($myVisibility[1])) echo "<div class='visibility'><strong>Visibility :&nbsp;</strong>" . $myVisibility[1] . "</div>";
						if (isset($myDewPoint[1])) echo "<div class='dewpoint'><strong>DewPoint :&nbsp;</strong>" . $myDewPoint[1] . "</div>";
						if (isset($myRelativeHumidity[1])) echo "<div class='humidity'><strong>Relative Humidity :&nbsp;</strong>" . $myRelativeHumidity[1] . "</div>";
						if (isset($myPressure[1])) echo "<div class='pressure'><strong>Pressure :&nbsp;</strong>" . $myPressure[1] . "</div>";
					} else {
						echo "<div class='error'>No data for ".$_GET["city"]."</div>";
						}
				echo "</div>";
				}

			}
		}		
	?>
</body>
</html>