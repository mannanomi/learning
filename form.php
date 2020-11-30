<?php 


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

if ($_SERVER["REQUEST_METHOD"] == "POST"){
	if (empty($_POST["fname"])) {
    $fnameError = "First name is required";
  }else{
  	$fname = $_POST["fname"];
  	$whiteSpace = substr_count($fname," ");
  	if (!preg_match($nameRE,$fname) || $whiteSpace>1) {
      $fnameError = "More than 4 to 25 characters can be allowed and one white space can be allowed between two words in first name";
    }else{
      $DBfName = $fname;
    }
  }

  if(!empty($_POST["mname"])){
  	$DBmName = $_POST["mname"];
  }

  if (empty($_POST["lname"])) {
    $lnameError = "Last name is required";
  }else{
  	$lname = $_POST["lname"];
  	$whiteSpace = substr_count($lname," ");
  	if (!preg_match($nameRE,$lname) || $whiteSpace>1) {
      $lnameError = "More than 4 to 25 characters can be allowed and one white space can be allowed between two words in last name";
    }else{
       $DBlName = $lname;  	
    }
  }


  if (empty($_POST["email"])) {
    $emailError = "Email is required";
  }else{
  	$email = $_POST["email"];
  	if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailError = "Invalid Email";
    }else{
    	$DBemail = $email;
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




?>

<!DOCTYPE html>
<html>
<head>
	<title>Form</title>

	<style type="text/css">
		.error{
			color: red;
		}
		form{
			margin-top: 10px;
		}
		input, .text-area{
			margin-bottom: 15px;
			margin-right: 5px;
		}

	</style>
</head>
<body>

	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
		<label for="fname">First Name:</label>
		<input type="text" name="fname" id="fname">
		<label for="mname">Middle Name:</label>
		<input type="text" name="mname" id="mname">
		<label for="lname">Last Name:</label>
		<input type="text" name="lname" id="lname">
		<span class="error">* <?php echo $fnameError; if($fnameError!=" " && $lnameError!=" " )echo " & "; echo $lnameError?></span>

		<br>

		<label for="email">Email:</label>
		<input type="text" name="email" id="email">
		<span class="error">* <?php echo $emailError;?></span>

		<br>

		<label for="pass">Password:</label>
		<input type="password" name="password" id="pass">
		<span class="error">* <?php echo $passError;?></span>

		<br>

		<label for="ip">IP Address:</label>
		<input type="text" name="ip" id="ip">
		<span class="error">* <?php echo $ipError;?></span>

		<br>

		<label for="url">Personal web URL:</label>
		<input type="text" name="url" id="url">
		<span class="error">* <?php echo $urlError;?></span>

		<br>

		<label for="birth">Date of Birth:</label>
		<input type="text" name="birth" id="birth" placeholder="dd-mm-yyyy">
		<span class="error">* <?php echo $dobError;?></span>

		<br>
		<label>Gender:</label>
		<input type="radio" name="gender" id="male" value="male">
		<label for="male">Male</label>
		<input type="radio" name="gender" id="female" value="female">
		<label for="female">Female</label>
		<span class="error">* <?php echo $genderError;?></span>

		<br>

		<label for="phone">Mobile Number:</label>
		<input type="text" name="mobile" id="phone" placeholder="017********">
		<span class="error">* <?php echo $mobileError;?></span>

		<br>
	<div class="text-area">	
		<label for="brief">Brief Info:</label>
		<textarea name="info" rows="3"></textarea>
		<span class="error">* <?php echo $infoError;?></span>
	</div>
		<br>

		<input type="submit" name="register" value="Register Button">

	</form>

</body>
</html>