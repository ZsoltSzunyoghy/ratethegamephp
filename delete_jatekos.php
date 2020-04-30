<?php
include 'db.php';
if(isset($_GET['id']))
{
	$link = opendb();
	$id = $_GET['id'];
	$result = mysqli_query($link, "SELECT id FROM jatekos WHERE id=" . mysqli_real_escape_string($link, $id));
	
	if(mysqli_num_rows($result) > 0)
	{
		$query = "DELETE FROM jatekos WHERE id=" . mysqli_real_escape_string($link, $id);
		mysqli_query($link, $query);
		mysqli_close($link);
		
		header("Location: jatekos.php");
	}
	else echo "Nincs ilyen játékos.";
}

?>