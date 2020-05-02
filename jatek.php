<!DOCTYPE html>
<html>
<div id="keret">
	<head>
		<title> Társasjáték értékelő </title>
		<link rel="stylesheet" type="text/css" href="theme.css"> 
	</head>
	<body>
		<?php include("menu.php"); ?>
		
		
		<div id="tartalom">
			<p>
				<h1 id="cim"> Játékok  </h1>   <a id="szerkeszt" href="insert_jatek.php"> Új játék beszúrása </a> </h1>
			</p>
			
			
			<?php
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
				
				if(isset($_GET['rendezes'])) {$rendez = $_GET['rendezes'];}
				else {$rendez = "cim";}
				
				if(isset($_POST['jatek'])) {$query = "SELECT jatek.id AS id, cim, szerzo, kiado, jatekido, korhatar, jatekosszam, osszetettseg, ROUND(avg(ertek), 2) AS atl FROM jatek LEFT OUTER JOIN ertekeles ON ertekeles.jatek_id = jatek.id GROUP BY cim HAVING cim LIKE '%" . mysqli_real_escape_string($link, $_POST['jatek']) . "%' ORDER BY " . $rendez;}
				elseif(isset($_GET['jatek'])) {$query = "SELECT jatek.id AS id, cim, szerzo, kiado, jatekido, korhatar, jatekosszam, osszetettseg, ROUND(avg(ertek), 2) AS atl FROM jatek LEFT OUTER JOIN ertekeles ON ertekeles.jatek_id = jatek.id GROUP BY cim HAVING cim LIKE '%" . mysqli_real_escape_string($link, $_GET['jatek']) . "%' ORDER BY " . $rendez;}
				else {$query = "SELECT jatek.id AS id, cim, szerzo, kiado, jatekido, korhatar, jatekosszam, osszetettseg, ROUND(avg(ertek), 2) AS atl FROM jatek LEFT OUTER JOIN ertekeles ON ertekeles.jatek_id = jatek.id GROUP BY cim ORDER BY " . $rendez;}
				
				$result = mysqli_query($link, $query);
			?>
			
			
			<p id="tabla">
				<table>
					<tr>
						<th> Átlag <a href="jatek.php?rendezes=atl DESC<?php if(isset($_POST['jatek'])) { ?>&jatek=<?=$_POST['jatek']?><?php } elseif(isset($_GET['jatek'])) { ?>&jatek=<?=$_GET['jatek']?><?php } ?>"> Rendez </a> </th>
						<th> Cím <a href="jatek.php?rendezes=cim<?php if(isset($_POST['jatek'])) { ?>&jatek=<?=$_POST['jatek']?><?php } elseif(isset($_GET['jatek'])) { ?>&jatek=<?=$_GET['jatek']?><?php } ?>"> Rendez </a> </th>
						<th> Szerző <a href="jatek.php?rendezes=szerzo<?php if(isset($_POST['jatek'])) { ?>&jatek=<?=$_POST['jatek']?><?php } elseif(isset($_GET['jatek'])) { ?>&jatek=<?=$_GET['jatek']?><?php } ?>"> Rendez </a> </th>
						<th> Kiadó <a href="jatek.php?rendezes=kiado<?php if(isset($_POST['jatek'])) { ?>&jatek=<?=$_POST['jatek']?><?php } elseif(isset($_GET['jatek'])) { ?>&jatek=<?=$_GET['jatek']?><?php } ?>"> Rendez </a> </th>
						<th> Játékidő </th>
						<th> Korhatár </th>
						<th> Játékosszám </th>
						<th> Összetettség <a href="jatek.php?rendezes=osszetettseg<?php if(isset($_POST['jatek'])) { ?>&jatek=<?=$_POST['jatek']?><?php } elseif(isset($_GET['jatek'])) { ?>&jatek=<?=$_GET['jatek']?><?php } ?>"> Rendez </a> </th>
					</tr> 
					
					<?php while($row = mysqli_fetch_array($result)):
						
						if(isset($row['atl'])) {$at = $row['atl'];}
						else {$at = 0;}
					?>
						
						<tr>
							<td id="szam"><?=$at?></td>
							<td><a id="nev" href="game.php?id=<?=$row['id']?>"> <?=$row['cim']?> </a></td>
							<td><?=$row['szerzo']?></td>
							<td><?=$row['kiado']?></td>
							<td><?=$row['jatekido']?></td>
							<td id="szam"><?=$row['korhatar']?></td>
							<td id="szam"><?=$row['jatekosszam']?></td>
							<td id="szam"><?=$row['osszetettseg']?></td>
							<td><a id="szerkeszt" href="insert_jatek.php?id=<?=$row['id']?>&cim=<?=$row['cim']?>&szerzo=<?=$row['szerzo']?>&kiado=<?=$row['kiado']?>&jatekido=<?=$row['jatekido']?>&korhatar=<?=$row['korhatar']?>&jatekosszam=<?=$row['jatekosszam']?>&osszetettseg=<?=$row['osszetettseg']?>"> Szerkeszt </a></td>
							<td><a id="ertekeles" href="ertekelo.php?jatek=<?=$row['id']?>"> Értékelés </a></td>
							<td><a id="torles" href="jatek.php?torles=1&id=<?=$row['id']?>"> Törlés </a></td>
							
						</tr>
					<?php endwhile; ?>
				</table>
				
				<?php mysqli_close($link) ?>
			</p>
			
		</div>
		
	</body>
</div>
</html>