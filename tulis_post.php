<?php
	
	// get JSON input from HTTP POST
  $postdata = file_get_contents("php://input");
	
  if ($postdata){
      // JSON Decode from input
      $request = json_decode($postdata);
      $subjek = $request->subjek;
			$isiartikel = $request->isi;

			$isiartikel2 = nl2br($isiartikel);
			$isi_artikel = '<p>'.$isiartikel2.'</p>';

      
      $pengguna = $request->idpengguna;
    

     
			$query2 = mysqli_query($link, "INSERT INTO ruang_diskusi (subjek, isi, timestamp, pengguna_id_pengguna) VALUES ('$subjek', '$isi', NOW(), '1');");
     
          $arr = array(
            'status' => true,
            'message' => 'sukses'
          );
          echo json_encode($arr);
      }
      else {
          $arr = array(
            'status' => false,
            'message' => 'gagal'
          );
          echo json_encode($arr);
      }
  }
  else{
      $arr = array(
        'status' => false,
        'message' => 'koneksi gagal'
      );
      echo json_encode($arr);
  }

?>