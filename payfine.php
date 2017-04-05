

<?php 

$cardno = $_POST["flag1"];

/*
$con = mysqli_connect("localhost","root","Qwerty1!","library");

							if (mysqli_connect_errno()) {
							  echo "Failed to connect to MySQL: " . mysqli_connect_error();
							  exit();
							}
							*/
include "db.php";

							
ini_set('max_execution_time', 300);


$altdata = "kd"; 

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

$cardno = trim($cardno); 

if(checkintruder($cardno))
{
		 
	$query = "update fines set paid = 1 where Loan_id  in ( select bl.Loan_id from book_loans as bl where bl.Card_id = '$cardno' and bl.Date_in <> 0)";
	$results = mysqli_query($con,$query);
	
	if($results)
	{
		$rs = "Payment Successful";
	}
	else
	{
		$rs = "Payment unSuccessful";
	}

$rs .= '<div class="filler"></div>';

}


/*
header('content-type: application/json');
echo json_encode($rs);
	*/
echo $rs;
?>