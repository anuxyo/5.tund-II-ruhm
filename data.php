<?php

	//kodus
	//login -> email kui parool vale
	//kui v�ljad j��vad t�hjaks -> error
	//kasutaja loomine oma andmetega
	//----------
	//oma andmed AB'i
	//n�idatakse nt tabeli kuju

	require("functions.php");
	
	//kui ei ole kasutaja id'd
	if (!isset ($_SESSION["userId"])) {
		
		//suunan sisselogimislehele
		header("Location: login.php");
		
	}
	
	//kui on ?logout aadressireal, siis login v�lja
	if (isset($_GET["logout"])){
		
		session_destroy();
		header("Location: login.php");
	}
	
	if(isset($_SESSION["message"])){
		$msg = $_SESSION["message"];
		$_SESSION["message"];
		
		//kui �he n�itame siis kustuta �ra, et p�rast refreshi ei n�itaks
		unset($_SESSION["message"]);
	}
	
	//auto stuff
	if(isset($_POST["plate"]) && isset($_POST["plate"]) &&
		!empty($_POST["color"]) && !empty($_POST["color"])
		){	
			saveCar($_POST["plate"], $_POST["color"]);
		}
		
		//saan k�ik andmed
		$carData = getAllCars();
		echo "<pre>";
		var_dump($carData);
		echo "<pre>";
?>
<h1>Data</h1>
<?=$msg;?>
<p>
	Tere tulemast<?=$_SESSION["userEmail"];?>!
	<a href="?logout=1">Logi v�lja</a>
</p>

	<h2>salvesta auto</h2>
	<form method="POST">
	
		<label>Autonumber</label>
		<input name="plate" type="text"> 
		<br><br>
		
		<label>Autov�rv</label>
		<input type="color" name="color" >>
		<br><br>	
		
		<input type="submit" value="Salvesta">
		
	</form>
	
	
<h2>Autod</h2>
<?php

	$html = "<table>";
	
	$html .= "<tr>";
		$html .="<th>id</th>";
		$html .="<th>plate</th>";
		$html .="<th>color</th>";
	$html .= "</tr>";

	//iga liikme kohta massiivis
	foreach($carData as $c){
		//iga auto on $c
		//echo $c->plate."<br>";
		
		$html .= "<tr>";
		$html .="<td>".$c->id."</td>";
		$html .="<td>".$c->plate."</td>";
		$html .="<td style='background-color:".$c->color."'></td>";
	$html .= "</tr>";
	
	}
	$html .= "</table>";
	echo $html;
	
	$listHtml = "<br><br>";
	foreach($carData as $c){
		
		$listHtml .= "<h1 style='color:".$c->color."'>".$c->plate."</h1>";
		$listHtml .= "<p>color= ".$c->color."</p>";
		
	}
	
?>



