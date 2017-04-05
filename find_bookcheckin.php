

<?php 

$cardno = "0";
$name = "";

$cardno = $_POST["flag1"];
$name = $_POST["flag2"];

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



if(checkintruder($cardno) || checkintruder($name))
{
	$count = 0;
	
		$totalfine = 0;
		 
		 
		if($name=="") $name = "xxxxxxxxxxxxxxxxxxxx";
		
		$query = 
		"select bl.ISBN, b.title, bl.Card_id, borrower.Fname, bl.Due_date from book as b, book_loans as bl, borrower where b.isbn = bl.isbn and bl.Card_id = '$cardno' and bl.Card_id = borrower.Card_id and bl.Date_in = 0
		union
		select bl.ISBN, b.title, bl.Card_id, borrower.Fname, bl.Due_date from book as b, book_loans as bl, borrower where b.isbn = bl.isbn and borrower.Fname like '%$name%' and bl.Card_id = borrower.Card_id and bl.Date_in = 0
		";			
		
		$results = mysqli_query($con,$query);
			
		while($row = mysqli_fetch_array($results))
		{
			$ISBN = $row['ISBN'];
			$title = $row['title'];
			$due_date = $row['Due_date'];
			$cardid = $row['Card_id'];
			$Fname = $row['Fname'];
			
			$rs .= "<div class='row' style='margin:5px;background:#f4f5f7;'><span class='col-md-1'>".$ISBN."</span><span class='col-md-5'>".$title."</span><span class='col-md-2'>".$cardid."</span><span class='col-md-1'>".$Fname."</span><span class='col-md-2'>".$due_date."</span>";
			$rs .= "<a class='col-md-1' href='index.php?checkin=".$ISBN."/#bookloans'><button data-id='".$ISBN."' class='btn btn-primary'>Checkin</button></a></div>";
		
		}
		
	
	if($rs=="")
	{
		$rs = "No Books found pending / User not found.";
	}
	


}
else
{
	$rs = "No input.";
}




echo $rs;
?>