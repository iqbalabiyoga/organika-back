<?php

  include 'config.php';

  //fetch table rows from mysql db
  $sql = "SELECT id_komoditas, nama_komoditas FROM komoditas ORDER BY nama_komoditas";
  $result = mysqli_query($link, $sql) or die("Error in Selecting " . mysqli_error($link));

  //create an array
  $emparray = array();
  while($row =mysqli_fetch_assoc($result))
  {
      $emparray[] = $row;
  }
  echo json_encode($emparray);

  //close the db connection
  mysqli_close($link);

?>
