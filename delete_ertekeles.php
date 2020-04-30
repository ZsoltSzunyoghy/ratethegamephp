<?php
include 'db.php';
if(isset($_GET['id']))
{
	$link = opendb();
	$id = $_GET['id'];
	$result = mysqli_query($link, "SELECT jatekos_id FROM ertekeles WHERE id=" . mysqli_real_escape_string($link, $id));
	$jatekos = mysqli_fetch_assoc($result);
	$user_id = $jatekos['jatekos_id'];
	
	
	if(mysqli_num_rows($result) > 0)
	{
		$query = "DELETE FROM ertekeles WHERE id=" . mysqli_real_escape_string($link, $id);
		mysqli_query($link, $query);
		mysqli_close($link);
		
		header("Location: user.php?id=" . $user_id);
	}
	else echo "Nincs ilyen adat.";
}

?>