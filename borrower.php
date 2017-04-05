
<?php 

$fname = $_POST['flag1'];
$ssn = $_POST['flag2'];
$addr = $_POST['flag3'];
$lname = $_POST['flag4'];
$phone = $_POST['flag5'];

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


function permit($ssn)
{
	$count = 0;
/*
	$con = mysqli_connect("localhost","root","Qwerty1!","library");

							if (mysqli_connect_errno()) {
							  echo "Failed to connect to MySQL: " . mysqli_connect_error();
							  exit();
							}
	*/
include "db.php";
	
	$query = "select 1 from borrower where Ssn='$ssn'";
	$results = mysqli_query($con,$query);
	
	while($row = mysqli_fetch_array($results))
	{
		$count++;
	}
	
	if($count>0)
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
	if (preg_match('/[\'^£$%&*()}{@#~?><>|=_+¬-]/', $query) || $query=="")
	{
		return false;
	}
	else
	{
		return true;
	}
}


if( true)
{
	$count = 0;
	
	if(permit($ssn))
	{		
		$query = "Insert into borrower (ssn, fname, lname, address, phone) values('$ssn','$fname','$lname','$addr', '$phone')";
		$results = mysqli_query($con,$query);
		
		$rs .= 'Borrower Successfully added.<div class="filler"></div>';
	}	
	else
	{
		$rs .= 'A borrower with same ssn Already exists!<div class="filler"></div>';		
	}

}

echo $rs;
?>