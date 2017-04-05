

<?php 

$isbn = $_POST['flag1'];
$cardno = $_POST['flag2'];

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


function permit($cardno)
{
	$count = 0;
	/*
	$con = mysqli_connect("localhost","root","Qwerty1!","library");

	*/
	include "db.php";

	$query = "select 1 from book_loans where card_id='$cardno' and date_in = 0";
	$results = mysqli_query($con,$query);
	
	while($row = mysqli_fetch_array($results))
	{
		$count++;
	}
	
	if($count>2)
	{
		return false;
	}
	else
	{
		return true;
	}
}

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


if(checkintruder($cardno))
{
	$count = 0;
	
	if(permit($cardno))
	{		
		
		$query = "Insert into book_loans(isbn, Card_id, Date_out, Due_date) values('$isbn','$cardno',CURRENT_TIMESTAMP,CURRENT_TIMESTAMP - INTERVAL 24 DAY)";
		$results = mysqli_query($con,$query);
		
		$rs = 'Checkout Successful';
	}	
	else
	{
		$rs = 'Checkout not allowed: more 3 books already actively checkedout.';		
	}

}

echo $rs;
?>