<?php

  include 'config.php';

  $id_artikel = $_GET['idartikel'];

  //fetch table rows from mysql db
  $sql = "SELECT artikel_view.id_artikel, artikel_view.id_kategori, artikel_view.nama_kategori,
  artikel_view.judul_artikel, artikel_view.tanggal, artikel_view.id_user_input,
  artikel_view.nama_user_input,artikel_view.isi_artikel, artikel_komentar_view.isi_komentar, artikel_komentar_view.id_user,
  artikel_komentar_view.nama_user, artikel_komentar_view.tanggal_komentar from artikel_view,
  artikel_komentar_view where artikel_view.id_artikel='$id_artikel' and artikel_komentar_view.id_artikel=artikel_view.id_artikel";

  $result = mysqli_query($link, $sql) or die("Error in Selecting " . mysqli_error($link));

  //create an array
  $emparray = array();
  while($row =mysqli_fetch_assoc($result))
  {
      $emparray[] = $row;
  }
  echo json_encode($emparray);
  //$res1 =  escapeJsonString($res);
  //echo $res;

  //close the db connection
  mysqli_close($link);

?>
