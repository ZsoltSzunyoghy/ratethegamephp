<!DOCTYPE html>
<html>
	<head>
		<title> Társasjáték értékelő </title>
		<link rel="stylesheet" type="text/css" href="style.css"> 
	</head>
	<body>
		<?php  include("menu.php"); ?>
		<div id="tartalom">
			
			<?php 
				include("db.php");
				$link = opendb();
				
				$query1 = "SELECT count(id), datum FROM ertekeles GROUP BY datum ORDER BY datum DESC";
				$res = mysqli_query($link, $query1);
			?>
			
			<h1> Értékelések ezen a napon: 
			<?php 
				if(isset($_POST['date'])) {echo $_POST['date'];}
				else {echo date('Y-m-d');}
			?>
			</h1>
			
			<form action="datum.php" method="post">
				
				Másik dátum: <select id="date" name="date" >
						<option selected value=0> Válassz </option>
					
					<?php while($sor = mysqli_fetch_array($res)): ?>
						<option value=<?=$sor['datum']?>><?=$sor['datum']?>  </option>
					<?php endwhile; ?>
				</select>
				
				<input type="submit" value="Listázás" name="uj" />
			</form>
			
			<table>
				<tr>
					<th> Játék </th>
					<th> Játékos </th>
					<th> Értékelés </th>
				</tr> 
				<?php 
					
					if(isset($_POST['date'])) {$query = sprintf("SELECT * FROM ertekeles WHERE datum='%s'", mysqli_real_escape_string($link, $_POST['date']));}
					else {$query = "SELECT * FROM ertekeles WHERE datum=curdate()";}
					
					$result = mysqli_query($link, $query);
					
					while($row = mysqli_fetch_array($result)): 
				
					$jatek = mysqli_query($link, "SELECT cim FROM jatek WHERE id=" . mysqli_real_escape_string($link, $row['jatek_id']));
					$jateknev = mysqli_fetch_array($jatek);
					
					$jatekos = mysqli_query($link, "SELECT nev FROM jatekos WHERE id=" . mysqli_real_escape_string($link, $row['jatekos_id']));
					$jatekosnev = mysqli_fetch_array($jatekos);
				
				?>
					<tr>
						<td><?=$jateknev['cim']?></td>
						<td><?=$jatekosnev['nev']?></td>
						<td><?=$row['ertek']?></td>
					</tr>
				<?php endwhile; ?>
			</table>
			
			<?php mysqli_close($link) ?>
			
		</div>
	</body>
</html>