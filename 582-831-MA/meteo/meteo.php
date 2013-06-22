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
			echo  $cityurl;
	//cashe end


			$getcityurl = file_get_contents($cityurl);

			$City = preg_match_all('/City&gt;(.*)&lt;/', $getcityurl, $myCity, PREG_SET_ORDER);
				
			if(!$City)
				echo "pas de ville";
			else {	
				echo "<select id=\"cityList\" name=\"city\">";
				echo "<option>Sélectionnez une Ville</option>";
				foreach($myCity as $citybycountry) {
					if(isset($_GET["city"]) && $citybycountry[1] == $_GET["city"])
						echo "<option selected='selected'>" .$citybycountry[1]. "</option>";
					else	
						echo "<option>" .$citybycountry[1]. "</option>";
				}
				echo "</select>";
			
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

					echo  $meteourl;
				// end cache
					
					$getmeteourl = file_get_contents($meteourl);

						$Location = 		preg_match('/Location&gt;(.*)&lt;/', $getmeteourl, $myLocation);
						$Time = 			preg_match('/Time&gt;(.*)&lt;/', $getmeteourl, $myTime);
						$Wind =	 			preg_match('/Wind&gt;(.*)&lt;/', $getmeteourl, $myWind);
						$Visibility = 		preg_match('/Visibility&gt;(.*)&lt;/', $getmeteourl, $myVisibility);
						$SkyConditions = 	preg_match('/SkyConditions&gt;(.*)&lt;/', $getmeteourl, $mySkyConditions);
						$Temperature = 		preg_match('/Temperature&gt;(.*)&lt;/', $getmeteourl, $myTemperature);
						$TemperatureC = 	preg_match('/Temperature&gt;(.*)F/', $getmeteourl, $myTemperatureC);
						$DewPoint = 		preg_match('/DewPoint&gt;(.*)&lt;/', $getmeteourl, $myDewPoint);
						$RelativeHumidity = preg_match('/RelativeHumidity&gt;(.*)&lt;/', $getmeteourl, $myRelativeHumidity);
						$Pressure = 		preg_match('/Pressure&gt;(.*)&lt;/', $getmeteourl, $myPressure);
						$Status = 			preg_match('/Status&gt;(.*)&lt;/', $getmeteourl, $myStatus);
							
						echo meteoclass($myTemperatureC[1]);
				if (isset($myTemperatureC[1])) echo "<div class=".meteoclass($myTemperatureC[1]).">";
					if (isset($myStatus[1]) && $myStatus[1] == "Success") {
						//if (isset($myTemperatureC[1])) meteoclass($myTemperatureC[1]). "<br />";
						if (isset($myLocation[1])) echo "<br>Location : " . $myLocation[1] . "<br />";
						if (isset($myTime[1])) echo "Time : " . $myTime[1] . "<br />";
						if (isset($myWind[1])) echo "Wind : " . $myWind[1] . "<br />";
						if (isset($myVisibility[1])) echo "Visibility : " . $myVisibility[1] . "<br />";
						if (isset($mySkyConditions[1])) echo "SkyConditions : " . $mySkyConditions[1] . "<br />";
						if (isset($myTemperature[1])) echo "Temperature : " . $myTemperature[1] . "<br />";
						if (isset($myDewPoint[1])) echo "DewPoint : " . $myDewPoint[1] . "<br />";
						if (isset($myRelativeHumidity[1])) echo "RelativeHumidity : " . $myRelativeHumidity[1] . "<br />";
						if (isset($myPressure[1])) echo "Pressure : " . $myPressure[1] . "<br />";
					} else {
						echo "Nus data ".$_GET["city"];
						}
				echo "</div>";
				}

			}
		}		
	?>
</form>
</body>
</html>