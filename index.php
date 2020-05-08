<!DOCTYPE html>
<html>
	<head>
		<title> Társasjáték értékelő </title>
		<link rel="stylesheet" type="text/css" href="theme.css"> 
	</head>
	<body>
		<div id="keret">
			<?php  include("menu.php"); ?>
			<div id="tartalom">
			
				<!-- Gyorsgomb az értékelő oldalra -->
				<div id="nagyertekelo" >
					<a id="ertekelo" href="ertekelo.php"> Értékelés </a> 
				</div>
				
				<div id="keresesek">
					<h1 id="cim"> Kezdőoldal </h1>
				
					
					<!-- 
					Keresőmotorok megvalóstása: a keresés az eredeti listázó oldalakat hívja meg, a szűrés ott valósul meg a bemenet alapján
						listázó oldalak: jatekos.php, jatek.php
					-->
					<form action="jatekos.php" method="post">
						<h2> Játékos keresése: <input type="text" name="jatekos" /> <input id="submit" type="submit" value="Keresés" name="uj" /> </h2>
					</form>
					
					<form action="jatek.php" method="post">
						<h2> Játék keresése: <input type="text" name="jatek" /> <input id="submit" type="submit" value="Keresés" name="uj" /> </h2>
					</form>
					
					<br />
					
					<p>
						<h1> Eddigi értékelések: </h1>
						
						<!-- Összes eddigi értékelés kilistázása táblázatos formában -->
						<table>
							<tr>
								<th> Játék </th>
								<th> Játékos </th>
								<th> Értékelés </th>
								<th> Dátum </th>
							</tr> 
							<?php 
								// Az adatbázis megnyitása külön fájlból történik, mert majdnem az összes fájlban úgyanúgy van használva.
								include("db.php"); 
								$link = opendb();
								
								// Az SQL parancs az ertékelések lekérdezésére. A lekérdezést dátum alapján csökkenő sorrendbe rendezve valósítottam meg.
								$result = mysqli_query($link, "SELECT * FROM ertekeles ORDER BY datum DESC");
								
								while($row = mysqli_fetch_array($result)): 
								
								// Az értékeléseket tartalmazó tábla csak id-val hivatkozik az értékeléshez tartozó játékra és játékosra.
								// Ezért minden sorban az id alapján lekérdezi a program az adott id-khoz tartozó játék és játékos nevét.
								
								$jatek = mysqli_query($link, "SELECT cim FROM jatek WHERE id=" . mysqli_real_escape_string($link, $row['jatek_id']));
								$jateknev = mysqli_fetch_array($jatek);
								
								$jatekos = mysqli_query($link, "SELECT nev FROM jatekos WHERE id=" . mysqli_real_escape_string($link, $row['jatekos_id']));
								$jatekosnev = mysqli_fetch_array($jatekos);
							
							?>
								<tr>
									<td><?=$jateknev['cim']?></td>
									<td><?=$jatekosnev['nev']?></td>
									<td  id="szam"><?=$row['ertek']?></td>
									<td><?=$row['datum']?></td>
								</tr>
							<?php endwhile; ?>
						</table>
					</p>
					
					
				</div>
					
				
			</div>
		</div>
	</body>
</html>