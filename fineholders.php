

<?php 

$cardno = $_POST["flag1"];
$paid = $_POST["flag2"];

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


if(checkintruder($cardno))
{
	$count = 0;
	
		$totalfine = 0;
		 
		if($paid==1)
		{			
			$query = "select b.ISBN, b.title, bl.Due_date, bl.Date_in, f.Fine_amt from fines as f,book as b, book_loans as bl where b.ISBN = bl.ISBN and bl.Loan_id = f.Loan_id and f.paid = 0 and bl.Card_id = '$cardno' and bl.Date_in <> 0";
			
		}
		else
		{
			$query = "select b.ISBN, b.title, bl.Due_date, bl.Date_in, f.Fine_amt from fines as f,book as b, book_loans as bl where b.ISBN = bl.ISBN and bl.Loan_id = f.Loan_id and f.paid = 1 and bl.Card_id = '$cardno' and bl.Date_in <> 0";	
			
		}
		
		
		$results = mysqli_query($con,$query);
			
		while($row = mysqli_fetch_array($results))
		{
			$ISBN = $row['ISBN'];
			$title = $row['title'];
			$due_date = $row['Due_date'];
			$tempfine = $row['Fine_amt'];
			
			$rs .= "<span>".$ISBN."</span><span>".$title."</span><span>".$due_date."</span><span>$".$tempfine."</span>";
			$totalfine += $tempfine;
		}
		
	
	if($rs=="")
	{
		$rs = "No fines Existing.";
	}
	else
	{
		$t = "<br><span>Total fine: </span>$".$totalfine."<br>";
		if($paid==1){
			$t .= "<button data-id='".$cardno."' id='finepaymentbutton' onclick='pay()' class='btn btn-primary'>Pay Fines</button>";
		}
		$rs .= $t;
		$rs .=
		"
		<script>
		$('#finepayment').on('click',function(){
				
				var x = $(this).attr('data-id');
				
				alert('into fine pament');
				$.ajax({
				type:'POST',
				url: 'payfine.php',
					data: {flag1: x},
					success: function(result){
						result = $.trim(result);	
						
					  document.getElementById('fineresults').innerHTML = result;
					  },
					error: function(err,e1,e2){alert(err.status+e1+e2);},
					complete: function(obj){setimages();}
				 });
				
			});
		</script>
		";
	}

$rs .= '<div class="filler"></div>';

}





echo $rs;
?>