<!DOCTYPE html>
<html>
	<!-- Ez az oldal valósítja meg az értékelések dátum alapján történő kilistázását. -->

	<head>
		<title> Társasjáték értékelő </title>
		<link rel="stylesheet" type="text/css" href="theme.css"> 
	</head>
	<body>
		<div id="keret">
			<?php  include("menu.php"); ?>
			<div id="tartalom">
				
				<?php 
					include("db.php");
					$link = opendb();
					
					// Ez a lekérdezés a másik dátum kiválasztásánál lévő legördülő menühöz szükséges, hogy minden dátum választási lehetőség legyen, amikorról az adatbázis értékelést tárol.
					$query1 = "SELECT count(id), datum FROM ertekeles GROUP BY datum ORDER BY datum DESC";
					$res = mysqli_query($link, $query1);
				?>
				
				<h1 id="cim"> Értékelések ezen a napon: 
				<?php 
					if(isset($_POST['date'])) {echo $_POST['date'];}
					else {echo date('Y-m-d');}
				?>
				</h1>
				
				<p>
					<!-- 
					Az alapértelmezett beállítás az aktuális dátum, tehát az aznapi értékelések listázása.
					Másik dátumot a felhasználó legördülő menüből választhat, a listázás a mellette lévő submit gomb megnyomása után valósul meg.
					-->
					<form action="datum.php" method="post">
						
						Másik dátum: <select id="date" name="date" >
								<option selected value=0> Válassz </option>
							
							<?php while($sor = mysqli_fetch_array($res)): ?>
								<option value=<?=$sor['datum']?>><?=$sor['datum']?>  </option>
							<?php endwhile; ?>
						</select>
						
						<input id="submit" type="submit" value="Listázás" name="uj" />
					</form>
				</p>
				
				<?php 
					// Adott dátumhoz tartozó értékelések lekérdezése:
					if(isset($_POST['date'])) {$query = sprintf("SELECT * FROM ertekeles WHERE datum='%s'", mysqli_real_escape_string($link, $_POST['date']));}
					else {$query = "SELECT * FROM ertekeles WHERE datum=curdate()";} // Alapértelmezett az aktuális dátum.
								
					$result = mysqli_query($link, $query);
					
					//Ha az aktuális dátumhoz még nincs értékelés:			
					if(mysqli_num_rows($result) == 0) {echo "Még nincs mai értékelés.";} 
					else
					{
				?>
				
						<table>
							<tr>
								<th> Játék </th>
								<th> Játékos </th>
								<th> Értékelés </th>
							</tr> 
							<?php 
								
								while($row = mysqli_fetch_array($result)): 
							
								// Az értékeléseket tartalmazó tábla csak id-val hivatkozik az értékeléshez tartozó játékra és játékosra.
								// Ezért minden sorban az id alapján lekérdezi a program az adott id-khoz tartozó játék és játékos nevét.
							
								$jatek = mysqli_query($link, "SELECT cim FROM jatek WHERE id=" . mysqli_real_escape_string($link, $row['jatek_id']));
								$jateknev = mysqli_fetch_array($jatek);
								
								$jatekos = mysqli_query($link, "SELECT nev FROM jatekos WHERE id=" . mysqli_real_escape_string($link, $row['jatekos_id']));
								$jatekosnev = mysqli_fetch_array($jatekos);
							
							?>
								<tr>
									<td><?=$jateknev['cim']?></td>
									<td><?=$jatekosnev['nev']?></td>
									<td  id="szam"><?=$row['ertek']?></td>
								</tr>
							<?php endwhile; ?>
						</table>
				
				<?php 
					} 
					mysqli_close($link);
				?>
				
			</div>
		</div>
	</body>
</html>