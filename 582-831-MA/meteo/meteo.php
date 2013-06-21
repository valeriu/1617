<?php
	header('Content-Type: text/html; charset=utf-8'); 
	require_once "inc/variable.php";
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Meteo - Yan et Valeriu</title>
	<script type="text/javascript" src="./js/lib.js"></script>
	<script type="text/javascript">
	window.addEventListener('load', function(){
		var selectPays = document.getElementById('paysList');
		var selectCity = document.getElementById('cityList');
		
		selectPays.addEventListener('change', function(){ window.location =  "meteo.php?pays=" + this.value;}, false);
		selectCity.addEventListener('change', function(){ window.location =  "meteo.php?pays=<?php echo $_GET["pays"];?>&city="+this.value;	}, false);
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
echo "</select>";

		if(isset($_GET["pays"])){
			//oras
			//$cityurl = "http://www.webservicex.net/globalweather.asmx/GetCitiesByCountry?CountryName=Moldova,%20Republic%20of";
			$cityurl = "http://www.webservicex.net/globalweather.asmx/GetCitiesByCountry?CountryName=".urlencode($_GET["pays"]);
			$getcityurl = file_get_contents($cityurl);

			$City = preg_match_all('/City&gt;(.*)&lt;/', $getcityurl, $myCity, PREG_SET_ORDER);
				
			if(!$City)
				echo "Orase nus";
			else	
			{	
				echo "<select id=\"cityList\" name=\"city\">";
				echo "<option>Sélectionnez une Ville</option>";
				foreach($myCity as $citybycountry){
					if(isset($_GET["city"]) && $citybycountry[1] == $_GET["city"])
						echo "<option selected='selected'>" .$citybycountry[1]. "</option>";
					else	
						echo "<option>" .$citybycountry[1]. "</option>";
				}
				echo "</select>";
			
				// start
				if(isset($_GET["city"])){
					$meteourl = "http://www.webservicex.net/globalweather.asmx/GetWeather?CityName=".urlencode($_GET["city"])."&CountryName=".urlencode($_GET["pays"]);
					$getmeteourl = file_get_contents($meteourl);

						$Location = 		preg_match('/Location&gt;(.*)&lt;/', $getmeteourl, $myLocation);
						$Time = 			preg_match('/Time&gt;(.*)&lt;/', $getmeteourl, $myTime);
						$Wind =	 			preg_match('/Wind&gt;(.*)&lt;/', $getmeteourl, $myWind);
						$Visibility = 		preg_match('/Visibility&gt;(.*)&lt;/', $getmeteourl, $myVisibility);
						$SkyConditions = 	preg_match('/SkyConditions&gt;(.*)&lt;/', $getmeteourl, $mySkyConditions);
						$Temperature = 		preg_match('/Temperature&gt;(.*)&lt;/', $getmeteourl, $myTemperature);
						$DewPoint = 		preg_match('/DewPoint&gt;(.*)&lt;/', $getmeteourl, $myDewPoint);
						$RelativeHumidity = preg_match('/RelativeHumidity&gt;(.*)&lt;/', $getmeteourl, $myRelativeHumidity);
						$Pressure = 		preg_match('/Pressure&gt;(.*)&lt;/', $getmeteourl, $myPressure);
							


							//$test = preg_match('/class="priceLarge">CDN\$ ([^<]*)</', $page, $lePrix);
					echo "<br>Location : " . $myLocation[1] . "<br />";
					echo "Time : " . $myTime[1] . "<br />";
					echo "Wind : " . $myWind[1] . "<br />";
					echo "Visibility : " . $myVisibility[1] . "<br />";
					echo "SkyConditions : " . $mySkyConditions[1] . "<br />";
					echo "Temperature : " . $myTemperature[1] . "<br />";
					echo "DewPoint : " . $myDewPoint[1] . "<br />";
					echo "RelativeHumidity : " . $myRelativeHumidity[1] . "<br />";
					echo "Pressure : " . $myPressure[1] . "<br />";
				// end
				}


			}
		}		
	?>
</form>
</body>
</html>