<?php
	
	include 'config.php';

	$postdata = file_get_contents("php://input");

	if($postdata){
		$data = json_decode($postdata);

		$username = $data->username;
		$password = $data->password;
		$nama_user = $data->nama;
		$email = $data->email;
		$passconf = $data->password2;

		$captchaBypass = true;
		$keterangan = "";

		$url = "http://cybex.ipb.ac.id/index.php/user/daftar_proses";
		$data = array("username" => $username, "password" => $password, "passconf" => $passconf,
			          "nama_user" => $nama_user, "email_user" => $email, "g-recaptcha-response" => $captchaBypass,
			          "keterangan" => $keterangan);

		// echo json_encode($data);

		$options = array(
	        'http' => array(
	            'header'  => "Content-Type: application/x-www-form-urlencoded\r\n",
	            'method'  => 'POST',
	            'content' => http_build_query($data)
	        )
	    );
	    $context  = stream_context_create($options);
	    $result =  file_get_contents($url, false, $context);

	    echo json_encode($result);

	}

?>