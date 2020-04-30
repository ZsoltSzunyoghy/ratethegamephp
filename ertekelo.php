<!DOCTYPE html>
<html>
	<head>
		<title> Társasjáték értékelő </title>
		<link rel="stylesheet" type="text/css" href="style.css"> 
	</head>
	<body>
		<div id="menu">
		<?php include("menu.php"); include("db.php"); ?>
		</div>
		
		<div id="tartalom">
		<h1> Értékelő </h1>
		
		<?php
			if(isset($_GET['id']))
			{
				
				$link = opendb();
				
				mysqli_query($link, "DELETE FROM ertekeles WHERE id=" . mysqli_real_escape_string($link, $_GET['id']));
				
				mysqli_close($link);
			}
		?>
		
		<form action="ertekelo.php" method="post">
			<p>
				Hogy hívnak? <input type="text" name="nev" value="<?php if(isset($_GET['nev'])) {echo $_GET['nev'];}?>" />
            </p>
            <p>
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
				?>
				</select>
            </p>
			<p>
				Értékelésed: 
					<input type="radio" name="ertek" value=1 <?php if (isset($_GET['ertek']) and $_GET['ertek']==1) { ?> CHECKED <?php } ?> > 1 </input>
					<input type="radio" name="ertek" value=2 <?php if (isset($_GET['ertek']) and $_GET['ertek']==2) { ?> CHECKED <?php } ?> > 2 </input>
					<input type="radio" name="ertek" value=3 <?php if (isset($_GET['ertek']) and $_GET['ertek']==3) { ?> CHECKED <?php } ?> > 3 </input>
					<input type="radio" name="ertek" value=4 <?php if (isset($_GET['ertek']) and $_GET['ertek']==4) { ?> CHECKED <?php } ?> > 4 </input>
					<input type="radio" name="ertek" value=5 <?php if (isset($_GET['ertek']) and $_GET['ertek']==5) { ?> CHECKED <?php } ?> > 5 </input>
					<input type="radio" name="ertek" value=6 <?php if (isset($_GET['ertek']) and $_GET['ertek']==6) { ?> CHECKED <?php } ?> > 6 </input>
					<input type="radio" name="ertek" value=7 <?php if (isset($_GET['ertek']) and $_GET['ertek']==7) { ?> CHECKED <?php } ?> > 7 </input>
					<input type="radio" name="ertek" value=8 <?php if (isset($_GET['ertek']) and $_GET['ertek']==8) { ?> CHECKED <?php } ?> > 8 </input>
					<input type="radio" name="ertek" value=9 <?php if (isset($_GET['ertek']) and $_GET['ertek']==9) { ?> CHECKED <?php } ?> > 9 </input>
					<input type="radio" name="ertek" value=10 <?php if (isset($_GET['ertek']) and $_GET['ertek']==10) { ?> CHECKED <?php } ?> > 10 </input>
			</p>
			<p> 
                <input type="submit" value="Értékelés" name="uj" />
            </p>
		</form>
		</div>
	</body>
</html>

<?php
	if(isset($_POST['uj']))
	{
		if($_POST['jatek'] == 0)
		{
			echo "Kérlek válassz ki egy játékot!";
		}
		
		else
		{
			$link = opendb();
			
			$lekerdez = sprintf("SELECT id FROM jatekos WHERE nev='%s'", mysqli_real_escape_string($link, $_POST['nev']));
			$result = mysqli_query($link, $lekerdez);
			
			if(mysqli_num_rows($result) > 0)
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
			
			else
			{
				echo "Nincs ilyen játékos az adatbázisban.";
				mysqli_close($link);
			}
			
		
		}
		
	}
?>