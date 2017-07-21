<?php
  include 'config.php';
 include 'indonesian_date.php';
  $idpost = $_GET['id'];
  //fetch table rows from mysql db
  $sql = "SELECT * from ruang_diskusi where id_post=$idpost";
  $result = mysqli_query($link, $sql) or die("Error in Selecting " . mysqli_error($link));

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