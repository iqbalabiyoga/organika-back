<?php

  include 'config.php';


  // get JSON input from HTTP POST
  $postdata = file_get_contents("php://input");

  if ($postdata){
    
      // JSON Decode from input
      $request = json_decode($postdata);
			$id_artikel = $request->id_artikel;
			$isikomentar = $request->isi_komentar;

			$isikomentar2 = nl2br($isikomentar);
			$isi_komentar = '<p>'.$isikomentar2.'</p>';

      
      $id_user_input = $request->id_user_input;

			$query = mysqli_query($link, "INSERT INTO artikel_komentar (id_user, isi_komentar, id_artikel, status) VALUES ('$id_user_input', '$isi_komentar', '$id_artikel', 1);");

      // avoid print unless username & password is set
      if ($query){
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
