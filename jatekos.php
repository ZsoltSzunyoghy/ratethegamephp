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
			
			if(isset($_POST['jatekos'])) {$query = "SELECT * FROM jatekos WHERE nev LIKE '%" . mysqli_real_escape_string($link, $_POST['jatekos']) . "%' ORDER BY nev";}
			else {$query = "SELECT * FROM jatekos ORDER BY nev";}
			
			$result = mysqli_query($link, $query);
		?>
		
		<table>
			<tr>
				<th> Név </th>
				<th> Email </th>
				<th> Megjegyzés </th>
			</tr> 
			<?php while($row = mysqli_fetch_array($result)): ?>
				<tr>
					<td><a href="user.php?id=<?=$row['id']?>"> <?=$row['nev']?> </a></td>
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