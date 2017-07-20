<?php

  include 'config.php';
  include 'indonesian_date.php';

  function rip_tags($string) { 
    
    // ----- remove HTML TAGs ----- 
    $string = preg_replace ('/<[^>]*>/', ' ', $string); 
    
    // ----- remove control characters ----- 
    $string = str_replace("\r", '', $string);    // --- replace with empty space
    $string = str_replace("\n", ' ', $string);   // --- replace with space
    $string = str_replace("\t", ' ', $string);   // --- replace with space
    
    // ----- remove multiple spaces ----- 
    $string = trim(preg_replace('/ {2,}/', ' ', $string));
    
    return $string; 
  }

  $limit = $_GET['limit'];
  //get current time via SQL
  $query_waktu = mysqli_query($link, "SELECT NOW() AS now");
  $waktu=mysqli_fetch_assoc($query_waktu);

  $sql = "SELECT * from kegiatan";
    

  $result = mysqli_query($link, $sql) or die("Error in Selecting " . mysqli_error($link));

  //create an array
  $emparray = array();
  while($row =mysqli_fetch_assoc($result))
  {
    $idpost=$row['id_post'];
      $idpengguna=$row['pengguna_id_pengguna'];
      $pengguna=mysqli_fetch_assoc(mysqli_query($link, "select * from pengguna where id_pengguna='$idpengguna'"));
      $nama=$pengguna['nama'];
    $row['isi'] = rip_tags($row['isi']);
    $row['isi'] = preg_replace("/&#?[a-z0-9]{2,8};/i","",$row['isi']); 

    
      
      
    $row['pengguna']=$nama;  
    $row['timestamp'] = indonesian_date($row['timestamp']);
    $emparray[] = $row;
  }
  echo json_encode($emparray);

  //close the db connection
  mysqli_close($link);




?>
