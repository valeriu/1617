/*window.addEventListener('load', function(){
	var selectPays = document.getElementById('paysList');
	var selectCity = document.getElementById('cityList');
	var generatyUrl = "";

	selectPays.addEventListener('change', function(){
		//generatyUrl = "meteo.php?pays="+this.value+"&";
		generatyUrl += 'meteo.php?pays=' + this.value;
		 window.location =  generatyUrl;
	}, false);


	selectCity.addEventListener('change', function(){
		generatyUrl = window.location.href+ '&city=' + this.value;
		 window.location =  generatyUrl;
	}, false);

console.log(generatyUrl);

}, false);
*/