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
			
				<form action="insert_jatekos.php" method="post">
				
					<h1 id="cim">
					<?php
						if(isset($_GET['id'])) {echo "Szerkesztés"; $szerk = $_GET['id'];}
						else {echo "Új játékos";}
					?>
					</h1>
					
					<?php if(isset($_GET['id'])) { ?>
						<!-- Ez a rész a kijelzőn nem jelenik meg, arra szolgál, hogy a form elküldése után a program eldöntse, hogy szerkesztésről van-e szó. -->
						<input type="hidden" name="id" value="<?php echo $_GET['id'];?>" />
					<?php } ?>
					
					<!-- Szerkesztés esetén az oldal kap alapértelmezett értékeket a beviteli mezőknek, amik itt jutnak érvényesülésre: -->
					<p>
						Név: <input type="text" name="nev" value="<?php if(isset($_GET['nev'])) {echo $_GET['nev'];}?>" />
					</p>
					<p>
						Email cím:: <input type="text" name="email" value="<?php if(isset($_GET['email'])) {echo $_GET['email'];}?>" />    
					</p>
					<p>
						Megjegyzés: <input type="text" name="megjegyzes" value="<?php if(isset($_GET['megjegyzes'])) {echo $_GET['megjegyzes'];}?>" />    
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
						
						// Ez a lekérdezés annak az ellenőrzéséhez szükséges, hogy szerepel-e már megadott nevű játékos az adatbázisban.
						$query0 = sprintf("SELECT id FROM jatekos WHERE nev='%s'", mysqli_real_escape_string($link, $_POST['nev']));
						$ellenorzes = mysqli_query($link, $query0);
						
						
						if(isset($_POST['id'])) //Szerkesztés -> Az ellenőrzés irreleváns, a létező adatot update-eli.
						{
							$upd= sprintf ("UPDATE jatekos SET nev = '%s', email = '%s', megjegyzes = '%s' WHERE id=",
								mysqli_real_escape_string($link, $_POST['nev']), 
								mysqli_real_escape_string($link, $_POST['email']), 
								mysqli_real_escape_string($link, $_POST['megjegyzes']));

							mysqli_query($link, $upd . mysqli_real_escape_string($link, $_POST['id']));
						}
							
						else // Új elem
						{
							if(mysqli_num_rows($ellenorzes) > 0)
							{
								// Ha a megadott játékosnév már létezik, arról figyelmeztetjük a felhasználót.
								mysqli_close($link);
								echo "Ilyen nevű játékos már létezik.";
							}
										
							else
							{
								
								$ins= sprintf( "INSERT INTO jatekos (nev, email, megjegyzes) VALUES('%s', '%s', '%s')", 
									mysqli_real_escape_string($link, $_POST['nev']), 
									mysqli_real_escape_string($link, $_POST['email']), 
									mysqli_real_escape_string($link, $_POST['megjegyzes']));

								mysqli_query($link, $ins);
							}
						}
						
						
						mysqli_close($link);
						header("Location: jatekos.php");
						
					}
				?>
			</div>
		</div>
    </body>

</html>
