<?php 
ini_set('max_execution_time', 3500);
include "db.php";
/*
$con = mysqli_connect("localhost","root","Qwerty1!","library");

							if (mysqli_connect_errno()) {
							  echo "Failed to connect to MySQL: " . mysqli_connect_error();
							  exit();
							}
	*/						
							{
							
							$query = "TRUNCATE table Borrower";
							$results = mysqli_query($con,$query);
							
$myfile = fopen("borrowers.csv","r");

$count = 0;

while(!feof($myfile)) {
	
	
  $temp = fgets($myfile);
  
  if($count>0)
  {
	  
	
	  
	echo '<br>{ Entry no: ' .$count. "} ";  
    $split_sentence = explode(',',$temp);
 
	$cardno = $split_sentence[0];
	$ssn = $split_sentence[1];
	$fname = $split_sentence[2];
	$lname = $split_sentence[3];
	$addr = $split_sentence[5] . $split_sentence[6]. $split_sentence[7];
	$phone = $split_sentence[8];
	
	
	$cardno = htmlspecialchars($cardno, ENT_QUOTES);
	$ssn = htmlspecialchars($ssn, ENT_QUOTES);
	$fname = htmlspecialchars($fname, ENT_QUOTES);
	$lname = htmlspecialchars($lname, ENT_QUOTES);
	$addr = htmlspecialchars($addr, ENT_QUOTES);
	$phone = htmlspecialchars($phone, ENT_QUOTES);
	$phone = trim($phone);
	
	
	$query = "insert into Borrower( card_id, ssn, Fname, Lname, Address, Phone) values ('$cardno','$ssn','$fname', '$lname', '$addr' , '$phone')";
	$results = mysqli_query($con,$query);
	
	}

  
 $count++;
 }
  
  
  
fclose($myfile);

}
					

?>