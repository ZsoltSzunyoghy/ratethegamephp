<!DOCTYPE html>
<html>
	<head>
		<title> Társasjáték értékelő </title>
		<link rel="stylesheet" type="text/css" href="style.css"> 
	</head>
	<body>
		<?php  include("menu.php"); ?>
		<div id="tartalom">
			<h1> Ez a főoldal </h1>
			
			<form action="jatek.php" method="post">
                Játék keresése: <input type="text" name="jatek" /> <input type="submit" value="Keresés" name="uj" />
            </form>
			
			<form action="jatekos.php" method="post">
                Játékos keresése: <input type="text" name="jatekos" /> <input type="submit" value="Keresés" name="uj" />
            </form>
		</div>
	</body>
</html>