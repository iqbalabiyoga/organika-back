<?php

  include 'config.php';

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

  //fetch table rows from mysql db
  $search = $_GET['search'];
  $limit = $_GET['limit'];

  //get current time via SQL
  $query_waktu = mysqli_query($link, "SELECT NOW() AS now");
  $waktu=mysqli_fetch_assoc($query_waktu);

  $sql = "SELECT id_artikel, judul_artikel, isi_artikel, tanggal, nama_user_input, total_baca, total_komentar FROM artikel_view WHERE is_remove='N' AND isi_artikel LIKE '%$search%' ORDER BY id_artikel DESC LIMIT $limit, 5";

  $result = mysqli_query($link, $sql) or die("Error in Selecting " . mysqli_error($link));

  //create an array
  $emparray = array();
  while($row =mysqli_fetch_assoc($result))
  {
      $idartikel=$row['id_artikel'];
    $foto=mysqli_fetch_array(mysqli_query($link,"select path from tabel_gambar where id_artikel='$idartikel'"));
     $row['isi_artikel'] = rip_tags($row['isi_artikel']);
     $row['isi_artikel'] = preg_replace("/&#?[a-z0-9]{2,8};/i","",$row['isi_artikel']); 

    if(strlen($row['isi_artikel']) > 100){
      $row['isi_artikel'] = substr($row['isi_artikel'], 0,100)."...";
    } 
    
    // $row['isi_artikel'] = htmlspecialchars($row['isi_artikel']);
    // echo $row['judul_artikel'], " ", $row['isi_artikel'];
    //Send the time difference instead of the date
    $seconds  = strtotime($waktu['now']) - strtotime($row['tanggal']);
    $years = floor($seconds / (3600*24*30*12));
    $months = floor($seconds / (3600*24*30));
    $day = floor($seconds / (3600*24));
    $hours = floor($seconds / 3600);
    $mins = floor(($seconds - ($hours*3600)) / 60);
    $secs = floor($seconds % 60);

    if($seconds < 60)
        $time = $secs." detik yang lalu";
    else if($seconds < 60*60 )
        $time = $mins." menit yang lalu";
    else if($seconds < 24*60*60)
        $time = $hours." jam yang lalu";
    else if($seconds < 30*24*60*60)
        $time = $day." hari yang lalu";
    else if ($seconds < 12*30*24*60*60)
        $time = $months." bulan yang lalu";
    else
        $time = $years." tahun yang lalu";

    $row['tanggal'] = $time;
      $row['foto'] = $foto['path'];
      $emparray[] = $row;
  }
  echo json_encode($emparray);

  //close the db connection
  mysqli_close($link);

?>
