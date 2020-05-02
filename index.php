<!DOCTYPE html>
<html>
<div id="keret">
	<head>
		<title> Társasjáték értékelő </title>
		<link rel="stylesheet" type="text/css" href="theme.css"> 
	</head>
	<body>
		<?php  include("menu.php"); ?>
		<div id="tartalom">
		
			
		
			
			
			<div id="nagyertekelo" >
				<a id="ertekelo" href="ertekelo.php"> Értékelés </a> 
			</div>
			
			<div id="keresesek">
				<h1 id="cim"> Kezdőoldal </h1>
			
				
				
				<form action="jatekos.php" method="post">
					<h2> Játékos keresése: <input type="text" name="jatekos" /> <input id="submit" type="submit" value="Keresés" name="uj" /> </h2>
				</form>
				
				<form action="jatek.php" method="post">
					<h2> Játék keresése: <input type="text" name="jatek" /> <input id="submit" type="submit" value="Keresés" name="uj" /> </h2>
				</form>
				
				
				<a id="szerkeszt" href="datum.php"> Mai értékelések </a>
			
			</div>
			
			
		</div>
	</body>
</div>
</html>