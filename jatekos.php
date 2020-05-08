<!DOCTYPE html>
<html>
	<!-- Ez az oldal szolgál az adatbázisban tárolt játékosok kilistázására -->

	<head>
		<title> Társasjáték értékelő </title>
		<link rel="stylesheet" type="text/css" href="theme.css"> 
	</head>
	<body>
		<div id="keret">
		
			<?php include("menu.php"); ?>
			
			<div id="tartalom">
				<p>
					<h1 id="cim"> Játékosok </h1>
					
					<!-- A lista tetején van lehetőség új játékos beszúrására -->
					<a id="szerkeszt" href="insert_jatekos.php"> Új játékos beszúrása </a>
				</p>
				
				<?php
					// Ez a kérdés akkor jelenik meg, ha valaki kiválasztja a lista egyik elemének törlését.
					// Mivel a házi feladathoz használt módszerekkel nem valósítható meg egy felugró ablak, ezért jelenik meg az oldalon a kérdés.
					
					if(isset($_GET['torles']))
					{
						?>
						<p>
							Biztosan törölni szeretnéd?
							
							<a id="hibagomb" href="delete_jatekos.php?id=<?=$_GET['id']?>"> Igen </a>
							<a id="hibagomb" href="jatekos.php"> Nem </a>
						</p>
							
						<?php
					}
				?>
				
				<p id="tabla">
					
					<?php 
						include("db.php");
						$link = opendb();
						
						// Ez az if szolgál a keresés utáni szűrés megvalósítására.
						if(isset($_POST['jatekos'])) {$query = "SELECT * FROM jatekos WHERE nev LIKE '%" . mysqli_real_escape_string($link, $_POST['jatekos']) . "%' ORDER BY nev";}
						else {$query = "SELECT * FROM jatekos ORDER BY nev";}
						
						$result = mysqli_query($link, $query);
						
						
						// Ha a keresés eredménye nem tartalmaz egy játékost sem, akkor nem jeleníti meg az oldal a listázási táblázatot, hanem tájékoztatja a felhasználót, hogy nincs találat.
						if(mysqli_num_rows($result) == 0) {echo "Nincs találat.";}
						else
						{
					?>
							<table>
								<tr>
									<th> Név </th>
									<th> Email </th>
									<th> Megjegyzés </th>
								</tr> 
								<?php while($row = mysqli_fetch_array($result)): ?>
									<tr>
										<td><a id="nev" href="user.php?id=<?=$row['id']?>"> <?=$row['nev']?> </a></td> <!-- Ez a hivatkozás mutat a játékos egyéni oldalára  -->
										<td><?=$row['email']?></td>
										<td><?=$row['megjegyzes']?></td>
										
										<!-- Minden sor végén megtalálhatóak az adott játékoshoz tartozó adminisztrációs oldalakra mutató hivatkozások: Szerkesztés és Törlés -->
										<td><a id="szerkeszt" href="insert_jatekos.php?id=<?=$row['id']?>&nev=<?=$row['nev']?>&email=<?=$row['email']?>&megjegyzes=<?=$row['megjegyzes']?>"> Szerkeszt </a></td>
										<td><a id="torles" href="jatekos.php?torles=1&id=<?=$row['id']?>"> Törlés </a></td>
									</tr>
								<?php endwhile; ?>
							</table>
					
					<?php 
						} 
						mysqli_close($link);
					?>
				
				</p>
				
				
				
			</div>
		</div>
	</body>
</html>