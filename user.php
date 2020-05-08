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
			$result = mysqli_query($link, "SELECT * FROM jatekos WHERE id=" . mysqli_real_escape_string($link, $_GET['id']));
			$adat = mysqli_fetch_assoc($result);
		?>
		
		<div id="tartalom">
			<h1 id="cim"><?=$adat['nev']?> </h1>
			<h3><?=$adat['email']?> </h3>
			
			<p>
				<!-- Az értékelő oldalnak megadja a játékos nevét, ami alapértelmezettként be lesz írva a formba. -->
				<a id="ertekeles" href="ertekelo.php?nev=<?=$adat['nev']?>"> Új értékelés </a>
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
						
						<a id="hibagomb" href="delete_ertekeles.php?id=<?=$_GET['torlendo']?>&vissza=user"> Igen </a>
						<a id="hibagomb" href="user.php?id=<?=$_GET['id']?>"> Nem </a>
					</p>
							
					<?php
				}
				
				// A játékoshoz tartozó értékelések lekérdezése:
				$ertek = mysqli_query($link, "SELECT * FROM ertekeles WHERE jatekos_id=" . mysqli_real_escape_string($link, $_GET['id']) . " ORDER BY ertek DESC");
				
				// Ha a játékos még nem adott le értékelést:
				if(mysqli_num_rows($ertek) == 0) {echo "Itt fognak megjelenni az értékeléseid.";}
				else
				{
			?>
		
			
					<table>
						<tr>
							<th> Játék </th>
							<th> Értékelés </th>
							<th> Dátum </th>
						</tr> 
						<?php 
							
							while($row = mysqli_fetch_array($ertek)): 
							
							// Minden sorban lekérdezzük az adott értékeléshez tartozó játék nevét a játék id-je alapján
							$jatek = mysqli_query($link, "SELECT cim FROM jatek WHERE id=" . mysqli_real_escape_string($link, $row['jatek_id']));
							$jateknev = mysqli_fetch_array($jatek);
						?>
							<tr>
								<td><?=$jateknev['cim']?></td>
								<td id="szam"><?=$row['ertek']?></td>
								<td><?=$row['datum']?></td>
								<td><a id="szerkeszt" href="ertekelo.php?id=<?=$row['id']?>&nev=<?=$adat['nev']?>&jatek=<?=$row['jatek_id']?>&ertek=<?=$row['ertek']?>"> Szerkeszt </a></td>
								<td><a id="torles" href="user.php?torles=1&torlendo=<?=$row['id']?>&id=<?=$_GET['id']?>"> Törlés </a></td>
							</tr>
						<?php endwhile; ?>
					</table>
					
			<?php
				}
			?>
			
			
		
		</div>
		
		<?php
			mysqli_close($link);
		?>
	</body>
</div>
</html>