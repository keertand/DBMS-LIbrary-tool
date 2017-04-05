

<?php 
/*
$con = mysqli_connect("localhost","root","Qwerty1!","library");

							if (mysqli_connect_errno()) {
							  echo "Failed to connect to MySQL: " . mysqli_connect_error();
							  exit();
							}
							
			*/
include "db.php";
			
ini_set('max_execution_time', 300);



$temp = $_POST['flag1'];
		 
	$query = "select * from book_loans";
	$res = mysqli_query($con,$query);
		
	while($row = mysqli_fetch_array($res))
		{	 
			$count = 0;
			$loan_id = $row['Loan_id'];
			$due_date = $row['Due_date'];
			$date_in = $row['Date_in'];
			
			
			if(strtotime($date_in) == "")
			{
			$dd=$due_date;
			$d=strtotime($dd);
			date_default_timezone_set('US/Central');
			$c=date('Y-m-d h:i:sa',time());
			$temp=strtotime($c);
			$diff=($temp-$d)/(24*60*60);
			$days=ceil($diff);
			
			$fine=$days*0.25;
			
			
			}
			else{
			// get difference between due date and date_in
			$dd=$due_date;
			$d=strtotime($dd);
			$temp = strtotime($date_in);
			
			date_default_timezone_set('US/Central');
			
			$diff=($temp-$d)/(24*60*60);
			$days=ceil($diff);
			$fine=$days*0.25;
			
			
			
			}
			
			
			if($fine>0)
			{			
				$query = "select 1 from Fines where Loan_id = '$loan_id'";
				$results = mysqli_query($con,$query);
				
				while($row = mysqli_fetch_array($results))
				{
					$count++;
				}
				
				if($count>0)
				{
				$query = "update Fines set fine_amt = '$fine' where Loan_id = '$loan_id'";
				$results = mysqli_query($con,$query);
				}
				else
				{
				$query = "insert into Fines values('$loan_id','$fine',0)";
				$results = mysqli_query($con,$query);
				}	

			}
		}
	
	
	
	
$rs = 'Updated.<div class="filler"></div>';




/*
header('content-type: application/json');
echo json_encode($rs);
	*/
echo $rs;
?>