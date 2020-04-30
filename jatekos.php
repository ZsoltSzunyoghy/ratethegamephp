<!DOCTYPE html>
<html>
	<head>
		<title> Társasjáték értékelő </title>
		<link rel="stylesheet" type="text/css" href="style.css"> 
	</head>
	<body>
		<?php include("menu.php"); ?>
		
		<div id="tartalom">
		<h1> Játékosok </h1>
		
		
		<?php 
			include("db.php");
			$link = opendb();
			
			$result = mysqli_query($link, "SELECT * FROM jatekos");
		?>
		
		<table>
			<tr>
				<th> Név </th>
				<th> Email </th>
				<th> Megjegyzés </th>
			</tr> 
			<?php while($row = mysqli_fetch_array($result)): ?>
				<tr>
					<td><?=$row['nev']?></td>
					<td><?=$row['email']?></td>
					<td><?=$row['megjegyzes']?></td>
					<td><a href="insert_jatekos.php?id=<?=$row['id']?>&nev=<?=$row['nev']?>&email=<?=$row['email']?>&megjegyzes=<?=$row['megjegyzes']?>"> Szerkeszt </a></td>
					<td><a href="delete_jatekos.php?id=<?=$row['id']?>"> Törlés </a></td>
				</tr>
			<?php endwhile; ?>
		</table>
		
		<?php mysqli_close($link) ?>
		
        <p>
           <a href="insert_jatekos.php"> Új játékos beszúrása </a>
        </p>
		
		</div>
	</body>
</html>