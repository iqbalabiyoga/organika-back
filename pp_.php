<?php
	include 'config.php';

	$id = $_GET['id'];


	$get = mysqli_fetch_assoc(mysqli_query($link, "SELECT max(tanggal_foto), nama_foto FROM `user_foto` WHERE id_user = $id"));

	echo json_encode($get);
?>