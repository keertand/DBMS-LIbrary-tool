

<?php 

$isbn = $_POST['flag1'];

$rs = "";

/*
$con = mysqli_connect("localhost","root","Qwerty1!","library");

							if (mysqli_connect_errno()) {
							  echo "Failed to connect to MySQL: " . mysqli_connect_error();
							  exit();
							}
							
*/							
include "db.php";

ini_set('max_execution_time', 300);



function checkintruder($query)
{
	if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $query) || $query=="")
	{
		return false;
	}
	else
	{
		return true;
	}
}


if(checkintruder($isbn))
{
	
	$query = "Select loan_id, due_date from book_loans where isbn = '$isbn' date_in=0";
	$results = mysqli_query($con,$query);
	
	while($row = mysqli_fetch_array($results))
	{
		$loan_id = $row['loan_id'];
		$dd=$row['due_date'];
		$d=strtotime($dd);
		date_default_timezone_set('US/Central');
        $c=date('Y-m-d h:i:sa',time());
		$temp=strtotime($c);
		$diff=($temp-$d)/(24*60*60);
		$days=ceil($diff);
		$fine=$days*0.25;
	}		

	
	$today = time();
	$query = "update book_loans set Date_in = CURRENT_TIMESTAMP where isbn='$isbn' and date_in = 0";
	$results = mysqli_query($con,$query);
		
	$query = "Select 1 from fines where loan_id = '$loan_id'";
	$results = mysqli_query($con,$query);
	$count = 0;
	while($row = mysqli_fetch_array($results))
	{
		$count = 1;
	}	
	
	if($count==0)
	{
		$query = "insert into fines (loan_id, fine_amt, Paid) values ('$loan_id','$fine',0)";
	}
	else
	{
		$query = "update fines set fine_amt = '$fine', paid = 0 where loan_id = '$loan_id'";
	}
	$results = mysqli_query($con,$query);
		
		
	$rs = 'CheckIn Successful';
}
else{
	$rs = 'Unsuccessfull.';
}

echo $rs;
?>