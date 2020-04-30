<!DOCTYPE html>
<html>
	<head>
		<title> Társasjáték értékelő </title>
		<link rel="stylesheet" type="text/css" href="style.css"> 
	</head>
	<body>
		<div id="menu">
		<?php include("menu.php"); ?>
		</div>
		
		<div id="tartalom">
		<h1> Értékelő </h1>
		
		<form action="ertekelo.php" method="post">
			<p>
				Hogy hívnak? <input type="text" name="nev" value="<?php if(isset($_GET['nev'])) {echo $_GET['nev'];}?>" />
            </p>
            <p>
				Játék: <select id="jatek" name="jatek" value="<?php if(isset($_GET['jatek'])) {echo $_GET['jatek'];}?>">
				<?php
					include("db.php");
					$link = opendb();
			
					$result = mysqli_query($link, "SELECT id, cim FROM jatek");
				while($row = mysqli_fetch_array($result)):
				?>
						<option value=<?=$row['id']?>><?=$row['cim']?> </option>
				<?php 
					endwhile; 
					mysqli_close($link);
				?>
				</select>
            </p>
			<p>
				Értékelésed: 
					<input type="radio" name="ertek" value=1> 1 </input>
					<input type="radio" name="ertek" value=2> 2 </input>
					<input type="radio" name="ertek" value=3> 3 </input>
					<input type="radio" name="ertek" value=4> 4 </input>
					<input type="radio" name="ertek" value=5> 5 </input>
					<input type="radio" name="ertek" value=6> 6 </input>
					<input type="radio" name="ertek" value=7> 7 </input>
					<input type="radio" name="ertek" value=8> 8 </input>
					<input type="radio" name="ertek" value=9> 9 </input>
					<input type="radio" name="ertek" value=10> 10 </input>
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
			header("Location: index.php");
		}
		
		else
		{
			echo "Nincs ilyen játékos az adatbázisban.";
			mysqli_close($link);
		}
		
		mysqli_close($link);
		
	}
?>