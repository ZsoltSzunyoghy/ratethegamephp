<!DOCTYPE html>

<html>
<div id="keret">
	<head>
		<title> Társasjáték értékelő </title>
		<link rel="stylesheet" type="text/css" href="theme.css"> 
	</head>
	<body>
		<?php 
			include("menu.php"); 
			include("db.php");
			$link = opendb();
			
			// Az adott játékos adatainak lekérdezése
			$result = mysqli_query($link, "SELECT * FROM jatek WHERE id=" . mysqli_real_escape_string($link, $_GET['id']));
			$adat = mysqli_fetch_assoc($result);
			
			// Az adott játékra adott értékelések átlaga
			$atlagresult = mysqli_query($link, "SELECT ROUND(avg(ertek), 2) AS atl FROM ertekeles GROUP BY jatek_id HAVING jatek_id =" . mysqli_real_escape_string($link, $_GET['id']));
			// Ha az átlag nem értelmezett, mert még nem érkezett értékelés a játékra, akkor az átlag értékét 0-ra állítjuk:
			if(mysqli_num_rows($atlagresult) > 0) {$atlag = mysqli_fetch_assoc($atlagresult);}
			else {$atlag['atl'] = 0;}
			
			
		?>
		
		<div id="tartalom">
			<h1 id="cim"><?=$adat['cim']?> </h1>
			<h3> Átlag értékelés: <?=$atlag['atl']?> </h3>
			
			<p>
				<!-- Az értékelő oldalnak megadja a játék nevét, ami alapértelmezettként ki lesz fálasztva a formban. -->
			   <a id="ertekeles" href="ertekelo.php?jatek=<?=$adat['id']?>"> Új értékelés </a>
			</p>
			
			<h2>Értékelések: </h2>
			
			<?php
				// Ez a kérdés akkor jelenik meg, ha valaki kiválasztja a lista egyik elemének törlését.
				// Mivel a házi feladathoz használt módszerekkel nem valósítható meg egy felugró ablak, ezért jelenik meg az oldalon a kérdés.
			
				if(isset($_GET['torles']))
				{
					?>
					<p>
						Biztosan törölni szeretnéd?
						
						<a id="hibagomb" href="delete_ertekeles.php?id=<?=$_GET['torlendo']?>&vissza=game"> Igen </a>
						<a id="hibagomb" href="game.php?id=<?=$_GET['id']?>"> Nem </a>
					</p>
							
					<?php
				}
			
			// A játékhoz tartozó értékelések lekérdezése:
			$ertek = mysqli_query($link, "SELECT * FROM ertekeles WHERE jatek_id=" . mysqli_real_escape_string($link, $_GET['id']) . " ORDER BY ertek DESC");
			
			if (mysqli_num_rows($ertek) == 0) {echo "Itt fognak megjelenni a játék értékelései.";}
			else
			{
			?>
			
				<table>
					<tr>
						<th> Játékos </th>
						<th> Értékelés </th>
						<th> Dátum </th>
					</tr> 
					<?php 
						
						while($row = mysqli_fetch_array($ertek)): 
						
						// Minden sorban lekérdezzük az adott értékeléshez tartozó játékos nevét a játék id-je alapján
						$jatekos = mysqli_query($link, "SELECT nev FROM jatekos WHERE id=" . mysqli_real_escape_string($link, $row['jatekos_id']));
						$jatekosnev = mysqli_fetch_array($jatekos);
					?>
						<tr>
							<td><?=$jatekosnev['nev']?></td>
							<td  id="szam"><?=$row['ertek']?></td>
							<td><?=$row['datum']?></td>
							<td><a id="szerkeszt" href="ertekelo.php?id=<?=$row['id']?>&nev=<?=$jatekosnev['nev']?>&jatek=<?=$row['jatek_id']?>&ertek=<?=$row['ertek']?>"> Szerkeszt </a></td>
							<td><a id="torles" href="game.php?torles=1&torlendo=<?=$row['id']?>&id=<?=$_GET['id']?>"> Törlés </a></td>
						</tr>
					<?php endwhile; ?>
				</table>
		<?php
			}
			mysqli_close($link);
		?>
			
			
		</div>
		
		
	</body>
</div>
</html>