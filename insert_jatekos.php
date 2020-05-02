<html>
<div id="keret">
   <head>
		<title> Társasjáték értékelő </title>
		<link rel="stylesheet" type="text/css" href="theme.css"> 
	</head>
    <body>
	
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
					<input type="hidden" name="id" value="<?php echo $_GET['id'];?>" />
				<?php } ?>
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
					
					$query0 = sprintf("SELECT id FROM jatekos WHERE nev='%s'", mysqli_real_escape_string($link, $_POST['nev']));
					$ellenorzes = mysqli_query($link, $query0);
							
					if(mysqli_num_rows($ellenorzes) > 0)
					{
						mysqli_close($link);
						echo "Ilyen nevű játékos már létezik.";
					}
							
					else
					{
					
					
						if(isset($_POST['id']))
						{
							$upd= sprintf ("UPDATE jatekos SET nev = '%s', email = '%s', megjegyzes = '%s' WHERE id=",
								mysqli_real_escape_string($link, $_POST['nev']), 
								mysqli_real_escape_string($link, $_POST['email']), 
								mysqli_real_escape_string($link, $_POST['megjegyzes']));

							mysqli_query($link, $upd . mysqli_real_escape_string($link, $_POST['id']));
						}
						
						else
						{
							$ins= sprintf( "INSERT INTO jatekos (nev, email, megjegyzes) VALUES('%s', '%s', '%s')", 
								mysqli_real_escape_string($link, $_POST['nev']), 
								mysqli_real_escape_string($link, $_POST['email']), 
								mysqli_real_escape_string($link, $_POST['megjegyzes']));

							mysqli_query($link, $ins);
							
						}
						
						
						$idresult = mysqli_query($link, "SELECT id FROM jatekos WHERE nev='" . $_POST['nev'] . "'");
						$userid = mysqli_fetch_assoc($idresult);
						
						echo  $userid['id'];
						
						mysqli_close($link);
						header("Location: user.php?id=" . $userid['id']);
					}
				}
			?>
		</div>
    </body>

</html>
