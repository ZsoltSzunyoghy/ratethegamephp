<!DOCTYPE html>

<html>
    <head><title>  </title></head>
    <body>
	
		
        <form action="insert_jatek.php" method="post">
			<h1>
			<?php
				if(isset($_GET['id'])) {echo "Szerkesztés"; $szerk = $_GET['id'];}
				else {echo "Új játék"; $szerk = 0;}
			?>
			</h1>
            <p>
				Játék címe: <input type="text" name="cim" value="<?php if(isset($_GET['cim'])) {echo $_GET['cim'];}?>" />
            </p>
            <p>
				Szerző: <input type="text" name="szerzo" value="<?php if(isset($_GET['szerzo'])) {echo $_GET['szerzo'];}?>" />    
            </p>
			<p>
				Kiadó: <input type="text" name="kiado" value="<?php if(isset($_GET['kiado'])) {echo $_GET['kiado'];}?>" />    
            </p>
			<p>
				Játékidő: <input type="text" name="jatekido" value="<?php if(isset($_GET['jatekido'])) {echo $_GET['jatekido'];}?>" />   
            </p>
			<p>
				Korhatár: <input type="text" name="korhatar" value="<?php if(isset($_GET['korhatar'])) {echo $_GET['korhatar'];}?>" />   
            </p>
			<p>
				Játékosszám: <input type="text" name="jatekosszam" value="<?php if(isset($_GET['jatekosszam'])) {echo $_GET['jatekosszam'];}?>" />   
            </p>
			<p>
				Összetettség: <input type="text" name="osszetettseg" value="<?php if(isset($_GET['osszetettseg'])) {echo $_GET['osszetettseg'];}?>" />   
            </p>
            <p> 
                <input type="submit" value="OK" name="uj" />
            </p>
        </form>
		
    </body>
</html>

<?php
	if(isset($_POST['uj']))
	{
		include("db.php");
		$link = opendb();
		
		if($szerk != 0)
		{
			
			$upd= sprintf ("UPDATE jatek SET cim = '%s', szerzo = '%s', kiado = '%s', jatekido = '%s', korhatar = '%s', jatekosszam = '%s', osszetettseg = '%s'  WHERE id=",
				mysqli_real_escape_string($link, $_POST['cim']), 
				mysqli_real_escape_string($link, $_POST['szerzo']), 
				mysqli_real_escape_string($link, $_POST['kiado']), 
				mysqli_real_escape_string($link, $_POST['jatekido']), 
				mysqli_real_escape_string($link, $_POST['korhatar']), 
				mysqli_real_escape_string($link, $_POST['jatekosszam']),
				mysqli_real_escape_string($link, $_POST['osszetettseg']));
				
			mysqli_query($link, $upd . mysqli_real_escape_string($link, $szerk));
		}
		
		else
		{
			
			$ins= sprintf( "INSERT INTO jatek (cim, szerzo, kiado, jatekido, korhatar, jatekosszam, osszetettseg) VALUES('%s', '%s', '%s', '%s', '%s', '%s', '%s')", 
				mysqli_real_escape_string($link, $_POST['cim']), 
				mysqli_real_escape_string($link, $_POST['szerzo']), 
				mysqli_real_escape_string($link, $_POST['kiado']), 
				mysqli_real_escape_string($link, $_POST['jatekido']), 
				mysqli_real_escape_string($link, $_POST['korhatar']), 
				mysqli_real_escape_string($link, $_POST['jatekosszam']),
				mysqli_real_escape_string($link, $_POST['osszetettseg']));
			echo $ins;
			mysqli_query($link, $ins);
			
		}
		mysqli_close($link);
		header("Location: jatek.php");
	}
?>