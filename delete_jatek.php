<?php
include 'db.php';
if(isset($_GET['id']))
{
	$link = opendb();
	$id = $_GET['id'];
	$result = mysqli_query($link, "SELECT id FROM jatek WHERE id=" . mysqli_real_escape_string($link, $id));
	
	// Ellenőrizzük, hogy a kapott id-vel rendelkező játék tényleg szerepel-e az játék táblában.
	if(mysqli_num_rows($result) > 0)
	{
		// Mielőtt kitörölhetnénk a játékot, törölnünk kell az összes olyan értékelést, ami rá hivatkozik!
		$query1 = "DELETE FROM ertekeles WHERE jatek_id=" . mysqli_real_escape_string($link, $id);
		$query2 = "DELETE FROM jatek WHERE id=" . mysqli_real_escape_string($link, $id);
		mysqli_query($link, $query1);
		mysqli_query($link, $query2);
		mysqli_close($link);
		
		header("Location: jatek.php");
	}
	else echo "Nincs ilyen játék.";
}

?>