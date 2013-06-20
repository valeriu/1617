<?php
	require_once "inc/variable.php";
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Meteo - Yan et Valeriu</title>
	<script type="text/javascript" src="./js/lib.js"></script>
</head>
<body>
<form action="#" method="GET">
<select name="pays" id="paysList">
	<option>Sélectionnez une valeur</option>
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
</form>
</body>
</html>
