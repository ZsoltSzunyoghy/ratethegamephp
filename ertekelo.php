<!DOCTYPE html>
<html>
	<!-- Ez az oldal tartalmazza az értékelési metódus megvalósítását. Ide van beépítve az értékelésszerkesztés is, hiszen abban az esetben is ugyanazt a formot kell kitölteni. -->
	<head>
		<title> Társasjáték értékelő </title>
		<link rel="stylesheet" type="text/css" href="theme.css"> 
	</head>
	<body>
		<div id="keret">
			
		<?php include("menu.php"); include("db.php"); ?>
			<div id="tartalom">
			
				<h1 id="cim"> Értékelő </h1>
				
				<?php
					// Abban az esetben, ha nem új értékelést vesz fel a felhasználó, az oldal megkapja a szerkesztendő értékelés id-ját.
					// Ha ez történik, akkor az értékelés adatai a form alapértelmezett értékeiben eltárolódnak, és a rekord törlésre kerül. Ezután ugyanaz történik, mintha simán új értékelés történne.
					// Side note: Ez a megoldás azért lehetséges, mert az értékelés id-je nyugodtan megváltozhat. A játék és játékos szerkesztését már bonyolultabban oldottam meg.
					
					if(isset($_GET['id']))
					{
						
						$link = opendb();
						
						mysqli_query($link, "DELETE FROM ertekeles WHERE id=" . mysqli_real_escape_string($link, $_GET['id']));
						
						mysqli_close($link);
					}
				?>
				<!-- 
				Az értékelés adatait kéri be a rendszer az alábbi formon keresztül:
				Szerkesztés esetén, ami a beállított GET értékek esetén történik, a kitöltési mezők alapértelmezett értékeket kaptak. Ugyan ez történik akkor is, ha az értékelés egy adott játék vagy játékos oldaláról történik.
				-->

<?php
	
	
	if(isset($_POST['uj']))
	{
		if($_POST['jatek'] == 0)
		{
			// Abban az esetben, ha az értékelés játék kiválasztása nélkül lett elküldve, a rendszer figyelmezteti erre a felhasználót
			$hiba = "Kérlek válassz ki egy játékot!";
			//echo "Kérlek válassz ki egy játékot!";
		}
						
		else
		{
			$link = opendb();
							
			// Mielőtt a rendszer elmentené az értékelést, ellenőrzi, hogy a beírt nevű játékos szerepel-e az adatbázisban.
			$lekerdez = sprintf("SELECT id FROM jatekos WHERE nev='%s'", mysqli_real_escape_string($link, $_POST['nev']));
			$result = mysqli_query($link, $lekerdez);
							
			// Amennyiben nem, akkor a rendszer jelzi ezt a felhasználó felé, emellett megkérdezi, hogy szeretne-e létrehozni egy játékost az adott névvel.
			if(mysqli_num_rows($result) == 0)
			{
				$hiba2 = 1;
				mysqli_close($link);
			}
							
			// Ha igen, akkor megtörténik az értékelés elmentése.
			else
			{
				$jatekos = mysqli_fetch_assoc($result);
								
				$ins= sprintf( "INSERT INTO ertekeles (jatek_id, jatekos_id, datum, ertek) VALUES(%s, %s, curdate(), %s)", 
					mysqli_real_escape_string($link, $_POST['jatek']), 
					mysqli_real_escape_string($link, $jatekos['id']), 
					mysqli_real_escape_string($link, $_POST['ertek']));


				mysqli_query($link, $ins);
								
				mysqli_close($link);
							
							
				header("Location: user.php?id=" . $jatekos['id']);
			}
						
		}
						
	}
?>
				<form action="ertekelo.php" method="post">
					<p>
						Hogy hívnak? <input type="text" name="nev" value="<?php if(isset($_GET['nev'])) {echo $_GET['nev'];}?>" />
					</p>
					
					<p>
						<!-- A játék kiválasztása legördülő listából történik. -->
						Játék: <select id="jatek" name="jatek" >
						<?php
							
							$link = opendb();
					
							$result = mysqli_query($link, "SELECT id, cim FROM jatek ORDER BY cim");
							
							if(!isset($_GET['jatek']))
							{
						?>
								<option selected value=0> Válassz </option>
						<?php }
							while($row = mysqli_fetch_array($result)): ?>
								<option <?php if(isset($_GET['jatek']) and $_GET['jatek'] == $row['id']) { ?> selected <?php } ?> value=<?=$row['id']?>><?=$row['cim']?>  </option>
						<?php 
							endwhile; 
							mysqli_close($link);
						?></select>
						
						<!-- Itt szerepel egy gomb, mely egy új játék felvételének lehetőségét rejti arra az esetre, ha a felhasználó a legördülő menü tanulmányozásával jönne rá, hogy az általa értékelni kívánt játék még nem szerepel az adatbázisban. -->
						<a id="hibagomb" href="insert_jatek.php?>"> Új játék beszúrása </a>
					</p>
					
					<p>
						<!-- Az értékelés 1-10-es skálán történik -->
						Értékelésed: 
							<input id="radio" type="radio" name="ertek" value=1 <?php if (isset($_GET['ertek']) and $_GET['ertek']==1) { ?> CHECKED <?php } ?> > 1 </input>
							<input id="radio" type="radio" name="ertek" value=2 <?php if (isset($_GET['ertek']) and $_GET['ertek']==2) { ?> CHECKED <?php } ?> > 2 </input>
							<input id="radio" type="radio" name="ertek" value=3 <?php if (isset($_GET['ertek']) and $_GET['ertek']==3) { ?> CHECKED <?php } ?> > 3 </input>
							<input id="radio" type="radio" name="ertek" value=4 <?php if (isset($_GET['ertek']) and $_GET['ertek']==4) { ?> CHECKED <?php } ?> > 4 </input>
							<input id="radio" type="radio" name="ertek" value=5 <?php if (isset($_GET['ertek']) and $_GET['ertek']==5) { ?> CHECKED <?php } ?> > 5 </input>
							<input id="radio" type="radio" name="ertek" value=6 <?php if (isset($_GET['ertek']) and $_GET['ertek']==6) { ?> CHECKED <?php } ?> > 6 </input>
							<input id="radio" type="radio" name="ertek" value=7 <?php if (isset($_GET['ertek']) and $_GET['ertek']==7) { ?> CHECKED <?php } ?> > 7 </input>
							<input id="radio" type="radio" name="ertek" value=8 <?php if (isset($_GET['ertek']) and $_GET['ertek']==8) { ?> CHECKED <?php } ?> > 8 </input>
							<input id="radio" type="radio" name="ertek" value=9 <?php if (isset($_GET['ertek']) and $_GET['ertek']==9) { ?> CHECKED <?php } ?> > 9 </input>
							<input id="radio" type="radio" name="ertek" value=10 <?php if (isset($_GET['ertek']) and $_GET['ertek']==10) { ?> CHECKED <?php } ?> > 10 </input>
					</p>
					<p> 
						<input id="submit" type="submit" value="Értékelés" name="uj" />
					</p>
				</form>
				
				<?php 
				if(isset($hiba)) {echo $hiba;} 
				
				if(isset($hiba2)) 
				{
				?>
				
					<p>
						Nincs ilyen játékos az adatbázisban. Szeretnél létrehozni egyet?
										
						<a id="hibagomb" href="insert_jatekos.php?nev=<?=$_POST['nev']?>"> Igen </a>
						<a id="hibagomb" href="ertekelo.php?nev=<?=$_POST['nev']?>&jatek=<?=$_POST['jatek']?>&ertek=<?=$_POST['ertek']?>"> Nem </a>
					</p>
				
				<?php } ?>
				
			</div>
		</div>
	</body>
</html>

