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
			
			if(isset($_POST['jatek'])) {$query = "SELECT * FROM jatek WHERE cim LIKE '%" . mysqli_real_escape_string($link, $_POST['jatek']) . "%' ORDER BY cim";}
			else {$query = "SELECT * FROM jatek ORDER BY cim";}
			
			$result = mysqli_query($link, $query);
		?>
		
		<table>
			<tr>
				<th> Átlag </th>
				<th> Cím </th>
				<th> Szerző </th>
				<th> Kiadó </th>
				<th> Játékidő </th>
				<th> Korhatár </th>
				<th> Játékosszám </th>
				<th> Összetettség </th>
			</tr> 
			<?php while($row = mysqli_fetch_array($result)):
				
				$atlag = mysqli_query($link, "SELECT ROUND(avg(ertek), 2) AS a FROM ertekeles GROUP BY jatek_id HAVING jatek_id =" . mysqli_real_escape_string($link, $row['id']));
				if(mysqli_num_rows($atlag) > 0) {$at = mysqli_fetch_assoc($atlag);}
				else {$at['a'] = 0;}
			?>
				
				<tr>
					<td><?=$at['a']?></td>
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