<!DOCTYPE html>
<html>
	<!-- Ez az oldal szolgál az adatbázisban tárolt játékok kilistázására -->
	
	
	<head>
		<title> Társasjáték értékelő </title>
		<link rel="stylesheet" type="text/css" href="theme.css"> 
	</head>
	<body>
		<div id="keret">
			<?php include("menu.php"); ?>
			
			
			<div id="tartalom">
				<p>
					<h1 id="cim"> Játékok  </h1>   
					
					<!-- A lista tetején van lehetőség új játék beszúrására -->
					<a id="szerkeszt" href="insert_jatek.php"> Új játék beszúrása </a> </h1> 
				</p>
				
				
				<?php
					// Ez a kérdés akkor jelenik meg, ha valaki kiválasztja a lista egyik elemének törlését.
					// Mivel a házi feladathoz használt módszerekkel nem valósítható meg egy felugró ablak, ezért jelenik meg az oldalon a kérdés.
				
					if(isset($_GET['torles']))
					{
						?>
						<p>
							Biztosan törölni szeretnéd?
							
							<a id="hibagomb" href="delete_jatek.php?id=<?=$_GET['id']?>"> Igen </a>
							<a id="hibagomb" href="jatek.php"> Nem </a>
						</p>
							
						<?php
					}
				?>
				
				<?php 
					include("db.php");
					$link = opendb();
					
					// A következő lekérdezés azért sikerült ilyen bonyolultra, mert megvalósítja, hogy a felhasználó kiválaszthassa, hogy melyik adat alapján szeretné sorbarendezni az adatokat a megjelenítéskor.
					
					// Az alapértelmezett sorbarendezés a játék címe alapján való sorbarendezés.
					// Ha ez másra állítódik, azt az oldal a GET tömbben kapja meg.
					// A sorbarendezés az értékelések átlaga alapján is lehetséges, ezért volt szükség a külső illesztésre.
					if(isset($_GET['rendezes'])) {$rendez = $_GET['rendezes'];}
					else {$rendez = "cim";}
					
					// Ez az if a keresés utáni szűrés megvalósítására szolgál. A POST és GET ellenőrzései közül a rendezés miatt szükséges mindkettő.
					if(isset($_POST['jatek'])) {$query = "SELECT jatek.id AS id, cim, szerzo, kiado, jatekido, korhatar, jatekosszam, osszetettseg, ROUND(avg(ertek), 2) AS atl FROM jatek LEFT OUTER JOIN ertekeles ON ertekeles.jatek_id = jatek.id GROUP BY cim HAVING cim LIKE '%" . mysqli_real_escape_string($link, $_POST['jatek']) . "%' ORDER BY " . $rendez;}
					elseif(isset($_GET['jatek'])) {$query = "SELECT jatek.id AS id, cim, szerzo, kiado, jatekido, korhatar, jatekosszam, osszetettseg, ROUND(avg(ertek), 2) AS atl FROM jatek LEFT OUTER JOIN ertekeles ON ertekeles.jatek_id = jatek.id GROUP BY cim HAVING cim LIKE '%" . mysqli_real_escape_string($link, $_GET['jatek']) . "%' ORDER BY " . $rendez;}
					else {$query = "SELECT jatek.id AS id, cim, szerzo, kiado, jatekido, korhatar, jatekosszam, osszetettseg, ROUND(avg(ertek), 2) AS atl FROM jatek LEFT OUTER JOIN ertekeles ON ertekeles.jatek_id = jatek.id GROUP BY cim ORDER BY " . $rendez;}
					
					$result = mysqli_query($link, $query);
				?>
				
				
				<p id="tabla">
					<?php 
						// Ha a keresés eredménye nem tartalmaz egy játékot sem, akkor nem jeleníti meg az oldal a listázási táblázatot, hanem tájékoztatja a felhasználót, hogy nincs találat.
						if(mysqli_num_rows($result) == 0) {echo "Nincs találat.";} 
						else 
						{
					?>
							<table>
								<tr>
									<!-- Ezek a hivatkozások szolgálnak a rendezés megvalósítására.  -->
									<th> Átlag <a href="jatek.php?rendezes=atl DESC<?php if(isset($_POST['jatek'])) { ?>&jatek=<?=$_POST['jatek']?><?php } elseif(isset($_GET['jatek'])) { ?>&jatek=<?=$_GET['jatek']?><?php } ?>"> Rendez </a> </th>
									<th> Cím <a href="jatek.php?rendezes=cim<?php if(isset($_POST['jatek'])) { ?>&jatek=<?=$_POST['jatek']?><?php } elseif(isset($_GET['jatek'])) { ?>&jatek=<?=$_GET['jatek']?><?php } ?>"> Rendez </a> </th>
									<th> Szerző <a href="jatek.php?rendezes=szerzo<?php if(isset($_POST['jatek'])) { ?>&jatek=<?=$_POST['jatek']?><?php } elseif(isset($_GET['jatek'])) { ?>&jatek=<?=$_GET['jatek']?><?php } ?>"> Rendez </a> </th>
									<th> Kiadó <a href="jatek.php?rendezes=kiado<?php if(isset($_POST['jatek'])) { ?>&jatek=<?=$_POST['jatek']?><?php } elseif(isset($_GET['jatek'])) { ?>&jatek=<?=$_GET['jatek']?><?php } ?>"> Rendez </a> </th>
									<th> Játékidő </th>
									<th> Korhatár </th>
									<th> Játékosszám </th>
									<th> Összetettség <a href="jatek.php?rendezes=osszetettseg<?php if(isset($_POST['jatek'])) { ?>&jatek=<?=$_POST['jatek']?><?php } elseif(isset($_GET['jatek'])) { ?>&jatek=<?=$_GET['jatek']?><?php } ?>"> Rendez </a> </th>
								</tr> 
								
								<?php 	
									while($row = mysqli_fetch_array($result)):
									
									// Ha a játékra még nem érkezett értékelés, akkor a játékra érkezett értékelések átlaga nem értelmezhető. Ebben az esetben manuálisan állítjuk be a '0' értéket.
									if(isset($row['atl'])) {$at = $row['atl'];}
									else {$at = 0;}
								?>
									
									<tr>
										<td id="szam"><?=$at?></td>
										<td><a id="nev" href="game.php?id=<?=$row['id']?>"> <?=$row['cim']?> </a></td> <!-- Ez a hivatkozás mutat a játék egyéni oldalára  -->
										<td><?=$row['szerzo']?></td>
										<td><?=$row['kiado']?></td>
										<td><?=$row['jatekido']?></td>
										<td id="szam"><?=$row['korhatar']?></td>
										<td id="szam"><?=$row['jatekosszam']?></td>
										<td id="szam"><?=$row['osszetettseg']?></td>
										
										<!-- Minden sor végén megtalálhatóak az adott játékhoz tartozó adminisztrációs oldalakra mutató hivatkozások: Szerkesztés, Értékelés és Törlés -->
										<td><a id="szerkeszt" href="insert_jatek.php?id=<?=$row['id']?>&cim=<?=$row['cim']?>&szerzo=<?=$row['szerzo']?>&kiado=<?=$row['kiado']?>&jatekido=<?=$row['jatekido']?>&korhatar=<?=$row['korhatar']?>&jatekosszam=<?=$row['jatekosszam']?>&osszetettseg=<?=$row['osszetettseg']?>"> Szerkeszt </a></td>
										<td><a id="ertekeles" href="ertekelo.php?jatek=<?=$row['id']?>"> Értékelés </a></td>
										<td><a id="torles" href="jatek.php?torles=1&id=<?=$row['id']?>"> Törlés </a></td>
										
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