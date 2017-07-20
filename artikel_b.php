<?php

  include 'config.php';

  $id_artikel = $_GET['idartikel'];
  $share = $_GET['share'];

  //fetch table rows from mysql db
  $sql = "SELECT id_artikel, id_kategori, nama_kategori, judul_artikel, tanggal, id_user_input,nama_user_input,isi_artikel, total_baca, total_komentar FROM artikel_view where id_artikel='$id_artikel'";
  $result = mysqli_query($link, $sql) or die("Error in Selecting " . mysqli_error($link));

  $query2 = mysqli_query($link, "INSERT INTO artikel_log (id_artikel, id_user, session_id) VALUES ('$id_artikel', 8, 'mobile');");

  //create an array
  $emparray = array();
$foto=mysqli_fetch_array(mysqli_query($link,"select path from tabel_gambar where id_artikel='$id_artikel'"));
  $format = array("/May/" => "Mei",
                  "/Aug/" => "Agu",
                  "/Oct/" => "Okt",
                  "/Dec/" => "Des"
                  );
  while($row =mysqli_fetch_array($result))
  {
    
      $row['tanggal'] = date_format(date_create($row['tanggal']),'d M Y');
      $row['tanggal'] = preg_replace(array_keys($format),array_values($format),$row['tanggal']);
      $row['foto'] = $foto['path'];

      if($_GET['share'])
        $emparray = $row;
      else
        $emparray[] = $row;
  }

  // print_r($emparray);
  echo json_encode($emparray);


  //close the db connection
  mysqli_close($link);

?>
