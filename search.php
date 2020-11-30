<!DOCTYPE html>
<html>
<head>
	<title>Search from table</title>
</head>


<body>

<center>
	
<div class="container">
	<form action=" " method="POST">
		
     <input type="text" name="firstname" placeholder="Enter First Name" >
     <input type="submit" name="search" value="SEARCH">

	</form>
	<table align="center" border="1px" style="width:1000px; line-height:40px;">
		

        <tr> 
		<th colspan="9"><h2>User Informations</h2></th> 
		</tr> 

		<tr>
		
			  <th> FirstName </th> 
			  <th> LastName </th> 
			  <th> Email </th>
			  <th> IP </th> 
			  <th> Website </th>
			  <th> Date of Birth </th> 
			  <th> Gender </th> 
			  <th> Mobile </th>
			  <th> Info </th>	  
			  
		</tr> <br>
        <?php
        $connection = mysqli_connect("localhost","root","");
        $db = mysqli_select_db($connection,'fall2020');

        if(isset($_POST['search']))
        {
        	$firstname = $_POST['firstname'];
        	$query = "SELECT *FROM `users` where firstname='$firstname' ";
        	$query_run = mysqli_query($connection,$query);

        	while ($row = mysqli_fetch_array($query_run))
        	 {
        		?>
        		<tr>
        			<td> <?php echo $row['firstname']; ?> </td>
        			<td> <?php echo $row['lastname']; ?> </td>
        			<td> <?php echo $row['email']; ?> </td>
        			<td> <?php echo $row['ipid']; ?> </td>
        			<td> <?php echo $row['urll']; ?> </td>
        			<td> <?php echo $row['bday']; ?> </td>
        			<td> <?php echo $row['gender']; ?> </td>
        			<td> <?php echo $row['phonenumber']; ?> </td>
        			<td> <?php echo $row['infoo']; ?> </td>

        		</tr>
                <?php
        	}
        }
         ?>

	        </table>
       </div>
      </center>

</body>
</html>