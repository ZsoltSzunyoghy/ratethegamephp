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
			
			$result = mysqli_query($link, "SELECT * FROM jatek WHERE id=" . mysqli_real_escape_string($link, $_GET['id']));
			$adat = mysqli_fetch_assoc($result);
			
			$atlagresult = mysqli_query($link, "SELECT ROUND(avg(ertek), 2) AS atl FROM ertekeles GROUP BY jatek_id HAVING jatek_id =" . mysqli_real_escape_string($link, $_GET['id']));
			
			if(mysqli_num_rows($atlagresult) > 0) {$atlag = mysqli_fetch_assoc($atlagresult);}
			else {$atlag['atl'] = 0;}
			
			
		?>
		
		<div id="tartalom">
		<h1 id="cim"><?=$adat['cim']?> </h1>
		<h3> Átlag értékelés: <?=$atlag['atl']?> </h3>
		
		<p>
           <a id="ertekeles" href="ertekelo.php?jatek=<?=$adat['id']?>"> Új értékelés </a>
        </p>
		
		<h2>Értékelések: </h2>
		
		<?php
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
		?>
		
		<table>
			<tr>
				<th> Játékos </th>
				<th> Értékelés </th>
			</tr> 
			<?php 
				$ertek = mysqli_query($link, "SELECT * FROM ertekeles WHERE jatek_id=" . mysqli_real_escape_string($link, $_GET['id']));
				while($row = mysqli_fetch_array($ertek)): 
				
				$jatekos = mysqli_query($link, "SELECT nev FROM jatekos WHERE id=" . mysqli_real_escape_string($link, $row['jatekos_id']));
				$jatekosnev = mysqli_fetch_array($jatekos);
			?>
				<tr>
					<td><?=$jatekosnev['nev']?></td>
					<td  id="szam"><?=$row['ertek']?></td>
					<td><a id="szerkeszt" href="ertekelo.php?id=<?=$row['id']?>&nev=<?=$jatekosnev['nev']?>&jatek=<?=$row['jatek_id']?>&ertek=<?=$row['ertek']?>"> Szerkeszt </a></td>
					<td><a id="torles" href="game.php?torles=1&torlendo=<?=$row['id']?>&id=<?=$_GET['id']?>"> Törlés </a></td>
				</tr>
			<?php endwhile; ?>
		</table>
		
		
		
		</div>
		
		<?php
			mysqli_close($link);
		?>
	</body>
</div>
</html>