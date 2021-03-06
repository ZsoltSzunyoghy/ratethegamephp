<!DOCTYPE html>

<html>
	<!-- Ez az oldal valósítja meg egy új játékos beszúrását vagy egy már meglévő szerkesztését. -->
	
    <head>
		<title> Társasjáték értékelő </title>
		<link rel="stylesheet" type="text/css" href="theme.css"> 
	</head>
    <body>
		<div id="keret">
		
			<?php include("menu.php"); ?>
			
			<div id="tartalom">
		
				
				<form action="insert_jatek.php" method="post">
					<h1 id="cim">
					<?php
						if(isset($_GET['id'])) {echo "Szerkesztés";}
						else {echo "Új játék";}
					?>
					</h1>
					
					<?php if(isset($_GET['id'])) { ?>
						<!-- Ez a rész a kijelzőn nem jelenik meg, arra szolgál, hogy a form elküldése után a program eldöntse, hogy szerkesztésről van-e szó. -->
						<input type="hidden" name="id" value="<?php echo $_GET['id'];?>" />
					<?php } ?>
					
					<!-- Szerkesztés esetén az oldal kap alapértelmezett értékeket a beviteli mezőknek, amik itt jutnak érvényesülésre: -->
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
						<input id="submit" type="submit" value="OK" name="uj" />
					</p>
				</form>
				
				<?php
				if(isset($_POST['uj']))
				{
					include("db.php");
					$link = opendb();
					
					
					// Ez a lekérdezés annak az ellenőrzéséhez szükséges, hogy szerepel-e már megadott című játék az adatbázisban.
					$query0 = sprintf("SELECT id FROM jatek WHERE cim='%s'", mysqli_real_escape_string($link, $_POST['cim']));
					$ellenorzes = mysqli_query($link, $query0);
					
					
					
					if(isset($_POST['id'])) //Szerkesztés -> Az ellenőrzés irreleváns, a létező adatot update-eli.
					{
						
						$upd= sprintf ("UPDATE jatek SET cim = '%s', szerzo = '%s', kiado = '%s', jatekido = '%s', korhatar = '%s', jatekosszam = '%s', osszetettseg = '%s'  WHERE id=",
							mysqli_real_escape_string($link, $_POST['cim']), 
							mysqli_real_escape_string($link, $_POST['szerzo']), 
							mysqli_real_escape_string($link, $_POST['kiado']), 
							mysqli_real_escape_string($link, $_POST['jatekido']), 
							mysqli_real_escape_string($link, $_POST['korhatar']), 
							mysqli_real_escape_string($link, $_POST['jatekosszam']),
							mysqli_real_escape_string($link, $_POST['osszetettseg']));
								
						mysqli_query($link, $upd . mysqli_real_escape_string($link, $_POST['id']));
					}
						
					else // Új elem
					{
						if(mysqli_num_rows($ellenorzes) > 0)
						{
							// Ha a megadott játéknév már létezik, arról figyelmeztetjük a felhasználót.
							mysqli_close($link);
							echo "Ilyen nevű játék már létezik.";
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
							mysqli_query($link, $ins);
						}
							
					}
					mysqli_close($link);
					header("Location: jatek.php");
					
				}
				?>
			</div>
		</div>
    </body>

</html>

