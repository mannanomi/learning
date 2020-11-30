<?php
require_once('config.php');
?>
<?php

if(isset($_POST)){

	$firstname 		= $_POST['firstname'];
	$lastname 		= $_POST['lastname'];
	$email 			= $_POST['email'];
	$password 		= sha1($_POST['password']);
	$ipid       	= $_POST['ipid'];
	$urll        	= $_POST['urll'];
	$bday       	= $_POST['bday'];
	$gender     	= $_POST['gender'];
	$phonenumber	= $_POST['phonenumber'];
	$infoo       	= $_POST['infoo'];

		$sql = "INSERT INTO users (firstname, lastname, email, password, ipid , urll , bday , gender , phonenumber ,infoo ) VALUES(?,?,?,?,?,?,?,?,?,?)";
		$stmtinsert = $db->prepare($sql);
		$result = $stmtinsert->execute([$firstname, $lastname, $email, $password, $ipid, $urll, $bday, $gender, $phonenumber, $infoo]);
		if($result){
			echo 'Successfully saved.';
		}else{
			echo 'There were erros while saving the data.';
		}
}else{
	echo 'No data';
}