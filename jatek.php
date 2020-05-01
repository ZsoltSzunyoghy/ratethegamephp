<!DOCTYPE html>
<html>
	<head>
		<title> Társasjáték értékelő </title>
		<link rel="stylesheet" type="text/css" href="style.css"> 
	</head>
	<body>
		<?php include("menu.php"); ?>
		
		
		<div id="tartalom">
		<h1> Játékok </h1>
		
		<?php 
			include("db.php");
			$link = opendb();
			
			if(isset($_GET['rendezes'])) {$rendez = $_GET['rendezes'];}
			else {$rendez = "cim";}
			
			if(isset($_POST['jatek'])) {$query = "SELECT cim, szerzo, kiado, jatekido, korhatar, jatekosszam, osszetettseg, ROUND(avg(ertek), 2) AS atl FROM jatek LEFT OUTER JOIN ertekeles ON ertekeles.jatek_id = jatek.id GROUP BY cim HAVING cim LIKE '%" . mysqli_real_escape_string($link, $_POST['jatek']) . "%' ORDER BY " . $rendez;}
			elseif(isset($_GET['jatek'])) {$query = "SELECT cim, szerzo, kiado, jatekido, korhatar, jatekosszam, osszetettseg, ROUND(avg(ertek), 2) AS atl FROM jatek LEFT OUTER JOIN ertekeles ON ertekeles.jatek_id = jatek.id GROUP BY cim HAVING cim LIKE '%" . mysqli_real_escape_string($link, $_GET['jatek']) . "%' ORDER BY " . $rendez;}
			else {$query = "SELECT cim, szerzo, kiado, jatekido, korhatar, jatekosszam, osszetettseg, ROUND(avg(ertek), 2) AS atl FROM jatek LEFT OUTER JOIN ertekeles ON ertekeles.jatek_id = jatek.id GROUP BY cim ORDER BY " . $rendez;}
			
			$result = mysqli_query($link, $query);
		?>
		
		<table>
			<tr>
				<th> Átlag <a href="jatek.php?rendezes=atl DESC<?php if(isset($_POST['jatek'])) { ?>&jatek=<?$_POST['jatek']?><?php } elseif(isset($_GET['jatek'])) { ?>&jatek=<?$_GET['jatek']?><?php } ?>"> Rendez </a> </th>
				<th> Cím <a href="jatek.php?rendezes=cim"> Rendez </a> </th>
				<th> Szerző </th>
				<th> Kiadó </th>
				<th> Játékidő </th>
				<th> Korhatár </th>
				<th> Játékosszám </th>
				<th> Összetettség </th>
			</tr> 
			<?php while($row = mysqli_fetch_array($result)):
				
				
				if(isset($row['atl'])) {$at = $row['atl'];}
				else {$at = 0;}
			?>
				
				<tr>
					<td><?=$at?></td>
					<td><?=$row['cim']?></td>
					<td><?=$row['szerzo']?></td>
					<td><?=$row['kiado']?></td>
					<td><?=$row['jatekido']?></td>
					<td><?=$row['korhatar']?></td>
					<td><?=$row['jatekosszam']?></td>
					<td><?=$row['osszetettseg']?></td>
					<td><a href="insert_jatek.php?id=<?=$row['id']?>&cim=<?=$row['cim']?>&szerzo=<?=$row['szerzo']?>&kiado=<?=$row['kiado']?>&jatekido=<?=$row['jatekido']?>&korhatar=<?=$row['korhatar']?>&jatekosszam=<?=$row['jatekosszam']?>&osszetettseg=<?=$row['osszetettseg']?>"> Szerkeszt </a></td>
					<td><a href="delete_jatek.php?id=<?=$row['id']?>"> Törlés </a></td>
					<td><a href="ertekelo.php?jatek=<?=$row['id']?>"> Értékelés </a></td>
				</tr>
			<?php endwhile; ?>
		</table>
		
		<?php mysqli_close($link) ?>
		
        <p>
           <a href="insert_jatek.php"> Új játék beszúrása </a>
        </p>
		
		</div>
		
	</body>
</html>