<?php
	
	//login failist
	require("../../config.php");
	//functions
	//$name="Amu";
	//var_dump $_GLOBALS($GLOBALS);
	
	//see fail, peab olema kıigil lehtedel, kus tahan kasutada SESSION muutujat
	session_start();
	
	//signup
	
	function signUp ($email, $password) {
			
		$database = "if16_anusada_2";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
	
		$stmt = $mysqli->prepare("INSERT INTO user_sample (email, password) VALUES (?, ?)");
		
		echo $mysqli->error;
		
		$stmt->bind_param("ss", $email, $password);

		if($stmt->execute()) {
			echo "salvestamine ınnestus";
		} else {
			echo "ERROR".$stmt->error;
		}
		
		$stmt->close();
		$mysqli->close();
		
	}
	
	
	function login ($email, $password) {
		
		$error = "";
		
		$database = "if16_anusada_2";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
	
		$stmt = $mysqli->prepare("SELECT id, email, password, created FROM user_sample WHERE email = ?");
		
		echo $mysqli->error;
		
		//asendan k¸sim‰rgi ....(WHERE email =?");
		$stmt->bind_param("s", $email);
		
		//m‰‰ran v‰‰rtused muutujatesse
		$stmt->bind_result($id, $emailFromDb, $passwordFromDb, $created);
		
		$stmt->execute();
		
		//andmed tulid andmebaasist vıi mitte
		//on tıene kui on v‰hemalt ¸ks vaste
		//vıetakse ¸ks rida andmebaasist. kui ˆelda teist korda, siis vıtab j‰rgmise rea
		if($stmt->fetch()){
			
			//oli sellise meiliga kasutaja
			//password millega kasutaja tahab sisse logida
			$hash = hash("sha512", $password);
			if ($hash == $passwordFromDb) {
				echo  "Kasutaja logis sisse".$id;
				
				//m‰‰ran sessioni muutujad, millele saan ligi teistelt lehtedelt
				$_SESSION["userId"] = $id;
				$_SESSION["userEmail"] = $emailFromDb;
				
				$_SESSION["message"] = "<h1>Tere tulemast!</h1>";
				
				header("Location: data.php");
				
			} else {
				$error = "vale parool";
			}
			
		} else {
			
			//ei leidnud kasutajat sellise meiliga
			$error = "ei ole sellist emaili";
		}
		
		return $error;
	}
	
	function saveCar ($plate, $color) {
			
		$database = "if16_anusada_2";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
	
		$stmt = $mysqli->prepare("INSERT INTO cars_and_colors (plate, color) VALUES (?, ?)");
		
		echo $mysqli->error;
		
		$stmt->bind_param("ss", $plate, $color);

		if($stmt->execute()) {
			echo "salvestamine ınnestus";
		} else {
			echo "ERROR".$stmt->error;
		}
		
		$stmt->close();
		$mysqli->close();
		
	}
	
	function getAllCars() {
		$database = "if16_anusada_2";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
		
		$stmt = $mysqli->prepare("
			SELECT id, plate, color
			FROM cars_and_colors
		");
		
		echo $mysqli->error;
		
		$stmt->bind_result($id, $plate, $color);
		$stmt->execute();
		
		//tekitan massiivi
		$result = array();
		
		
		//tee seda seni, kuni on rida andmeid
		//mis vastab select lausele
		while($stmt->fetch()) {
			
			//tekitan objekt
			$car = new StdClass();
			
			$car->id = $id;
			$car->plate = $plate;
			$car->color = $color;
			
			//echo $plate."<br>";
			//iga kord massiivi lisan juurde nr m‰rgi
			array_push($result, $car);
		}
	
		$stmt->close();
		$mysqli->close();
		
		return $result;
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	//function sum($x, $y) {
		
		//return $x + $y;
		
	//}

	//echo sum(845983, 1232432);
	//echo "<br>";
	//echo sum(1,1);

	//function hello($firstname, $lastname) {
		
		//return "Tere tulemast ".$firstname." ".$lastname."!";
		
	//}
	//echo sum(845983, 1232432);
	//echo "<br>"
	//echo hello("Anu", "Sadam");
	
	
	
?>