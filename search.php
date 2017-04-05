

<?php 

$query = $_POST["flag1"];
$rs = "";
$category = 0;
$category = $_POST["flag2"];

$constraint = $_POST["flag3"];

/*
$con = mysqli_connect("localhost","root","Qwerty1!","library");

							if (mysqli_connect_errno()) {
							  echo "Failed to connect to MySQL: " . mysqli_connect_error();
							  exit();
							}
							
		*/					

include "db.php";
		
ini_set('max_execution_time', 300);

$temp = explode(" ",$query);

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


if(checkintruder($query))
{
	$count = 0;


	//from books matching complete key


	
	foreach ($temp as $word)
	{
		
		// like product name 
		
		
		
			
				$rs = "<ul>";
				
				
				//from books matching all keys
				
				$query = "
				
				select b.isbn as isbn, b.title as title from book as b where b.title like '%$word%'
				union
				select b.isbn as isbn, b.title as title from book as b where b.isbn like '%$word%'
				union
				select b.isbn as isbn, b.title as title from book as b, authors as a, book_authors as ba where ba.ISBN = b.ISBN and ba.author_id = a.author_id and a.Name like '%$word%'
				";	//update this to a better query.
				
				//union 
				//select b.isbn as isbn, b.title as title from book as b, author as a, books_author as bl where bl.author_id = a.author_id and a.Name = like '%$word%'
				
				
				$results = mysqli_query($con, $query);
				
				while($row = mysqli_fetch_array($results))
				{
					$isbn = $row['isbn'];
					$title = $row['title'];
					
					$date_in = 1;
					
					$query2 = "select Date_in from Book_loans as bl where bl.isbn = '$isbn'";
					$results2 = mysqli_query($con, $query2);
					while($row2 = mysqli_fetch_array($results2))
					{
						if($row2['Date_in'] == 0) 
							$date_in = 0;
					}
					
					
					
					$butt = "";
					$authors = "";
					
					$query2 = "select Name as author_name from Authors, Book_Authors as ba where ba.isbn = '$isbn' and ba.author_id = Authors.Author_id";	//update this to a better query.
					$results2 = mysqli_query($con, $query2);
					while($row2 = mysqli_fetch_array($results2))
					{
						$authors .= $row2['author_name'] . ", ";
					}
					
					$authors = rtrim($authors,", ");
					
					if($date_in==0) 
					{
						$avail = "Not available";
						$butt = "<a href='index.php?checkin=".$isbn."/#bookloans'><button id='shortcut' class='checkoutshortcut btn btn-default' data-id='".$isbn."' >Check In</button></a>";
					}
					else
					{
						$avail = "available";	
						$butt = "<a href='index.php?isbn=".$isbn."/#bookloans'><button id='shortcut' class='checkoutshortcut btn btn-primary' data-id='".$isbn."' >Check out</button></a>";
					}	
					$rs .= "<li class='row'><span class='col-md-1'>".$isbn ."</span><span class='col-md-5'>". $title ."</span><span class='col-md-3'>". $authors ."</span><span class='col-md-1'>". $avail ."</span><span class='col-md-1'>". $butt ."</span></li>";
				}
		
		
				//
		$query = "select a.Name, a.Author_id from authors as a where a.Name like '%$word%'";		
		$results = mysqli_query($con, $query);
				
				while($row = mysqli_fetch_array($results))
				{
					$author_name = $row['Name'];
					$author_id = $row['Author_id'];
				
				
				$rs .= "<li class='row'><span class='col-md-3'>".$author_id ."</span><span class='col-md-3'>".$author_name ."</span></li>";
				}
		
	}

	if($rs=="")
	{
		$rs = "We have hit a bum.Please search something else...";
	}

	$rs .= '</ul><div class="filler"></div>';

}



if($constraint>0)
{
	$t = "<button class='loadmore' onclick='loadmore()' data-id='". $constraint. "' >Load more...</button>";
	$rs .= $t;
}


/*
header('content-type: application/json');
echo json_encode($rs);
	*/
echo $rs;
?>