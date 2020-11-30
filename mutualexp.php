<?php 


if ($_SERVER["REQUEST_METHOD"] == "POST"){
	if (empty($_POST["firstname"])) {
    $firstnameE = "required";
  }else{
  	$firstname = $_POST["firstname"];
  	$whiteSpace = substr_count($firstname," ");
  	if (!preg_match($nameRE,$firstname) || $whiteSpace>1) {
      $firstnameE = "Enter Without space";
    }else{
      $firstname = $firstname;
    }
  }

  if (empty($_POST["lastname"])) {
    $lastnameE = "required";
  }else{
  	$lastname = $_POST["lastname"];
  	$whiteSpace = substr_count($lastname," ");
  	if (!preg_match($nameRE,$lastname) || $whiteSpace>1) {
      $lastname = "Enter Without space";
    }else{
       $lastName = $lastname;  	
    }
  }


  if (empty($_POST["email"])) {
    $emailE = "Email is required";
  }else{
  	$email = $_POST["email"];
  	if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailE = "Invalid Email";
    }else{
    	$email = $email;
    }
  }

  if (empty($_POST["password"])) {
    $passError = "Password is required";
  }else{
  	$password = $_POST["password"];
  	if (!preg_match($passRE,$password) || preg_match($specialcharRE,$password)) {
      $passError = "Password must contain an uppercase, a lowercase, a number between 8 to 20 characters and no special character";
    }else{
    	$DBpass = $password;
    }
  }

  if (empty($_POST["ip"])) {
    $ipError = "IP Address is required";
  }else{
  	$ip = $_POST["ip"];
  	if (!preg_match($ipRE,$ip)) {
      $ipError = "Invalid IP Address";
    }else{
    	$DBip = $ip;
    }
  }

  if (empty($_POST["url"])) {
    $urlError = "Personal URL is required";
  }else{
  	$url = $_POST["url"];
  	if (!preg_match($urlRE,$url)) {
      $urlError = "Invalid URL";
    }else{
    	$DBurl = $url;
    }
  }

  if (empty($_POST["birth"])) {
    $dobError = "Date of Birth is required";
  }else{
  	$dob = $_POST["birth"];

	$age = explode("-", $dob);
    $birthDay = (int)$age[0];
    $birthMonth = (int)$age[1];
    $birthYear = (int)$age[2];

    $currentTime=time();
    $Day = date("d",$currentTime);
	$Month = date("m",$currentTime);
	$Year = date("yy",$currentTime);
	$currentDay = (int)$Day;
	$currentMonth = (int)$Month;
	$currentYear = (int)$Year;

  	if (!preg_match($dobRE,$dob)) {
      $dobError = "Invalid Date of Birth";
    }else{

    	if($currentYear<$birthYear){
    		$dobError = "Invalid Date of Birth";
    	}elseif($currentYear==$birthYear){
    		if($currentMonth<$birthMonth){
    			$dobError = "Invalid Date of Birth";
    		}elseif($currentMonth==$birthMonth){
    			if($currentDay<$birthDay){
    				$dobError = "Invalid Date of Birth";
    			}
    		}
    	}else{
    		$DBage = $currentYear-$birthYear;

			if($currentMonth < $birthMonth) $DBage--;
			elseif ($currentMonth == $birthMonth) {
				if($currentDay < $birthDay) $DBage--;
			}
    	}

    }
  }

  if (empty($_POST["gender"])) {
    $genderError = "Gender is required";
  }else{
  	$DBgender = $_POST["gender"];
  }

  if (empty($_POST["mobile"])) {
    $mobileError = "Mobile Number is required";
  }else{
  	$mobile = $_POST["mobile"];
  	if (!preg_match($mobileRE,$mobile)) {
      $mobileError = "Invalid Mobile Number";
    }else{
    	$DBmobile = $mobile;
    }
  }

  if (empty($_POST["info"])) {
    $infoError = "Brief information is required";
  }else{
  	$info = $_POST["info"];
  	if (!preg_match($infoRE,$info)) {
      $infoError = "Can not contain more than 15 words";
    }else{
    	$DBinfo=preg_replace($cleanRE, '****', $info);
    }
  }


  if(!empty($DBfName) && !empty($DBlName) && !empty($DBemail) && !empty($DBpass) && !empty($DBip) && !empty($DBurl) && !empty($DBage) && !empty($DBgender) && !empty($DBmobile) && !empty($DBinfo)){


  	$conn = mysqli_connect("localhost","root","","fall2020");
  	if (!$conn) {
  		die("Failed to connect: " . mysqli_connect_error());
	}

	$username = $DBfName." ".$DBmName." ".$DBlName;
	$DBusername=preg_replace("/(\s\s*)/", " ", $username);

	$sql = "INSERT INTO user (username, email, password, ip, url, age, gender, mobile, info) VALUES ('$DBusername', '$DBemail', 'DBpass', '$DBip', '$DBurl', '$DBage', '$DBgender', '$DBmobile', '$DBinfo')";

	if (mysqli_query($conn, $sql)) {
	  echo "Registration successful <br>";
	} else {
	  echo "Error: " . mysqli_error($conn);
	}

	mysqli_close($conn);
} 


}


$fnameError = $lnameError = $emailError = $passError = $ipError = $urlError = $dobError = $genderError= $mobileError= $infoError = " ";

$DBfName =  $DBmName = $DBlName = $DBemail = $DBpass = $DBip = $DBurl = $DBage = $DBgender= $DBmobile= $DBinfo = "";

$nameRE = "/^[a-zA-Z(\s)?]{4,25}$/";

$passRE = "/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,20}$/";

$specialcharRE = "/[^a-zA-Z\d]/";

$ipRE = "/^\d{1,3}[\.]\d{1,3}[\.]\d{1,3}[\.]\d{1,3}$/";

$urlRE = "/^(?=((http|https)\:\/\/)|www\.)(.+\.)(org|com|edu|[a-z]{2})$/";

$dobRE = "/^([0-2][0-9]|[3][0-1])\-([0][0-9]|[1][0-2])\-[0-9]{4}$/";

$mobileRE ="/^[0][1]\d{9}$/";

$infoRE = "/^(\w+\s){0,14}\w+$/";

$cleanRE = '/(Damn)|(Kill)|(Death)|(Liar)/i';

?>