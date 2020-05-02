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
			
			$result = mysqli_query($link, "SELECT * FROM jatekos WHERE id=" . mysqli_real_escape_string($link, $_GET['id']));
			$adat = mysqli_fetch_assoc($result);
		?>
		
		<div id="tartalom">
		<h1 id="cim"><?=$adat['nev']?> </h1>
		<h3><?=$adat['email']?> </h3>
		
		 <p>
           <a id="ertekeles" href="ertekelo.php?nev=<?=$adat['nev']?>"> Új értékelés </a>
        </p>
		
		<h2>Értékelések: </h2>
		
		<?php
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
		?>
		
		<table>
			<tr>
				<th> Játék </th>
				<th> Értékelés </th>
			</tr> 
			<?php 
				$ertek = mysqli_query($link, "SELECT * FROM ertekeles WHERE jatekos_id=" . mysqli_real_escape_string($link, $_GET['id']));
				while($row = mysqli_fetch_array($ertek)): 
				
				$jatek = mysqli_query($link, "SELECT cim FROM jatek WHERE id=" . mysqli_real_escape_string($link, $row['jatek_id']));
				$jateknev = mysqli_fetch_array($jatek);
			?>
				<tr>
					<td><?=$jateknev['cim']?></td>
					<td  id="szam"><?=$row['ertek']?></td>
					<td><a id="szerkeszt" href="ertekelo.php?id=<?=$row['id']?>&nev=<?=$adat['nev']?>&jatek=<?=$row['jatek_id']?>&ertek=<?=$row['ertek']?>"> Szerkeszt </a></td>
					<td><a id="torles" href="user.php?torles=1&torlendo=<?=$row['id']?>&id=<?=$_GET['id']?>"> Törlés </a></td>
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