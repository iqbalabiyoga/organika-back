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


  $sql = "SELECT * from aliran_dana";
    

  $result = mysqli_query($link, $sql) or die("Error in Selecting " . mysqli_error($link));

  //create an array
  $emparray = array();
  while($row =mysqli_fetch_assoc($result))
  {
      
      $idpengguna=$row['pengguna_id_pengguna'];
      $idorganisasi=$row['kegiatan_organisasi_id_organisasi'];
      $iddivisi=$row['kegiatan_Divisi_id_divisi'];
      $idkegiatan=$row['kegiatan_id_kegiatan'];
      $kegiatan=mysqli_fetch_assoc(mysqli_query($link,"select * from kegiatan where id_kegiatan='$idkegiatan'"));
      $organisasi=mysqli_fetch_assoc(mysqli_query($link,"select * from organisasi where id_organisasi='$idorganisasi'"));
      $pengguna=mysqli_fetch_assoc(mysqli_query($link,"select * from pengguna where id_pengguna='$idpengguna'"));
      $divisi=mysqli_fetch_assoc(mysqli_query($link,"select * from divisi where organisasi_id_organisasi='$idorganisasi' and id_divisi='$iddivisi'"));
      $row['namakegiatan']=$kegiatan['nama_kegiatan'];
      $row['namadivisi']=$divisi['nama_divisi'];
      $row['pengguna']=$pengguna['nama'];
      $row['jumlah']=rupiah($row['jumlah']);
    if($row['tipe']==0){
        $row['jenis']='keluar';
    }
      
      else $row['jenis']='masuk';
    $row['timestamp'] = indonesian_date($row['timestamp']);
    $emparray[] = $row;
  }
  echo json_encode($emparray);
  //close the db connection
  mysqli_close($link);




?>
