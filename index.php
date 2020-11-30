<?php 
include_once('connection.php'); 
$query="select * from users"; 
$result=mysql_query($query); 
?> 
<!DOCTYPE html> 
<html> 
	<head> 
		<title> Data From Database </title> 
	</head> 
	<body> 
	<table align="center" border="1px" style="width:600px; line-height:40px;"> 
	<tr> 
		<th colspan="4"><h2>User</h2></th> 
		</tr> 
		
			  <th> FName </th> 
			  <th> LName </th> 
			  <th> Email </th>
			  <th> IP </th> 
			  <th> URL </th>
			  <th> Date of Birth </th> 
			  <th> Gender </th> 
			  <th> Mobile </th>
			  <th> Info </th> 
			  
			  
		</tr> 
		
		<?php while($rows=mysql_fetch_assoc($users)) 
		{ 
		?> 
		<tr>
		<td><?php echo $rows['firstname']; ?></td> 
		<td><?php echo $rows['lastname']; ?></td> 
		<td><?php echo $rows['email']; ?></td> 
		<td><?php echo $rows['ipid']; ?></td>
		<td><?php echo $rows['urll']; ?></td> 
		<td><?php echo $rows['bday']; ?></td> 
		<td><?php echo $rows['gender']; ?></td> 
		<td><?php echo $rows['phonenumber']; ?></td> 
		<td><?php echo $rows['infoo']; ?></td>  
		</tr> 
	<?php 
               } 
          ?> 

	</table> 
	</body> 
	</html>