<?php

  include 'config.php';

  // get JSON input from HTTP POST
  $postdata = file_get_contents("php://input");

  if ($postdata){
      // JSON Decode from input
      $request = json_decode($postdata);
			$id_user = $request->id_user;
			$nama_user = $request->nama_user;
			$email_user = $request->email_user;
			$ket_user = NULL;
			$id_kategoriuser = 3;
			$username = $request->username;
			$password = $request->password;
			
			$isiketerangan = $request->keterangan;

			$isiketerangan2 = nl2br($isiketerangan);
			$isi_keterangan = '<p>'.$isiketerangan2.'</p>';

      
      $id_user_input = $request->id_user_input;

			$query = mysqli_query($link, "INSERT INTO user (id_user, nama_user, email_user, ket_user, id_kategoriuser, username, password, keterangan, is_remove) VALUES ('', '$nama_user', '$email_user', );");

      // avoid print unless username & password is set
      if ($query){
          echo "sukses";
      }
      else {
          echo "gagal";
      }
  }
  else echo "gagal koneksi";

?>
