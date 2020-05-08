<?php
include 'db.php';
if(isset($_GET['id']))
{
	$link = opendb();
	$id = $_GET['id'];
	
	$result1 = mysqli_query($link, "SELECT jatekos_id FROM ertekeles WHERE id=" . mysqli_real_escape_string($link, $id));
	$jatekos = mysqli_fetch_assoc($result1);
	$user_id = $jatekos['jatekos_id'];
	
	// Ez a lekérdezés a visszatéréshez kell.
	$result2 = mysqli_query($link, "SELECT jatek_id FROM ertekeles WHERE id=" . mysqli_real_escape_string($link, $id));
	$jatek = mysqli_fetch_assoc($result2);
	$game_id = $jatek['jatek_id'];
	
	// Ellenőrizzük, hogy a kapott id-vel rendelkező értékelés tényleg szerepel-e az értékelés táblában.
	if(mysqli_num_rows($result1) > 0)
	{
		$query = "DELETE FROM ertekeles WHERE id=" . mysqli_real_escape_string($link, $id);
		mysqli_query($link, $query);
		mysqli_close($link);
		
		// Arra az oldalra tér vissza, ahonnan meghívták:
		
		if($_GET['vissza'] == "game") {$id=$game_id;}
		else {$id=$user_id;}
		
		header("Location:" . $_GET['vissza'] . ".php?id=" . $id);
	}
	else echo "Nincs ilyen adat.";
}

?>